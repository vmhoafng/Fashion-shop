<?php
$listProduct = loadSanPham_Product();
$listCategories = loadAllCategory();
$pageSize = 3;
$currentPageIdx = 1;
$test = 0;
$BASE_URL = 'index.php?ac=product';
$TEMP_URL = $BASE_URL;
$searchKeyWord = '';
$currentCategoryId = '';
$currentSelectedColor = '';
$currentSort = 0;
$currentProductDetailId = 0;
$minPrice = '';
$maxPrice = '';
$advanceCategoryFilter = [];
$advanceColorFilter = [];
$advanceSizeFilter = [];
$advancePriceFilter = [];
$availabelColors = getUniqueProductColors($listProduct);
$availableSizes = getUniqueProductSize($listProduct);

// Xử lý reset bộ lọc khi người dùng chọn "All Products"
if (isset($_GET['all_product'])) {
    unset($_SESSION['searchKeyWord']);
    unset($_SESSION['advanceCategoryFilter']);
    unset($_SESSION['advanceColorFilter']);
    unset($_SESSION['advanceSizeFilter']);
    unset($_SESSION['advancePriceFilter']);
    unset($_SESSION['sort']);
}

// Xử lý dữ liệu gửi từ form POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fields = ['searchKeyWord', 'advanceCategoryFilter', 'advanceColorFilter', 'advanceSizeFilter', 'advancePriceFilter', 'sort'];
    foreach ($fields as $field) {
        if (!empty($_POST[$field])) {
            echo '<script>console.log("Bộ lọc không rỗng: ' . $field . '")</script>';
            continue;
        } else {
            echo '<script>console.log("Phiên còn tồn tại: ' . $field . '")</script>';
            unset($_SESSION[$field]);
        }
    }
}

// Xử lý từ khóa tìm kiếm
if (isset($_GET['search'])) {
    $searchKeyWord = $_GET['search'];
}
if (isset($_POST['searchProduct']) && !empty($_POST['searchProduct'])) {
    $searchKeyWord = $_POST['searchProduct'];
    $_SESSION['searchKeyWord'] = $searchKeyWord;
} elseif (isset($_SESSION['searchKeyWord'])) {
    $searchKeyWord = $_SESSION['searchKeyWord'];
}

// Xử lý bộ lọc danh mục
if (isset($_POST['categoryfilter'])) {
    $categoryFilter = $_POST['categoryfilter'];
    $advanceCategoryFilter = $categoryFilter;
    $_SESSION['advanceCategoryFilter'] = $categoryFilter;
    foreach ($advanceCategoryFilter as $category) {
        echo "<script>console.log('Kiểm tra hộp kiểm danh mục: " . $category . "' );</script>";
    }
} elseif (isset($_SESSION['advanceCategoryFilter'])) {
    $advanceCategoryFilter = $_SESSION['advanceCategoryFilter'];
}

// Xử lý bộ lọc màu sắc
if (isset($_POST['colorfilter'])) {
    $colorFilter = $_POST['colorfilter'];
    $advanceColorFilter = $colorFilter;
    $_SESSION['advanceColorFilter'] = $colorFilter;
    foreach ($advanceColorFilter as $color) {
        echo "<script>console.log('Kiểm tra hộp kiểm màu sắc: " . $color . "' );</script>";
    }
} elseif (isset($_SESSION['advanceColorFilter'])) {
    $advanceColorFilter = $_SESSION['advanceColorFilter'];
}

// Xử lý bộ lọc kích thước
if (isset($_POST['sizefilter'])) {
    $sizeFilter = $_POST['sizefilter'];
    $advanceSizeFilter = $sizeFilter;
    $_SESSION['advanceSizeFilter'] = $sizeFilter;
    foreach ($advanceSizeFilter as $size) {
        echo "<script>console.log('Kiểm tra hộp kiểm kích thước: " . $size . "' );</script>";
    }
} elseif (isset($_SESSION['advanceSizeFilter'])) {
    $advanceSizeFilter = $_SESSION['advanceSizeFilter'];
}

// Xử lý bộ lọc giá
if (isset($_POST['pricefilter'])) {
    $priceFilter = $_POST['pricefilter'];
    $advancePriceFilter = $priceFilter;
    $_SESSION['advancePriceFilter'] = $priceFilter;
    foreach ($advancePriceFilter as $price) {
        echo "<script>console.log('Kiểm tra hộp kiểm giá: " . $price . "' );</script>";
    }
} elseif (isset($_SESSION['advancePriceFilter'])) {
    $advancePriceFilter = $_SESSION['advancePriceFilter'];
}

// Xử lý sắp xếp
if (isset($_POST['sort'])) {
    $currentSort = $_POST['sort'];
    $_SESSION['sort'] = $currentSort;
} elseif (isset($_SESSION['sort'])) {
    $currentSort = $_SESSION['sort'];
}

if (isset($_GET['searchProduct']) && !empty($_GET['searchProduct'])) {
    if (isset($_POST['searchProduct'])) {
        $_GET['searchProduct'] = $_POST['searchProduct'];
    }
    $searchKeyWord = $_GET['searchProduct'];
}

// Xử lý danh mục hiện tại
if (isset($_GET['categoryid']) && !empty($_GET['categoryid'])) {
    $currentCategoryId = $_GET['categoryid'];
    $advanceCategoryFilter = [];
    $advanceCategoryFilter[] = $currentCategoryId;
    $_SESSION['advanceCategoryFilter'] = $advanceCategoryFilter;
}

// Xử lý giá tối thiểu và tối đa
if (isset($_GET['minprice']) && !empty($_GET['minprice'])) {
    $minPrice = $_GET['minprice'];
    $maxPrice = $_GET['maxprice'];
}

// Xử lý trang hiện tại
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPageIdx = $_GET['page'];
}
if (isset($_POST['page']) && !empty($_POST['page'])) {
    $currentPageIdx = $_POST['page'];
    if (isset($_SESSION['advanceSizeFilter'])) {
        echo '<script>console.log("Ghi log tại trang: ' . $_SESSION['advanceSizeFilter'] . '")</script>';
    }
}

// Xử lý màu sắc hiện tại
if (isset($_GET['color']) && !empty($_GET['color'])) {
    $currentSelectedColor = $_GET['color'];
    $advanceColorFilter[] = $currentSelectedColor;
    if (strpos($TEMP_URL, "&color=") !== false) {
        $TEMP_URL = preg_replace('/&color=[^&]*/', '&color=' . $_GET['color'], $TEMP_URL);
    } else {
        $TEMP_URL .= '&color=' . $currentSelectedColor;
    }
}

// Xử lý sắp xếp hiện tại
if (isset($_GET['orderby']) && !empty($_GET['orderby'])) {
    $currentSort = $_GET['orderby'];
    $TEMP_URL .= '&orderby=' . $currentSort;
}

echo "<script>console.log('Thứ tự sắp xếp hiện tại: " . $currentSort . "' );</script>";

// Tìm kiếm nâng cao và phân trang
$listProduct = advanceSearch($searchKeyWord, $advanceCategoryFilter, $advanceColorFilter, $advanceSizeFilter, $advancePriceFilter);
$totalPage = totalPage($listProduct, $pageSize);
$totalProduct = count($listProduct);

// Sắp xếp sản phẩm
if ($currentSort == 1) {
    $prices = array_column($listProduct, 'product_price');
    array_multisort($prices, SORT_ASC, $listProduct);
} elseif ($currentSort == 2) {
    $prices = array_column($listProduct, 'product_price');
    array_multisort($prices, SORT_DESC, $listProduct);
} elseif ($currentSort == 3) {
    $ids = array_column($listProduct, 'product_id');
    array_multisort($ids, SORT_DESC, $listProduct);
} elseif ($currentSort == 4) {
    $ids = array_column($listProduct, 'product_id');
    array_multisort($ids, SORT_ASC, $listProduct);
}

$listProduct = array_slice($listProduct, ($currentPageIdx - 1) * $pageSize, $pageSize);
?>

<!-- CSS để định dạng lớp phủ "Hết hàng" -->
<style>
.out-of-stock-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-size: 20px;
    font-weight: bold;
    text-transform: uppercase;
}
</style>

<!-- Cart -->
<!-- Product -->
<div class="bg0 m-t-23 p-b-140">
    <div class="container">
        <div class="flex-w flex-sb-m p-b-52">
            <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5">
                    <?php echo "<a href='$BASE_URL&all_product=true'>Tất cả sản phẩm</a>"; ?>
                </button>
                <?php
                foreach ($listCategories as $category) {
                    extract($category);
                    if ($currentCategoryId == $category_id) {
                        echo "<a href='$BASE_URL&categoryid=$category_id' class='stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1' data-filter='.$category_name'>$category_name</a>";
                    } else {
                        echo "<a href='$BASE_URL&categoryid=$category_id' class='stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5' data-filter='.$category_name'>$category_name</a>";
                    }
                }
                ?>
            </div>
            <div class="flex-w flex-c-m m-tb-10">
                <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
                    <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                    <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                    Tìm kiếm
                </div>
            </div>
            <!-- Search product -->
            <div class="dis-none panel-search w-full p-t-10 p-b-15">
                <form method="post" action="index.php?ac=product">
                    <div class="bor8 dis-flex p-l-15">
                        <button type="submit" class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                            <i class="zmdi zmdi-search"></i>
                        </button>
                        <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="searchProduct"
                            placeholder="Tìm kiếm">
                    </div>
                    <div
                        class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-advanced-search">
                        <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                        <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Tìm kiếm nâng cao
                    </div>
                    <!-- Advanced Search Panel -->
                    <div class="dis-none panel-advanced-search w-full p-t-10 p-b-15">
                        <div class="row">
                            <div class="col m-l-1">
                                <h3>Danh mục</h3>
                                <?php
                                foreach ($listCategories as $category) {
                                    extract($category);
                                    $checked = in_array($category_id, $advanceCategoryFilter) ? 'checked' : '';
                                    echo "<div class='form-check'>
                                            <input class='form-check-input m-l-1' type='checkbox' id='category$category_id' name='categoryfilter[]' value='$category_id' $checked>
                                            <label class='form-check-label' for='category$category_id'>$category_name</label>
                                          </div>";
                                }
                                ?>
                            </div>
                            <div class="col">
                                <h3>Màu sắc</h3>
                                <?php
                                foreach ($availabelColors as $color) {
                                    $checked = in_array($color, $advanceColorFilter) ? 'checked' : '';
                                    echo "<div class='form-check'>
                                            <input class='form-check-input' type='checkbox' id='color$color' name='colorfilter[]' value='$color' $checked>
                                            <label class='form-check' for='color$color'>$color</label>
                                          </div>";
                                }
                                ?>
                            </div>
                            <div class="col">
                                <h3>Kích thước</h3>
                                <div class="filter-option">
                                    <?php
                                    foreach ($availableSizes as $size) {
                                        $checked = in_array($size, $advanceSizeFilter) ? 'checked' : '';
                                        echo "<div class='form-check'>
                                                <input class='form-check-input' type='checkbox' id='size$size' name='sizefilter[]' value='$size' $checked>
                                                <label class='form-check' for='size$size'>$size</label>
                                              </div>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col">
                                <h3>Khoảng giá</h3>
                                <?php
                                for ($i = 1; $i <= 4; $i++) {
                                    $checked = in_array("between " . (($i - 1) * 50) . " and " . $i * 50, $advancePriceFilter) ? 'checked' : '';
                                    echo "<div class='form-check'>
                                            <input class='form-check-input m-l-1' type='checkbox' id='price$i' name='pricefilter[]' value='between " . (($i - 1) * 50) . " and " . ($i * 50) . "' $checked>
                                            <label class='form-check-label' for='price$i'>" . (($i - 1) * 50) . " - " . ($i * 50) . " $</label>
                                          </div>";
                                }
                                ?>
                            </div>
                            <div class="col">
                                <h3>Sắp xếp theo</h3>
                                <?php
                                for ($i = 1; $i <= 4; $i++) {
                                    $checked = $i == $currentSort ? 'checked' : '';
                                    if ($i == 1) {
                                        $label = 'Giá: Thấp đến cao';
                                    } elseif ($i == 2) {
                                        $label = 'Giá: Cao đến thấp';
                                    } elseif ($i == 3) {
                                        $label = 'Mới nhất';
                                    } elseif ($i == 4) {
                                        $label = 'Cũ nhất';
                                    }
                                    echo "<div class='form-check'>
                                            <input class='form-check-input' type='radio' id='sort$i' name='sort' value='$i' $checked>
                                            <label class='form-check-label' for='sort$i'>$label</label>
                                          </div>";
                                }
                                ?>
                                <button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 p-lr-15 trans-04"
                                    type="submit">Tìm kiếm</button>
                                <a href="index.php?ac=product&all_product=true"
                                    class="flex-c-m stext-101 cl0 size-103 w-50 bg1 bor1 trans-04 mt-2">Xóa bộ lọc</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
        if (!empty($searchKeyWord) && isset($searchKeyWord)) {
            echo "<h2 class='fw-bold mb-3'>Từ khóa tìm kiếm: <span>$searchKeyWord</span></h2>";
        }
        ?>
        <div class="row isotope-grid">
            <?php
            if (count($listProduct) > 0) {
                foreach ($listProduct as $product) {
                    extract($product);
                    $stock = $product['amount'] ?? 0;
                    echo "<div class='col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women'>
                            <div class='block2'>
                                <div class='block2-pic hov-img0' style='position: relative;'>
                                    <img style='width: 315px; height: 390.06px;' src='data:image/jpeg;base64," . base64_encode($product_image) . "' alt='IMG-PRODUCT'>";
                    // Hiển thị lớp phủ "Hết hàng" nếu amount <= 0
                    if ($stock <= 0) {
                        echo "<div class='out-of-stock-overlay'>Hết hàng</div>";
                    }
                    echo "</div>
                                <div class='block2-txt flex-w flex-t p-t-14'>
                                    <div class='block2-txt-child1 flex-col-l'>
                                        <a href='index.php?ac=productDetail&id=$product_id' class='stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6'>
                                            $product_name
                                        </a>
                                        <span class='stext-105 cl3'>$product_price $</span>
                                    </div>
                                </div>
                            </div>
                          </div>";
                }
            } else {
                echo "<h1>Không có sản phẩm nào khớp với mô tả của bạn</h1>";
            }
            ?>
        </div>
        <!-- Pagination -->
        <div class="flex-c-m flex-w w-full p-t-45">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php
                    echo "<div class='m-r-10 m-t-15'>Trên tổng $totalProduct sản phẩm</div>";
                    echo "<div id='paginationForm' class='row m-l-5'>";
                    if ($totalPage > 1) {
                        for ($i = 1; $i <= $totalPage; $i++) {
                            if (empty($searchKeyWord)) {
                                echo "<li class='page-item'><a href='index.php?ac=product&page=$i' class='page-link' name='page'>$i</a></li>";
                            } else {
                                echo "<li class='page-item'><a href='index.php?ac=product&page=$i&search=$searchKeyWord' class='page-link' name='page'>$i</a></li>";
                            }
                        }
                    }
                    echo "</div>";
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Modal1 -->
