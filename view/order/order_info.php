<!-- Title page -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
	<h2 class="ltext-105 cl0 txt-center">
    THÔNG TIN CHI TIẾT ĐƠN HÀNG
	</h2>
</section>

<?php
	if(!empty($detailOrder)) {
		foreach($detailOrder as $item) {
			extract($item);
		}
	}

	

	
?>

<div>Mã đơn hàng: <?= $order_id ?></div>
<div>Tên người nhận: <?= $_SESSION['user']['user_name'] ?></div>
<div>SĐT: <?= $_SESSION['user']['user_phoneNumber']?></div>
<div>Địa chỉ: <?= $address_order ?></div>
<div>Hình thức thanh toán: <?= $payment ?></div>
<table class="table table-hover" border="1">
	<tr class="table-header">
        <th>Mã sản phẩm</th>
        <th>Ảnh sản phẩm</th>
        <th>Tên sản phẩm</th>
        <th>Màu sắc</th>
        <th>Kích thước</th>
        <th>Giá ($)</th>
        <th>Số lượng (cái)</th>
        <th>Thành tiền ($)</th>
    </tr>
	<?php
	$total_bill = 0;
        if(!empty($detailOrder)) {
            foreach($detailOrder as $item) {
                extract($item);
                $total_bill += $total;

                $pro_info = get_info_product($product_id);
                extract($pro_info);

                echo "<tr>
                        <td>".$product_id."</td>
                        <td><img style='width:100px;height:130px' src='data:image/jpeg;base64,".base64_encode($product_image)."' alt='IMG-PRODUCT'></td>
                        <td><a href='index.php?ac=productDetail&id=".$product_id."'>". $product_name ."</a></td>
                        <td>".$product_color."</td>
                        <td>".$product_size."</td>
                        <td>".$product_price."</td>
                        <td>".$quantity."</td>
                        <td>".$quantity * $product_price."</td>
                    </tr>";
            }
        }
    ?>
    
    <tr>
        <td colspan="7">Tổng tiền ($)</td>
        <td><?= $total_bill ?></td>
</table>