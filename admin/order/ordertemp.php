<?php 
    function getOrderFromDateToDate($fromDate, $toDate) {
        $sql = "SELECT * FROM `order` WHERE order_created_date BETWEEN '$fromDate' AND '$toDate'";
        return pdo_query($sql);
    }
    function getOrderTotalFromOrderDetail($orderId) {
        $sql = "SELECT SUM(quantity*price) as total FROM orderdetail WHERE order_id = $orderId";
        return pdo_query_value($sql);
    }
    function getStatusNameFromStatusId($statusId) {
        $sql = "SELECT status_name FROM status WHERE status_id = $statusId";
        return pdo_query_value($sql);
    }
    function getOrderDetailFromOrderId($orderId) {
        $sql = "SELECT * FROM orderdetail WHERE order_id = $orderId";
        return pdo_query($sql);
    }
    function getOrderStatusAndUpdateByOne($orderId) {
        $sql = "SELECT status_id FROM `order` WHERE order_id = $orderId";
        $statusId = pdo_query_value($sql);
        $statusId = intval($statusId) + 1;
        $sql = "UPDATE `order` SET status_id = $statusId WHERE order_id = $orderId";
        pdo_execute($sql);
    }
    function getOrderStatusAndMinusByOne($orderId) {
        $sql = "SELECT status_id FROM `order` WHERE order_id = $orderId";
        $statusId = pdo_query_value($sql);
        $statusId = intval($statusId) - 1;
        $sql = "UPDATE `order` SET status_id = $statusId WHERE order_id = $orderId";
        pdo_execute($sql);
    }
    function huydon($orderId) {
        $sql = "UPDATE `order` SET status_id = 5 WHERE order_id = $orderId";
        pdo_execute($sql);
    }
    function getAllStatus() {
        $sql = "SELECT * FROM status";
        return pdo_query($sql);
    }

?>