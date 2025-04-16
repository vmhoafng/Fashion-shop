<?php
    function add_new_bill($user_id, $created_date, $address, $payment) {
        $sql = "INSERT INTO bill (user_id, created_date, address_order, payment) VALUES ('$user_id', '$created_date', '$address', '$payment')";
        return pdo_execute_lastInsertId($sql);
    }

    function get_bill($bill_id) {
        $sql = "SELECT * FROM bill WHERE bill_id = $bill_id";
        return pdo_query_one($sql);
    }

    function get_all_bill($user_id) {
        $sql = "SELECT * FROM bill WHERE user_id = $user_id ORDER BY bill_id DESC";
        return pdo_query($sql);
    }

    function get_bill_info($bill_id, $user_id) {
        $sql = "SELECT * FROM bill WHERE bill_id = $bill_id AND user_id = $user_id";
        return pdo_query($sql);
    }

