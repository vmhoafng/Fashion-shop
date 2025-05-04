<?php
$categories = loadAllCategory();
echo '<script>console.log("Hi")</script>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';

    if (isset($_POST['product_name']) && isset($_POST['product_price']) && isset($_POST['product_color']) && 
        isset($_POST['product_category']) && isset($_POST['product_description']) && isset($_POST['product_size']) && 
        isset($_POST['product_amount'])) {
        echo '<script>console.log("Ho")</script>';
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_color = $_POST['product_color'];
        $product_category = $_POST['product_category'];
        $product_image = addslashes(file_get_contents($_FILES['product_image']['tmp_name']));
        $product_description = $_POST['product_description'];
        $product_size = $_POST['product_size'];
        $product_amount = $_POST['product_amount'];

        echo '<script>console.log("' . $product_image . '")</script>';
        addProduct($product_name, $product_price, $product_color, $product_category, $product_image, $product_description, $product_size, $product_amount);
        header("Location: index.php?ac=product");
    }
}
?>

<main class="page-content">
    <div class="container-fluid">
        <div class="title-management">
            <h3>Product Management</h3>
            <h5><i class="fa fa-angle-right"></i> Add New Product</h5>
            <a href="index.php?ac=product" class="btn all-btn-management btn-primary">
                <i class="fas fa-angle-double-left"></i> Return
            </a>
        </div>
        <hr>
        <form method="post" action="#" enctype="multipart/form-data" class="form-management">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Product Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="product_name" name="product_name" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Price</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="product_price" name="product_price" min="0" step="0.01" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Color</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="product_color" name="product_color" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Size</label>
                <div class="col-sm-10">
                    <select class="form-control" id="product_size" name="product_size" required>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Category</label>
                <div class="col-sm-10">
                    <select class="form-control" id="product_category" name="product_category" required>
                        <?php foreach ($categories as $category) { ?>
                        <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Amount</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="product_amount" name="product_amount" min="0" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="product_image" name="product_image" onchange="previewImage(event)" required>
                    <img id="preview" src="" alt="Xem trước hình ảnh" style="max-width:200px; max-height:200px; margin-top: 10px;">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="product_description" name="product_description" required></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg mx-auto d-block">
                <i class="fas fa-plus"></i> Add
            </button>
        </form>
    </div>
</main>
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