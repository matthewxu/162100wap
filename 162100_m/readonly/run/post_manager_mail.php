<?php
require ('authentication_manager.php');
?>
<?php

/* 网站参数配置 */
/* 162100源码 - 162100.com */
if (POWER != 5) {
  err('该命令必须以基本管理员身份登陆！请重登陆');
}
@ require ('readonly/function/filter.php');

$_POST['smtppwd'] = str_replace('\'', '\\\'', $_POST['smtppwd']);

//$_POST = array_map('filter1', $_POST);

if (empty($_POST['smtpuser']) || !preg_match('/^[\w\.\-]+@[\w\-]+\.[\w\.]+$/', $_POST['smtpuser']) || strlen($_POST['smtpuser']) > 255) {
  err('您登陆smtp服务器的用户名必填！格式：xxx@xxx.xxx(.xx) 。');
}
if (empty($_POST['sender']) || !preg_match('/^[\w\.\-]+@[\w\-]+\.[\w\.]+$/', $_POST['sender']) || strlen($_POST['sender']) > 255) {
  err('发件人必填！格式：xxx@xxx.xxx(.xx) 。');
}
if ($_POST['mailtype'] != 'html' && $_POST['mailtype'] != 'txt') {
  $_POST['mailtype'] = 'html';
}


$text = '<?php
$web[\'smtpserver\'] = \''.$_POST['smtpserver'].'\'; //您的smtp服务器的地址 
$web[\'port\']       = '.(int)$_POST['port'].'; //smtp服务器的端口，一般是 25  
$web[\'smtpuser\']   = \''.$_POST['smtpuser'].'\'; //您登陆smtp服务器的用户名 
$web[\'smtppwd\']    = \''.$_POST['smtppwd'].'\'; //您登陆smtp服务器的密码 
$web[\'mailtype\']   = \''.$_POST['mailtype'].'\'; //邮件的类型，可选值是 TXT 或 HTML ,TXT 表示是纯文本的邮件,HTML 表示是 html格式的邮件 
$web[\'sender\']     = \''.$_POST['sender'].'\'; //发件人,一般要与您登陆smtp服务器的用户名($smtpuser)相同,否则可能会因为smtp服务器的设置导致发送失败


?>';
@ require ('readonly/function/write_file.php');

/* 写 */
write_file('writable/set/set_mail.php', $text);

alert('设置完毕！', '?get=mail');




?>