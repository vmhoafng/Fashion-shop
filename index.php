<!-- Header -->
<?php
ob_start();
session_start();

include "view/header.php";


include "model/pdo.php";
include "model/account.php";
include "model/product.php";
include "model/productdetail.php";
include "admin/order/ordertemp.php";

// Nguyen Van Dung
include "model/cart.php";
include "model/cart_detail.php";
include "model/bill.php";
include "model/bill_detail.php";
include "model/order.php";
include "model/order_detail.php";
include "model/status.php";
?>

<?php

	function sum_session_cart() {
		$sum_quantity = 0;
		if(!empty($_SESSION['cart_no_login'])) {
			// tính tổng số lượng sản phẩm trong cart
			foreach($_SESSION['cart_no_login'] as $item) {
				$sum_quantity += $item[1];
			}
			$_SESSION['sum_quantity_no_login'] = $sum_quantity;
		}
		else {
			$_SESSION['sum_quantity_no_login'] = 0;
		}

	}


?>





<!-- Controller -->
<?php

if (isset($_GET['ac']) && $_GET['ac'] != "") {
	$ac = $_GET['ac'];

	switch ($ac) {
		case 'userdetail':
			include "view/user/userDetail.php";
			break;
		case 'edituser':
			include "view/user/editUser.php";
			break;
		case 'changepassword':
			include "view/user/changepassword.php";
			break;
		case 'cart':
			
			// kiểm tra user đã login hay chưa
			if(isset($_SESSION['user'])) { // đã login
				// show cart

				//1. lấy danh sách id sản phẩm
				
				$list_id_product = get_list_code_product($_SESSION['user']['user_id']);

				$sum_product_cart = get_quantity_product($_SESSION['user']['user_id']);
				$_SESSION['sum_product_cart'] = $sum_product_cart;
				
			}
			else { //chưa login
				// show cart chưa login
				// $_SESSION['cart_no_login']

				sum_session_cart();

			}
			
			include "view/cart/cart.php";
			break;
		case 'add_to_cart':
			// lấy thông tin sản phẩm
			if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_add_to_cart'])) {
				$product_id_get = $_POST['id_product'];
				$quantity_get = $_POST['num-product'];
			}
			// kiểm tra khi nhấn add to cart user đăng nhập chưa:
			if(isset($_SESSION['user'])) {
				// nếu đã đăng nhập:
				// Kiểm tra mã user có trong cart chưa
				$user_cart_info = get_info_user_cart($_SESSION['user']['user_id']);
				if(is_array($user_cart_info)) { 
					extract($user_cart_info);
					$id_cart = $cart_id;
					// echo "<script> alert('". $id_cart ."'); </script>";
					// nếu đã tồn tại thì xét sp đã có trong chi tiết cart chưa
					$info_cartdetail = get_info_product_cart_detail($product_id_get, $id_cart);
					if(is_array($info_cartdetail)){
						// nếu tồn tại thì update số lượng theo cart id
						extract($info_cartdetail);
						$quantity_current = $quantity;
						$quantity_new  = $quantity_current + $quantity_get;
						// update số lượng
						update_quantity($quantity_new, $product_id_get, $id_cart);

						// lấy số lượng sản phẩm trong giỏ hàng rồi hiển thị ra
						$sum_product_cart = get_quantity_product($_SESSION['user']['user_id']);
						$_SESSION['sum_product_cart'] = $sum_product_cart;
						echo "<script> alert('Đã thêm');
						window.location.href = 'index.php?ac=productDetail&id=". $product_id_get ."';</script>";
					}
					else {
						// nếu chưa thêm dô cart detail
						insert_cartdetail($id_cart, $product_id_get, $quantity_get);
						$sum_product_cart = get_quantity_product($_SESSION['user']['user_id']);
						$_SESSION['sum_product_cart'] = $sum_product_cart;
						echo "<script> alert('Đã thêm');
						window.location.href = 'index.php?ac=productDetail&id=". $product_id_get ."';</script>";
					}
				}
				else {
					// nếu chưa tồn tại thì thêm vào cart và trả về id_cart để thêm dô cart detail
					// lấy user_id thêm dô:
					$id_cart = insert_cart($_SESSION['user']['user_id']);
					
					// sau đó thêm sp vào cart detail
					insert_cartdetail($id_cart, $product_id_get, $quantity_get);

					$sum_product_cart = get_quantity_product($_SESSION['user']['user_id']);
					$_SESSION['sum_product_cart'] = $sum_product_cart;
					echo "<script> alert('Đã thêm');
					window.location.href = 'index.php?ac=productDetail&id=". $product_id_get ."';</script>";
				}
			}
			else {
				if(!isset($_SESSION['cart_no_login'])) {
					$_SESSION['cart_no_login'] = [];
				}

				// kiểm tra id sp đã tồn tại chưa 
				// nếu rồi thì thêm sl
				if(empty($_SESSION['cart_no_login'])) {
					// tạo 1 mảng: id, quantity
					$cart_product = [$product_id_get, $quantity_get];
					array_push($_SESSION['cart_no_login'], $cart_product);

					sum_session_cart();
				}
				else {
					$find = false;
					foreach($_SESSION['cart_no_login'] as $key => $item) {
						if($item[0] == $product_id_get) {
							$_SESSION['cart_no_login'][$key][1] += $quantity_get;
							$find = true;
							sum_session_cart();
							break;
						}
						
					}
					if($find == false) {
						// tạo 1 mảng: id, quantity
						$cart_product = [$product_id_get, $quantity_get];
						array_push($_SESSION['cart_no_login'], $cart_product);
						sum_session_cart();
					}
				}
				echo "<script> alert('Đã thêm');
						window.location.href = 'index.php?ac=productDetail&id=". $product_id_get ."';</script>";
			}
			
			break;


		case 'bill_info':
			

			if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_checkout']) && isset($_SESSION['user'])) {

				$payment = $_POST['pay'];

				if (isset($_POST['addHaoNam'])) {
					$diachi = intval($_POST['addHaoNam']);

					
					
					if($_POST['addHaoNam'] == 1) {
						$id_province = $_POST['province'];
						$id_district = $_POST['disrict'];
						$id_ward = $_POST['ward'];
						$post_code = $_POST['postcode'];

						$province = get_province($id_province);
						if(isset($province)){
							extract($province);
							$name_province = $name;
						}

						$district = get_district($id_district);
						if(isset($district)){
							extract($district);
							$name_district = $name;
						}
						
						$ward = get_ward($id_ward);
						if(isset($ward)){
							extract($ward);
							$name_ward = $name;
						}
						$address = $post_code . ", " . $name_ward . ", " . $name_district . ", " . $name_province;
					}
					else if($_POST['addHaoNam'] == 2) {
						$address = $_SESSION['user']['user_address'];
					}
				}



				// $address = $post_code . ", " . $name_ward . ", " . $name_district . ", " . $name_province;
				
				date_default_timezone_set('Asia/Ho_Chi_Minh');
				$created_date = date('Y-m-d');

				$list_detail_cart_1 = get_list_code_product($_SESSION['user']['user_id']);
			
				if(isset($_SESSION['user'])) {

					// thêm vào bill
					$id_bill = add_new_bill($_SESSION['user']['user_id'], $created_date, $address, $payment);

					if(empty($list_detail_cart_1)) {
						echo "<script> alert('Giỏ hàng rỗng'); 
						window.location.href = 'index.php?ac=cart';</script></script>";
					}
					else {
						$user_id = $_SESSION['user']['user_id'];

						$user = get_account($user_id);
						if(isset($user)) {
							extract($user);
							$name_user = $user_name;
							$phone = $user_phoneNumber;
						}
						// add vào bill info: bill_detail_id	bill_id  product_id	quantity	price	total
						// $list_detail_cart = get_list_code_product($_SESSION['user']['user_id']);
	
						$total_bill_cart = 0;
						$total_bill_success= 0;
						if(isset($list_detail_cart_1)){
							foreach($list_detail_cart_1 as $item) {
								extract($item);
								
								$id_pro = $product_id;
								$quantity_pro = $quantity;
	
								$get_pro = get_info_product($id_pro);
								if(isset($get_pro)) {
									extract($get_pro);
	
									$price_pro = $product_price;
									$total_bill_cart = $price_pro * $quantity_pro;
									$total_bill_success += $total_bill_cart;
	
									add_new_bill_detail($id_bill, $id_pro, $quantity_pro, $price_pro, $total_bill_cart);
								}
							}
						}
						// thêm vào order
						// order_id	user_id	status_id	order_created_date	estimate_ship_date	total

						$ship_date = date('Y-m-d', strtotime($created_date . ' +3 days'));
						//order_id	user_id	status_id	order_created_date	estimate_ship_date	total	

						$idOrder = add_new_order($user_id, $created_date, $ship_date, $total_bill_success, $address, $payment);

						$total_bill_cart_2 = 0;
						// $list_detail_cart_2 = get_list_code_product($_SESSION['user']['user_id']);
						if(isset($list_detail_cart_1)){
							foreach($list_detail_cart_1 as $item) {
								extract($item);

								$id_pro_2 = $product_id;
								$quantity_pro_2 = $quantity;
	
								$get_pro_2 = get_info_product($id_pro_2);
								if(isset($get_pro_2)) {
									extract($get_pro_2);
	
									$price_pro_2 = $product_price;
									$total_bill_cart_2 = $price_pro_2 * $quantity_pro_2;

									//order_detail_id	order_id	product_id	quantity	price	total
									add_new_order_detail($idOrder, $id_pro_2, $quantity_pro_2, $price_pro_2, $total_bill_cart_2);
								}
							}
						}
						// xóa chi tiết hóa đơn
						$del_cart_detail = get_info_user_cart($user_id);
						if(isset($del_cart_detail)) {
							extract($del_cart_detail);
							$id_card_delete = $cart_id;
							delete_cart_detail($id_card_delete);
							$_SESSION['sum_product_cart'] = 0;
							header("Location: index.php?ac=view_info_bill&id=$id_bill");
							exit();
						}
					}	
				}
				
			}
			else {
				echo "<script> alert('Vui lòng đăng nhập để tiếp tục mua hàng'); 
				window.location.href = 'index.php?ac=signin';</script></script>";
			}

			$_SESSION['sum_product_cart'] = 0;

		include "view/bill/bill_info.php";
		break;
		case 'to_bill':
			include "view/bill/list_bill.php";

			break;
		case 'view_info_bill':
			if(isset($_GET['id']) && $_GET['id'] > 0) {
				$bill_info = get_info_one_bill($_GET['id']);
				$bill = get_bill_info($_GET['id'], $_SESSION['user']['user_id']);
			}
			include "view/bill/view_info_bill.php";
			break;
		case 'to_order':
			
			include "view/order/list_order.php";
			break;
		
		case 'info_order':
			if(isset($_GET['id']) && $_GET['id'] > 0) {
				
				$detailOrder = get_order($_GET['id']);

				$orderOne = get_one_order($_GET['id'], $_SESSION['user']['user_id']);

				if(!empty($orderOne)) {
					extract($orderOne);
				}
			}
			include "view/order/order_info.php";
			break;
		case 'plus':
			if (isset($_GET['ac']) && isset($_GET['id'])) {
				$id_product = $_GET['id'];
				// Muốn cập nhập: cart_id, product_id, quantity + 1

				if(isset($_SESSION['user'])) {
					$item_cart = get_item_cartdetail($_SESSION['user']['user_id'], $id_product);
					if(isset($item_cart)){
						extract($item_cart);
						$id_cart = $cart_id;
						$new_quantity = $quantity + 1;

						update_item_cart($id_product, $id_cart, $new_quantity);

					}
					$sum_product_cart = get_quantity_product($_SESSION['user']['user_id']);
					$_SESSION['sum_product_cart'] = $sum_product_cart;

					header("Location: index.php?ac=cart");
				}
				else {
					if(!empty($_SESSION['cart_no_login'])) {
						foreach ($_SESSION['cart_no_login'] as $key => $item) {
							if ($item[0] == $id_product) {
								$_SESSION['cart_no_login'][$key][1] += 1;
								
            					break;
							}
						}
					}
					$_SESSION['cart_no_login'] = array_values($_SESSION['cart_no_login']);

					sum_session_cart();

					header("Location: index.php?ac=cart");
				}
			}
			
			break;
		case 'minus':
			if (isset($_GET['ac']) && isset($_GET['id'])) {
				$id_product = $_GET['id'];

				if(isset($_SESSION['user'])) {
					$item_cart = get_item_cartdetail($_SESSION['user']['user_id'], $id_product);
					if(isset($item_cart)){
						extract($item_cart);
						$id_cart = $cart_id;

						if($quantity > 1) {
							$new_quantity = $quantity - 1;
							update_item_cart($id_product, $id_cart, $new_quantity);
						}
					}
					$sum_product_cart = get_quantity_product($_SESSION['user']['user_id']);
					$_SESSION['sum_product_cart'] = $sum_product_cart;

					header("Location: index.php?ac=cart");
				}
				else {
					if(!empty($_SESSION['cart_no_login'])) {
						foreach ($_SESSION['cart_no_login'] as $key => $item) {
							if ($item[0] == $id_product) {
								if($_SESSION['cart_no_login'][$key][1] > 1) {
									$_SESSION['cart_no_login'][$key][1] -= 1;
								}
            					break;
							}
						}
					}
					$_SESSION['cart_no_login'] = array_values($_SESSION['cart_no_login']);

					sum_session_cart();

					header("Location: index.php?ac=cart");


				}
			}
			break;
		case 'delete_product':
			if(isset($_GET['id']) && $_GET['id'] > 0) {
				$product_id = $_GET['id'];
				if(isset($_SESSION['user'])) {
					

					delete_item_cart($_SESSION['user']['user_id'], $product_id);

					$list_id_product = get_list_code_product($_SESSION['user']['user_id']);

					$sum_product_cart = get_quantity_product($_SESSION['user']['user_id']);
					$_SESSION['sum_product_cart'] = $sum_product_cart;

					echo "<script> alert('Đã xóa');
								window.location.href = 'index.php?ac=cart';</script>";
				}
				else {
					// Xóa sản phẩm khỏi giỏ hàng
					foreach ($_SESSION['cart_no_login'] as $key => $item) {
						if ($item[0] == $product_id) {
							unset($_SESSION['cart_no_login'][$key]);
							break;
						}
					}

					// Sắp xếp lại mảng để tránh lỗ hổng key
					$_SESSION['cart_no_login'] = array_values($_SESSION['cart_no_login']);


					sum_session_cart();

					// $sum_quantity = 0;
					// if(!empty($_SESSION['cart_no_login'])) {
					// 	// tính tổng số lượng sản phẩm trong cart
					// 	foreach($_SESSION['cart_no_login'] as $item) {
					// 		$sum_quantity += $item[1];
					// 	}
					// 	$_SESSION['sum_quantity_no_login'] = $sum_quantity;
					// }
					// else {
					// 	$_SESSION['sum_quantity_no_login'] = 0;
					// }

					echo "<script> alert('Đã xóa');
								window.location.href = 'index.php?ac=cart';</script>";
				}

				
			}

			


			include "view/cart/cart.php";
			break;
		case 'cancel_order':
			if(isset($_GET['id']) && $_GET['id'] > 0) {
				$order_id = $_GET['id'];

				huydon($order_id);

			}
			$list_all_order = get_all_order($_SESSION['user']['user_id']);
			include "view/order/list_order.php";
			break;

		case 'product':

			include "view/product.php";
			break;
		case 'productDetail':

			
			
			if(isset( $_GET['id'] ) && $_GET['id'] >0){
				$currentProductDetailId=$_GET['id'];
				$currentProduct=getProductByProductId( $currentProductDetailId );
				// $listProductDetail=getProductDetailByProductId($currentProductDetailId);
				$categoryId=getCategoryIdByProductId($currentProductDetailId);
				$categoryName=getCategoryNameById($categoryId);

				
			}
			include "view/product-detail.php";
			break;
		case 'blog':
			include "view/blog.php";
			break;
		case 'about':
			include "view/about.php";
			break;
		case 'contact':
			include "view/contact.php";
			break;

		case 'signin':
			if (isset($_POST['signin']) && ($_POST['signin'])) {
				$email = $_POST['email'];
				$password = $_POST['password'];

				$result = check_user($email, $password);
			

				if (is_array($result)) {

					if ($result['role_id'] == 2) {
						$_SESSION['admin'] = $result;
						header('Location: admin/index.php');
					} else {
						$_SESSION['user'] = $result;
						$_SESSION['sum_product_cart'] = get_quantity_product($_SESSION['user']['user_id']);

						// Kiểm tra giỏ hàng có chưa
						// có thì lấy session ghi đè
						// chưa thì đổ vào cart

						$list_id_product = get_list_code_product($_SESSION['user']['user_id']);
						if(!empty($list_id_product) && !empty($_SESSION['cart_no_login'])){

							
							// xóa sạch cart detail theo id
							$cart_info = get_info_user_cart($_SESSION['user']['user_id']);
							extract($cart_info);

							delete_cart_detail($cart_id);
						
							// đổ session cart dô theo card id
							foreach($_SESSION['cart_no_login'] as $i) {
								insert_cartdetail($cart_id, $i[0], $i[1]);
							}

							$_SESSION['cart_no_login'] = [];
							$_SESSION['sum_product_cart'] = $_SESSION['sum_quantity_no_login'];
							$_SESSION['sum_quantity_no_login'] = 0;
						}

						if(empty($list_id_product) && !empty($_SESSION['cart_no_login'])){

							
							// // xóa sạch cart detail theo id
							// $cart_info = get_info_user_cart($_SESSION['user']['user_id']);
							// extract($cart_info);

							// kiểm tra user đã có id cart chưa
							$info_cart = get_info_user_cart($_SESSION['user']['user_id']);
							if($info_cart) {

								extract($info_cart);
						
								// đổ session cart dô theo card id
								foreach($_SESSION['cart_no_login'] as $i) {
									insert_cartdetail($cart_id, $i[0], $i[1]);
								}

								$_SESSION['cart_no_login'] = [];
								$_SESSION['sum_product_cart'] = $_SESSION['sum_quantity_no_login'];
								$_SESSION['sum_quantity_no_login'] = 0;

							}
							else {
								$id_cart = insert_cart($_SESSION['user']['user_id']);
						
								// đổ session cart dô theo card id
								foreach($_SESSION['cart_no_login'] as $i) {
									insert_cartdetail($id_cart, $i[0], $i[1]);
								}

								$_SESSION['cart_no_login'] = [];
								$_SESSION['sum_product_cart'] = $_SESSION['sum_quantity_no_login'];
								$_SESSION['sum_quantity_no_login'] = 0;

							}


							
							


						}
						

						header('Location: index.php');
					}

				} else {
					$notice = "Đăng nhập thất bại.";
				}
			}
			include "view/account/signin.php";
			break;

		case 'signout':
			unset($_SESSION['user']); // Xóa session 'user'
			unset($_SESSION['sum_product_cart']);
			header("Location: index.php");
			exit();
			break;

		case 'signup':
			if (isset($_POST['signup']) && ($_POST['signup'])) {
				$email = $_POST['email'];
				$password = $_POST['password'];
				$username = $_POST['username'];
				$phone = $_POST['phone'];
				$address = $_POST['address'];

				// check exits Email
				$result = check_email($email);
				$notice = "";

				// exits Email
				if ($result && $result['email_count'] > 0) {
					$notice = "Email đã được sử dụng.";
				} else {
					insert_user($email, $password, $username, $phone, 1, $address);
					$notice = "Đăng ký thành công.";
				}
			}
			include "view/account/signup.php";
			break;


		default:
			include "view/slider.php";
			include "view/home.php";
	}
} else {
	include "view/slider.php";
	include "view/home.php";
}

include "view/footer.php";


ob_end_flush();
?>
