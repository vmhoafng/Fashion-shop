<?php 
if(isset( $_POST['orderId']) ) {
    $orderId = $_POST['orderId'];
    getOrderStatusAndUpdateByOne($orderId);
}
if(isset( $_POST['huydon'])) {
    $orderId = $_POST['huydon'];
    huydon($orderId);
}
if(isset($_POST['undo'])) {
    $orderId = $_POST['undo'];
    getOrderStatusAndMinusByOne($orderId);
}

$status=getAllStatus();
$fromDate = $_POST['fromDate'] ?? date('Y-m-d', strtotime('-1 month'));
$toDate = $_POST['toDate'] ?? date('Y-m-d');
if(isset($_GET['fromdate']) && isset($_GET['todate'])){
    $fromDate = $_GET['fromdate'];
    $toDate = $_GET['todate'];
}
if(isset($_SESSION['statusName'])) {
    $statusName = $_SESSION['statusName'];
}
else{
    $statusName = "All";
}
$orders=getOrderFromDateToDate($fromDate,$toDate);
if(isset($_POST['orderStatus'])) {
    if($_POST['orderStatus']!=0){
        $statusName=getStatusNameByStatusId($_POST['orderStatus']);
    }
    else{
        $statusName="All";
    }
    $_SESSION['statusName'] = $statusName;
    if($_POST['orderStatus'] == 0) {
        $orders = getOrderFromDateToDate($fromDate,$toDate);
    }
    else{
        $statusId = $_POST['orderStatus'];
        $orders = getOrderFromDateToDate($fromDate,$toDate);
        $orders = array_filter($orders, function($order) use ($statusId) {
            return $order['status_id'] == $statusId;
        });
    }
}

$pageIndex = 1;
$pageSize=5;
if(isset($_GET['page'])){
    $pageIndex=$_GET['page'];
}
$totalPage=ceil(count($orders)/$pageSize);
$orders=array_slice($orders,($pageIndex-1)*$pageSize,$pageSize);


?>
<main class="page-content">
    <div class="container-fluid">
        <h2>Order management</h2>
        <div class="row ml-1 mt-3">
                <form class="row ml-1" method="post">
                    <h4 class="mr-1">Order Date filter From date</h4> <input class="datepicker mr-3" type="date" id="fromDate" name="fromDate" value=<?php echo $fromDate?> >
                    <h4 class="mr-1">To date</h4> <input type="date" id="toDate" name="toDate" value=<?php echo $toDate?>>
                    <h4 class="col-12 pl-0">Order status</h4>
                    <select class="form-control col-4" id="orderStatus" name="orderStatus" >
                        <option value="0">All</option>
                        <?php foreach($status as $st) { 
                            $selected = ($st['status_name'] == $statusName) ? 'selected' : '';
                            ?>
                            <option value="<?php echo $st['status_id']; ?>" <?php echo $selected; ?>><?php echo $st['status_name']; ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit" class="btn btn-primary ml-3">Filter</button>
                </form>
        </div>
        

            <table class="table table-hover">
                <tr class="table-header">
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Order Date</th>
                    <th>Order shipment date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Detail</th>
                    <th>Process</th>
                    <th>Undo</th>
                    <th>Cancel</th>
                </tr>
                <?php foreach($orders as $order) { ?>
                <tr>
                    
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['user_id']; ?></td>
                    <td><?php echo $order['order_created_date']; ?></td>
                    <td><?php echo $order['estimate_ship_date'];  ?></td>
                    <td><?php echo strval(getOrderTotalFromOrderDetail($order['order_id'])); ?></td>
                    <td><?php echo strval(getStatusNameByStatusId($order['status_id']));?></td>
                    <td><a href="index.php?ac=orderdetail&id=<?php echo $order['order_id']; ?>" class="btn btn-danger">Detail</a></td>
                    <td>
                    <form method="post">
                        <input type="hidden" name="orderId" value="<?php echo $order['order_id']; ?>">
                        <?php if($order['status_id']<4) {?>
                        <button type="submit" name="submit" class="btn btn-danger">Process</button>
                        <?php }?>
                        <?php if($order['status_id']>=4) {?>
                        <button type="submit" name="submit" class="btn btn-danger" disabled>Process</button>
                        <?php }?>
                    </form></td>
                    <td>
                    <form method="post">
                        <input type="hidden" name="undo" value="<?php echo $order['order_id']; ?>">
                        <?php if($order['status_id']>1) {?>
                        <button type="submit" name="submit" class="btn btn-danger">Undo</button>
                        <?php }?>
                        <?php if($order['status_id']<=1) {?>
                        <button type="submit" name="submit" class="btn btn-danger" disabled>Undo</button>
                        <?php }?>
                    </form></td>
                    <td>
                    <form method="post">
                        <input type="hidden" name="huydon" value="<?php echo $order['order_id']; ?>">
                        <button type="submit" name="submit" class="btn btn-danger">Cancel</button>
                    </form>
                    </td>
                    
                </tr>
                <?php } ?>
            </table>
            <div class="mt-5">
            <ul class="pagination justify-content-center">
                <?php
                    echo '<div id="paginationForm" class="row m-l-5">';
                       
                            for($i = 1; $i <= $totalPage; $i++){
                                    echo '<li class="page-item"><a href="index.php?ac=order&page='.$i.'&fromdate='.$fromDate.'&todate='.$toDate.'" class=" page-link" name="page">'.$i.'</a></li>';                           
                            }
                    
                    echo '</div>';
                ?>
            </ul>
        </div>
    </div>
        
</main>
