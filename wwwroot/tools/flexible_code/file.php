<?php

require_once dirname(dirname(dirname(__DIR__))) . "/config/defined.php";
require_once dirname(dirname(dirname(__DIR__))) . "/config/functions.php";
require_once dirname(dirname(__DIR__)) . "/photo_info/photo_info_fun.php";

$allowed_extension_name = array("pjpeg", "jpeg", "pjp", "jpg", "png");

$file = $qrcode_img_file;

$error = $file["error"];
$tmp_file_name = $file['tmp_name'];
$file_name = $file['name'];
$file_ext_name = get_file_ext_name($file_name);
$file_type = $file['type'];
$file_size = $file['size'];

$php_created_image = PHP_TMP_DIR . $file_name;


if (is_uploaded_file($tmp_file_name)) {
  if ($error === 0) {
    if (in_array($file_ext_name, $allowed_extension_name)) {
      if (!file_exists(LHM_RESULT_IMG_YMD_PATH)) mk_dir(LHM_RESULT_IMG_YMD_PATH);
      $image_create_result = filters_image_types($file_name, $file_ext_name, $tmp_file_name);
      if ($image_create_result === true) {
        if (!file_exists(LHM_RESULT_IMG_YMD_PATH . $file_name)) {
          $rename_file_result = rename($php_created_image, LHM_RESULT_IMG_YMD_PATH . $file_name);

          if ($rename_file_result === true) {
            global $new_img_file;
            $new_img_file = array(
              'file_path' => LHM_RESULT_IMG_YMD_DIR . $file_name,
              'file_name' => $file_name,
              'file_ext_name' => $file_ext_name,
              'file_size' => $file_size,
            );
            return $new_img_file;
          } else {
            echo '文件创建成功，移动失败';
          }

        } else {
          die('文件已经存在');
        }
      } else {
        die('文件创建失败');
      }
    } else {
      if (file_exists($tmp_file_name)) unlink($tmp_file_name);
      die('文件格式不允许');
    }
  }
} else {
  if (file_exists($tmp_file_name)) unlink($tmp_file_name);
  die('文件获取途径问题');
}
