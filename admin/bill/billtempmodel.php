<?php 
    function getAllBill() {
        $sql = "SELECT * FROM bill";
        return pdo_query($sql);
    }
    function getBillTotalFromBillDetail($bill_id){
        $sql = "SELECT SUM(total) as total FROM billdetail WHERE bill_id = $bill_id";
        return pdo_query_value($sql);
    }
    function getBillDetailFromBillId($bill_id){
        $sql = "SELECT * FROM billdetail WHERE bill_id = $bill_id";
        return pdo_query($sql);
    }
    function billFromDateToDate($fromDate, $toDate){
        $sql = "SELECT * FROM bill WHERE created_date BETWEEN '$fromDate' AND '$toDate'";
        return pdo_query($sql);
    }
?>