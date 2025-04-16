<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>

    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../css/admin/style.css">
    <link rel="stylesheet" type="text/css" href="../css/admin/management.css">
</head>

<body>
    <div class="page-wrapper chiller-theme toggled">
        <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
            <i class="fas fa-bars"></i>
        </a>
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <div class="sidebar-brand">
                    <a href="index.php">
                        <i class="fas fa-user-cog"></i>
                        &nbsp; administrator
                    </a>

                    <div id="close-sidebar">
                        <i class="fas fa-times"></i>
                    </div>
                </div>

                <div class="sidebar-header">
                    <div class="user-pic">
                        <img class="img-responsive img-rounded" src="../images/tran-hao-nam.jpg" alt="User picture">
                    </div>
                    
                    <div class="user-info">

                        <?php if (isset($_SESSION['admin'])) {
                            extract($_SESSION['admin']); ?>

                        <span class="user-name">
                            <strong>
                                <?= $user_name ?>&nbsp;
                                <i class="fa fa-heart" style="color:red"></i>
                            </strong>
                        </span>

                        <?php } ?>

                        <span class="user-role">Admin</span>

                        <span class="user-status">
                            <i class="fa fa-circle"></i>
                            <span>Online</span>
                        </span>
                    </div>
                </div>

                <!-- sidebar-header  -->
                <div class="sidebar-search">
                    <div>
                        <div class="input-group">
                            <input type="text" class="form-control search-menu" placeholder="Search...">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- sidebar-search  -->
                <div class="sidebar-menu">
                    <ul>
                        <li>
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                                <span>Home</span>
                            </a>
                        </li>

                        <li class="header-menu">
                            <span>General</span>
                        </li>

                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                                <span class="badge badge-pill badge-warning">New</span>
                            </a>

                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="index.php?ac=account">Accounts Management</a>
                                    </li>

                                    <li>
                                        <a href="index.php?ac=product">Product Management</a>
                                    </li>
                                    <li>
                                        <a href="index.php?ac=category">Category Management</a>
                                    </li>
                                    <li>
                                        <a href="index.php?ac=bill">Bill Management</a>
                                    </li>
                                    <li>
                                        <a href="index.php?ac=order">Order Management</a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fas fa-chart-line"></i>
                                <span>Statistical</span>
                                <span class="badge badge-pill badge-primary">Beta</span>
                            </a>

                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="index.php?ac=topcustomer">Customer Statistic</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>

            <!-- sidebar-content -->
            <div class="sidebar-footer">
                <a href="index.php?ac=signout">
                    <i class="fas fa-sign-out-alt"></i>
                    &nbsp; Sign out
                    <span class="badge-sonar"></span>
                </a>
            </div>
        </nav>