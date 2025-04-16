<?php
// function getProductDetailByProductId($id){
//     $sql="select * from product_variation where product_id=".$id."";
    
// 	echo "<script>console.log('Debug Objects: " . $sql . "' );</script>";
//     $listOfProductDetail=pdo_query($sql);
//     return $listOfProductDetail;
// }
// function getProductPriceByColorAndSize($id,$color,$size){
//     $sql='select price from product_variation where product_id='.$id.' and color='.$color.' and size='.$size.' ';
//     $productPrice=pdo_query_value($sql);
//     return $productPrice;
// }
function getCategoryIdByProductId($id){
    $sql='select category_id from product where product_id='.$id.'';
    $categoryid=pdo_query_value($sql);
    return $categoryid;
}
