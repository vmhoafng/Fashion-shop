<?php
// order_id	product_id	quantity	price	total
    function add_new_order_detail($order_id, $product_id, $quantity, $price, $total) {
        $sql = "INSERT INTO orderdetail(order_id, product_id, quantity, price, total) VALUES ('$order_id', '$product_id', '$quantity', '$price', '$total')";
        pdo_execute($sql);
    }

    function get_order($order_id) {
        $sql = "SELECT * FROM orderdetail WHERE order_id = $order_id";
        return pdo_query($sql);
    }