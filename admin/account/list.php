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

            <form method="POST">
                <div class="input-group" style="margin-left: 80%;">
                    <input type="text" class="form-control" placeholder="Search" id="live_search" name="input"
                        autocomplete="off">

                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary input-group-text" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                    <div class="input-group-append">
                        <a class="btn btn-secondary input-group-text" href="index.php?ac=account">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </div>
            </form>

            <!-- Test search without click use JS -->
            <!-- <script>
            $(document).ready(function() {
                $("#live_search").keyup(function() {

                    var input = $(this).val();

                    if (input != "") {
                        $.ajax({
                            url: "/admin/account/list.php", // Gửi yêu cầu tới chính file PHP hiện tại
                            method: "POST",
                            data: {
                                input: input
                            },
                            success: function(response) {
                                // Xử lý kết quả trả về nếu cần
                                // alert(response);
                            },
                            error: function(xhr, status, error) {
                                // Xử lý lỗi nếu cần
                            }
                        });
                    }
                });
            });
            </script> -->

            <a href="index.php?ac=account&act=add" class="btn all-btn-management btn-success">
                <i class="fas fa-user-plus"></i> &nbsp; Create a new account
            </a>

        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
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

                    <tr <?php echo $row['user_account_status'] == 0 ? 'class="table-danger"' : ''; ?>>
                        <th scope="row">
                            <?= $row['user_id']; ?>
                        </th>

                        <td>
                            <?= $row['user_email']; ?>
                        </td>

                        <td>
                            <?= $row['user_password']; ?>
                        </td>

                        <td>
                            <?= $row['user_phoneNumber']; ?>
                        </td>

                        <td>
                            <?= $row['user_name']; ?>
                        </td>

                        <td>
                            <?= $row['user_address']; ?>
                        </td>

                        <td>
                            <?php echo $row['role_id'] == 2 ? 'Admin' : 'User'; ?>
                        </td>

                        <td>
                            <?php echo $row['user_account_status'] == 0 ? 'Lock' : 'Online'; ?>
                        </td>

                        <td>
                            <a href="index.php?ac=account&act=edit&id=<?= $row['user_id']; ?>"
                                class="btn btn-sm btn-outline-info">
                                <i class="fa fa-pen"></i>&nbsp;Update
                            </a>&nbsp;&nbsp;

                            <a href="index.php?ac=account&act=lock&id=<?= $row['user_id']; ?>"
                                class="btn btn-sm btn-outline-danger">
                                <i class="fa fa-trash"></i>&nbsp;Delete
                            </a>

                            <?php if ($row['user_account_status'] == 0) { ?>

                            <a href="index.php?ac=account&act=unlock&id=<?= $row['user_id']; ?>"
                                class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-undo"></i>&nbsp;Unlock
                            </a>

                            <?php } ?>

                        </td>
                    </tr>

                    <?php }
                    } ?>

                </tbody>
            </table>
        </div>

        <nav>
            <ul class="pagination justify-content-center">
                <?php
                // Hiển thị các nút phân trang
                for ($i = 1; $i <= $total_pages; $i++) { ?>

                <li class='page-item'>
                    <a class='page-link' href='index.php?ac=account&page=<?= $i ?>'> <?= $i ?> </a>
                </li>

                <?php } ?>
            </ul>
        </nav>