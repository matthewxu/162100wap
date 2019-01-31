<?php
require ('authentication_manager.php');
?>
<?php

/* 群发电邮 */
/* 162100源码 - 162100.com */
if (POWER != 5) {
  err('该命令必须以管理员身份！');
}

function filter($text) {
  return (!preg_match('/[\s\"\']|^$/', $text) && $text != '');
}

$_POST['id'] = array_unique((array)$_POST['id']);
$_POST['id'] = array_filter($_POST['id'], 'filter');

//$_POST['id'] = array_filter($_POST['id']);
//$_POST['id'] = preg_grep('/^\d+$/', $_POST['id']);

if (count($_POST['id']) == 0) {
  err('参数出错！<br>问题分析：<br>1、您可能未点选<br>2、参数传递出错。');
}



if (!@file_exists('readonly/function/mail_class.php')) {
  err('邮件发送功能未安装！');
}
@ require ('readonly/function/filter.php');
$subject = filter1($_POST['subject']);
server_sbj($subject); //主题检测
$content = filter2($_POST['content']);
server_chk($content, 10000); //内容检测。限10000字符
@ require ('readonly/function/mail_class.php');
$subject = "=?UTF-8?B?".base64_encode($subject)."?="; //此行解决utf-8编码邮件标题乱码
foreach ($_POST['id'] as $to){
  $send = $smtp -> sendmail($to, $web['sender'], $subject, $content, $web['mailtype']);
  if ($send == 1) { 
    echo '<p>邮件['.$to.']发送成功！</p>';
  } else { 
    echo '<p>邮件['.$to.']发送失败！原因：邮箱密码未设置或出错。</p>'; 
  }
  @ob_flush();
  @flush();

}


  
alert('邮件发送完毕。', '?get=member_bulk_mail');


?>