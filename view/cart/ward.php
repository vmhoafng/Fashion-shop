<?php

include "../../model/pdo.php";
include "../../model/cart.php";


$maqh = $_POST['district_id'];
$list_province = get_list_ward($maqh);

$options = "<option value=''>Chọn xã/thị trấn</option>";
foreach($list_province as $item){
    extract($item);
    $options .= "<option value='" . $xaid . "'>" . $name . "</option>";
}

echo $options;
