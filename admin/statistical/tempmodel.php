<?php 
    function getAllOrder(){
        $sql="SELECT * FROM `order` WHERE 1";
        return pdo_query($sql);
    }
    function totalRevenue() {
        $sql = "SELECT SUM(total) as total FROM `order` WHERE status_id != 5"; // Loại trừ đơn hàng đã hủy
        return pdo_query_value($sql);
    }
    function getOrderDetailByOrderId($id){
        echo '<script>console.log("order id '.$id.'")</script>';
        $sql="SELECT * FROM `orderdetail` WHERE  order_id=".$id;
        return pdo_query($sql);
    }
    function getStatusNameByStatusId($id){
        $sql="select status_name from status where status_id=".$id;
        return pdo_query_value($sql);
    }
    function getUserDetailByUserId($id){
        $sql="select * from user where user_id=".$id;
        return pdo_query_one($sql);
    }
    function getProductNameByProductId($id){
        $sql="select product_name from product where product_id=".$id;
        return pdo_query_value($sql);
    }
    function getProductPriceByProductId($id){
        $sql="select product_price from product where product_id=".$id;
        return pdo_query_value($sql);
    }
    function getProductImageByProductId($id){
        $sql="select product_image from product where product_id=".$id;
        return pdo_query_value($sql);
    }
    function top5MostProfitUserFromdateToDate($fromDate,$toDate){
        $sql = "SELECT user_id, SUM(total) as total 
            FROM `order` 
            WHERE order_created_date BETWEEN '".$fromDate."' AND '".$toDate."'
            AND status_id != 5  -- Loại trừ đơn hàng đã hủy
            GROUP BY user_id 
            ORDER BY total DESC 
            LIMIT 5";
        return pdo_query($sql);
    }
    function getOrderByUserId($userId) {
        $sql = "SELECT * FROM `order` WHERE user_id = $userId AND status_id != 5";  // Loại trừ đơn hàng đã hủy (status_id = 5)
        return pdo_query($sql);
    }
    
    function totalRevenueOfOrders($orders){
        $totalRevenue = 0;
    foreach ($orders as $order) {
        // Chỉ tính doanh thu của đơn hàng có status_id khác 5 (không phải đã hủy)
        if ($order['status_id'] != 5) {
            $totalRevenue += $order['total'];
        }
    }
    return $totalRevenue;
    }
    function searchProductByName($name){
        $sql="SELECT * FROM product WHERE product_name LIKE '%".$name."%'";
        return pdo_query($sql);
    }
    function deleteProductByProductId($id){
        $sql="DELETE FROM product WHERE product_id=".$id;
        return pdo_execute($sql);
    }
    function isProductExistedInOrderDetail($id){
        $sql="SELECT * FROM orderdetail WHERE product_id=".$id;
        return pdo_query($sql);
    }
    function isProductExistedInOrderDetailAndCartDetail($id){
        $sql="SELECT * FROM orderdetail WHERE product_id=".$id;
        $sql2="SELECT * FROM cartdetail WHERE product_id=".$id;
        $result1=pdo_query($sql);
        $result2=pdo_query($sql2);
        return array_merge($result1,$result2);
    }
?>