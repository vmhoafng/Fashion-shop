<?php
    function get_name_status($status_id) {
        $sql = "SELECT status_name FROM status WHERE status_id = $status_id";
        return pdo_query_value($sql);
    }