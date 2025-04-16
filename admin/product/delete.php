<?php 

    if(isset($_GET['id'])){
        
        $product_id=$_GET['id'];
        $product=getProductByProductId($product_id);
        $checkProduct=isProductExistedInOrderDetailAndCartDetail($product_id);
    }
    if(isset($_POST['product_id'])){
        $product_id=$_POST['product_id'];
        $checkProduct=isProductExistedInOrderDetailAndCartDetail($product_id);
        if(count($checkProduct)>0){
            hideProduct($product_id);
        }
        else{
            deleteProductByProductId($product_id);
        }
        
        header("Location: index.php?ac=product");
    }
?>

<main class="page-content">
    <div class="container-fluid">
        <h2>Delete product</h2>
        <form method="post" action="#" class="pb-0 pl-0 pt-0 pr-0">
            <div class="form-group">
                <label for="product_id">Product ID</label>
                <input type="text" class="form-control" id="product_id" name="product_id" value=<?php echo $product['product_id'] ?> hidden>

                <input type="text" class="form-control" id="product_id" name="product_id_show" value=<?php echo $product['product_id'] ?> disabled>
            </div>
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value=<?php echo $product['product_name'] ?> disabled>
            </div>
            <div class="form-group">
                <label for="product_price">Product Price($)</label>
                <input type="number" class="form-control" id="product_price" name="product_price" value=<?php echo $product['product_price'] ?> disabled>
            </div>
            <div class="form-group">
                <label for="product_color">Product Color</label>
                <input type="text" class="form-control" id="product_color" name="product_color" value=<?php echo $product['product_color'] ?> disabled>
            </div>
            <div class="form-group">
                <label for="product_size">Product Size</label>
                <input type="text" class="form-control" id="product_size" name="product_size" value=<?php echo $product['product_size'] ?> disabled>
            </div>
            <?php if(count($checkProduct)>0){ ?>
            <button type="submit" class="btn btn-primary mt-0" onClick="return confirm('Product has been bought. Do you want to hide it?')">Delete</button>
            <?php } else{ ?>
            <button type="submit" class="btn btn-primary mt-0" onClick="return confirm('Are you sure you want to delete this product?')">Delete</button>
            <?php } ?>
            <a href="index.php?ac=product" class="btn btn-secondary">Go Back</a>
        </form>
        
</main>