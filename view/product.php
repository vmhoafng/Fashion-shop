
<?php
	
		$listProduct=loadSanPham_Product();
						
		$listCategories=loadAllCategory();
		$pageSize=3;
		$currentPageIdx=1;
		$test=0;
		//$totalPage= totalPage($listProduct,$pageSize);
		//$listProduct=loadProductByPageIdx($currentPageIdx,$pageSize);
		$BASE_URL='index.php?ac=product';
		$TEMP_URL= $BASE_URL;
		$searchKeyWord='';
		$currentCategoryId='';
		$currentSelectedColor='';
		$currentSort=0;
		$currentProductDetailId=0;
		//
		$minPrice='';
		$maxPrice='';
		//
		//advance search
		$advanceCategoryFilter=[];
		$advanceColorFilter=[];
		$advanceSizeFilter=[];
		$advancePriceFilter=[];
		//

		$availabelColors=getUniqueProductColors($listProduct);
		$availableSizes=getUniqueProductSize($listProduct);
		if(isset($_GET['all_product'])){
			unset($_SESSION['searchKeyWord']);
			unset($_SESSION['advanceCategoryFilter']);
			unset($_SESSION['advanceColorFilter']);
			unset($_SESSION['advanceSizeFilter']);
			unset($_SESSION['advancePriceFilter']);
			unset($_SESSION['sort']);
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// List of all the form fields
			$fields = ['searchKeyWord', 'advanceCategoryFilter', 'advanceColorFilter', 'advanceSizeFilter', 'advancePriceFilter', 'sort'];
		
			// Flag to check if all fields are empty
			$allEmpty = true;
		
			foreach ($fields as $field) {
				if (!empty($_POST[$field])) {
					echo'<script>console.log("not empty filter: '.$field.'")</script>';
					//$allEmpty = false;
					//break;
					continue;
				}
				else{
					echo'<script>console.log("alive sesion: '.$field.'")</script>';
					unset($_SESSION[$field]);
				}
			}
		
			// if ($allEmpty) {
			// 	echo'all empty';
			// 	// All fields are empty
			// 	// Reset the session filter here
			// } else {
			// 	echo' At least one field is not empty';
			// 	// Process the form data here
			// }
		}
		
		// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// 	// Print out the contents of the $_POST array
		// 	echo '<pre>';
		// 	print_r($_SESSION);
		// 	echo '</pre>';
			
		// }
		
		
		if(isset($_GET['search']))
		{
			$searchKeyWord=$_GET['search'];
		}
		if(isset($_POST['searchProduct']) && !empty($_POST['searchProduct'])) {
			$searchKeyWord=$_POST['searchProduct'];
			$_SESSION['searchKeyWord'] = $searchKeyWord;
			//$TEMP_URL.="&searchProduct=".$searchKeyWord;
		}
		else if (isset($_SESSION['searchKeyWord'])) {
			$searchKeyWord = $_SESSION['searchKeyWord'];
		}
		if (isset($_POST['categoryfilter'])) {
			$categoryFilter = $_POST['categoryfilter'];
			$advanceCategoryFilter=$categoryFilter;
			$_SESSION['advanceCategoryFilter'] = $categoryFilter;
			foreach($advanceCategoryFilter as $category){
				echo "<script>console.log('test checkbox category: " .$category . "' );</script>";
			}
			// Do something with $price1
		}
		else if (isset($_SESSION['advanceCategoryFilter'])) {
			$advanceCategoryFilter = $_SESSION['advanceCategoryFilter'];
		}
		if (isset($_POST['colorfilter'])) {
			$colorFilter = $_POST['colorfilter'];
			$advanceColorFilter=$colorFilter;
			$_SESSION['advanceColorFilter'] = $colorFilter;
			foreach($advanceColorFilter as $color){
				echo "<script>console.log('test checkbox color: " .$color . "' );</script>";
			}
			// Do something with $price1
		}
		else if (isset($_SESSION['advanceColorFilter'])) {
			$advanceColorFilter = $_SESSION['advanceColorFilter'];
		}
		if (isset($_POST['sizefilter'])) {
			$sizeFilter = $_POST['sizefilter'];
			$advanceSizeFilter=$sizeFilter;
			$_SESSION['advanceSizeFilter'] = $sizeFilter;
			foreach($advanceSizeFilter as $size){
				echo "<script>console.log('test checkbox size: " .$size . "' );</script>";
			}
			// Do something with $price1
		}
		else if (isset($_SESSION['advanceSizeFilter'])) {
			$advanceSizeFilter = $_SESSION['advanceSizeFilter'];
		}
		if (isset($_POST['pricefilter'])) {
			$priceFilter = $_POST['pricefilter'];
			$advancePriceFilter=$priceFilter;
			$_SESSION['advancePriceFilter'] = $priceFilter;
			foreach($advancePriceFilter as $price){
				echo "<script>console.log('test checkbox price: " .$price . "' );</script>";
			}
			// Do something with $price1
		}
		else if (isset($_SESSION['advancePriceFilter'])) {
			$advancePriceFilter = $_SESSION['advancePriceFilter'];
		}
		if(isset($_POST['sort'])){
			$currentSort=$_POST['sort'];
			$_SESSION['sort'] = $currentSort;

		}
		else if(isset($_SESSION['sort'])){
			$currentSort=$_SESSION['sort'];
		}

		
		if(isset($_GET['searchProduct']) && !empty($_GET['searchProduct'])) {
			if(isset($_POST['searchProduct'])){
				$_GET['searchProduct']=$_POST['searchProduct'];
			}
			$searchKeyWord=$_GET['searchProduct'];
		}

		if(isset($_GET['categoryid']) && !empty($_GET['categoryid'])){
			$currentCategoryId=$_GET['categoryid'];
			$advanceCategoryFilter=[];
			$advanceCategoryFilter[]=$currentCategoryId;
			$_SESSION['advanceCategoryFilter']=$advanceCategoryFilter;
			
			// if(str_contains($TEMP_URL,"categoryid")){
			// 	str_replace(("categoryid=".$currentCategoryId),("categoryid=".$_GET['categoryid']),$TEMP_URL);
				
			// }
			// else{
			// 	$currentCategoryId=$_GET['categoryid'];
			// 	$TEMP_URL.='&categoryid='.$currentCategoryId;
			// }
			// if (strpos($TEMP_URL, "&categoryid=") !== false) {
			// 	// Replace existing category ID with new_category_id
			// 	$TEMP_URL = preg_replace('/&categoryid=[^&]*/', '&categoryid=' . $currentCategoryId, $TEMP_URL);
			// }
			// else{
			// 	$TEMP_URL.='&categoryid='.$currentCategoryId;
			// }
			// echo "<script>console.log('zxczxc: " .$TEMP_URL . "' );</script>";
		}
		
		if(isset($_GET['minprice']) && !empty($_GET['minprice'])){
			$minPrice=$_GET['minprice'];
			$maxPrice=$_GET['maxprice'];	
		}
		if(isset($_GET['page']) && !empty($_GET['page'])){
			$currentPageIdx=$_GET['page'];
		}
		if(isset($_POST['page']) && !empty($_POST['page'])){
			$currentPageIdx=$_POST['page'];
			if (isset($_SESSION['advanceSizeFilter'])){
				echo'<script>console.log("log at page: '.$_SESSION['advanceSizeFilter'].'")</script>';
			}
		}
		if(isset($_GET['color']) && !empty($_GET['color'])){
			$currentSelectedColor=$_GET['color'];
			$advanceColorFilter[]=$currentSelectedColor;
			//$TEMP_URL.='&color='.$currentSelectedColor;
			if (strpos($TEMP_URL, "&color=") !== false) {
				// Replace existing category ID with new_category_id
				$TEMP_URL = preg_replace('/&color=[^&]*/', '&color=' . $_GET['color'], $TEMP_URL);
			}
			else{
				$TEMP_URL.='&color='.$currentSelectedColor;
			}
		}
		if(isset($_GET['orderby']) && !empty($_GET['orderby'])){
			$currentSort=$_GET['orderby'];
			$TEMP_URL.='&orderby='.$currentSort;
		}
		// if($BASE_URL!=$TEMP_URL){
		// 	$listProduct=filterBy($currentSelectedColor,$currentCategoryId,$searchKeyWord,$minPrice,$maxPrice);
		// }
		echo "<script>console.log('current sort=	: " . $currentSort . "' );</script>";
		$listProduct=advanceSearch($searchKeyWord,$advanceCategoryFilter,$advanceColorFilter,$advanceSizeFilter,$advancePriceFilter);
		$totalPage=totalPage($listProduct,$pageSize);
		$totalProduct=count($listProduct);
		
		if($currentSort==1){
			$prices = array_column($listProduct, 'product_price');
			array_multisort($prices, SORT_ASC, $listProduct);
		}
		else if($currentSort==2){
			$prices = array_column($listProduct, 'product_price');
			array_multisort($prices, SORT_DESC, $listProduct); 
		}
		else if($currentSort==3){
			$ids = array_column($listProduct, 'product_id');
			array_multisort($ids, SORT_DESC, $listProduct);
		}
		else if($currentSort==4){
			$ids = array_column($listProduct, 'product_id');
			array_multisort($ids, SORT_ASC, $listProduct);
		}
		$listProduct=array_slice($listProduct,($currentPageIdx-1)*$pageSize,$pageSize);
	##
	// Start the session
// session_start();

// // Example filter parameters with default values as null
// $filters = array(
//   'category' => null,
//   'color' => null,
//   'minprice' => null,
//   'maxprice' => null
// );

// // Save filters to the session
// $_SESSION['filters'] = $filters;
// // Retrieve the saved filters from the session
// $filters = isset($_SESSION['filters']) ? $_SESSION['filters'] : array();

// // Access the filter parameters
// $category = $filters['category'];   // null if not set
// $color = $filters['color'];         // null if not set
// $minprice = $filters['minprice'];   // null if not set
// $maxprice = $filters['maxprice'];   // null if not set

?>
<!-- Cart -->
<div class="wrap-header-cart js-panel-cart">
	<div class="s-full js-hide-cart"></div>

	<div class="header-cart flex-col-l p-l-65 p-r-25">
		<div class="header-cart-title flex-w flex-sb-m p-b-8">
			<span class="mtext-103 cl2">
				Your Cart
			</span>

			<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
				<i class="zmdi zmdi-close"></i>
			</div>
		</div>

		<div class="header-cart-content flex-w js-pscroll">
			
			<ul class="header-cart-wrapitem w-full">
				
				<li class="header-cart-item flex-w flex-t m-b-12">
					<div class="header-cart-item-img">
						<img src="images/item-cart-01.jpg" alt="IMG">
					</div>

					<div class="header-cart-item-txt p-t-8">
						<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
							White Shirt Pleat
						</a>

						<span class="header-cart-item-info">
							1 x $19.00
						</span>
					</div>
				</li>

				<li class="header-cart-item flex-w flex-t m-b-12">
					<div class="header-cart-item-img">
						<img src="images/item-cart-02.jpg" alt="IMG">
					</div>

					<div class="header-cart-item-txt p-t-8">
						<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
							Converse All Star
						</a>

						<span class="header-cart-item-info">
							1 x $39.00
						</span>
					</div>
				</li>

				<li class="header-cart-item flex-w flex-t m-b-12">
					<div class="header-cart-item-img">
						<img src="images/item-cart-03.jpg" alt="IMG">
					</div>

					<div class="header-cart-item-txt p-t-8">
						<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
							Nixon Porter Leather
						</a>

						<span class="header-cart-item-info">
							1 x $17.00
						</span>
					</div>
				</li>
			</ul>

			<div class="w-full">
				<div class="header-cart-total w-full p-tb-40">
					Total: $75.00
				</div>

				<div class="header-cart-buttons flex-w w-full">
					<a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
						View Cart
					</a>

					<a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
						Check Out
					</a>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Product -->
<div class="bg0 m-t-23 p-b-140">
	<div class="container">
		<div class="flex-w flex-sb-m p-b-52">
			<div class="flex-w flex-l-m filter-tope-group m-tb-10">
				<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter="*">
					<?php 
						echo"<a href=".$BASE_URL."&all_product=true"."> All Products</a>";
					?>
				</button>
				<?php
					foreach($listCategories as $category) {
						extract($category);
						
						// $categoryLink="";
						if($currentCategoryId==$category_id){
							echo '
								<a href="'.$BASE_URL.'&categoryid='.$category_id.'" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5  how-active1" data-filter=".'.$category_name.'">
										'. $category_name.'
										</a>
							';
						}
						else{
							echo '
								<a href="'.$BASE_URL.'&categoryid='.$category_id.'" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".'.$category_name.'">
										'. $category_name.'
										</a>';
						}
						// if (strpos($TEMP_URL, "&categoryid=") !== false && empty($currentCategoryId)) {
						// 	// Replace existing category ID with new_category_id
						// 	$TEMP_URL = preg_replace('/&categoryid=[^&]*/', '&categoryid=' . $category_id, $TEMP_URL);
						// 	$categoryLink=$TEMP_URL;
						// }
						// else{
						// 	$categoryLink=$TEMP_URL."&categoryid=".$category_id;
						// }
						// echo "<script>console.log('categoryLink: " .$categoryLink . "' );</script>";
						// if($currentCategoryId==$category_id){
						// 	echo'
						// 		<a href="'.$categoryLink.'" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter=".'.$category_name.'">
						// 		'. $category_name.'
						// 		</a>';
						// }
						// else{
						// 	echo'
						// 		<a href="'.$categoryLink.'" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".'.$category_name.'">
						// 		'. $category_name.'
						// 		</a>';
						// }
					}
				?>
			</div>

			<div class="flex-w flex-c-m m-tb-10">
				<!-- <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
					<i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
					<i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
					Filter
				</div> -->

				<div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
					<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
					<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
					Search
				</div>
			</div>

			<!-- Search product -->
			<div class="dis-none panel-search w-full p-t-10 p-b-15">
				<form method="post" action="index.php?ac=product">
					<div class="bor8 dis-flex p-l-15">
						<button type="submit" class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
							<i class="zmdi zmdi-search"></i>
						</button>
						<input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="searchProduct" placeholder="Search">
					</div>
				
				<!-- 
					Test
				-->
					<div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-advanced-search">
						<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
						<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						Advanced Search
    				</div>
					<!-- Advanced Search Panel -->
					<div class="dis-none panel-advanced-search w-full p-t-10 p-b-15">
						<div class="row">
							<div class="col m-l-1">
								<h3>Category</h3>
								<?php 
									foreach($listCategories as $category) {
										extract($category);
										$checked = in_array($category_id, $advanceCategoryFilter) ? 'checked' : '';
										echo'<div class="form-check">
												<input class="form-check-input m-l-1" type="checkbox" id="category'.$category_id.'" name="categoryfilter[]" value="'.$category_id.'" '.$checked.'>'
												.'<label class="form-check-label" for="category'.$category_id.'">'.$category_name.'</label>'
											.'</div>';
									}
								?>

								<!-- Add more categories as needed -->
							</div>

							<div class="col">
								<h3>Color</h3>
								<?php 
									foreach($availabelColors as $color) {
										$checked = in_array($color, $advanceColorFilter) ? 'checked' : '';
										echo'<div class="form-check">
												<input class="form-check-input" type="checkbox" id="color'.$color.'" name="colorfilter[]" value="'.$color.'" '.$checked.'>'
												.'<label class="form-check" for="color'.$color.'">'.$color.'</label>'
											.'</div>';
									}
								?>
								<!-- Add more colors as needed -->
							</div>
							<div class="col">
								<h3>Size</h3>
								<div class="filter-option">
									<?php
									foreach($availableSizes as $size) {
										$checked = in_array($size, $advanceSizeFilter) ? 'checked' : '';
										echo'<div class="form-check">
												<input class="form-check-input " type="checkbox" id="size'.$size.'" name="sizefilter[]" value="'.$size.'" '.$checked.'>
												<label class="form-check" for="size'.$size.'">'.$size.'</label>
											</div>';
									}
									?>
								</div>
								<!-- Add more sizes as needed -->
							</div>
							<div class="col">
								<h3>Price Range</h3>
								<?php 
								for ($i = 1; $i <= 4; $i++) {
									$checked = in_array("between ".(($i-1)*50)." and ".$i*50, $advancePriceFilter) ? 'checked' : '';
									echo'<div class="form-check">
									<input class="form-check-input m-l-1" type="checkbox" id="price'.$i.'" name="pricefilter[]" value="between '.(($i-1)*50).' and '.($i*50).'" '.$checked.'>
									<label class="form-check-label" for="price'.$i.'">'.(($i-1)*50).' - '.($i*50).' $</label>
								</div>
										';
								}
								?>

								<!-- Add more price ranges as needed -->
							</div>
							<div class="col">
								<h3>Sort By</h3>
								<!-- <div class="form-check">
									<input class="form-check-input" type="radio" id="sort1" name="sort" value="1">
									<label class="form-check-label" for="sort1">Price: Low to High</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" id="sort2" name="sort" value="2">
									<label class="form-check-label" for="sort2">Price: High to Low</label>
								</div> -->
								<?php 
								for ($i = 1; $i <= 4; $i++) {
									$checked = $i == $currentSort ? 'checked' : '';
									if($i==1){
										$label='Price: Low to High';
									}
									else if($i==2){
										$label='Price: High to Low';
									}
									else if($i==3){
										$label='Newest';
									}
									else if($i==4){
										$label='Oldest';
									}
									//$label = $i == 1 ? 'Price: Low to High' : 'Price: High to Low';
									echo'<div class="form-check">
											<input class="form-check-input" type="radio" id="sort'.$i.'" name="sort" value="'.$i.'" '.$checked.'>
											<label class="form-check-label" for="sort'.$i.'">'.$label.'</label>
										</div>';
								}
								
								?>
								<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1  p-lr-15 trans-04" type="submit">
                            		Search
                        		</button>
								<a href="index.php?ac=product&all_product=true"  class="flex-c-m stext-101 cl0 size-103 w-50 bg1 bor1 trans-04 mt-2">Reset filter</a>
							</div>
							
						</div>
						
					
					</div>
					</form>
			</div>

			<!-- Filter -->
			<div class="dis-none panel-filter w-full p-t-10">
				<div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
					<div class="filter-col1 p-r-15 p-b-27">
						<div class="mtext-102 cl2 p-b-15">
							Sort By
						</div>

						<ul>
							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04">
									Default
								</a>
							</li>

							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04">
									Popularity
								</a>
							</li>

							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04">
									Average rating
								</a>
							</li>

							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04 filter-link-active">
									Newness
								</a>
							</li>

							<li class="p-b-6">
								<?php
								$orderByLink=$TEMP_URL.'&orderby=1';
									echo'<a href="'.$orderByLink.'" class="filter-link stext-106 trans-04">
											Price: Low to High
										</a>';
								?>
							</li>

							<li class="p-b-6">
							<?php
								$orderByLink=$TEMP_URL.'&orderby=2';
									echo'<a href="'.$orderByLink.'" class="filter-link stext-106 trans-04">
											Price: High to low
										</a>';
								?>
							</li>
						</ul>
					</div>

					<div class="filter-col2 p-r-15 p-b-27">
						<div class="mtext-102 cl2 p-b-15">
							Price
						</div>

						<ul>
							<li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04 filter-link-active">
									All
								</a>
							</li>

							<li class="p-b-6">	
								<?php 
								$filterPriceLink=$TEMP_URL.'&minprice=1&maxprice=50';
								echo'	<a href="'.$filterPriceLink.'" class="filter-link stext-106 trans-04">
										$1.00 - $50.00
									</a>' ;
								?>
							</li>

							<li class="p-b-6">

								<?php 
								$filterPriceLink=$TEMP_URL.'&minprice=50&maxprice=100';
								echo'	<a href="'.$filterPriceLink.'" class="filter-link stext-106 trans-04">
										$50.00 - $100.00
									</a>' ;
								?>
							</li>

							<li class="p-b-6">
								<?php 
								$filterPriceLink=$TEMP_URL.'&minprice=100&maxprice=150';
								echo'	<a href="'.$filterPriceLink.'" class="filter-link stext-106 trans-04">
										$100.00 - $150.00
									</a>' ;
								?>
							</li>

							<li class="p-b-6">
								<?php 
								$filterPriceLink=$TEMP_URL.'&minprice=150&maxprice=200';
								echo'	<a href="'.$filterPriceLink.'" class="filter-link stext-106 trans-04">
										$150.00 - $200.00
									</a>' ;
								?>
							</li>

							<!-- <li class="p-b-6">
								<a href="#" class="filter-link stext-106 trans-04">
									$200.00+
								</a>
							</li> -->
						</ul>
					</div>

					<div class="filter-col3 p-r-15 p-b-27">
						<div class="mtext-102 cl2 p-b-15">
							Color
						</div>

						<ul>
							<!-- <li class="p-b-6">
								<span class="fs-15 lh-12 m-r-6" style="color: #222;">
									<i class="zmdi zmdi-circle"></i>
								</span>

								<a href="#" class="filter-link stext-106 trans-04">
									Black
								</a>
							</li>

							<li class="p-b-6">
								<span class="fs-15 lh-12 m-r-6" style="color: #4272d7;">
									<i class="zmdi zmdi-circle"></i>
								</span>

								<a href="#" class="filter-link stext-106 trans-04 filter-link-active">
									Blue
								</a>
							</li>

							<li class="p-b-6">
								<span class="fs-15 lh-12 m-r-6" style="color: #b3b3b3;">
									<i class="zmdi zmdi-circle"></i>
								</span>

								<a href="#" class="filter-link stext-106 trans-04">
									Grey
								</a>
							</li>

							<li class="p-b-6">
								<span class="fs-15 lh-12 m-r-6" style="color: #00ad5f;">
									<i class="zmdi zmdi-circle"></i>
								</span>

								<a href="#" class="filter-link stext-106 trans-04">
									Green
								</a>
							</li>

							<li class="p-b-6">
								<span class="fs-15 lh-12 m-r-6" style="color: #fa4251;">
									<i class="zmdi zmdi-circle"></i>
								</span>

								<a href="#" class="filter-link stext-106 trans-04">
									Red
								</a>
							</li>

							<li class="p-b-6">
								<span class="fs-15 lh-12 m-r-6" style="color: #aaa;">
									<i class="zmdi zmdi-circle-o"></i>
								</span>

								<a href="#" class="filter-link stext-106 trans-04">
									White
								</a>
							</li> -->

							<?php 
								foreach($availabelColors as $color) {
									$color_link=$TEMP_URL.'&color='.$color;
									echo '	<li class="p-b-6">
									<span class="fs-15 lh-12 m-r-6" style="color: '.$color.';">
										<i class="zmdi zmdi-circle"></i>
									</span>
	
									<a href="'.$color_link.'" class="filter-link stext-106 trans-04">
									'.$color.'
									</a>
								</li>';
								}
							?>
						</ul>
					</div>

					<div class="filter-col4 p-b-27">
						<div class="mtext-102 cl2 p-b-15">
							Tags
						</div>

						<div class="flex-w p-t-4 m-r--5">
							<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
								Fashion
							</a>

							<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
								Lifestyle
							</a>

							<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
								Denim
							</a>

							<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
								Streetstyle
							</a>

							<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
								Crafts
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php 
			if(!empty($searchKeyWord)&&isset($searchKeyWord)){
					echo '<h2 class="fw-bold mb-3">Search key: <span>'.$searchKeyWord.'</span></h2>';
			}
		?>
		<!-- <?php
		
			$flag=0;
			if($currentCategoryId!=''){
				$flag=1;
				$ClearCategoryLink=$TEMP_URL;
				$ClearCategoryLink = preg_replace('/&categoryid=[^&]*/', '', $ClearCategoryLink);
				$categoryName=getCategoryNameById($currentCategoryId);
				echo '<a href="'.$ClearCategoryLink.'">';
				echo'<span class="badge badge-pill badge-secondary m-b-10">'.$categoryName.'  <sup style="font-size:9px">x</sup></span>&nbsp;';
				echo '</a>';
			}
			if($currentSelectedColor!=''){
				$flag=1;
				$ClearColor=$TEMP_URL;
				$ClearColor = preg_replace('/&color=[^&]*/', '', $ClearColor);
				echo '<a href="'.$ClearColor.'">';
				echo'<span class="badge badge-pill badge-secondary m-b-10">'.$currentSelectedColor.'  <sup style="font-size:9px">x</sup></span>&nbsp;';
				echo '</a>';
			}
			if($currentSort==1){
				$flag=1;
				$ClearSort=$TEMP_URL;
				$ClearSort = preg_replace('/&orderby=[^&]*/', '', $ClearSort);
				echo '<a href="'.$ClearSort.'">';
				echo'<span class="badge badge-pill badge-secondary m-b-10">Price low to high  <sup style="font-size:9px">x</sup></span>&nbsp;';
				echo '</a>';
			}
			if($currentSort==2){
				$flag=1;
				$ClearSort=$TEMP_URL;
				$ClearSort = preg_replace('/&orderby=[^&]*/', '', $ClearSort);
				echo '<a href="'.$ClearSort.'">';
				echo'<span class="badge badge-pill badge-secondary m-b-10">Price hight to low <sup style="font-size:9px">x</sup></span>&nbsp;';
				echo '</a>';
			}
			if(!empty($minPrice) &&!empty($maxPrice)){
				$flag=1;
				$clearPrice=$TEMP_URL;
				$clearPrice = preg_replace('/&minprice=[^&]*/', '', $clearPrice);
				$clearPrice = preg_replace('/&maxprice=[^&]*/', '', $clearPrice);
				echo '<a href="'.$clearPrice.'">';
				echo'<span class="badge badge-pill badge-secondary m-b-10">Price range: '.$minPrice.'-'.$maxPrice.' $ <sup style="font-size:9px">x</sup> </span>&nbsp;';
				echo '</a>';
			}
			if($flag==1){echo'<a href="'.$BASE_URL.'">Clear filter</a>';}
		
		?> -->

		<div class="row isotope-grid">
			<?php
				if(count($listProduct)> 0){
					foreach($listProduct as $product){
						extract($product);
						echo'<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
								<!-- Block2 -->
								<div class="block2">
									<div class="block2-pic hov-img0">
										<img style="width: 315px; height: 390.06px;" src="data:image/jpeg;base64,'.base64_encode($product_image).'" alt="IMG-PRODUCT">
									</div>
					
									<div class="block2-txt flex-w flex-t p-t-14">
										<div class="block2-txt-child1 flex-col-l ">
											<a href="index.php?ac=productDetail&id='.$product_id.'" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
												'.$product_name.'
											</a>
					
											<span class="stext-105 cl3">
												'.$product_price.'$
											</span>
										</div>
					
										
									</div>
								</div>
							</div>';
					}
				}
				else{
					echo '<h1>No product match your description</h1>';
				}
			?>
		</div>

		<!-- Load more -->
		<div class="flex-c-m flex-w w-full p-t-45">
			<!-- <a href="#" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
				Load More
			</a> -->
			<nav aria-label="Page navigation example">
				<ul class="pagination">
					<!-- <li class="page-item"><a class="page-link" href="#">Previous</a></li> -->
					<?php
					echo'<div class="m-r-10 m-t-15">Trên tổng '.$totalProduct.' sản phẩm</div>';
						// if($totalPage>1){
						// 	for( $i= 1; $i<=$totalPage;$i++){
						// 		$pageLink=$TEMP_URL.'&page='.$i;
						// 		echo '<li class="page-item"><a class="page-link" value="'.$i.'" type="submit">'.$i.'</a></li>';
						// 	}
						// }
						echo '<div id="paginationForm" class="row m-l-5">';
						if($totalPage > 1){
							for($i = 1; $i <= $totalPage; $i++){
								if(($searchKeyWord)==""){
                                    echo '<li class="page-item"><a href="index.php?ac=product&page='.$i.'" class=" page-link" name="page">'.$i.'</a></li>';
                                }
                                else{
                                    echo '<li class="page-item"><a href="index.php?ac=product&page='.$i.'&search='.$searchKeyWord.'" class=" page-link" name="page">'.$i.'</a></li>';
                                }
							}
						}
						echo '</div>';
					?>
    				<!-- <li class="page-item"><a class="page-link" href="#">Next</a></li> -->
  				</ul>
			</nav>
		</div>
	</div>
</div>


<!-- Modal1 -->
<div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
	<div class="overlay-modal1 js-hide-modal1"></div>

	<div class="container">
		<div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
			<button class="how-pos3 hov3 trans-04 js-hide-modal1">
				<img src="images/icons/icon-close.png" alt="CLOSE">
			</button>

			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						<div class="wrap-slick3 flex-sb flex-w">
							<div class="wrap-slick3-dots"></div>
							<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

							<div class="slick3 gallery-lb">
								<div class="item-slick3" data-thumb="images/product-detail-01.jpg">
									<div class="wrap-pic-w pos-relative">
										<img src="images/product-detail-01.jpg" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="images/product-detail-01.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>

								<div class="item-slick3" data-thumb="images/product-detail-02.jpg">
									<div class="wrap-pic-w pos-relative">
										<img src="images/product-detail-02.jpg" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="images/product-detail-02.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>

								<div class="item-slick3" data-thumb="images/product-detail-03.jpg">
									<div class="wrap-pic-w pos-relative">
										<img src="images/product-detail-03.jpg" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="images/product-detail-03.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="p-r-50 p-t-5 p-lr-0-lg">
						<h4 class="mtext-105 cl2 js-name-detail p-b-14">
							Lightweight Jacket
						</h4>

						<span class="mtext-106 cl2">
							$58.79
						</span>

						<p class="stext-102 cl3 p-t-23">
							Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris consequat ornare feugiat.
						</p>

						<!--  -->
						<div class="p-t-33">
							<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6">
									Size
								</div>

								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select class="js-select2" name="time">
											<option>Choose an option</option>
											<option>Size S</option>
											<option>Size M</option>
											<option>Size L</option>
											<option>Size XL</option>
										</select>
										<div class="dropDownSelect2"></div>
									</div>
								</div>
							</div>

							<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6">
									Color
								</div>

								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select class="js-select2" name="time">
											<option>Choose an option</option>
											<option>Red</option>
											<option>Blue</option>
											<option>White</option>
											<option>Grey</option>
										</select>
										<div class="dropDownSelect2"></div>
									</div>
								</div>
							</div>

							<div class="flex-w flex-r-m p-b-10">
								<div class="size-204 flex-w flex-m respon6-next">
									<div class="wrap-num-product flex-w m-r-20 m-tb-10">
										<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-minus"></i>
										</div>

										<input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1">

										<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-plus"></i>
										</div>
									</div>

									<button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
										Add to cart
									</button>
								</div>
							</div>
						</div>

						<!--  -->
						<div class="flex-w flex-m p-l-100 p-t-40 respon7">
							<div class="flex-m bor9 p-r-10 m-r-11">
								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
									<i class="zmdi zmdi-favorite"></i>
								</a>
							</div>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
								<i class="fa fa-facebook"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
								<i class="fa fa-twitter"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
								<i class="fa fa-google-plus"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>