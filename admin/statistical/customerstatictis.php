<!-- ----Lấy default lọc top 5 người dùng mua nhiều nhất
----Khi bấm lọc lấy giá trị post lọc 5 người mua nhiều nhất
----Sẽ có cột detail bấm vào sẽ qua các order được người dùng đó mua bấm chi tiết sẽ ra các sản phẩm mà người dùng đó đã mua ở đơn hàng đó.
----Làm cái trên = cách ẩn order statictis đi, truyền user id vào chỉ lọc order có user id đó thôi.Là done.
----Bỏ statistic này vào dashboard vì nó chỉ có 1 option. -->
<?php 
$fromDate = $_POST['fromDate'] ?? date('Y-m-d', strtotime('-1 month'));
$toDate = $_POST['toDate'] ?? date('Y-m-d');
$topUser= top5MostProfitUserFromdateToDate($fromDate,$toDate);

?>
<main class="page-content">
    <div class="container-fluid">
        <h2>Top 5 most buy customer</h2>
        <div class="row ml-1 mt-3">
            <form class="row ml-1" method="post">
                <h4 class="mr-1">From date</h4> <input class="datepicker mr-3" type="date" id="fromDate" name="fromDate" value=<?php echo $fromDate?> >
                <h4 class="mr-1">To date</h4> <input type="date" id="toDate" name="toDate" value=<?php echo $toDate?>>
                <button type="submit" class="btn btn-primary ml-3">Filter</button>
            </form>
        </div>
        <div class="row mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>User name</th>
                        <th>Total</th>
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
                            <td><a href="index.php?ac=orderstatistic&user_id=<?php echo $value['user_id']; ?>">Detail</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        
    </div>
</main
