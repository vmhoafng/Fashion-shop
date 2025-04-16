<?php 
    function getAllCategory(){
        $sql="SELECT * FROM `categories` WHERE 1";
        return pdo_query($sql);
    }
    function searchCategoryByName($search){
        $sql="SELECT * FROM `categories` WHERE `category_name` LIKE '%$search%'";
        return pdo_query($sql);
    }
    
    function getCategoryByCategoryId($category_id){
        $sql="SELECT * FROM `categories` WHERE `category_id`=".$category_id;
        return pdo_query_one($sql);
    }
    function deleteCategoryByCategoryId($category_id){
        $sql="DELETE FROM `categories` WHERE `category_id`=".$category_id;
        pdo_execute($sql);
    }
    function updateCategoryByCategoryId($category_id,$category_name){
        $sql="UPDATE `categories` SET `category_name`='".$category_name."' WHERE `category_id`=".$category_id;
       
        pdo_execute($sql);
    }
    function isCategoryContainProduct($category_id){
        $sql="SELECT * FROM `product` WHERE `category_id`=".$category_id;
        $products=pdo_query($sql);
        if(count($products)>0){
            return true;
        }
        return false;
    }
    function addCategory($category_name){
        $sql="INSERT INTO `categories`(`category_name`) VALUES ('".$category_name."')";
        pdo_execute($sql);
    }
?>