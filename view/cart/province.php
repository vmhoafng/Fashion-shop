<?php

include "../../model/pdo.php";
include "../../model/cart.php";

$list_province = get_list_province_and_city();

$options = "<option value=''>Chọn tỉnh/thành phố</option>";
foreach($list_province as $item){
    extract($item);
    $options .= "<option value='" . $matp . "'>" . $name . "</option>";
}

echo $options;
