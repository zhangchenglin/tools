<?php
if (isset($_POST['phone_number_search']['search_type'])) {
    require_once "mysqli.php";
    $db = new MysqliDb($db_host, $db_user, $db_pwd, $db_database);
}

$query_key = $_POST['phone_number_search']['search_value'];
$result_columns = ["id", "phone_name", "tel_number", "mobile_number"];

switch ($_POST['phone_number_search']['search_type']) {
    case "number":
        $db->orWhere("tel_number", "%$query_key%", 'LIKE');
        $db->orWhere("mobile_number", "%$query_key%", 'LIKE');

        $query = $db->get("phone_number", null, $result_columns);
        break;
    case "name":
    default:
        $db->orWhere("phone_name", "%$query_key%", 'LIKE');
        $db->orWhere("phone_nick_name", "%$query_key%", 'LIKE');

        $query = $db->get("phone_number", null, $result_columns);
        break;
}

echo json_encode($query);
unset($query);
