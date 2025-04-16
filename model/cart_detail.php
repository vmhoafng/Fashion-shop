<?php

    // lấy thông tin chi tiết hóa đơn theo mã sp
    function get_info_product_cart_detail($product_id, $id_cart) {
        $sql = "SELECT * FROM cartdetail WHERE product_id = $product_id AND cart_id = $id_cart";
        return pdo_query_one($sql);
    }

    // update số lượng sản phẩm trong cart detail
    function update_quantity($quantity, $product_id, $id_cart) {
        $sql = "UPDATE cartdetail SET quantity = $quantity WHERE product_id = $product_id AND cart_id = $id_cart";
        return pdo_execute($sql);
    }

    // thêm mới 1 cart detail
    function insert_cartdetail($cart_id, $product_id, $quantity) {
        $sql = "INSERT INTO cartdetail (cart_id, product_id, quantity) VALUES ('$cart_id', '$product_id', '$quantity')";
        return pdo_execute($sql);
    }

    // tính số lượng sản phẩm có trong giỏ hàng
    function get_quantity_product($user_id) {
        $sql = "SELECT SUM(quantity) FROM cartdetail WHERE cart_id = (SELECT cart_id FROM cart WHERE user_id = $user_id)";
        return pdo_query_value($sql);
    }

    // lấy danh sách các chi tiết hóa đơn theo mã giỏ hàng của user
    function get_list_code_product($user_id) {
        $sql = "SELECT * FROM cartdetail WHERE cart_id = (SELECT cart_id FROM cart WHERE user_id = $user_id)";
        return pdo_query($sql);
    }

    function get_item_cartdetail($user_id, $product_id) {
        $sql = "SELECT * FROM cartdetail WHERE cart_id = (SELECT cart_id FROM cart WHERE user_id = $user_id) AND product_id = $product_id";
        return pdo_query_one($sql);
    }

    function delete_cart_detail($card_id) {
        $sql = "DELETE FROM cartdetail WHERE cart_id = $card_id";
        return pdo_execute($sql);
    }

    function delete_item_cart($user_id, $product_id) {
        $sql = "DELETE FROM cartdetail WHERE cart_id = (SELECT cart_id FROM cart WHERE user_id = $user_id) AND product_id = $product_id";
        return pdo_execute($sql);
    }

    // update 
    function update_item_cart($product_id, $cart_id, $quantity) {
        $sql = "UPDATE cartdetail SET quantity = $quantity WHERE product_id = $product_id AND cart_id = $cart_id";
        return pdo_execute($sql);
    }