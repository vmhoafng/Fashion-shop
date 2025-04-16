<?php
    function get_list_province_and_city() {
        $sql = "SELECT * FROM devvn_tinhthanhpho";
        return pdo_query($sql);
    }

    function get_list_district($matp) {
        $sql = "SELECT * FROM devvn_quanhuyen WHERE matp = $matp";
        return pdo_query($sql);
    }

    function get_list_ward($maqh) {
        $sql = "SELECT * FROM devvn_xaphuongthitran WHERE maqh = $maqh";
        return pdo_query($sql);
    }

    // lấy 1 dòng thông tin cart theo mã user
    function get_info_user_cart($user_id) {
        $sql = "SELECT * FROM cart WHERE user_id = $user_id";
        return pdo_query_one($sql);
    }

    // thêm mới cart
    function insert_cart($user_id){
        $sql = "INSERT INTO cart (user_id) VALUES ('$user_id')";
        return pdo_execute_lastInsertId($sql);
    }

    // thông tin province
    function get_province($matp) {
        $sql = "SELECT * FROM devvn_tinhthanhpho WHERE matp = $matp";
        return pdo_query_one($sql);
    }

    // thông tin district
    function get_district($maqh) {
        $sql = "SELECT * FROM devvn_quanhuyen WHERE matp = $maqh";
        return pdo_query_one($sql);
    }

    // thông tin ward
    function get_ward($xaid) {
        $sql = "SELECT * FROM devvn_xaphuongthitran WHERE maqh = $xaid";
        return pdo_query_one($sql);
    }

    function del_cart($card_id) {
        $sql = "DELETE FROM cart WHERE card_id = $card_id";
        return pdo_execute($sql);
    }

    // xóa
