<?php
    function add_new_order($user_id, $created_date, $ship_date, $total, $address, $payment) {
        $sql = "INSERT INTO `order`(user_id, status_id, order_created_date, estimate_ship_date, total, address_order, payment) VALUES ('$user_id', 1, '$created_date', '$ship_date', '$total', '$address', '$payment')";
        return pdo_execute_lastInsertId($sql);
    }



    function get_all_order($user_id) {
        $sql = "SELECT * FROM `order` WHERE user_id = $user_id ORDER BY order_id DESC";
        return pdo_query($sql);
    }

    function get_one_order($order_id, $user_id) {
        $sql = "SELECT * FROM `order` WHERE order_id = $order_id AND user_id = $user_id";
        return pdo_query_one($sql);
    }