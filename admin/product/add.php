<?php 
    $categories=loadAllCategory();
    echo '<script>console.log("Hi")</script>';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Print out the contents of the $_POST array
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
        
    }
    

    // echo '<script>console.log("name:'.$_POST['product_name'].'/ price: '.$_POST['product_price'].'/ color:'.$_POST['product_color'].'/category:'.$_POST['product_category'].'/image:'.$_POST['product_image'].'/desb:'.$_POST['product_description'].'/size:'.$_POST['product_size'].'")</script>';
    if(isset($_POST['product_name']) && isset($_POST['product_price']) && isset($_POST['product_color']) && isset($_POST['product_category'])  && isset($_POST['product_description']) && isset($_POST['product_size']) ){
        echo '<script>console.log("Ho")</script>';
        $product_name=$_POST['product_name'];
        $product_price=$_POST['product_price'];
        $product_color=$_POST['product_color'];
        $product_category=$_POST['product_category'];
        $product_image=addslashes(file_get_contents($_FILES['product_image']['tmp_name']));
        $product_description=$_POST['product_description'];
        $product_size=$_POST['product_size'];
        // echo $product_name;
        // echo $product_price;
        // echo $product_color;
        // echo $product_category;
        // echo $product_image;
        // echo $product_description;
        // echo $product_size
        echo '<script>console.log("'.$product_image.'")</script>';
        addProduct($product_name,$product_price,$product_color,$product_category,$product_image,$product_description,$product_size);
        header("Location: index.php?ac=product");
    }
    


?>
<main class="page-content">
    <div class="container-fluid">

        <h2>Add new product</h2>
        <form method="post"  action="#"  enctype="multipart/form-data" class="pb-0 pt-0 pr-0 pl-0">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <div class="form-group">
                <label for="product_price">Product Price</label>
                <input type="number" class="form-control" id="product_price" name="product_price" min=0 step="0.01" required >
            </div>
            <div class="form-group">
                <label for="product_color">Product Color</label>
                <input type="text" class="form-control" id="product_color" name="product_color" required>
            </div>
            <div class="form-group">
                <label for="product_size">Product Size</label>
                <!-- <input type="text" class="form-control" id="product_size" name="product_size" required> -->
                <select class="form-control" id="product_size" name="product_size" required>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                </select>
            </div>
            <div class="form-group">
                <label for="product_category">Product Category</label>
                <select class="form-control" id="product_category" name="product_category" required>
                    <?php foreach($categories as $category) { ?>
                        <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
                    <?php } ?>
            </div>
            <div class="form-group">
                <label for="product_image">Product Image</label>
                <input type="file" class="form-control" id="product_image" name="product_image" onchange="previewImage(event)" required>
                <img id="preview" src="" alt="Image preview" style="max-width:200px; max-height:200px;">
            </div>
            <script>
            function previewImage(event) {
                var reader = new FileReader();
                reader.onload = function(){
                    var output = document.getElementById('preview');
                    output.src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            }
            </script>

            <div class="form-group">
                <label for="product_description">Product Description</label>
                <textarea class="form-control" id="product_description" name="product_description" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-0">Add</button>
            <a href="index.php?ac=product" class="btn btn-secondary">Go Back</a>
        </form>
    </div>
</main>
