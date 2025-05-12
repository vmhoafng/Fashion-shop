<?php 
$fromDate = $_POST['fromDate'] ?? date('Y-m-d', strtotime('-1 month'));
$toDate = $_POST['toDate'] ?? date('Y-m-d');
$topUser = top5MostProfitUserFromdateToDate($fromDate, $toDate);

// Sắp xếp theo Total
if (isset($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc'])) {
    usort($topUser, function($a, $b) {
        return ($_GET['sort'] == 'asc') ? ($a['total'] - $b['total']) : ($b['total'] - $a['total']);
    });
}
?>

<main class="page-content">
    <div class="container-fluid">
        <h2>Top 5 most buy customer</h2>
        <div class="row ml-1 mt-3">
            <form class="row ml-1" method="post">
                <h4 class="mr-1">From date</h4>
                <input class="datepicker mr-3" type="date" id="fromDate" name="fromDate"
                    value="<?php echo $fromDate ?>">
                <h4 class="mr-1">To date</h4>
                <input type="date" id="toDate" name="toDate" value="<?php echo $toDate ?>">
                <button type="submit" class="btn btn-primary ml-3">Filter</button>
            </form>
        </div>
        <div class="row mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>User name</th>
                        <th>
                            <a
                                href="index.php?ac=topcustomer&sort=<?php echo (isset($_GET['sort']) && $_GET['sort'] == 'asc') ? 'desc' : 'asc'; ?>">
                                Total <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'asc') ? '↑' : '↓'; ?>
                            </a>
                        </th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topUser as $key => $value) {
                        $user = getUserDetailByUserId($value['user_id']);
                    ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $user['user_name']; ?></td>
                        <td><?php echo $value['total']; ?></td>
                        <td><a href="index.php?ac=orderstatistic&user_id=<?php echo $value['user_id']; ?>">Detail</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>