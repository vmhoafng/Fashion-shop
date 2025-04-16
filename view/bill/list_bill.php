<!-- Title page -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
	<h2 class="ltext-105 cl0 txt-center">
        Bill
	</h2>
</section>

<?php
    if(isset($_SESSION['user'])) {
        $list_bill = get_all_bill($_SESSION['user']['user_id']);
        $pageIndex = 1;
        $pageSize = 5;
        if(isset($_GET['page'])) {
            $pageIndex = $_GET['page'];
        }

        $totalPage = ceil(count($list_bill)/$pageSize);
        $list_bill = array_slice($list_bill, ($pageIndex-1)*$pageSize, $pageSize);
        echo "<table border='1' class='table table-hover'>
        <tr class='table-header'>
            <th>Mã hóa đơn</th>
            <th>Ngày tạo</th>
            <th>Tổng tiền</th>
            <th>Hành động</th>
        </tr>";
        
        if(!empty($list_bill)) {
                foreach($list_bill as $item) {
                    extract($item);
    
    
                    $bill_info = get_info_one_bill($bill_id);
                    $total_bill = 0;
                    foreach($bill_info as $item) {
                        extract($item);
                        $total_bill += $total;
                    }
    
                    echo "<tr>
                            <td>".$bill_id."</td>
                            <td>".$created_date."</td>
                            <td>". $total_bill ."$</td>
                            <td><a href='index.php?ac=view_info_bill&id=".$bill_id."'>Xem chi tiết</a></td>
                        </tr>";
                }
        }
        else {
            echo "<tr>
                    <td colspan='4' class='text-center p-4'> Không có danh sách hóa đơn</td>
                </tr>";
        }
    echo "</table>";
    }
    else {
        echo "Vui lòng đăng nhập!";
    }
?>

<div class="mt-5">
	<ul class="pagination justify-content-center">
		<?php
            if(isset($list_bill)) {
                echo "<div id='paginationForm' class='row m-l-5'>";
                for($i = 1; $i <= $totalPage; $i++){
                        echo "<li class='page-item'><a href='index.php?ac=to_bill&page=".$i."' class='page-link' name='page'>".$i."</a></li>";                           
                }
                
                echo '</div>';
            }
			
		?>
	</ul>
</div>