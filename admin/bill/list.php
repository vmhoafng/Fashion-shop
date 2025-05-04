<?php
$fromDate = $_POST['fromDate'] ?? date('Y-m-d', strtotime('-1 month'));
$toDate = $_POST['toDate'] ?? date('Y-m-d');
if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
    $fromDate = $_GET['fromdate'];
    $toDate = $_GET['todate'];
}
$bills = billFromDateToDate($fromDate, $toDate);
$pageIndex = 1;
$pageSize = 5;
if (isset($_GET['page'])) {
    $pageIndex = $_GET['page'];
}
$totalPage = ceil(count($bills) / $pageSize);
$bills = array_slice($bills, ($pageIndex - 1) * $pageSize, $pageSize);
?>

<main class="page-content">
    <div class="container-fluid">
        <div class="title-management">
            <h3>Bill Management</h3>
        </div>
        <hr>
        <form method="POST" class="form-management row">
            <div class="col-sm-3">
                <label for="fromDate" class="form-label">From Date</label>
                <input type="date" class="form-control" id="fromDate" name="fromDate" value="<?= htmlspecialchars($fromDate); ?>">
            </div>
            <div class="col-sm-3">
                <label for="toDate" class="form-label">To Date</label>
                <input type="date" class="form-control" id="toDate" name="toDate" value="<?= htmlspecialchars($toDate); ?>">
            </div>
            <div class="col-sm-2 align-self-end">
                <button type="submit" class="btn btn-primary btn-block">Filter</button>
            </div>
        </form>
        <table class="table table-hover mt-4">
            <thead>
                <tr class="table-header">
                    <th>Bill ID</th>
                    <th>Customer ID</th>
                    <th>Order Date</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bills as $bill) { ?>
                    <tr>
                        <td><?= htmlspecialchars($bill['bill_id']); ?></td>
                        <td><?= htmlspecialchars($bill['user_id']); ?></td>
                        <td><?= htmlspecialchars($bill['created_date']); ?></td>
                        <td><?= htmlspecialchars(strval(getBillTotalFromBillDetail($bill['bill_id']))); ?></td>
                        <td>
                            <a href="index.php?ac=billdetail&id=<?= $bill['bill_id']; ?>" class="btn btn-sm btn-primary">
                                <i class="fa fa-eye"></i> Detail
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
                            $link = "index.php?ac=bill&page=$i&fromdate=" . urlencode($fromDate) . "&todate=" . urlencode($toDate);
                            echo "<li class='page-item'><a href='$link' class='page-link'>$i</a></li>";
                        }
                    }
                ?>
            </ul>
        </div>
    </div>
</main>