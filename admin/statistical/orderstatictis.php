<?php 
    if(isset($_GET['user_id'])){
       $orders=getOrderByUserId($_GET['user_id']);
       $totalRevenue=totalRevenueOfOrders($orders);
    }
    // $orders=getAllOrder();
    // $totalRevenue=totalRevenue();
    $pageIndex=1;
    if(isset($_GET['page'])){
        $pageIndex=$_GET['page'];
    }
    $pageSize=5;
    $totalPage=ceil(count($orders)/$pageSize);
    $orders=array_slice($orders,($pageIndex-1)*$pageSize,$pageSize);

?>
<main class="page-content">
    <div class="container-fluid">
    <a href="index.php?ac=topcustomer">Back</a>
        <div>
            <h2>Order statictis</h2>
            <h3>Total revenue: <?php echo $totalRevenue ?>$</h3>
        </div>
        <table class="table">
            <tr class="table-header">
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Estimate shipment Date</th>
                <th>Customer Name</th>
                <th>Customer Phone</th>
                <th>Customer Address</th>
                <th>Order Total</th>
                <th>Order Status</th>
                <th>Action</th>
            </tr>
            <?php foreach($orders as $order) { 
                    $user=getUserDetailByUserId($order['user_id']);
                ?>
                <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['order_created_date']; ?></td>
                    <td><?php echo $order['estimate_ship_date']; ?></td>
                    <td><?php echo $user['user_name']; ?></td>
                    <td><?php echo $user['user_phoneNumber']; ?></td>
                    <td><?php echo $user['user_address']; ?></td>
                    <td><?php echo $order['total']; ?></td>
                    <td><?php echo strval(getStatusNameByStatusId($order['status_id'])); ?></td>
                    <td><a href="index.php?ac=orderdetailstatistic&id=<?php echo $order['order_id']; ?>">Order Detail</a></td>
                </tr>
            <?php } ?>
        </table>
        <div class="mt-5">
            <ul class="pagination justify-content-center">
                <?php
                    echo '<div id="paginationForm" class="row m-l-5">';
                            for($i = 1; $i <= $totalPage; $i++){
                                echo '<li class="page-item"><a href="index.php?ac=orderstatistic&user_id='.$_GET['user_id'].'&page='.$i.'" class=" page-link" name="page">'.$i.'</a></li>';
                               
                            }
                        
                    echo '</div>';
                ?>
            </ul>
        </div>

    </div>

</main>