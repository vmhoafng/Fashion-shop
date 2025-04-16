<?php
// bill_id  product_id	quantity	price	total
    function add_new_bill_detail($bill_id, $product_id, $quantity, $price, $total) {
        $sql = "INSERT INTO billdetail(bill_id, product_id, quantity, price, total) VALUES ('$bill_id', '$product_id', '$quantity', '$price', '$total')";
        pdo_execute($sql);
    }

    // lấy chi tiết 1 bill detail theo id
    function get_info_one_bill($bill_id) {
        $sql = "SELECT * FROM billdetail WHERE bill_id = $bill_id";
        return pdo_query($sql);
    }