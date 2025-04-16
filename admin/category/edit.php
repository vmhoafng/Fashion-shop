<?php 
//chưa kiểm tra trùng tên
    if(isset($_GET['id'])){
        
        $category_id=$_GET['id'];
        $category=getCategoryByCategoryId($category_id);
    }
    if(isset($_POST['category_id'])){
        $category_id=$_POST['category_id'];
        $category_name=$_POST['category_name'];
        updateCategoryByCategoryId($category_id,$category_name);
        header("Location: index.php?ac=category");
    
       
    }

?>
<main class="page-content">
    <div class="container-fluid">
        <h2>Edit category</h2>
        <form class="pt-0 pl-0 pr-0 pb-0 w-50" method="POST">
            <div class="form-group">
                <label for="category_id">Category ID</label>
                <input type="text" class="form-control" id="category_id" name="category_id" value=<?php echo $category['category_id'] ?> hidden>
                <input type="text" class="form-control" id="category_id" name="category_id_show" value=<?php echo $category['category_id'] ?> disabled>
            </div>
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" value=<?php echo $category['category_name'] ?> required>
                <button type="submit" class="btn btn-primary mt-2">Update</button>
            </div>
        </form>

    </div>

</main>