<?php
if (filter_input(INPUT_POST, "number_stored")) {
    require_once "../mysqli/mysqli.php";
    require_once "phone_number_common.php";
    $result = table_num_rows("jzeg_tools/phone_number");
    echo $result;
}
