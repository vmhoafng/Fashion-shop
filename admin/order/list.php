<?php
if (isset($_POST['orderId'])) {
    $orderId = $_POST['orderId'];
    getOrderStatusAndUpdateByOne($orderId);
}
if (isset($_POST['huydon'])) {
    $orderId = $_POST['huydon'];
    huydon($orderId);
}
if (isset($_POST['undo'])) {
    $orderId = $_POST['undo'];
    getOrderStatusAndMinusByOne($orderId);
}

$status = getAllStatus();
$fromDate = $_POST['fromDate'] ?? date('Y-m-d', strtotime('-1 month'));
$toDate = $_POST['toDate'] ?? date('Y-m-d');
if (isset($_GET['fromdate']) && isset($_GET['todate'])) {
    $fromDate = $_GET['fromdate'];
    $toDate = $_GET['todate'];
}
if (isset($_SESSION['statusName'])) {
    $statusName = $_SESSION['statusName'];
} else {
    $statusName = "All";
}
$orders = getOrderFromDateToDate($fromDate, $toDate);
if (isset($_POST['orderStatus'])) {
    if ($_POST['orderStatus'] != 0) {
        $statusName = getStatusNameByStatusId($_POST['orderStatus']);
    } else {
        $statusName = "All";
    }
    $_SESSION['statusName'] = $statusName;
    if ($_POST['orderStatus'] == 0) {
        $orders = getOrderFromDateToDate($fromDate, $toDate);
    } else {
        $statusId = $_POST['orderStatus'];
        $orders = getOrderFromDateToDate($fromDate, $toDate);
        $orders = array_filter($orders, function($order) use ($statusId) {
            return $order['status_id'] == $statusId;
        });
    }
}

$pageIndex = 1;
$pageSize = 5;
if (isset($_GET['page'])) {
    $pageIndex = $_GET['page'];
}
$totalPage = ceil(count($orders) / $pageSize);
$orders = array_slice($orders, ($pageIndex - 1) * $pageSize, $pageSize);
?>

<main class="page-content">
    <div class="container-fluid">
        <div class="title-management">
            <h3>Order Management</h3>
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
            <div class="col-sm-3">
                <label for="orderStatus" class="form-label">Order Status</label>
                <select class="form-control" id="orderStatus" name="orderStatus">
                    <option value="0" <?= $statusName == "All" ? 'selected' : ''; ?>>All</option>
                    <?php foreach ($status as $st) { ?>
                        <option value="<?= $st['status_id']; ?>" <?= $st['status_name'] == $statusName ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($st['status_name']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-2 align-self-end">
                <button type="submit" class="btn btn-primary btn-block">Filter</button>
            </div>
        </form>
        <table class="table table-hover mt-4">
            <thead>
                <tr class="table-header">
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Order Date</th>
                    <th>Shipment Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Detail</th>
                    <th>Process</th>
                    <th>Undo</th>
                    <th>Cancel</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) { ?>
                    <tr>
                        <td><?= htmlspecialchars($order['order_id']); ?></td>
                        <td><?= htmlspecialchars($order['user_id']); ?></td>
                        <td><?= htmlspecialchars($order['order_created_date']); ?></td>
                        <td><?= htmlspecialchars($order['estimate_ship_date']); ?></td>
                        <td><?= htmlspecialchars(strval(getOrderTotalFromOrderDetail($order['order_id']))); ?></td>
                        <td><?= htmlspecialchars(strval(getStatusNameByStatusId($order['status_id']))); ?></td>
                        <td>
                            <a href="index.php?ac=orderdetail&id=<?= $order['order_id']; ?>" class="btn btn-sm btn-primary">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="orderId" value="<?= $order['order_id']; ?>">
                                <button type="submit" class="btn btn-sm btn-success" <?= $order['status_id'] >= 4 ? 'disabled' : ''; ?>>
                                    <i class="fa fa-forward"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="undo" value="<?= $order['order_id']; ?>">
                                <button type="submit" class="btn btn-sm btn-warning" <?= $order['status_id'] <= 1 ? 'disabled' : ''; ?>>
                                    <i class="fa fa-undo"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="huydon" value="<?= $order['order_id']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>
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
                            $link = "index.php?ac=order&page=$i&fromdate=" . urlencode($fromDate) . "&todate=" . urlencode($toDate);
                            echo "<li class='page-item'><a href='$link' class='page-link'>$i</a></li>";
                        }
                    }
                ?>
            </ul>
        </div>
    </div>
</main>