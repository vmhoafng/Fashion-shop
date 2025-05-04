<?php 
    $pageIndex = 1;
    $pageSize = 3;
    $searchTerm = "";
    $categories = getAllCategory();
    if (isset($_POST['search'])) {
        $search = $_POST['search'];
        $searchTerm = $search;
        $categories = searchCategoryByName($search);
    }
    if (isset($_GET['page'])) {
        $pageIndex = $_GET['page'];
    }
    $totalPage = ceil(count($categories) / $pageSize);
    $categories = array_slice($categories, ($pageIndex - 1) * $pageSize, $pageSize);
?>
<main class="page-content">
    <div class="container-fluid">
        <div class="title-management">
            <h3>Category Management</h3>
            <a href="index.php?ac=category&act=add" class="btn all-btn-management btn-success">
                <i class="fa fa-plus"></i> Add New Category
            </a>
        </div>
        <hr>
        <form method="POST" class="form-management row">
            <div class="col-sm-3">
                <input type="text" class="form-control" name="search" placeholder="Search Categories" value="<?= htmlspecialchars($searchTerm); ?>">
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary btn-block">Search</button>
            </div>
            <div class="col-sm-2">
                <a href="index.php?ac=category" class="btn btn-secondary btn-block">Reload</a>
            </div>
        </form>
        <table class="table table-hover mt-4">
            <thead>
                <tr class="table-header">
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category) { ?>
                    <tr>
                        <td><?= htmlspecialchars($category['category_id']); ?></td>
                        <td><?= htmlspecialchars($category['category_name']); ?></td>
                        <td>
                            <a href="index.php?ac=category&act=edit&id=<?= $category['category_id']; ?>" class="btn btn-sm btn-warning">
                                <i class="fa fa-pen"></i>
                            </a>
                            <a href="index.php?ac=category&act=delete&id=<?= $category['category_id']; ?>" class="btn btn-sm btn-danger">
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
                            $link = $searchTerm == "" 
                                ? "index.php?ac=category&page=$i" 
                                : "index.php?ac=category&page=$i&search=" . urlencode($searchTerm);
                            echo "<li class='page-item'><a href='$link' class='page-link'>$i</a></li>";
                        }
                    }
                ?>
            </ul>
        </div>
    </div>
</main>