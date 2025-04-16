<!-- Viết các hàm truy vấn sql của sản phẩm như: thêm sản phẩm, xóa sản phẩm, lấy thông tin sản phẩm, cập nhật thông tin sản phẩm... -->
<!-- Ví dụ
    // hàm thêm sản phẩm mới
    function add_product($ten_sp, $gia_sp, $fileName, $mota_sp, $ma_dm, $gia_ban) {
        $sql = "INSERT INTO sanpham(ten_sp, gia_sp, anh_sp, mota_sp, luotxem_sp, ma_dm, trangthai, gia_ban) VALUES('$ten_sp', '$gia_sp', '$fileName', '$mota_sp', 0, '$ma_dm', 1, '$gia_ban')";
        pdo_execute($sql);
    } 
-->
<?php
 function loadSanPham_Product(){
    $sql="select * from product where hidden=0 order by product_name";
    return pdo_query($sql);
}
function loadSanPham_OrderByProductId(){
    $sql="select * from product order by product_id";
    return pdo_query($sql);
}
function addProduct($product_name,$product_price,$product_color,$product_category,$product_image,$product_description,$product_size){
    $sql="insert into product(product_name,product_price,product_color,category_id,product_image,product_description,product_size) values('".$product_name."','".$product_price."','".$product_color."','".$product_category."','".$product_image."','".$product_description."','".$product_size."')";
    pdo_execute($sql);
    echo '<script>console.log("'.$sql.'")</script>';
}
 function searchFunction($searchText) {
    $sql= "select * from product where 1";
    $sql.=" and product_name like '%".$searchText."%'";
    $listProduct=pdo_query($sql);
    return $listProduct;
}
function loadAllCategory(){
    $sql= "select * from categories";
    $listCategories=pdo_query($sql);
    return $listCategories;
}
function loadProductByCategory($categoryId){
    $sql= 'select * from product where hidden=0 and product.category_id='.$categoryId;
    $listProduct=pdo_query($sql);
    return $listProduct;
}
function loadProductByPageIdx($pageIndex,$pageSize){
    $offSet=($pageIndex-1)*$pageSize;
    $sql='Select * from product limit '.$offSet.','.$pageSize;

    $listProduct=pdo_query($sql);
    return $listProduct;

}
function loadProductByPageIdxAndCategory($pageIndex,$pageSize,$categoryId){
    $offSet=($pageIndex-1)*$pageSize;
    $sql='Select * from product where product.category_id = '.$categoryId.' limit '.$offSet.','.$pageSize;
    // $sql='Select * from product limit '.$offSet.','.$pageSize.' where product.category_id='.$categoryId;
    $listProduct=pdo_query($sql);
    return $listProduct;
}
function totalPage($listProduct,$pageSize){
    $totalPage=ceil(count($listProduct)/$pageSize);
    return $totalPage;
}
function loadProductByColor($color){
    $sql= 'select * from product where hidden=0 and product.product_color='.$color;
    $listProduct=pdo_query($sql);
    return $listProduct;
}
function getUniqueProductColors($listProduct) {
    $uniqueColors = [];

    foreach($listProduct as $product) {
        // Check if the product color is not already in the uniqueColors array
        if(!in_array($product['product_color'], $uniqueColors)) {
            // Add the product color to the uniqueColors array
            $uniqueColors[] = $product['product_color'];
        }
    }

    return $uniqueColors;
}
function getUniqueProductSize($listProduct){
    $uniqueSize=[];
    foreach($listProduct as $product){
        if(!in_array($product['product_size'],$uniqueSize)){
            $uniqueSize[]=$product['product_size'];
        }
    }
    return $uniqueSize;

}
function filterProductByColor($color){
    $sql= "select * from product where product.product_color='".$color."'";
    $listProudct=pdo_query($sql);
    return $listProudct;
}
function constructQuery($color = null, 
                    $category = null, $searchKeywork = null,
                    $minPrice=null,$maxPrice=null) {
    $sql = "SELECT * FROM product WHERE 1 and hidden=0 ";

    // Add conditions based on the provided arguments
    if ($color !== null && $color!=='') {
        $sql .= " AND product_color = '".$color."'";
    }
    if ($category !== null && $category!=='') {
        $sql .= " AND category_id = ".$category;
    }
    // Add additional conditions as needed
    
    // Add search  clause
    if ($searchKeywork !== null && $searchKeywork!='') {
        $sql .= " and product_name like '%".$searchKeywork."%'";
    }
    
    if($minPrice!==null && $maxPrice!==null && $minPrice!='' && $maxPrice!='' ){
        $sql.=' and product_price between '.$minPrice.' and '.$maxPrice.'';
        echo "<script>console.log('Debug Objects: " . $sql . "' );</script>";
    }
    // if($pageIdx!==null && $pageSize!=''){
    //     if($pageIdx==1){
    //         $sql.=' limit '.($pageIdx-1).','.$pageSize;
    //     }
    //     else{
    //         $sql.=' limit '.($pageIdx-1)+$pageSize.','.$pageSize;
    //     }

    // }
    

    return $sql;
}
function filterBy($color = null, $category = null, $searchKeywork = null
,$minPrice=null,$maxPrice=null){
    $sql=constructQuery($color, $category, $searchKeywork,$minPrice,$maxPrice);
    $listProduct=pdo_query($sql);
    return $listProduct;
}

function advanceSearch($searchKeywork=null,$categoryFilter=null,$colorFilter=null,$sizeFilter=null,$priceFilter=null){
   $sql="select * from product where 1 and hidden=0 ";
    if($searchKeywork!==null && $searchKeywork!=''){
         $sql.=" and product_name like '%".$searchKeywork."%'";
    }
    if(!empty($categoryFilter)){
        $count=count($categoryFilter);
        $idx=0;
        $sql.=" and (";
        foreach($categoryFilter as $category){
            $idx++;
            if($idx==$count){
                $sql.=" category_id=".$category;
            }
            else{
                $sql.=" category_id=".$category." or";
            }
        }
        $sql.=")";
    }
    if(!empty($colorFilter)){
        $count=count($colorFilter);
        $idx=0;
        $sql.=" and (";
        foreach($colorFilter as $color){
            $idx++;
            if($idx==$count){
                $sql.=" product_color='".$color."'";
            }
            else{
                $sql.=" product_color='".$color."' or";
            }
        }
        $sql.=")";
    }
    if(!empty($sizeFilter)){
        $count=count($sizeFilter);
        $idx=0;
        $sql.=" and (";
        foreach($sizeFilter as $size){
            $idx++;
            if($idx==$count){
                $sql.=" product_size='".$size."'";
            }
            else{
                $sql.=" product_size='".$size."' or";
            }
        }
        $sql.=")";
    }
    if(!empty($priceFilter)){
        $count=count($priceFilter);
        $idx=0;
        $sql.=" and (";
        foreach($priceFilter as $price){
            $idx++;
            if($idx==$count){
                $sql.="( product_price ".$price.")";
            }
            else{
                $sql.="(product_price ".$price.") or";
            }
        }
        $sql.=")";
    }
    echo '<script>console.log("'.$sql.'")</script>';
    $listProduct=pdo_query($sql);
    return $listProduct;

}
function getProductByProductId($id){
    $sql='select * from product where product_id='.$id;
    $productDetail=pdo_query_one($sql);
    return $productDetail;
}
//cheat
function getCategoryNameById($id){
    $sql='select category_name from categories where category_id='.$id;
    $categoryName=pdo_query_value($sql);
    return $categoryName;
}
function hideProduct($id){
    $sql = "UPDATE product SET hidden = 1 WHERE product_id = $id";
    pdo_execute($sql);
}
function editProduct($product_id,$product_name,$product_price,$product_color,$product_category,$product_image,$product_description,$product_size,$product_status){
    $sql="update product set category_id='".$product_category."', product_name='".$product_name."',product_size='".$product_size."',product_price='".$product_price."',product_description='".$product_description."',product_color='".$product_color."' ,product_image='".$product_image."' , hidden=".$product_status." where product_id='".$product_id."'";
    echo '<script>console.log("'.$sql.'")</script>';
    pdo_execute($sql);
}


function get_info_product($product_id) {
    $sql = "SELECT * FROM product WHERE product_id = $product_id";
    return pdo_query_one($sql);
}

function edituser($user_id,$user_name,$user_email,$user_phoneNumber,$user_address){
    $sql="update user set user_name='".$user_name."',user_email='".$user_email."',user_phoneNumber='".$user_phoneNumber."',user_address='".$user_address."' where user_id='".$user_id."'";
    pdo_execute($sql);
}
function changePassword($user_id,$newPassword){
    $sql="update user set user_password='".$newPassword."' where user_id='".$user_id."'";
    pdo_execute($sql);
}
?>