<?php
require ('authentication_member.php');
?>
<?php

//用户风格
if (POWER == 0) {
  err('请登陆或注册帐号！先');
}

if (!isset($_POST['cssfile']) || !is_numeric($_POST['cssfile'])) {
  err('请选择风格！');
}
if (!file_exists('readonly/css/'.$_POST['cssfile'].'.css')) {
  err('风格不存在！');
}
if (!setcookie('myStyle', $_POST['cssfile'], time() + floatval($web['time_pos']) * 3600 + 365 * 24 * 60 * 60)) {
  err('Cookie保存失败！请检查您的设置');
}

alert('风格设置完毕！请浏览<a href="main.php">首页</a>', '?get=style');
?>