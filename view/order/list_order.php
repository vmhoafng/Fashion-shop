<!-- Title page -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
	<h2 class="ltext-105 cl0 txt-center">
    	Order
	</h2>
</section>


<?php
	if(isset($_SESSION['user'])) {
		$list_all_order = get_all_order($_SESSION['user']['user_id']);
		if(isset($list_all_order)) {
			$pageIndex = 1;
			$pageSize = 5;
			if(isset($_GET['page'])) {
				$pageIndex = $_GET['page'];
			}
		
			$totalPage = ceil(count($list_all_order)/$pageSize);
			$list_all_order = array_slice($list_all_order, ($pageIndex-1)*$pageSize, $pageSize);
		}
		echo "<table border='1'class='table table-hover'>
		<tr class='table-header'>
			<th>Mã đơn hàng</th>
			<th>Trạng thái</th>
			<th>Ngày đặt</th>
			<th>Tổng tiền</th>
			<th>Địa chỉ</th>
			<th>Thanh toán</th>
			<th colspan='2'>Hành động</th>
		</tr>";
		
			if(!empty($list_all_order)) {
				foreach($list_all_order as $item) {
					extract($item);
	
					$name_stt = get_name_status($status_id);
	
					echo "<tr>
							<td>".$order_id."</td>
							<td>".$name_stt."</td>
							<td>". $order_created_date."</td>
							<td>".$total."</td>
							<td>".$address_order."</td>
							<td>".$payment."</td>
							<td><a href='index.php?ac=info_order&id=".$order_id."'>Xem chi tiết</a></td>
					
							<td><a href='index.php?ac=cancel_order&id=".$order_id."'>Hủy đơn</a></td>
						</tr>";
				}
			}
			else {
				echo "<tr>
							<td colspan='8' class='text-center p-4'> Không có danh sách đơn hàng!</td>
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
			if(isset($list_all_order)) {
				echo "<div id='paginationForm' class='row m-l-5'>";
				for($i = 1; $i <= $totalPage; $i++){
						echo "<li class='page-item'><a href='index.php?ac=to_order&page=".$i."' class='page-link' name='page'>".$i."</a></li>";                           
				}
				
				echo '</div>';
			}
			
		?>
	</ul>
</div>

