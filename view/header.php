<?php $current_page = isset($_GET['ac']) ? $_GET['ac'] : 'index'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.png" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/sign/style.css">

    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">

    <!-- Thêm thư viện jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <?php if ($current_page == 'signup' || $current_page == 'signin') echo '<link rel="stylesheet" type="text/css" href="css/sign/background.css">'; ?>

    <?php
    $titles = array(
        'index' => 'Home',
        'about' => 'About Us',
        'blog' => 'Blog',
        'cart' => 'Giỏ Hàng',
        'contact' => 'Liên lạc',
        'productDetail' => 'Chi tiết',
        'product' => 'Shop',
        'signin' => 'Đăng nhập',
        'signup' => 'Đăng ký'
    );

    $title = isset($titles[$current_page]) ? $titles[$current_page] : '';
    ?>
    
    <title> <?php echo $title ?> </title>
</head>

<body class="animsition">
    <!-- Header -->
    <header
        class=" <?php if ($current_page == 'product' || $current_page == 'cart' || $current_page == 'productDetail') echo 'header-v4'; ?> ">
        <!-- Header desktop -->
        <div class="container-menu-desktop">
            <!-- Topbar -->
            <div class="top-bar">
                <div class="content-topbar flex-sb-m h-full container">
                    <div class="left-top-bar">
                        Free ship &nbsp;
                        <i class="fas fa-shipping-fast"></i>
                        &nbsp; cho đơn hàng trên 500.000 đ
                    </div>

                    <?php // check SESSION
                    if (isset($_SESSION['user'])) {
                        extract($_SESSION['user']); ?>

                    <div class="right-top-bar flex-w h-full ml-auto">
                        <a href="index.php?ac=signout" class="flex-c-m trans-04 p-lr-25">
                        Signout &nbsp;
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>

                    <div class="right-top-bar flex-w h-full">
                        <a href="index.php?ac=userdetail" class="flex-c-m trans-04 p-lr-25" style="color: pink;">
                            <?= $user_name ?> &nbsp;
                            <i class="fa fa-heart" style="color:red"></i>
                        </a>
                    </div>

                    <?php } else { ?>

                    <div class="right-top-bar flex-w h-full">
                        <a href="index.php?ac=signin" class="flex-c-m trans-04 p-lr-25">
                            Signin &nbsp;
                            <i class="fa fa-power-off"></i>
                        </a>
                    </div>

                    <?php } ?>

                </div>
            </div>

            <!-- Navbar -->
            <div
                class="wrap-menu-desktop <?php if ($current_page == 'product' || $current_page == 'cart' || $current_page == 'productDetail') echo 'how-shadow1'; ?> ">
                <nav class="limiter-menu-desktop container">

                    <!-- Logo desktop -->
                    <a href="index.php" class="logo">
                        <img src="images/icons/logo-01.png" alt="IMG-LOGO">
                    </a>

                    <!-- Menu desktop -->
                    <div class="menu-desktop">
                        <ul class="main-menu">
                            <li class=" <?php if ($current_page == 'index') echo 'active-menu'; ?> ">
                                <a href="index.php">Home</a>
                            </li>

                            <li class=" <?php if ($current_page == 'cart') echo 'active-menu'; ?> ">
                                <a href="index.php?ac=cart">Cart</a>
                            </li>

                            <li class="label1 <?php if ($current_page == 'product') echo 'active-menu'; ?> "
                                data-label1="sale">
                                <a href="index.php?ac=product">Shop</a>
                            </li>

                            <li class=" <?php if ($current_page == 'blog') echo 'active-menu'; ?> ">
                                <a href="index.php?ac=blog">Blog</a>
                            </li>

                            <li class=" <?php if ($current_page == 'about') echo 'active-menu'; ?> ">
                                <a href="index.php?ac=about">About</a>
                            </li>

                            <li class=" <?php if ($current_page == 'contact') echo 'active-menu'; ?> ">
                                <a href="index.php?ac=contact">Contact</a>
                            </li>

                            <li class=" <?php if ($current_page == 'to_order') echo 'active-menu'; ?> ">
                                <a href="index.php?ac=to_order">Order</a>
                            </li>

                            <li class=" <?php if ($current_page == 'to_bill') echo 'active-menu'; ?> ">
                                <a href="index.php?ac=to_bill">Bill</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Icon header -->
                    <div class="wrap-icon-header flex-w flex-r-m">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
                            data-notify="<?php 
                                //$_SESSION['sum_quantity_no_login']
                                if(isset($_SESSION['user'])) {
                                    if(isset($_SESSION['sum_product_cart'])) {
                                        echo $_SESSION['sum_product_cart'];
                                    }
                                    else {
                                        echo "0";
                                    }
                                }
                                else {
                                    if(isset($_SESSION['sum_quantity_no_login'])) {
                                        echo $_SESSION['sum_quantity_no_login'];
                                    }
                                    else {
                                        echo "0";
                                    }
                                }
                                 ?>">
                            <i class="zmdi zmdi-shopping-cart"></i>
                            <!-- document.getElementById('cart-number').innerText = '".$total."'; -->
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header Mobile -->
        <div class="wrap-header-mobile">
            <!-- Logo moblie -->
            <div class="logo-mobile">
                <a href="../index.php"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
            </div>

            <!-- Icon header -->
            <div class="wrap-icon-header flex-w flex-r-m m-r-15">
                <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
                data-notify="<?php 
                                if(isset($_SESSION['user'])) {
                                    if(isset($_SESSION['sum_product_cart'])) {
                                        echo $_SESSION['sum_product_cart'];
                                    }
                                    else {
                                        echo "0";
                                    }
                                }
                                else {
                                    if(isset($_SESSION['sum_quantity_no_login'])) {
                                        echo $_SESSION['sum_quantity_no_login'];
                                    }
                                    else {
                                        echo "0";
                                    }
                                }
                                 ?>">
                    <i class="zmdi zmdi-shopping-cart"></i>
                </div>
            </div>

            <!-- Button show menu -->
            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>
        </div>


        <!-- Menu Mobile -->
        <div class="menu-mobile">
            <ul class="topbar-mobile">
                <li>
                    <div class="left-top-bar">
                        Free ship cho đơn hàng trên 200.000đ
                    </div>
                </li>

                <li>
                    <div class="right-top-bar flex-w h-full">
                        <a href="index.php?ac=login" class="flex-c-m p-lr-10 trans-04">
                            Đăng nhập
                        </a>
                    </div>
                </li>
            </ul>

            <ul class="main-menu-m">
                <li>
                    <a href="index.php">Home</a>
                </li>

                <li>
                    <a href="product.php" class="label1 rs1" data-label1="hot">Shop</a>
                </li>

                <li>
                    <a href="shoping-cart.php">Cart</a>
                </li>

                <li>
                    <a href="blog.php">Blog</a>
                </li>

                <li>
                    <a href="about.php">About</a>
                </li>

                <li>
                    <a href="contact.php">Contact</a>
                </li>
            </ul>
        </div>
    </header>