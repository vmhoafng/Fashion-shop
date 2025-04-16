<?php 
    $pageSize=3;
    $pageIndex=1;
    $searchTerm="";
    if(isset($_GET['page'])){
        $pageIndex=$_GET['page'];
    }
    if(isset($_GET['search'])){
        $searchTerm=$_GET['search'];
        $products=searchProductByName($_GET['search']);
    }
    if(isset($_POST['search'])){
        $searchTerm=$_POST['search'];
        $_GET['search']=$_POST['search'];
        $products=searchProductByName($_POST['search']);
    }
    if(!isset($_GET['search']) && !isset($_POST['search'])){
        $products =loadSanPham_OrderByProductId();
    }
    $totalPage=ceil(count($products)/$pageSize);
    $products=array_slice($products,($pageIndex-1)*$pageSize,$pageSize);
    
    
?>
<main class="page-content">
    <div class="container-fluid">
        <div>
            <h2>Product Management</h2>
            <a href="index.php?ac=product&act=add"> <i class="fa fa-plus mr-1"></i>Add new product</a>
        </div>
        <div class="form-group mt-1 ml-3">
            
            <form method="POST" class="row m-l-5 pl-0 pt-0 pb-0 pr-0">
                <input type="text" class="form-control col-2 mr-2" name="search" placeholder="Search">
                <button type="submit" class="btn btn-primary col-2 mt-0">Search by product name</button>
                <a href="index.php?ac=product" class=" ml-1 btn btn-primary">reload</a>
            </form>
            
        </div>
        <table class="table table-hover">
            <tr class="table-header">
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Product Price($)</th>
                <th>Product Color</th>
                <th>Product Size</th>
                <th>Product Category</th>
                <th>Product Image</th>
                <th>Product Description</th>
                <th>Status</th>
                <th>Product Action</th>
            </tr>
            <?php foreach($products as $product) { ?>
                <tr>
                    <td><?php echo $product['product_id']; ?></td>
                    <td><a href="../index.php?ac=productDetail&id=<?php echo $product['product_id'] ?>"><?php echo $product['product_name']; ?></a></td>
                    <td><?php echo $product['product_price']; ?></td>
                    <td><?php echo $product['product_color']; ?></td>
                    <td><?php echo $product['product_size']; ?></td>
                    <td><?php 
                            echo strval(getCategoryNameById($product['category_id']));
                        ?>
                    </td>
                    <?php 
                        echo'<td><img style="width:50px;height:50px" src="data:image/jpeg;base64,'.base64_encode($product['product_image']).'" alt="IMG-PRODUCT"></td>'
                    ?>
                    <td><?php echo $product['product_description']; ?></td>
                    <td><?php 
                        if($product['hidden']==0){
                            echo "Active";
                        }
                        else{
                            echo "Inactive";
                        }
                        ?>
                    </td>
                    <td>
                        <a href="index.php?ac=product&act=edit&id=<?php echo $product['product_id']; ?>"><i class="fa fa-pen mr-2"></i></a>
                        <a href="index.php?ac=product&act=delete&id=<?php echo $product['product_id']; ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <div class="mt-5">
            <ul class="pagination justify-content-center">
                <?php
                    echo '<div id="paginationForm" class="row m-l-5">';
                        if($totalPage > 1){
                            for($i = 1; $i <= $totalPage; $i++){
                                if(($searchTerm)==""){
                                    echo '<li class="page-item"><a href="index.php?ac=product&page='.$i.'" class=" page-link" name="page">'.$i.'</a></li>';
                                }
                                else{
                                    echo '<li class="page-item"><a href="index.php?ac=product&page='.$i.'&search='.$searchTerm.'" class=" page-link" name="page">'.$i.'</a></li>';
                                }
                               
                            }
                        }
                    echo '</div>';
                ?>
            </ul>
        </div>
    </div>
</main>
<!-- <main class="page-content">
    <div class="container-fluid">
    <h2>Admin Page</h2>
    </div>    
</main> -->