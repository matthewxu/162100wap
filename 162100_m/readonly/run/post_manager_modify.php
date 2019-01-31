<?php
require ('authentication_manager.php');
?>
<?php

/* 在线修改文件 */
/* 162100源码 - 162100.com */
if (POWER != 5) {
  err('该命令必须以基本管理员身份登陆！请重登陆');
}

if (!$_POST['thefile'] || !file_exists($_POST['thefile'])) {
  err('文件参数缺失！');
}

if (!get_magic_quotes_gpc()) {
  $_POST['content'] = addslashes($_POST['content']);
}

if (!empty($_POST['charset'])) {
  if (strtolower($_POST['charset']) != 'utf-8') {
    if (!function_exists('iconv')) {
      err('你的PHP版本不支持编码转换函数（iconv），无法转换成'.$_POST['charset'].'，请选择手动修改文件吧。');
    } else {
      $_POST['content'] = iconv('utf-8', $_POST['charset'], $_POST['content']);
    }
  }
}

@ require ('readonly/function/write_file.php');
write_file($_POST['thefile'], stripslashes($_POST['content']));

err('在线修改文件完成！', 'ok');


?>