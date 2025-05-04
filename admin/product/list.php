<?php
$pageSize = 3;
$pageIndex = 1;
$searchTerm = "";

if (isset($_GET['page'])) {
    $pageIndex = $_GET['page'];
}

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $products = searchProductByName($_GET['search']);
}

if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];
    $_GET['search'] = $_POST['search'];
    $products = searchProductByName($_POST['search']);
}

if (!isset($_GET['search']) && !isset($_POST['search'])) {
    $products = loadSanPham_OrderByProductId();
}

$totalPage = ceil(count($products) / $pageSize);
$products = array_slice($products, ($pageIndex - 1) * $pageSize, $pageSize);
?>

<main class="page-content">
    <div class="container-fluid">
        <div class="title-management">
            <h3>Product Management</h3>
            <a href="index.php?ac=product&act=add" class="btn all-btn-management btn-success">
                <i class="fa fa-plus"></i> Add New Product
            </a>
        </div>
        <hr>
        <form method="POST" class="form-management row align-items-center">
            <div class="col-sm-3">
                <input type="text" class="form-control" name="search" placeholder="Search Products" value="<?= htmlspecialchars($searchTerm); ?>">
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary btn-block">Search</button>
            </div>
            <div class="col-sm-2">
                <a href="index.php?ac=product" class="btn btn-secondary btn-block">Reload</a>
            </div>
        </form>
        <table class="table table-hover mt-4">
            <thead>
                <tr class="table-header">
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price ($)</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) { ?>
                    <tr>
                        <td><?= htmlspecialchars($product['product_id']); ?></td>
                        <td>
                            <a href="../index.php?ac=productDetail&id=<?= $product['product_id']; ?>">
                                <?= htmlspecialchars($product['product_name']); ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($product['product_price']); ?></td>
                        <td><?= htmlspecialchars($product['product_color']); ?></td>
                        <td><?= htmlspecialchars($product['product_size']); ?></td>
                        <td><?= htmlspecialchars(strval(getCategoryNameById($product['category_id']))); ?></td>
                        <td>
                            <img style="width:50px;height:50px" 
                                 src="data:image/jpeg;base64,<?= base64_encode($product['product_image']); ?>" 
                                 alt="IMG-PRODUCT">
                        </td>
                        <td><?= htmlspecialchars($product['product_description']); ?></td>
                        <td><?= $product['hidden'] == 0 ? "Visible" : "Hidden"; ?></td>
                        <td><?= htmlspecialchars($product['amount']); ?></td>
                        <td>
                            <a href="index.php?ac=product&act=edit&id=<?= $product['product_id']; ?>" class="btn btn-sm btn-warning">
                                <i class="fa fa-pen"></i>
                            </a>
                            <a href="index.php?ac=product&act=delete&id=<?= $product['product_id']; ?>" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="mt-5">
            <ul class="pagination justify-content-center">
                <?php
                    if ($totalPage > 1) {
                        for ($i = 1; $i <= $totalPage; $i++) {
                            $link = empty($searchTerm) 
                                ? "index.php?ac=product&page=$i" 
                                : "index.php?ac=product&page=$i&search=" . urlencode($searchTerm);
                            echo "<li class='page-item'><a href='$link' class='page-link'>$i</a></li>";
                        }
                    }
                ?>
            </ul>
        </div>
    </div>
</main>