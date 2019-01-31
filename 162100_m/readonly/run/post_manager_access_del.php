<?php

//栏目分类设置
@ require ('readonly/function/confirm_power.php');
define('POWER', confirm_power());

if (POWER != 5) {
  err('该命令必须以基本管理员身份登陆！请重登陆');
}

$d_ = date('Ymd');
$s = 0;
if ($a = @glob('writable/__temp__/weather_*.txt')) {
  foreach ($a as $f) {
    if (date('Ymd', filemtime($f)) != $d_) {
      $s++;
      @unlink($f);
    }
  }
}

alert('执行完毕（'.$s.'条）。', 'webmaster_central.php');

?>