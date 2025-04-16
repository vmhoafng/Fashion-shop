<?php 
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $orderDetails = pdo_query("SELECT * FROM orderdetail WHERE order_id = $id");
}
$pageIndex=1;
if(isset($_GET['page'])){
    $pageIndex=$_GET['page'];
}
$pageSize=1;
$totalPage=ceil(count($orderDetails)/$pageSize);
$orderDetails=array_slice($orderDetails,($pageIndex-1)*$pageSize,$pageSize);
?>
<main class="page-content">
    <div class="container-fluid">
        <h2>Order detail</h2>
        <button type="submit" onclick="window.location.href='index.php?ac=order' " class="btn btn-info btn-lg mx-auto d-block float-left mb-2">
            Back to order
        </button>
        <table class="table table-hover">
            <tr class="table-header">
                <th>Product ID</th>
                <th>Product name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
            <?php foreach($orderDetails as $orderDetail) { ?>
            <tr>
                <td><?php echo $orderDetail['product_id']; ?></td>
                <td><a href="../index.php?ac=productDetail&id=<?php echo $orderDetail['product_id'] ?>"><?php echo strval(getProductNameByProductId($orderDetail['product_id'])); ?></a></td>
                <td><?php echo $orderDetail['quantity']; ?></td>
                <td><?php echo $orderDetail['price']; ?></td>
                <td><?php echo $orderDetail['quantity']*$orderDetail['price']; ?></td>
            </tr>
            <?php } ?>
        </table>
        <div class="mt-5">
            <ul class="pagination justify-content-center">
                <?php
                    echo '<div id="paginationForm" class="row m-l-5">';
                            for($i = 1; $i <= $totalPage; $i++){
                                echo '<li class="page-item"><a href="index.php?ac=orderdetail&id='.$_GET['id'].'&page='.$i.'" class=" page-link" name="page">'.$i.'</a></li>';
                               
                            }
                        
                    echo '</div>';
                ?>
            </ul>
        </div>

    </div>
</main>
