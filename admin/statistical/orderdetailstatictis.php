<?php 
if(isset($_GET['id'])){
    $orderDetails = getOrderDetailByOrderId($_GET['id']);
}

// Sắp xếp theo Total
if (isset($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc'])) {
    usort($orderDetails, function($a, $b) {
        $totalA = intval(getProductPriceByProductId($a['product_id'])) * $a['quantity'];
        $totalB = intval(getProductPriceByProductId($b['product_id'])) * $b['quantity'];
        return ($_GET['sort'] == 'asc') ? ($totalA - $totalB) : ($totalB - $totalA);
    });
}

$pageIndex = 1;
if(isset($_GET['page'])){
    $pageIndex = $_GET['page'];
}
$pageSize = 1;
$totalPage = ceil(count($orderDetails)/$pageSize);
$orderDetails = array_slice($orderDetails, ($pageIndex-1)*$pageSize, $pageSize);
?>

<main class="page-content">
    <div class="container-fluid">
        <h2>Order Detail</h2>
        <table class="table table-hover">
            <tr class="table-header">
                <th>Order ID</th>
                <th>Order Detail id</th>
                <th>Product Name</th>
                <th>Product Image</th>
                <th>Product Price</th>
                <th>Product Quantity</th>
                <th>
                    <a
                        href="index.php?ac=orderdetailstatistic&id=<?php echo $_GET['id']; ?>&page=<?php echo $pageIndex; ?>&sort=<?php echo (isset($_GET['sort']) && $_GET['sort'] == 'asc') ? 'desc' : 'asc'; ?>">
                        Total <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'asc') ? '↑' : '↓'; ?>
                    </a>
                </th>
            </tr>
            <?php 
                foreach($orderDetails as $orderDetail){
                    $product = getProductNameByProductId($orderDetail['product_id']);
                    $productPrice = getProductPriceByProductId($orderDetail['product_id']);
                    $productImage = getProductImageByProductId($orderDetail['product_id']);
            ?>
            <tr class="table-body">
                <td><?php echo $orderDetail['order_id']; ?></td>
                <td><?php echo $orderDetail['order_detail_id']; ?></td>
                <td><a
                        href="../index.php?ac=productDetail&id=<?php echo $orderDetail['product_id'] ?>"><?php echo $product; ?></a>
                </td>
                <td><img style="width:50px;height:50px"
                        src="data:image/jpeg;base64,<?php echo base64_encode(strval($productImage)); ?>"
                        alt="IMG-PRODUCT"></td>
                <td><?php echo $productPrice; ?></td>
                <td><?php echo $orderDetail['quantity']; ?></td>
                <td><?php echo intval($productPrice) * $orderDetail['quantity']; ?></td>
            </tr>
            <?php } ?>
        </table>
        <div class="mt-5">
            <ul class="pagination justify-content-center">
                <?php
                    echo '<div id="paginationForm" class="row m-l-5">';
                    for($i = 1; $i <= $totalPage; $i++){
                        echo '<li class="page-item"><a href="index.php?ac=orderdetailstatistic&id='.$_GET['id'].'&page='.$i.'&sort='.($_GET['sort'] ?? '').'" class="page-link" name="page">'.$i.'</a></li>';
                    }
                    echo '</div>';
                ?>
            </ul>
        </div>
    </div>
</main>