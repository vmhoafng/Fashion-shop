<!-- Title page -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
	<h2 class="ltext-105 cl0 txt-center">
    HÓA ĐƠN MUA HÀNG
	</h2>
</section>



    <?php
        if(isset($_SESSION['user'])) {
            echo "<div>
            <div>Mã hóa đơn: ".$id_bill ."</div>
            <div>Ngày tạo hóa đơn: ".$created_date ."</div>
            <div>Phương thức thanh toán: ".$payment ."</div>
            <div>Địa chỉ nhận hàng: ".$address ."</div>
            <div>Tên người mua: ".$name_user ."</div>
            <div>SĐT: ".$phone ."</div>
        
            <table class='table table-hover' border='1'>
                <tr class='table-header'>
                    <th>Mã sản phẩm</th>
                    <th>Ảnh sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                </tr>";
                
                    if(isset($list_detail_cart_1)) {
                        foreach($list_detail_cart_1 as $item) {
                            extract($item);
                            $pro_id = $product_id;
                            $pro_quantity = $quantity;
            
                            $pro_detail = get_info_product($pro_id);
                            if(isset($pro_detail)) {
                                extract($pro_detail);
                                $pro_price = $product_price;
                                $price_quantity = $pro_quantity * $pro_price;
                            }
                            echo "<tr>
                                    <td>". $pro_id ."</td>
                                    <td><img style='width:100px;height:130px' src='data:image/jpeg;base64,".base64_encode($product_image)."' alt='IMG-PRODUCT'></td>
                                    <td><a href='index.php?ac=productDetail&id=".$pro_id."'>". $product_name ."</a></td>
                                    <td>". $quantity ."</td>
                                    <td>". $pro_price."$</td>
                                    <td>". $price_quantity."$</td>
                                </tr>";
            
                        }
                    }
            
                    echo " </table>
        
                    <div>Tổng tiền: ". $total_bill_success ."$</div>
                
                </div>";
            
        }
        else {
            echo "Vui lòng đăng nhập!";
        }
    ?>
