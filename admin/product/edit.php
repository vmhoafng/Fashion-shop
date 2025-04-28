<?php
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $product = getProductByProductId($product_id);
    $categories = loadAllCategory();
}

if (isset($_POST['product_id'])) {
    echo '<script>console.log("' . $product['product_image'] . '")</script>';
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_color = $_POST['product_color'];
    $product_category = $_POST['product_category'];
    $product_description = $_POST['product_description'];
    $product_size = $_POST['product_size'];
    $product_status = $_POST['product_status'];
    $product_amount = $_POST['product_amount'];

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $product_image = addslashes(file_get_contents($_FILES['product_image']['tmp_name']));
    } else {
        $product_image = addslashes($product['product_image']);
    }

    editProduct($product_id, $product_name, $product_price, $product_color, $product_category, $product_image, $product_description, $product_size, $product_status, $product_amount);
    header("Location: index.php?ac=product");
}
?>

<main class="page-content">
    <div class="container-fluid">
        <h2>Chỉnh sửa sản phẩm</h2>
        <form method="post" action="#" enctype="multipart/form-data" class="pb-0 pt-0 pl-0 pr-0">
            <div class="form-group">
                <label for="product_id" hidden>Mã sản phẩm</label>
                <input type="text" class="form-control" id="product_id" name="product_id"
                    value="<?php echo $product['product_id']; ?>" hidden>
            </div>
            <div class="form-group">
                <label for="product_name">Tên sản phẩm</label>
                <input type="text" class="form-control" id="product_name" name="product_name"
                    value="<?php echo $product['product_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_price">Giá sản phẩm ($)</label>
                <input type="number" class="form-control" id="product_price" name="product_price"
                    value="<?php echo $product['product_price']; ?>" min="0" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="product_color">Màu sắc sản phẩm</label>
                <input type="text" class="form-control" id="product_color" name="product_color"
                    value="<?php echo $product['product_color']; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_size">Kích thước sản phẩm</label>
                <input type="text" class="form-control" id="product_size" name="product_size"
                    value="<?php echo $product['product_size']; ?>" required>
            </div>
            <div class="form-group">
                <label for="product_category">Danh mục sản phẩm</label>
                <select class="form-control" id="product_category" name="product_category" required>
                    <?php foreach ($categories as $category) { ?>
                    <option value="<?php echo $category['category_id']; ?>"
                        <?php if ($category['category_id'] == $product['category_id']) echo 'selected'; ?>>
                        <?php echo $category['category_name']; ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="product_status">Trạng thái sản phẩm</label>
                <select class="form-control" id="product_status" name="product_status" required>
                    <option value="0" <?php if ($product['hidden'] == 0) echo 'selected'; ?>>Hiển thị</option>
                    <option value="1" <?php if ($product['hidden'] == 1) echo 'selected'; ?>>Ẩn</option>
                </select>
            </div>
            <div class="form-group">
                <label for="product_amount">Số lượng sản phẩm</label>
                <input type="number" class="form-control" id="product_amount" name="product_amount"
                    value="<?php echo $product['amount']; ?>" min="0" required>
            </div>
            <div class="form-group">
                <label for="product_image">Hình ảnh sản phẩm</label>
                <input type="file" class="form-control" id="product_image" name="product_image"
                    onchange="previewImage(event)">
                <img id="preview" src="data:image/jpeg;base64,<?php echo base64_encode($product['product_image']); ?>"
                    alt="Xem trước hình ảnh" style="max-width:200px; max-height:200px;">
            </div>
            <script>
            function previewImage(event) {
                var reader = new FileReader();
                reader.onload = function() {
                    var output = document.getElementById('preview');
                    output.src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            }
            </script>
            <div class="form-group">
                <label for="product_description">Mô tả sản phẩm</label>
                <textarea class="form-control" id="product_description" name="product_description"
                    required><?php echo $product['product_description']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-0">Cập nhật</button>
            <a href="index.php?ac=product" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</main>