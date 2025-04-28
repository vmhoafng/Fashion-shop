<?php
// Hàm lấy danh sách sản phẩm không bị ẩn, sắp xếp theo tên
function loadSanPham_Product() {
    $sql = "SELECT * FROM product WHERE hidden = 0 ORDER BY product_name";
    return pdo_query($sql);
}

// Hàm lấy danh sách sản phẩm, sắp xếp theo product_id
function loadSanPham_OrderByProductId() {
    $sql = "SELECT * FROM product ORDER BY product_id";
    return pdo_query($sql);
}

// Hàm thêm sản phẩm mới (đã thêm amount)
function addProduct($product_name, $product_price, $product_color, $product_category, $product_image, $product_description, $product_size, $product_amount) {
    $sql = "INSERT INTO product (product_name, product_price, product_color, category_id, product_image, product_description, product_size, amount) 
            VALUES ('$product_name', '$product_price', '$product_color', '$product_category', '$product_image', '$product_description', '$product_size', '$product_amount')";
    pdo_execute($sql);
    echo '<script>console.log("'.$sql.'")</script>';
}

// Hàm tìm kiếm sản phẩm theo từ khóa
function searchFunction($searchText) {
    $sql = "SELECT * FROM product WHERE product_name LIKE '%$searchText%'";
    $listProduct = pdo_query($sql);
    return $listProduct;
}

// Hàm lấy tất cả danh mục
function loadAllCategory() {
    $sql = "SELECT * FROM categories";
    $listCategories = pdo_query($sql);
    return $listCategories;
}

// Hàm lấy sản phẩm theo danh mục
function loadProductByCategory($categoryId) {
    $sql = "SELECT * FROM product WHERE hidden = 0 AND category_id = $categoryId";
    $listProduct = pdo_query($sql);
    return $listProduct;
}

// Hàm lấy sản phẩm theo trang
function loadProductByPageIdx($pageIndex, $pageSize) {
    $offSet = ($pageIndex - 1) * $pageSize;
    $sql = "SELECT * FROM product LIMIT $offSet, $pageSize";
    $listProduct = pdo_query($sql);
    return $listProduct;
}

// Hàm lấy sản phẩm theo trang và danh mục
function loadProductByPageIdxAndCategory($pageIndex, $pageSize, $categoryId) {
    $offSet = ($pageIndex - 1) * $pageSize;
    $sql = "SELECT * FROM product WHERE category_id = $categoryId LIMIT $offSet, $pageSize";
    $listProduct = pdo_query($sql);
    return $listProduct;
}

// Hàm tính tổng số trang
function totalPage($listProduct, $pageSize) {
    $totalPage = ceil(count($listProduct) / $pageSize);
    return $totalPage;
}

// Hàm lấy sản phẩm theo màu sắc
function loadProductByColor($color) {
    $sql = "SELECT * FROM product WHERE hidden = 0 AND product_color = '$color'";
    $listProduct = pdo_query($sql);
    return $listProduct;
}

// Hàm lấy danh sách màu sắc duy nhất từ sản phẩm
function getUniqueProductColors($listProduct) {
    $uniqueColors = [];
    foreach ($listProduct as $product) {
        if (!in_array($product['product_color'], $uniqueColors)) {
            $uniqueColors[] = $product['product_color'];
        }
    }
    return $uniqueColors;
}

// Hàm lấy danh sách kích thước duy nhất từ sản phẩm
function getUniqueProductSize($listProduct) {
    $uniqueSize = [];
    foreach ($listProduct as $product) {
        if (!in_array($product['product_size'], $uniqueSize)) {
            $uniqueSize[] = $product['product_size'];
        }
    }
    return $uniqueSize;
}

// Hàm lọc sản phẩm theo màu sắc
function filterProductByColor($color) {
    $sql = "SELECT * FROM product WHERE product_color = '$color'";
    $listProduct = pdo_query($sql);
    return $listProduct;
}

// Hàm xây dựng truy vấn SQL động
function constructQuery($color = null, $category = null, $searchKeyword = null, $minPrice = null, $maxPrice = null) {
    $sql = "SELECT * FROM product WHERE hidden = 0";
    
    if ($color !== null && $color !== '') {
        $sql .= " AND product_color = '$color'";
    }
    if ($category !== null && $category !== '') {
        $sql .= " AND category_id = $category";
    }
    if ($searchKeyword !== null && $searchKeyword !== '') {
        $sql .= " AND product_name LIKE '%$searchKeyword%'";
    }
    if ($minPrice !== null && $maxPrice !== null && $minPrice !== '' && $maxPrice !== '') {
        $sql .= " AND product_price BETWEEN $minPrice AND $maxPrice";
        echo "<script>console.log('Debug Objects: " . $sql . "' );</script>";
    }
    
    return $sql;
}

// Hàm lọc sản phẩm theo các tiêu chí
function filterBy($color = null, $category = null, $searchKeyword = null, $minPrice = null, $maxPrice = null) {
    $sql = constructQuery($color, $category, $searchKeyword, $minPrice, $maxPrice);
    $listProduct = pdo_query($sql);
    return $listProduct;
}

// Hàm tìm kiếm nâng cao
function advanceSearch($searchKeyword = null, $categoryFilter = null, $colorFilter = null, $sizeFilter = null, $priceFilter = null) {
    $sql = "SELECT * FROM product WHERE hidden = 0";
    
    if ($searchKeyword !== null && $searchKeyword !== '') {
        $sql .= " AND product_name LIKE '%$searchKeyword%'";
    }
    if (!empty($categoryFilter)) {
        $count = count($categoryFilter);
        $idx = 0;
        $sql .= " AND (";
        foreach ($categoryFilter as $category) {
            $idx++;
            if ($idx == $count) {
                $sql .= " category_id = $category";
            } else {
                $sql .= " category_id = $category OR";
            }
        }
        $sql .= ")";
    }
    if (!empty($colorFilter)) {
        $count = count($colorFilter);
        $idx = 0;
        $sql .= " AND (";
        foreach ($colorFilter as $color) {
            $idx++;
            if ($idx == $count) {
                $sql .= " product_color = '$color'";
            } else {
                $sql .= " product_color = '$color' OR";
            }
        }
        $sql .= ")";
    }
    if (!empty($sizeFilter)) {
        $count = count($sizeFilter);
        $idx = 0;
        $sql .= " AND (";
        foreach ($sizeFilter as $size) {
            $idx++;
            if ($idx == $count) {
                $sql .= " product_size = '$size'";
            } else {
                $sql .= " product_size = '$size' OR";
            }
        }
        $sql .= ")";
    }
    if (!empty($priceFilter)) {
        $count = count($priceFilter);
        $idx = 0;
        $sql .= " AND (";
        foreach ($priceFilter as $price) {
            $idx++;
            if ($idx == $count) {
                $sql .= "( product_price $price)";
            } else {
                $sql .= "(product_price $price) OR";
            }
        }
        $sql .= ")";
    }
    echo '<script>console.log("'.$sql.'")</script>';
    $listProduct = pdo_query($sql);
    return $listProduct;
}

// Hàm lấy thông tin sản phẩm theo product_id
function getProductByProductId($id) {
    $sql = "SELECT * FROM product WHERE product_id = $id";
    $productDetail = pdo_query_one($sql);
    return $productDetail;
}

// Hàm lấy tên danh mục theo category_id
function getCategoryNameById($id) {
    $sql = "SELECT category_name FROM categories WHERE category_id = $id";
    $categoryName = pdo_query_value($sql);
    return $categoryName;
}

// Hàm ẩn sản phẩm
function hideProduct($id) {
    $sql = "UPDATE product SET hidden = 1 WHERE product_id = $id";
    pdo_execute($sql);
}

// Hàm sửa thông tin sản phẩm (đã thêm amount)
function editProduct($product_id, $product_name, $product_price, $product_color, $product_category, $product_image, $product_description, $product_size, $product_status, $product_amount) {
    $sql = "UPDATE product 
            SET category_id = '$product_category', 
                product_name = '$product_name', 
                product_size = '$product_size', 
                product_price = '$product_price', 
                product_description = '$product_description', 
                product_color = '$product_color', 
                product_image = '$product_image', 
                hidden = $product_status, 
                amount = $product_amount 
            WHERE product_id = '$product_id'";
    echo '<script>console.log("'.$sql.'")</script>';
    pdo_execute($sql);
}

// Hàm lấy thông tin sản phẩm
function get_info_product($product_id) {
    $sql = "SELECT * FROM product WHERE product_id = $product_id";
    return pdo_query_one($sql);
}

// Hàm sửa thông tin người dùng
function edituser($user_id, $user_name, $user_email, $user_phoneNumber, $user_address) {
    $sql = "UPDATE user 
            SET user_name = '$user_name', 
                user_email = '$user_email', 
                user_phoneNumber = '$user_phoneNumber', 
                user_address = '$user_address' 
            WHERE user_id = '$user_id'";
    pdo_execute($sql);
}

// Hàm thay đổi mật khẩu người dùng
function changePassword($user_id, $newPassword) {
    $sql = "UPDATE user SET user_password = '$newPassword' WHERE user_id = '$user_id'";
    pdo_execute($sql);
}

// Hàm giảm số lượng sản phẩm khi thêm vào giỏ hàng
function decreaseProductAmount($product_id, $quantity) {
    $sql = "UPDATE product 
            SET amount = amount - $quantity 
            WHERE product_id = $product_id AND amount >= $quantity";
    pdo_execute($sql);
}
?>