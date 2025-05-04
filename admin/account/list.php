<?php
// Xác định trang hiện tại
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

if (isset($_POST["input"])) {
    $search = $_POST["input"];
    // Số lượng bản ghi trên mỗi trang
    $records_per_page = 8;
    // Tính tổng số bản ghi
    $total_records = count(select_all_user_search($search));
    // Tính tổng số trang
    $total_pages = ceil($total_records / $records_per_page);
    // Tính vị trí bắt đầu của bản ghi trên trang hiện tại
    $start_from = ($page - 1) * $records_per_page;

    $result = select_all_user_search_paganation($start_from, $records_per_page, $search);
} else {
    // Số lượng bản ghi trên mỗi trang
    $records_per_page = 8;
    // Tính tổng số bản ghi
    $total_records = count(select_all_user());
    // Tính tổng số trang
    $total_pages = ceil($total_records / $records_per_page);
    // Tính vị trí bắt đầu của bản ghi trên trang hiện tại
    $start_from = ($page - 1) * $records_per_page;

    $result = select_all_user_paganation($start_from, $records_per_page);
}
?>

<main class="page-content">
    <div class="container-fluid">
        <div class="title-management">
            <h3>Accounts Management</h3>
            <a href="index.php?ac=account&act=add" class="btn all-btn-management btn-success">
                <i class="fa fa-user-plus"></i> Create a new account
            </a>
        </div>
        <hr>
        <form method="POST" class="form-management row align-items-center">
            <div class="col-sm-3">
                <input type="text" class="form-control" placeholder="Search Accounts" id="live_search" name="input" autocomplete="off">
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary btn-block" type="submit">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
            <div class="col-sm-2">
                <a class="btn btn-secondary btn-block" href="index.php?ac=account">
                    <i class="fa fa-sync-alt"></i> Reload
                </a>
            </div>
        </form>
        <div class="table-responsive mt-4">
            <table class="table table-hover">
                <thead>
                    <tr class="table-header">
                        <th scope="col">ID</th>
                        <th scope="col">Email</th>
                        <th scope="col">Password</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Role</th>
                        <th scope="col">Status</th>
                        <th scope="col">Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($result)) {
                        foreach ($result as $row) { ?>
                            <tr <?= $row['user_account_status'] == 0 ? 'class="table-danger"' : ''; ?>>
                                <td><?= htmlspecialchars($row['user_id']); ?></td>
                                <td><?= htmlspecialchars($row['user_email']); ?></td>
                                <td><?= htmlspecialchars($row['user_password']); ?></td>
                                <td><?= htmlspecialchars($row['user_phoneNumber']); ?></td>
                                <td><?= htmlspecialchars($row['user_name']); ?></td>
                                <td><?= htmlspecialchars($row['user_address']); ?></td>
                                <td><?= $row['role_id'] == 2 ? 'Admin' : 'User'; ?></td>
                                <td><?= $row['user_account_status'] == 0 ? 'Locked' : 'Online'; ?></td>
                                <td>
                                    <a href="index.php?ac=account&act=edit&id=<?= $row['user_id']; ?>" class="btn btn-sm btn-warning">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a href="index.php?ac=account&act=lock&id=<?= $row['user_id']; ?>" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <?php if ($row['user_account_status'] == 0) { ?>
                                        <a href="index.php?ac=account&act=unlock&id=<?= $row['user_id']; ?>" class="btn btn-sm btn-secondary">
                                            <i class="fa fa-unlock"></i>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>
        <div class="mt-5">
            <ul class="pagination justify-content-center">
                <?php
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $link = "index.php?ac=account&page=$i";
                        echo "<li class='page-item'><a class='page-link' href='$link'>$i</a></li>";
                    }
                ?>
            </ul>
        </div>
    </div>
</main>