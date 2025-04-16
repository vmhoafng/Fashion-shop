<!-- Cart -->
<?php 
	if(isset($_GET['id'])){
		
	}
?>
<!-- <div class="wrap-header-cart js-panel-cart">
	<div class="s-full js-hide-cart"></div>

	<div class="header-cart flex-col-l p-l-65 p-r-25">
		<div class="header-cart-title flex-w flex-sb-m p-b-8">
			<span class="mtext-103 cl2">
				Your Cart
			</span>

			<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
				<i class="zmdi zmdi-close"></i>
			</div>
		</div>

		<div class="header-cart-content flex-w js-pscroll">
			<ul class="header-cart-wrapitem w-full">
				<li class="header-cart-item flex-w flex-t m-b-12">
					<div class="header-cart-item-img">
						<img src="images/item-cart-01.jpg" alt="IMG">
					</div>

					<div class="header-cart-item-txt p-t-8">
						<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
							White Shirt Pleat
						</a>

						<span class="header-cart-item-info">
							1 x $19.00
						</span>
					</div>
				</li>

				<li class="header-cart-item flex-w flex-t m-b-12">
					<div class="header-cart-item-img">
						<img src="images/item-cart-02.jpg" alt="IMG">
					</div>

					<div class="header-cart-item-txt p-t-8">
						<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
							Converse All Star
						</a>

						<span class="header-cart-item-info">
							1 x $39.00
						</span>
					</div>
				</li>

				<li class="header-cart-item flex-w flex-t m-b-12">
					<div class="header-cart-item-img">
						<img src="images/item-cart-03.jpg" alt="IMG">
					</div>

					<div class="header-cart-item-txt p-t-8">
						<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
							Nixon Porter Leather
						</a>

						<span class="header-cart-item-info">
							1 x $17.00
						</span>
					</div>
				</li>
			</ul>

			<div class="w-full">
				<div class="header-cart-total w-full p-tb-40">
					Total: $75.00
				</div>

				<div class="header-cart-buttons flex-w w-full">
					<a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
						View Cart
					</a>

					<a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
						Check Out
					</a>
				</div>
			</div>
		</div>
	</div>
</div> -->


<!-- breadcrumb -->
<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="index.php" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            Shoping Cart
        </span>
    </div>
</div>


<!-- Shoping Cart -->
<form class="bg0 p-t-75 p-b-85" method="POST" action="index.php?ac=bill_info">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">

                        <table class="table-shopping-cart">
                            <tr class="table_head">
                                <th class="column-1">Product</th>
                                <th class="column-2">Name</th>
                                <th class="column-2">Size</th>
                                <th class="column-2">Color</th>
                                <th class="column-3">Price</th>
                                <th class="column-4">Quantity</th>
                                <th class="column-5">Total</th>
                                <th class="column-2"></th>


                            </tr>
                            <?php
							if(isset($_SESSION['user'])) {
								$total = 0;
								$total_all = 0;
								if(isset($list_id_product)) {
									foreach($list_id_product as $item) {
										extract($item);
										$id_product = $product_id;
		
										$item_product = get_info_product($id_product);
										extract($item_product);
		
										$total = $quantity * $product_price;
										$total_all += $total;
										echo "	<tr class='table_row'>
												<td class='column-1'>
													<div class='how-itemcart1'>
														<img src='data:image/jpeg;base64,".base64_encode($product_image)."' alt='IMG-PRODUCT'>
													</div>
												</td>
												<td class='column-2'><a href='index.php?ac=productDetail&id=". $id_product ."'>". $product_name ."</a></td>
												<td >". $product_size ."</td>
												<td class='column-2'>". $product_color ."</td>
												<td class='column-3'>$ ". $product_price ."</td>
												<td class='column-4'>
													<div class='wrap-num-product flex-w m-l-auto m-r-0'>
														<a href='index.php?ac=minus&id=".$id_product."'>
															<div class='btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m'>
																<i class='fs-16 zmdi zmdi-minus'></i>
															</div>
														</a>
		
														<input class='mtext-104 cl3 txt-center num-product' type='number' name='num-product1' value='".$quantity."'>
														<a href='index.php?ac=plus&id=".$id_product."'>
															<div class='btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m'>
																<i class='fs-16 zmdi zmdi-plus'></i>
															</div>
														</a>
													</div>
												</td>
												<td class='column-5'>$ ". $total ."</td>
												<td class='column-2'><a href='index.php?ac=delete_product&id=".$id_product."'>Xóa</a></td>
											</tr>";
									}
								}		
								if(empty($list_id_product)) {
									echo "<tr>
											<td colspan='7' class='text-center p-4'>EMPTY CART</td>
										</tr>";
								}	
							}
							else {
								$total = 0;
								$total_all = 0;
								if(!empty($_SESSION['cart_no_login'])) {
									foreach($_SESSION['cart_no_login'] as $item) {
										$item_product = get_info_product($item[0]);
										extract($item_product);
		
										$total = $item[1] * $product_price;
										$total_all += $total;
										echo "	<tr class='table_row'>
												<td class='column-1'>
													<div class='how-itemcart1'>
														<img src='data:image/jpeg;base64,".base64_encode($product_image)."' alt='IMG-PRODUCT'>
													</div>
												</td>
												<td class='column-2'><a href='index.php?ac=productDetail&id=". $item[0] ."'>". $product_name ."</a></td>
												<td >". $product_size ."</td>
												<td class='column-2'>". $product_color ."</td>
												<td class='column-3'>$ ". $product_price ."</td>
												<td class='column-4'>
													<div class='wrap-num-product flex-w m-l-auto m-r-0'>
														<a href='index.php?ac=minus&id=".$item[0]."'>
															<div class='btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m'>
																<i class='fs-16 zmdi zmdi-minus'></i>
															</div>
														</a>
		
														<input class='mtext-104 cl3 txt-center num-product' type='number' name='num-product1' value='".$item[1]."'>
														<a href='index.php?ac=plus&id=".$item[0]."'>
															<div class='btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m'>
																<i class='fs-16 zmdi zmdi-plus'></i>
															</div>
														</a>
													</div>
												</td>
												<td class='column-5'>$ ". $total ."</td>
												<td class='column-2'><a href='index.php?ac=delete_product&id=".$item[0]."'>Xóa</a></td>
											</tr>";
									}
								}
								else {
									echo "<tr>
											<td colspan='7' class='text-center p-4'>GIỎ HÀNG TRỐNG!</td>
										</tr>";		
								}
							}
				
							?>

                            <!-- <tr class="table_row">
								<td class="column-1">
									<div class="how-itemcart1">
										<img src="images/item-cart-05.jpg" alt="IMG">
									</div>
								</td>
								<td class="column-2">Lightweight Jacket</td>
								<td class="column-3">$ 16.00</td>
								<td class="column-4">
									<div class="wrap-num-product flex-w m-l-auto m-r-0">
										<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-minus"></i>
										</div>

										<input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product2" value="1">

										<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-plus"></i>
										</div>
									</div>
								</td>
								<td class="column-5">$ 16.00</td>
							</tr> -->
                        </table>
                    </div>

                    <!-- <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
						<div class="flex-w flex-m m-r-20 m-tb-5">
							<input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text" name="coupon" placeholder="Coupon Code">

							<div class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
								Apply coupon
							</div>
						</div>

						<div class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
							<button type="submit" name="btn_update_cart">Update Cart</button>
						</div>
					</div> -->


                </div>
            </div>

            <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                    <h4 class="mtext-109 cl2 p-b-30">
                        Cart Totals
                    </h4>

                    <div class="flex-w flex-t bor12 p-b-13">
                        <div class="size-208">
                            <span class="stext-110 cl2">Payment:&nbsp;</span>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pay" id="atmBanking" value="Chuyển khoản"
                                checked>
                            <label class="form-check-label" for="atmBanking">ATM Banking</label>

                            <input class="form-check-input" type="radio" name="pay" id="atmBanking" value="Tiền mặt">
                            <label class="form-check-label" for="atmBanking">Ship COD</label>
                        </div>
                    </div>

                    <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                        <div class="size-208 w-full-ssm">
                            <span class="stext-110 cl2">
                                Shipping:
                            </span>
                        </div>
                        <?php 
						$radiocheck=1;
						?>

                        <div class="size-209 p-r-18 p-r-0-sm w-full-ssm" id="tpm">
                            <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                <select class="js-select2" name="province" id="provinceSelect" required>
                                    <option value="">City</option>
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>

                            <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                <select class="js-select2" name="disrict" id="districtSelect" required>
                                    <option value="">District</option>
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>

                            <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9" required>
                                <select class="js-select2" name="ward" id="wardSelect">
                                    <option value="">Ward</option>
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>

                            <div class="bor8 bg0 m-b-22">
                                <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" id="sn"
                                    placeholder="Address" required>
                            </div>

                            <!-- <div class="flex-w">
									<div class="flex-c-m stext-101 cl2 size-115 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer">
										Update Totals
									</div>
								</div> -->
                        </div>
                    </div>

                    <!-- <div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="pay" id="atmBanking" value="Chuyển khoản" checked>
							<label class="form-check-label" for="atmBanking">ATM Banking</label>

							<input class="form-check-input" type="radio" name="pay" id="atmBanking" value="Tiền mặt">
							<label class="form-check-label" for="atmBanking">Ship COD</label>
						</div> -->
                    <div class="flex-w flex-t bor12 p-b-13">
                        <div class="size-208">
                            <span class="stext-110 cl2">Payment:&nbsp;</span>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="addHaoNam" id="radioid" value="1"
                                onChange="test()" checked>
                            <label class="form-check-label">New address</label>

                            <input class="form-check-input" type="radio" name="addHaoNam" id="radioid" value="2"
                                onChange="test()">
                            <label class="form-check-label">Default address</label>

                            <span>
                                <?php
								if(isset($_SESSION['user'])) {
									echo  $_SESSION['user']['user_address'];
								}
								else {
									echo "Chưa đăng nhập tài khoản!";
								}
							?>
                            </span>
                        </div>
                    </div>

                    <script>
                    function test() {

                        var options = document.getElementsByName('addHaoNam');
                        var selectedOption;

                        for (var i = 0; i < options.length; i++) {
                            if (options[i].checked) {
                                selectedOption = options[i].value;
                                break;
                            }
                        }
                        console.log(selectedOption);
                        if (selectedOption == 2) {
                            <?php
									$radiocheck=2;
									?>
                            document.getElementById('provinceSelect').disabled = true;
                            document.getElementById('districtSelect').disabled = true;
                            document.getElementById('wardSelect').disabled = true;
                            document.getElementById('sn').readOnly = true;

                        } else {
                            document.getElementById('provinceSelect').disabled = false;
                            document.getElementById('districtSelect').disabled = false;
                            document.getElementById('wardSelect').disabled = false;
                            document.getElementById('sn').readOnly = false;


                        }

                    }
                    </script>

                    <hr>

                    <div class="flex-w flex-t p-t-27 p-b-33">
                        <div class="size-208">
                            <span class="mtext-101 cl2">
                                Total:
                            </span>
                        </div>

                        <div class="size-209 p-t-1">
                            <span class="mtext-110 cl2">
                                <?= $total_all ?>$
                            </span>
                        </div>
                    </div>

                    <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer"
                        type="submit" name="btn_checkout">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


<!-- Nguyễn Văn Dũng -->
<script>
$(document).ready(function() {
    $.ajax({
        url: 'view/cart/province.php',
        method: 'GET',
        success: function(data) {
            $('#provinceSelect').html(data);
        }
    });

    $('#provinceSelect').change(function() {
        var provinceId = $(this).val();
        $.ajax({
            url: 'view/cart/district.php',
            method: 'POST',
            data: {
                province_id: provinceId
            },
            success: function(data) {
                $('#districtSelect').html(data);
            }
        });
    });

    $('#districtSelect').change(function() {
        var districtId = $(this).val();
        $.ajax({
            url: 'view/cart/ward.php',
            method: 'POST',
            data: {
                district_id: districtId
            },
            success: function(data) {
                $('#wardSelect').html(data);
            }
        });
    });
});
</script>

<script>
function sendPlusRequest(element) {
    var id = element.getAttribute('data-id');
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "index.php?ac=plus&id=" + id, true);
    xhr.send();
}
</script>