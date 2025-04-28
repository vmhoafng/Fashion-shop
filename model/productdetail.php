<?php
// Hàm lấy danh mục của sản phẩm theo product_id
function getCategoryIdByProductId($id) {
    $sql = "SELECT category_id FROM product WHERE product_id = $id";
    $categoryId = pdo_query_value($sql);
    return $categoryId;
}

// Hàm lấy thông tin biến thể sản phẩm theo product_id (nếu cần)
function getProductDetailByProductId($id) {
    $sql = "SELECT * FROM product_variation WHERE product_id = $id";
    echo "<script>console.log('Debug Objects: " . $sql . "' );</script>";
    $listOfProductDetail = pdo_query($sql);
    return $listOfProductDetail;
}

// Hàm lấy giá sản phẩm theo màu sắc và kích thước (nếu cần)
function getProductPriceByColorAndSize($id, $color, $size) {
    $sql = "SELECT price FROM product_variation 
            WHERE product_id = $id AND color = '$color' AND size = '$size'";
    $productPrice = pdo_query_value($sql);
    return $productPrice;
}

// Hàm kiểm tra số lượng sản phẩm có đủ để thêm vào giỏ hàng không
function checkProductAmount($product_id, $quantity) {
    $sql = "SELECT amount FROM product WHERE product_id = $product_id";
    $amount = pdo_query_value($sql);
    return $amount >= $quantity;
}
?>