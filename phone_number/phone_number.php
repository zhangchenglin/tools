<?php
if (filter_has_var(INPUT_POST, "data")) {
    $phone_number_data_post = filter_input(INPUT_POST, 'data');
} else {
    die("访问受限");
}


$udate = new DateTime();
$create_date = $udate->format("Y-m-d H:i:s.u");
$modify_date = $udate->format("Y-m-d H:i:s.u");
$udate = null;

$PREG_rules = array(
    "chinese_name" => "/^([\u4e00-\u9fa5·]{2,16})$/",
    "tel_number" => "/\d{3}-\d{8}|\d{4}-\d{7}/",
    "mobile_number" => "/^(?:(?:\+|00)86)?1(?:(?:3[\d])|(?:4[5-7|9])|(?:5[0-3|5-9])|(?:6[5-7])|(?:7[0-8])|(?:8[\d])|(?:9[1|8|9]))\d{8}$/",
    "ip_v4" => "/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/",
    "ip_v6" => "/^((([0-9A-Fa-f]{1,4}:){7}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}:[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){5}:([0-9A-Fa-f]{1,4}:)?[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){4}:([0-9A-Fa-f]{1,4}:){0,2}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){3}:([0-9A-Fa-f]{1,4}:){0,3}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){2}:([0-9A-Fa-f]{1,4}:){0,4}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(([0-9A-Fa-f]{1,4}:){0,5}:((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(::([0-9A-Fa-f]{1,4}:){0,5}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|([0-9A-Fa-f]{1,4}::([0-9A-Fa-f]{1,4}:){0,5}[0-9A-Fa-f]{1,4})|(::([0-9A-Fa-f]{1,4}:){0,6}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){1,7}:))$/i",
);
$ip = "unset";
$server_remote_addr = $_SERVER["REMOTE_ADDR"];

$ip_v4_preg = preg_match($PREG_rules["ip_v4"], $server_remote_addr);
$ip_v6_preg = preg_match($PREG_rules["ip_v6"], $server_remote_addr);

if ($ip_v4_preg) {
    $ip_v4 = $server_remote_addr;
    $ip_v6 = "";
} elseif ($ip_v6_preg) {
    $ip_v6 = $server_remote_addr;
    $ip_v4 = "";
} else {
    $ip = "unset";
    $ip_v4 = "";
    $ip_v6 = "";
}


$static = array(
    'n' => 'no',
    'y' => 'yes',
    'v' => 'Verify',
    'vd' => 'Verified',
);
//矿区
$regional = array(
    'un' => 'unset',
    'xm' => 'xingmei',
    'gq' => 'gequan',
    'dp' => 'dongpang',
    'xdw' => 'xiandewang',
);
//区队、科室
$department = array(
    'un' => 'unset',
    'bwk' => 'baoweike',
);
$user_agent = $_SERVER['HTTP_USER_AGENT'];

$data_post_array = json_decode($phone_number_data_post, true);

$data_count = count($data_post_array);
for ($i = 0; $i < $data_count; $i++) {
    $phone_number_data[$i] = array(
        "phone_name" => $data_post_array["$i"]["phone_name"],
        "phone_nick_name" => "",
        "note" => "",
        "tel_number" => $data_post_array[$i]['tel_number'],
        "mobile_number" => $data_post_array[$i]['mobile_number'],
        "static" => $static['n'],
        "regional" => $regional['xm'],
        "department" => $department['un'],
        "create_data" => $create_date,
        "modify_data" => $modify_date,
        "ip" => $ip,
        "ip_v4" => $ip_v4,
        "ip_v6" => $ip_v6,
        "user_agent" => $user_agent,
    );
}


require_once "../mysqli/mysqli.php";
//$db = new MysqliDb($db_host, $db_user, $db_pwd, $db_database);

$db = new MysqliDb();
$db->addConnection("add_phone_number", array(
    'host' => $db_host,
    'username' => $db_user,
    'password' => $db_pwd,
    'db' => $db_database,
//        'port' => 3306,
//        'prefix' => '',
//        'charset' => 'utf8'
));


try {
    $id = $db->connection("add_phone_number")->insertMulti("phone_number", $phone_number_data);
} catch (Exception $e) {
    die($e->getMessage());
}

if (!$id) {
    $phone_number_error_data = $phone_number_data;
    foreach ($phone_number_error_data as $k => $v) {
        unset($phone_number_error_data[$k]["phone_nick_name"]);
        unset($phone_number_error_data[$k]["note"]);
        unset($phone_number_error_data[$k]["static"]);
        unset($phone_number_error_data[$k]["regional"]);
        unset($phone_number_error_data[$k]["department"]);
        unset($phone_number_error_data[$k]["create_data"]);
        unset($phone_number_error_data[$k]["modify_data"]);
        unset($phone_number_error_data[$k]["ip"]);
        unset($phone_number_error_data[$k]["ip_v4"]);
        unset($phone_number_error_data[$k]["ip_v6"]);
        unset($phone_number_error_data[$k]["user_agent"]);
    }
    $message = array(
        'result' => "提交失败",
        'Errno' => $db->getLastErrno(),
        'Error' => $db->getLastError(),
        'data' => $phone_number_error_data,
    );
} else {
    $message = array(
        'result' => "您提交的" . $data_count . "个号码已经成功被收录",
    );
}
echo json_encode($message);

