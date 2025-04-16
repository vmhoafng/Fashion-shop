<?php 
$fromDate = $_POST['fromDate'] ?? date('Y-m-d', strtotime('-1 month'));
$toDate = $_POST['toDate'] ?? date('Y-m-d');
if(isset($_GET['fromdate']) && isset($_GET['todate'])){
    $fromDate = $_GET['fromdate'];
    $toDate = $_GET['todate'];
}
$bills=billFromDateToDate($fromDate,$toDate);
$pageIndex = 1;
$pageSize=5;
if(isset($_GET['page'])){
    $pageIndex=$_GET['page'];
}
$totalPage=ceil(count($bills)/$pageSize);
$bills=array_slice($bills,($pageIndex-1)*$pageSize,$pageSize);
?>
<main class="page-content">
    <div class="container-fluid">
        <h2>Bill management</h2>
        <div class="row ml-1 mt-3">
            <form class="row ml-1" method="post">
                <h4 class="mr-1">From date</h4> <input class="datepicker mr-3" type="date" id="fromDate" name="fromDate" value=<?php echo $fromDate?> >
                <h4 class="mr-1">To date</h4> <input type="date" id="toDate" name="toDate" value=<?php echo $toDate?>>
                <button type="submit" class="btn btn-primary ml-3">Filter</button>
            </form>
        </div>
        <table class="table table-hover">
            <tr class="table-header">
                <th>Bill ID</th>
                <th>Customer ID</th>
                <th>Order Date</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php foreach($bills as $bill) { ?>
            <tr>
                
                <td><?php echo $bill['bill_id']; ?></td>
                <td><?php echo $bill['user_id']; ?></td>
                <td><?php echo $bill['created_date']; ?></td>
                <td><?php echo strval(getBillTotalFromBillDetail($bill['bill_id'])); ?></td>
                <td><a href="index.php?ac=billdetail&id=<?php echo $bill['bill_id']; ?>">Detail</a></td>
            </tr>
            <?php } ?>
        </table>
        <div class="mt-5">
            <ul class="pagination justify-content-center">
                <?php
                    echo '<div id="paginationForm" class="row m-l-5">';
                       
                            for($i = 1; $i <= $totalPage; $i++){
                                    echo '<li class="page-item"><a href="index.php?ac=bill&page='.$i.'&fromdate='.$fromDate.'&todate='.$toDate.'" class=" page-link" name="page">'.$i.'</a></li>';                           
                            }
                    
                    echo '</div>';
                ?>
            </ul>
        </div>
</main>