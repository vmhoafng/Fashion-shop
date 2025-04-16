<?php

include "../../model/pdo.php";
include "../../model/cart.php";

$matp = $_POST['province_id'];

$list_province = get_list_district($matp);

$options = "<option value=''>Chọn quận/huyện</option>";
foreach($list_province as $item){
    extract($item);
    $options .= "<option value='" . $maqh . "'>" . $name . "</option>";
}

echo $options;
