<?php
if (filter_has_var(INPUT_POST, 'search_type')) {
    $search_type = filter_input(INPUT_POST, 'search_type');
} else {
    die("访问受限");
}

$query_key = filter_input(INPUT_POST, 'search_value');

$result_columns = ["phone_name", "tel_number", "mobile_number", "department", "phone_nick_name", "note"];

$static = "yes";
$regional = "xingmei";


require_once "../mysqli/mysqli.php";
//$db = new MysqliDb($db_host, $db_user, $db_pwd, $db_database);


$db = new MysqliDb();
$db->addConnection("phone_number_search", array(
    'host' => $db_host,
    'username' => $db_user,
    'password' => $db_pwd,
    'db' => $db_database,
//        'port' => 3306,
//        'prefix' => '',
//        'charset' => 'utf8'
));

$db->connection("phone_number_search");
$db->Where("static", $static);
$db->Where("regional", $regional);

switch ($search_type) {
    case "number":
        $db->orHaving("tel_number", "%$query_key%", 'LIKE');
        $db->orHaving("mobile_number", "%$query_key%", 'LIKE');

        $query = $db->get("phone_number", null, $result_columns);
        break;
    case "name":
        $db->orHaving("phone_name", "%$query_key%", 'LIKE');
        $db->orHaving("phone_nick_name", "%$query_key%", 'LIKE');
        $db->orHaving("note", "%$query_key%", 'LIKE');

        $query = $db->get("phone_number", null, $result_columns);
        break;
    default:
}

echo json_encode($query);
unset($query);
