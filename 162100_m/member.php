<?php

/* 用户后台 */
/* 162100源码 - 162100.com */


@ require('writable/set/set.php');
@ require('writable/set/set_sql.php');
  @ require ('readonly/function/confirm_power.php');
  define('POWER', confirm_power());

$post = !empty($_POST['post']) ? $_POST['post'] : (!empty($_GET['post']) ? $_GET['post'] : false);
$post = preg_replace('/[\.\/]+|eval|base64_/i', '', $post);
if (!empty($post)) {

  //一次性输出信息
  function alert($text = '', $href) {
    header('Refresh:5; url='.$href.'');
    echo '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">
<wml>
<card title="请稍候…" ontimer="'.$href.'">
  <timer value="50" />
  <p><b>√</b>'.$text.'</p>
  <p><small>或点击进入...<a href="'.$href.'">'.($href == './' ? '首页' : $href).'</a></small></p>
</card>
</wml>';
    die;
  }

  //一次性输出错误
  function err($text = '', $src = '！') {
    echo '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">
<wml>
<card title="提示…">
  <p><b>'.$src.'</b>'.$text.'</p>
  <p><small>点此可<a href="javascript:window.history.back();">返回</a></small></p>
</card>
</wml>';
    die;
  }
/*
  if ($_SERVER['HTTP_REFERER'] && strpos($_SERVER['HTTP_REFERER'], $web['sitehttp']) !== 0) {
    err('跨域操作越权！');
  }
*/
  //echo str_repeat(' ', 4096);
  //@ob_flush();
  //@flush();

  if ($post != false && file_exists('readonly/run/post_member_'.$post.'.php')) {
    @ require ('readonly/run/post_member_'.$post.'.php');
  } else {
    err('命令错误或功能尚未开通！');
  }
  die;
}







@ require('readonly/function/imcode.php');

$text_session = '';

if ($_COOKIE['cookieconfirm'] == 1) {
  $text_session .= '<div id="search">';
  if (POWER > 0) {
    $text_session .= '欢迎您！'.$session[0].$GLOBALS['session_err'].' '.(POWER == 5?'（管理员[<a href="webmaster_central.php">后台</a>]）':'').' <a href="?post=login&act=logout">退出</a>';
  } else {
    $text_session .= '<a href="login.php?location=.%2F">登陆</a> <a href="reg.php?location=.%2F">注册</a>';
  }
  $text_session .= '</div>';
} else {
  setcookie('cookieconfirm', 1, time() + 365 * 24 * 60 * 60); //+8*3600
}

$power_url = array(
  'file'            => '我的帐户',
  //'funds'           => '我的收入', //取决于$web['addfunds'] == 1
  'style'           => '我的风格',
  'collection'      => '我的收藏网址',
  'memory_website'  => '我的浏览记录',
  'memory_search'   => '我的搜索记录',
  'notepad'         => '记事本',
  'weather'         => '我的天气',
);

echo '<?xml version="1.0" encoding="UTF-8"?>';
?><!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,shrink-to-fit=no" />
<meta name="MobileOptimized" content="320" />
<meta name="HandheldFriendly" content="true" />
<title>用户中心<?php

if (!empty($_GET['get']) && array_key_exists($_GET['get'], $power_url)) {
  echo ' - '.strip_tags($power_url[$_GET['get']]);
  $nav = '<a href="member.php">用户控制台</a> &gt; '.$power_url[$_GET['get']];

} else {
  $_GET['get'] = 'door';
  $nav = '用户控制台';
}

echo ' - '.$web['sitename2'], $web['code_author'];
?></title>
<style type="text/css">
<!--
<?php
if (isset($_COOKIE['myStyle']) && file_exists('readonly/css/'.$_COOKIE['myStyle'].'.css')) {
  $cssf = $_COOKIE['myStyle'];
} else {
  $cssf = $web['cssfile'] ? $web['cssfile'] : 1;
}
@ require ('readonly/css/'.$cssf.'.css');
unset($cssf);

?>
-->
</style>
</head>
<body>
<div id="top"><a href="./">首页</a> &gt; <?php echo $nav; ?></div>
<?php echo $text_session; ?>
<div class="body">
<?php
if (file_exists('readonly/run/get_member_'.$_GET['get'].'.php')) {
  @ require ('readonly/run/get_member_'.$_GET['get'].'.php');
  //echo '<center><a href="member.php">返回用户控制台</a></center>';
} else {
  echo '<div class="output"> 命令错误！请<a href="javascript:window.history.back();">返回</a></div>';
}
?>
</div>
<?php include ('writable/require/foot.php'); ?>
<?php include ('writable/require/statistics.txt'); ?>

</body>
</html>
