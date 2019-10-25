<?php
if ($_POST) {
    $phone_number_data_post = $_POST["data"];
}

require_once "mysqli.php";
$db = new MysqliDb($db_host, $db_user, $db_pwd, $db_database);

$udate = new DateTime();
$create_data = $udate->format("Y-m-d H:i:s.u");
$modify_data = $udate->format("Y-m-d H:i:s.u");
$udate = null;

$RegExp_rules = array(
    "chinese_name" => "/^([\u4e00-\u9fa5·]{2,16})$/",
    "tel_number" => "/\d{3}-\d{8}|\d{4}-\d{7}/",
    "mobile_number" => "/^(?:(?:\+|00)86)?1(?:(?:3[\d])|(?:4[5-7|9])|(?:5[0-3|5-9])|(?:6[5-7])|(?:7[0-8])|(?:8[\d])|(?:9[1|8|9]))\d{8}$/",
    "ip_v4" => "/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/",
    "ip_v6" => "/^((([0-9A-Fa-f]{1,4}:){7}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}:[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){5}:([0-9A-Fa-f]{1,4}:)?[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){4}:([0-9A-Fa-f]{1,4}:){0,2}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){3}:([0-9A-Fa-f]{1,4}:){0,3}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){2}:([0-9A-Fa-f]{1,4}:){0,4}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(([0-9A-Fa-f]{1,4}:){0,5}:((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(::([0-9A-Fa-f]{1,4}:){0,5}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|([0-9A-Fa-f]{1,4}::([0-9A-Fa-f]{1,4}:){0,5}[0-9A-Fa-f]{1,4})|(::([0-9A-Fa-f]{1,4}:){0,6}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){1,7}:))$/i",
);

//$ip = $_SERVER['SERVER_ADDR'];
$ip = $_SERVER['REMOTE_ADDR'];
$ip_v4 = $_SERVER['REMOTE_ADDR'];
$ip_v6 = "test";
$static = array(
    'n' => 'no',
    'y' => 'yes',
    'v' => 'Verify',
    'vd' => 'Verified',
);
$regional = array(
    'xm' => 'xingmei',
    'gq' => 'gequan',
    'dp' => 'dongpang',
    'xdw' => 'xiandewang',
);
$user_agent = $_SERVER['HTTP_USER_AGENT'];

$data_post_array = json_decode($phone_number_data_post, true);

$data_count = count(json_decode($phone_number_data_post));
for ($i = 0; $i < $data_count; $i++) {
    $phone_number_data[$i] = array(
        "phone_name" => $data_post_array["$i"]["phone_name"],
        "phone_nick_name" => $data_post_array[$i]['phone_name'],
        "tel_number" => $data_post_array[$i]['tel_number'],
        "mobile_number" => $data_post_array[$i]['mobile_number'],
        "static" => $static['n'],
        "regional" => $regional['xm'],
        "create_data" => $create_data,
        "modify_data" => $modify_data,
        "ip" => $ip,
        "ip_v4" => $ip_v4,
        "ip_v6" => $ip_v6,
        "user_agent" => $user_agent,
    );
}

$id = $db->insertMulti("phone_number", $phone_number_data);

if (!$id) {
    $message = array(
        'result' => "提交失败",
        'Errno' => $db->getLastErrno(),
        'Error' => $db->getLastError(),
    );
//    die('无法插入数据: ' . $db->getLastErrno() . "&nbsp;&nbsp;&nbsp;&nbsp;" . $db->getLastError());
} else {
    $message = array(
        'count' => $data_count,
        'result' => "您提交的号码已经成功被收录",
        'data' => $phone_number_data,
        'data_post' => $data_post_array,
    );
}
echo json_encode($message);

