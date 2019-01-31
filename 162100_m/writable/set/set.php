<?php
@ini_set('default_charset', 'utf-8');
@ini_set('display_errors', false);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if (PHP_VERSION < '4.1.0') {
  $_GET = &$HTTP_GET_VARS;
  $_POST = &$HTTP_POST_VARS;
  $_COOKIE = &$HTTP_COOKIE_VARS;
  $_SERVER = &$HTTP_SERVER_VARS;
  $_ENV = &$HTTP_ENV_VARS;
  $_FILES = &$HTTP_POST_FILES;
}

$_GET = preg_replace('/[\r\n\'\"\>\<\&]+/i', '', $_GET);

$web = array();

/* ----------【网站设置】能不用尽量不要用特殊符号，如 \ / : ; * ? ' < > | ，必免导致错误--------- */

//基本设置：
$web['code_author'] = ''; //base64_decode('IC0gUG93ZXJlZCBieSAxNjIxMDAuY29t');

$web['manager'] = 'admin';  //基础管理员名称
$web['password'] = 'aa7e25f80cf4f64e990b78a9fc5ebd6c';  //基础管理员密码，注：系统出现一切故障时以基础管理员名称和密码为准

$web['sitehttp'] = '';  //站点网址
$web['root'] = ''; //根目录
if ($web['sitehttp'] == '') {
  $web['sitehttp'] = 'http://'.(!empty($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']).'/';  //站点网址
  $GLOBALS['WEATHER_DATA'] = (isset($GLOBALS['WEATHER_DATA']) && $GLOBALS['WEATHER_DATA']) ? $GLOBALS['WEATHER_DATA'] : '';
  if (!function_exists('get_root_domain')) {
    @ require ($GLOBALS['WEATHER_DATA'].'readonly/function/get_root_domain.php');
  }
  $web['root'] = get_root_domain($web['sitehttp']);
}
$web['path'] = dirname(trim($web['sitehttp'], '/').$_SERVER['REQUEST_URI'].'.abc').'/';  //路径

$web['sitename'] = '我的手机导航 - 162100.com提供源码';  //站点名称
$web['sitename2'] = '我的网址导航 - 162100.com提供源码';  //站点简称
$web['description'] = '162100.com 162100网址导航，绿色快捷，包含各种方便实用功能，是您设为上网主页的最好选择。';  //站点描述
$web['keywords'] = '主页导航,上网导航,网址导航,绿色网址,网址之家,网址大全,网上黄页,集成搜索,一站式搜索';  //关键字
$web['slogan'] = '拒绝繁冗，选择简炼！——162100源码——162100.com';  //口号
$web['link_type'] = 1;  //通过export.php?url=链接路径 中转链接
$web['p_static'] = 1;  //1开启伪静态

$web['chmod'] = '777';  //权限
if (empty($web['chmod']) || $web['chmod'] < 755) {
  $web['chmod'] = 755;
}
$web['time_pos'] = '8北京，重庆，香港特别行政区，乌鲁木齐，台北';  //服务器时区调整
$web['cssfile'] = '3';  //站点默认风格
$web['search_bar'] = array('百度一下', 'http://m.baidu.com/s?word=');  //默认搜索引擎样式

$web['stop_reg'] = 0;  //用户注册 1禁止 0不禁止 2注册需审核
$web['mail_send'] = 0;  //1发送邮件 0不发送
$web['stop_login'] = 3;  //用户登录密码错误限数 0不限

?>