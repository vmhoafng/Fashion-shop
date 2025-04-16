<?php
ob_start();
session_start();

// check SESSION
if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit();
}


include "header.php";
include "../model/pdo.php";
include "../model/product.php";
include "../model/account.php";
include "statistical/tempmodel.php";
include "category/categoryTempModel.php";
include "bill/billtempmodel.php";
include "order/ordertemp.php";



// Controller
if (isset($_GET['ac']) && $_GET['ac'] != "") {
    $ac = $_GET['ac'];

    switch ($ac) {
        case 'billdetail':
            include 'bill/detail.php';
            break;
        case 'bill':
            include 'bill/list.php';
            break;
        case 'order':
            include 'order/list.php';
            break;
        case 'orderdetail':
            include 'order/detail.php';
            break;
        case 'product':
            $action = isset($_GET['act']) ? $_GET['act'] : 'list';

            if ($action == 'add') {
                include 'product/add.php';
            } else if ($action == 'edit') {
                include 'product/edit.php';
            } else if ($action == 'delete') {
                include 'product/delete.php';
            } else {
                include 'product/list.php';
            }
            break;

        case 'orderstatistic':
            include 'statistical/orderstatictis.php';
            break;

        case 'orderdetailstatistic':
            include 'statistical/orderdetailstatictis.php';
            break;

        case 'topcustomer':
            include 'statistical/customerstatictis.php';
            break;

        case 'account':
            $action = isset($_GET['act']) ? $_GET['act'] : 'list';

            if ($action == 'add') {
                include 'account/add.php';
            } else if ($action == 'edit') {
                include 'account/edit.php';
            } else if ($action == 'lock' || $action == 'unlock') {
                include 'account/delete.php';
            } else {
                include 'account/list.php';
            }
            break;

        case 'category':
            $action = isset($_GET['act']) ? $_GET['act'] : 'list';

            if ($action == 'add') {
                include 'category/add.php';
            } else if ($action == 'edit') {
                include 'category/edit.php';
            } else if ($action == 'delete') {
                include 'category/delete.php';
            } else {
                include 'category/list.php';
            }
            break;

        case 'signout':
            unset($_SESSION['admin']); // Xóa session 'admin'
            header("Location: ../index.php?ac=signin");
            exit();
            break;

        default:
            include "home.php";
    }
} else {
    include "home.php";
    include "footer.php";
}

if(isset($_GET['ac']) && $_GET['ac'] !== 'billdetail'){
    include "footer.php";
}


ob_end_flush();
?>
