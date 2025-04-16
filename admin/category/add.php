<?php
if(isset($_POST['category_name'])){
    $category_name=$_POST['category_name'];
    addCategory($category_name);
    header("Location:index.php?ac=category");
}
?>
<main class="page-content">
    <div class="container-fluid">
        <h2>Add category</h2>
        <form class="pt-0 pl-0 pr-0 pb-0 w-50" method="POST">
            <div class="form-group">
                <label for="category_name" class="h5">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" required>
                <button type="submit" class="btn btn-primary mt-2">Add</button>
            </div>
        </form>
        <a href="index.php?ac=category" class="btn btn-secondary">Go Back</a>
    </div>
</main>