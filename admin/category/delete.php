<?php 
    if(isset($_GET['id'])){
        
        $category_id=$_GET['id'];
        $category=getCategoryByCategoryId($category_id);
    }
    if(isset($_POST['category_id'])){
        $category_id=$_POST['category_id'];
        if(isCategoryContainProduct($category_id)){
            //Dosomething
        }
        else{
            deleteCategoryByCategoryId($category_id);
            header("Location: index.php?ac=category");
        }
       
    }

?>
<main class="page-content">
    <div class="container-fluid">
        <h2>Delete Category</h2>
        <form class="pt-0 pl-0 pr-0 pb-0 w-50" method="post" action="#">
            <div class="form-group">
                <label for="category_id">Category ID</label>
                <input type="text" class="form-control" id="category_id" name="category_id" value=<?php echo $category['category_id'] ?> hidden>
                <input type="text" class="form-control" id="category_id" name="category_id_show" value=<?php echo $category['category_id'] ?> disabled>
                
                <?php if(isCategoryContainProduct($category_id)) {?>
                    <div class="alert alert-danger mt-2" role="alert">
                        This category contains product. You can not delete this category.
                    </div>
                    <button type="submit" class="btn btn-primary mt-2" disabled>Delete</button>

                    <?php } ?>
                    <?php if(!isCategoryContainProduct($category_id)){?>
                        <button type="submit" class="btn btn-primary mt-2">Delete</button>
                    <?php }?>
            </div>
        </form>
        <a href="index.php?ac=category" class="btn btn-secondary">Go Back</a>


    </div>
</main>