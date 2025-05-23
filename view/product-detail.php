<?php
$currentProduct = get_info_product($_GET['id']);
$categoryId = getCategoryIdByProductId($currentProduct['product_id']);
$categoryName = getCategoryNameById($categoryId);
$listProduct = loadSanPham_Product();

?>

<!-- Cart -->

<!-- Breadcrumb -->
<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="index" class="stext-109 cl8 hov-cl1 trans-04">
            Trang chủ
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>
        <a href="index.php?ac=product&categoryid=<?php echo $categoryId; ?>" class="stext-109 cl8 hov-cl1 trans-04">
            <?php echo $categoryName; ?>
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>
        <span class="stext-109 cl4">
            <?php echo $currentProduct['product_name']; ?>
        </span>
    </div>
</div>

<!-- Product Detail -->
<section class="sec-product-detail bg0 p-t-65 p-b-60">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-7 p-b-30">
                <div class="p-l-25 p-r-30 p-lr-0-lg">
                    <div class="wrap-slick3 flex-sb flex-w">
                        <div class="wrap-slick3-dots"></div>
                        <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
                        <div class="slick3 gallery-lb">
                            <div class="item-slick3"
                                data-thumb="data:image/jpeg;base64,<?php echo base64_encode($currentProduct['product_image']); ?>">
                                <div class="wrap-pic-w pos-relative">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($currentProduct['product_image']); ?>"
                                        alt="IMG-PRODUCT">
                                    <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                        href="images/product-detail-01.jpg">
                                        <i class="fa fa-expand"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-5 p-b-30">
                <div class="p-r-50 p-t-5 p-lr-0-lg">
                    <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                        <?php echo $currentProduct['product_name']; ?>
                    </h4>
                    <span class="mtext-106 cl2">
                        $<?php echo $currentProduct['product_price']; ?>
                    </span>
                    <p class="stext-102 cl3 p-t-23">
                        <?php echo $currentProduct['product_description']; ?>
                    </p>
                    <!-- Form thêm vào giỏ hàng -->
                    <form action="index.php?ac=add_to_cart" method="post">
                        <input type="hidden" name="id_product" value="<?php echo $currentProduct['product_id']; ?>">
                        <div class="p-t-33">
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">Kích thước</div>
                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        <select class="js-select2" name="size" id="sizeselect">
                                            <option>Kích thước <?php echo $currentProduct['product_size']; ?></option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">Màu sắc</div>
                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        <select class="js-select2" name="color">
                                            <option><?php echo $currentProduct['product_color']; ?></option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-204 flex-w flex-m respon6-next">
                                    <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>
                                        <?php $stock = $currentProduct['amount'] ?? 0; ?>
                                        <input class="mtext-104 cl3 txt-center num-product" type="number"
                                            name="num-product" value="1" min="1" max="<?php echo $stock; ?>"
                                            <?php if ($stock <= 0) echo 'disabled'; ?>>
                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>
                                    </div>
                                    <?php if ($stock > 0): ?>
                                    <button
                                        class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail"
                                        type="submit" name="btn_add_to_cart">
                                        Thêm vào giỏ hàng
                                    </button>
                                    <?php else: ?>
                                    <button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 p-lr-15 trans-04" disabled>
                                        Hết hàng
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">Số lượng còn lại</div>
                                <div class="size-204 respon6-next">
                                    <span class="stext-102 cl3">
                                        <?php echo $stock > 0 ? "$stock sản phẩm còn lại" : "Hết hàng"; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                        <div class="flex-m bor9 p-r-10 m-r-11">
                            <a href="#"
                                class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
                                data-tooltip="Thêm vào danh sách yêu thích">
                                <i class="zmdi zmdi-favorite"></i>
                            </a>
                        </div>
                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                            data-tooltip="Facebook">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                            data-tooltip="Twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                            data-tooltip="Google Plus">
                            <i class="fa fa-google-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bor10 m-t-50 p-t-43 p-b-40">
            <!-- Tab01 -->
            <div class="tab01">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item p-b-10">
                        <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Mô tả</a>
                    </li>
                    <li class="nav-item p-b-10">
                        <a class="nav-link" data-toggle="tab" href="#information" role="tab">Thông tin bổ sung</a>
                    </li>
                    <li class="nav-item p-b-10">
                        <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Đánh giá (1)</a>
                    </li>
                </ul>
                <div class="tab-content p-t-43">
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="how-pos2 p-lr-15-md">
                            <p class="stext-102 cl6"><?php echo $currentProduct['product_description']; ?></p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="information" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                <ul class="p-lr-28 p-lr-15-sm">
                                    <li class="flex-w flex-t p-b-7">
                                        <span class="stext-102 cl3 size-205">Trọng lượng</span>
                                        <span class="stext-102 cl6 size-206">0.79 kg</span>
                                    </li>
                                    <li class="flex-w flex-t p-b-7">
                                        <span class="stext-102 cl3 size-205">Kích thước</span>
                                        <span class="stext-102 cl6 size-206">110 x 33 x 100 cm</span>
                                    </li>
                                    <li class="flex-w flex-t p-b-7">
                                        <span class="stext-102 cl3 size-205">Chất liệu</span>
                                        <span class="stext-102 cl6 size-206">60% cotton</span>
                                    </li>
                                    <li class="flex-w flex-t p-b-7">
                                        <span class="stext-102 cl3 size-205">Màu sắc</span>
                                        <span
                                            class="stext-102 cl6 size-206"><?php echo $currentProduct['product_color']; ?></span>
                                    </li>
                                    <li class="flex-w flex-t p-b-7">
                                        <span class="stext-102 cl3 size-205">Kích thước</span>
                                        <span
                                            class="stext-102 cl6 size-206"><?php echo $currentProduct['product_size']; ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                <div class="p-b-30 m-lr-15-sm">
                                    <div class="flex-w flex-t p-b-68">
                                        <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                            <img src="images/avatar-01.jpg" alt="AVATAR">
                                        </div>
                                        <div class="size-207">
                                            <div class="flex-w flex-sb-m p-b-17">
                                                <span class="mtext-107 cl2 p-r-20">Ariana Grande</span>
                                                <span class="fs-18 cl11">
                                                    <i class="zmdi zmdi-star"></i>
                                                    <i class="zmdi zmdi-star"></i>
                                                    <i class="zmdi zmdi-star"></i>
                                                    <i class="zmdi zmdi-star"></i>
                                                    <i class="zmdi zmdi-star-half"></i>
                                                </span>
                                            </div>
                                            <p class="stext-102 cl6">
                                                Quod autem in homine praestantissimum atque optimum est, id deseruit.
                                                Apud ceteros autem philosophos
                                            </p>
                                        </div>
                                    </div>
                                    <form class="w-full">
                                        <h5 class="mtext-108 cl2 p-b-7">Thêm đánh giá</h5>
                                        <p class="stext-102 cl6">Địa chỉ email của bạn sẽ không được công khai. Các
                                            trường bắt buộc được đánh dấu *</p>
                                        <div class="flex-w flex-m p-t-50 p-b-23">
                                            <span class="stext-102 cl3 m-r-16">Đánh giá của bạn</span>
                                            <span class="wrap-rating fs-18 cl11 pointer">
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <input class="dis-none" type="number" name="rating">
                                            </span>
                                        </div>
                                        <div class="row p-b-25">
                                            <div class="col-12 p-b-5">
                                                <label class="stext-102 cl3" for="review">Đánh giá của bạn</label>
                                                <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10"
                                                    id="review" name="review"></textarea>
                                            </div>
                                            <div class="col-sm-6 p-b-5">
                                                <label class="stext-102 cl3" for="name">Tên</label>
                                                <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name" type="text"
                                                    name="name">
                                            </div>
                                            <div class="col-sm-6 p-b-5">
                                                <label class="stext-102 cl3" for="email">Email</label>
                                                <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email"
                                                    type="text" name="email">
                                            </div>
                                        </div>
                                        <button
                                            class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">Gửi
                                            đánh giá</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
            <span class="stext-107 cl6 p-lr-25">Mã sản phẩm: JAK-01</span>
            <span class="stext-107 cl6 p-lr-25">Danh mục: <?php echo $categoryName; ?></span>
        </div>
    </div>
</section>

<!-- Related Products -->
<section class="sec-relate-product bg0 p-t-45 p-b-105">
    <div class="container">
        <div class="p-b-45">
            <h3 class="ltext-106 cl5 txt-center">Sản phẩm liên quan</h3>
        </div>
        <div class="wrap-slick2">
        
<div class="slick2">
    <?php
    if (count($listProduct) > 0) {
        foreach ($listProduct as $product) {
            extract($product);
            $stock = $product['amount'] ?? 0;
            echo "<div class='item-slick2 p-l-15 p-r-15 p-t-15 p-b-15'>
                    <div class='block2'>
                        <div class='block2-pic hov-img0' style='position: relative;'>
                            <img style='width: 315px; height: 390.06px;' src='data:image/jpeg;base64," . base64_encode($product_image) . "' alt='IMG-PRODUCT'>";
                            // Hiển thị lớp phủ \"Hết hàng\" nếu amount <= 0
                            if ($stock <= 0) {
                                echo "<div class='out-of-stock-overlay'>Hết hàng</div>";
                            }
                            echo "<a href='index.php?ac=productDetail&id=$product_id'
                               class='block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04'>
                               Chi tiết
                            </a>
                        </div>
                        <div class='block2-txt flex-w flex-t p-t-14'>
                            <div class='block2-txt-child1 flex-col-l'>
                                <a href='index.php?ac=productDetail&id=$product_id' class='stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6'>
                                    $product_name
                                </a>
                                <span class='stext-105 cl3'>$product_price $</span>
                            </div>
                            <div class='block2-txt-child2 flex-r p-t-3'>
                                <a href='#' class='btn-addwish-b2 dis-block pos-relative js-addwish-b2'>
                                    <img class='icon-heart1 dis-block trans-04' src='images/icons/icon-heart-01.png'
                                         alt='ICON'>
                                    <img class='icon-heart2 dis-block trans-04 ab-t-l'
                                         src='images/icons/icon-heart-02.png' alt='ICON'>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>";
        }
    } else {
        echo "<div class='item-slick2 p-l-15 p-r-15 p-t-15 p-b-15'><h1>Không có sản phẩm nào khớp với mô tả của bạn</h1></div>";
    }
    ?>
</div>
        </div>
    </div>
</section>

<!-- Modal1 -->
<!-- <div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
    <div class="overlay-modal1 js-hide-modal1"></div>
    <div class="container">
        <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
            <button class="how-pos3 hov3 trans-04 js-hide-modal1">
                <img src="images/icons/icon-close.png" alt="CLOSE">
            </button>
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">
                            <div class="wrap-slick3-dots"></div>
                            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
                            <div class="slick3 gallery-lb">
                                <div class="item-slick3" data-thumb="images/product-detail-01.jpg">
                                    <div class="wrap-pic-w pos-relative">
                                        <img src="images/product-detail-01.jpg" alt="IMG-PRODUCT">
                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                            href="images/product-detail-01.jpg">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="item-slick3" data-thumb="images/product-detail-02.jpg">
                                    <div class="wrap-pic-w pos-relative">
                                        <img src="images/product-detail-02.jpg" alt="IMG-PRODUCT">
                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                            href="images/product-detail-02.jpg">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="item-slick3" data-thumb="images/product-detail-03.jpg">
                                    <div class="wrap-pic-w pos-relative">
                                        <img src="images/product-detail-03.jpg" alt="IMG-PRODUCT">
                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                            href="images/product-detail-03.jpg">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">Áo khoác nhẹ</h4>
                        <span class="mtext-106 cl2">$58.79</span>
                        <p class="stext-102 cl3 p-t-23">
                            Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris consequat ornare
                            feugiat.
                        </p>
                        <div class="p-t-33">
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">Kích thước</div>
                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        <select class="js-select2" name="size">
                                            <option>Chọn kích thước</option>
                                            <option>Kích thước S</option>
                                            <option>Kích thước M</option>
                                            <option>Kích thước L</option>
                                            <option>Kích thước XL</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">Màu sắc</div>
                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        <select class="js-select2" name="color">
                                            <option>Chọn màu sắc</option>
                                            <option>Đỏ</option>
                                            <option>Xanh</option>
                                            <option>Trắng</option>
                                            <option>Xám</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-204 flex-w flex-m respon6-next">
                                    <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>
                                        <input class="mtext-104 cl3 txt-center num-product" type="number"
                                            name="num-product" value="1">
                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>
                                    </div>
                                    <button
                                        class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                        Thêm vào giỏ hàng
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                            <div class="flex-m bor9 p-r-10 m-r-11">
                                <a href="#"
                                    class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
                                    data-tooltip="Thêm vào danh sách yêu thích">
                                    <i class="zmdi zmdi-favorite"></i>
                                </a>
                            </div>
                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Google Plus">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->