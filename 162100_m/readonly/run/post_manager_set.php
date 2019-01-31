<?php
require ('authentication_manager.php');
?>
<?php
//error_reporting(E_ALL);
/*网站设置*/
@ require ('writable/set/set_area.php');
if (!function_exists('get_root_domain')) {
  @ require ('readonly/function/get_root_domain.php');
}
if (POWER != 5) {
  err('该命令必须以基本管理员身份登陆！请重登陆');
}

if (!preg_match('/^[\x80-\xff\w]{3,45}$/', $_POST['manager'])) {
  err('基础管理员名称不能空且请用汉字、数字、英文及下划线组成！长度范围为3-45字符！');
}
$_POST['manager'] = strtolower($_POST['manager']);
$_POST['password'] = strtolower($_POST['password']);

if ($_POST['password'] == '') {
  $psw = $web['password'];
} else {
  if (preg_match('/[\s\r\n]+/', $_POST['password'])) {
    err('基础管理员密码不能有空格。');
  }
  if (strlen($_POST['password']) > 30 || strlen($_POST['password']) < 3) {
    err('基础管理员密码长度是3-30字符。');
  }
  $psw = md162100($_POST['password']);
}

if (empty($_POST['cssfile']) || !file_exists('readonly/css/'.$_POST['cssfile'].'.css')) {
  $_POST['cssfile'] = '1';
}

if (isset($_POST['p_static']) && $_POST['p_static'] == 1) {
  $htaccess = file_get_contents('.htaccess');
  if (!preg_match('/^RewriteRule\s+\^\(homepage\|\[0\-9\]\+\).*/m', $htaccess) || !preg_match('/^RewriteRule\s+\^\(homepage\|\[0\-9\]\+\)_\(\[0\-9\]\+\).*/m', $htaccess)) {
    err('你点选了伪静态开启，可文件.htaccess中未发现伪静态规则！');
  }
}

$_POST['search_bar'][0] = htmlspecialchars(stripslashes(trim($_POST['search_bar'][0])));
$_POST['search_bar'][1] = htmlspecialchars(stripslashes(trim($_POST['search_bar'][1])));

function md162100($str) {
  return substr(sha1(md5($str)), 4, 32);
}
@ require ('readonly/function/filter.php');
unset($web['sitehttp']);
$web['sitehttp'] = 'http://'.(!empty($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']).'/';  //站点网址
$web['sitehttp'] = (strstr($web['sitehttp'], 'http://localhost/') || strstr($web['sitehttp'], 'http://127.0.0.1/')) ? '' : $web['sitehttp'];

/*
*/
  @unlink('./.htaccess');
  @unlink('./web.config');
  @unlink('./httpd.ini');
  $wjt = 1;
if ($_POST['p_static'] == 'Apache') {
  @copy('readonly/data/Apache/.htaccess', './.htaccess');
} elseif ($_POST['p_static'] == 'IIS7') {
  @copy('readonly/data/IIS7/web.config', './web.config');
} elseif ($_POST['p_static'] == 'IIS6') {
  @copy('readonly/data/IIS6/httpd.ini', './httpd.ini');
} else {
  $wjt = 0;
}
$text = '<?php
@ini_set(\'default_charset\', \'utf-8\');
@ini_set(\'display_errors\', false);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if (PHP_VERSION < \'4.1.0\') {
  $_GET = &$HTTP_GET_VARS;
  $_POST = &$HTTP_POST_VARS;
  $_COOKIE = &$HTTP_COOKIE_VARS;
  $_SERVER = &$HTTP_SERVER_VARS;
  $_ENV = &$HTTP_ENV_VARS;
  $_FILES = &$HTTP_POST_FILES;
}

$_GET = preg_replace(\'/[\r\n\\\'\"\>\<\&]+/i\', \'\', $_GET);

$web = array();

/* ----------【网站设置】能不用尽量不要用特殊符号，如 \ / : ; * ? \' < > | ，必免导致错误--------- */

//基本设置：
$web[\'code_author\'] = \'\'; //base64_decode(\'IC0gUG93ZXJlZCBieSAxNjIxMDAuY29t\');

$web[\'manager\'] = \''.$_POST['manager'].'\';  //基础管理员名称
$web[\'password\'] = \''.$psw.'\';  //基础管理员密码，注：系统出现一切故障时以基础管理员名称和密码为准

$web[\'sitehttp\'] = \''.$web['sitehttp'].'\';  //站点网址
$web[\'root\'] = \''.get_root_domain($web['sitehttp']).'\'; //根目录
if ($web[\'sitehttp\'] == \'\') {
  $web[\'sitehttp\'] = \'http://\'.(!empty($_SERVER[\'HTTP_X_FORWARDED_HOST\']) ? $_SERVER[\'HTTP_X_FORWARDED_HOST\'] : $_SERVER[\'HTTP_HOST\']).\'/\';  //站点网址
  $GLOBALS[\'WEATHER_DATA\'] = (isset($GLOBALS[\'WEATHER_DATA\']) && $GLOBALS[\'WEATHER_DATA\']) ? $GLOBALS[\'WEATHER_DATA\'] : \'\';
  if (!function_exists(\'get_root_domain\')) {
    @ require ($GLOBALS[\'WEATHER_DATA\'].\'readonly/function/get_root_domain.php\');
  }
  $web[\'root\'] = get_root_domain($web[\'sitehttp\']);
}
$web[\'path\'] = dirname(trim($web[\'sitehttp\'], \'/\').$_SERVER[\'REQUEST_URI\'].\'.abc\').\'/\';  //路径

$web[\'sitename\'] = \''.(!empty($_POST['sitename']) ? filter1($_POST['sitename'], true) : '我的网站').'\';  //站点名称
$web[\'sitename2\'] = \''.(!empty($_POST['sitename2']) ? filter1($_POST['sitename2'], true) : '我的网站').'\';  //站点简称
$web[\'description\'] = \''.filter1($_POST['description'], true).'\';  //站点描述
$web[\'keywords\'] = \''.filter1($_POST['keywords'], true).'\';  //关键字
$web[\'slogan\'] = \''.filter1($_POST['slogan'], true).'\';  //口号
$web[\'link_type\'] = '.($_POST['link_type'] == true ? 1 : 0).';  //通过export.php?url=链接路径 中转链接
//$web[\'p_static\'] = '.$wjt.';  //1开启伪静态
$web[\'p_static\'] = '.$wjt.';  //1开启伪静态

$web[\'chmod\'] = \''.(!preg_match('/^0?([0-7]{3})$/', $_POST['chmod'], $matches_chmod) ? '777' : $matches_chmod[1]).'\';  //权限
if (empty($web[\'chmod\']) || $web[\'chmod\'] < 755) {
  $web[\'chmod\'] = 755;
}
$web[\'time_pos\'] = \''.$_POST['time_pos'].'\';  //服务器时区调整
$web[\'cssfile\'] = \''.$_POST['cssfile'].'\';  //站点默认风格
$web[\'search_bar\'] = array('.($_POST['search_bar'][0] && $_POST['search_bar'][1] ? '\''.$_POST['search_bar'][0].'\', \''.$_POST['search_bar'][1].'\'' : '\'百度一下\', \'http://m.baidu.com/s?word=\'').');  //默认搜索引擎样式

$web[\'stop_reg\'] = '.($_POST['stop_reg'] != 1 && $_POST['stop_reg'] != 2 ? 0 : $_POST['stop_reg']).';  //用户注册 1禁止 0不禁止 2注册需审核
$web[\'mail_send\'] = '.(abs((int)$_POST['mail_send']) != 1 ? 0 : 1).';  //1发送邮件 0不发送
$web[\'stop_login\'] = '.abs($_POST['stop_login']).';  //用户登录密码错误限数 0不限

?>';


$sqlaccess = '';
if ($_POST['manager'] != $web['manager'] || $psw != $web['password']) {

  if (!isset($sql['db_err'])) {
    db_conn();
  }
  if ($sql['db_err'] == '') {
    if (@mysql_query('UPDATE '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' SET username="'.$_POST['manager'].'",password="'.$psw.'" WHERE username="'.$web['manager'].'" LIMIT 1', $db)) {
      $admin_c = 1;
    } else {
      if (@mysql_query('UPDATE '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' SET password="'.$psw.'" WHERE username="'.$_POST['manager'].'" LIMIT 1', $db)) {
        $admin_c = 1;
      }
    }
    if (isset($admin_c) && $admin_c == 1) {
    //if (@mysql_affected_rows() > 0) {
      $sqlaccess = '数据库管理员名称和密码副本同时更新成功。由于管理员信息被改动，建议重新登陆以使新设置生效！
      <script language="javascript" type="text/javascript">
      <!--
      var expiration=new Date((new Date()).getTime()-86400000);
      document.cookie="usercookie="+""+"; expires="+expiration.toGMTString()+"; path="+"/"+";";
      -->
      </script>';
    }
  }
  @mysql_close();
  if ($sqlaccess == '') {
    $sqlaccess = '<span class="red">由于基础管理员信息(如名称或密码)有变，但数据库(或数据表)连接不成功或被删除或尚未安装，拒绝更改设置！<br>请检查数据库及数据表</span>';
  }
}
@ require ('readonly/function/write_file.php');
write_file('writable/set/set.php', $text);




alert('设置系统参数成功！'.$sqlaccess, '?get=set');




?>