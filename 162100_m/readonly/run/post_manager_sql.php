<?php
require ('authentication_manager.php');
?>
<?php
if (POWER != 5) {
  err('该命令必须以基本管理员身份登陆！请重登陆');
}

function filter($text) {
  if (!empty($text) && preg_match('/[\=\s\`\r\n\"\'\\\\(\)]+/', $text)) {
    err('所填内容不能含空格及 = \' " \ ` ( )。');
  }
  $text = stripslashes($text);
  $text = htmlspecialchars($text);
  return $text;
}
$_POST = @array_map('filter', $_POST);

if ($_POST['dbtype'] == '') {
  err('服务器类型不能留空！');
}
if ($_POST['dbhost'] == '') {
  err('服务器地址不能留空！');
}
if ($_POST['dbport'] == '') {
  $_POST['dbport'] = 3306;
}
if ($_POST['dbname'] == '') {
  err('数据库名不能留空！');
}
/*
if (preg_match('/^\d+/', $_POST['dbname'])) {
  err('数据库名必须字母开头！因为MySQL有些版本不允许');
}
*/
if ($_POST['dbuser'] == '') {
  err('数据库用户名不能留空！');
}
if ($_POST['dbpswd'] == '') {
  if (empty($_POST['cnp'])) {
    err('数据库密码不能留空！');
  }
}
if (preg_match('/^\d+/', $_POST['dbpref'])) {
  err('数据库表名前缀必须字母开头！因为MySQL有些版本不允许');
}
if (!preg_match('/\_$/', $_POST['dbpref'])) {
  err('数据库表名前缀后面必须加下划线！');
}


if (!$db = @mysql_connect($_POST['dbhost'].':'.$_POST['dbport'], $_POST['dbuser'], "".$_POST['dbpswd']."")) {
  echo mysql_errno().':'.mysql_error();
  err('数据库服务器['.$_POST['dbhost'].':'.$_POST['dbport'].']连接不成功！请检查用户名或密码。如果是新建请点选前面“创建新/启动数据库”');
}
if ($_POST['create'] == 1) {
  @mysql_query('CREATE DATABASE '.$_POST['dbname'].'', $db); //如果数据库不存在则创建
}
if (!@mysql_select_db($_POST['dbname'], $db)) {
  err('数据库['.$_POST['dbname'].']连接不成功！请检查用户名或密码。如果是新建请点选前面“创建新/启动数据库”');
}
@mysql_query('SET NAMES '.$sql['char'].'');

$sql['db_err'] = '';
@ require('readonly/function/write_file.php');

write_file('writable/set/set_sql.php','<?php
//数据库配置文件
$sql[\'type\'] = \''.$_POST['dbtype'].'\'; //服务器类型
$sql[\'host\'] = \''.$_POST['dbhost'].'\'; //服务器地址
$sql[\'port\'] = \''.$_POST['dbport'].'\'; //服务器端口
$sql[\'user\'] = \''.$_POST['dbuser'].'\'; //数据库用户名
$sql[\'pass\'] = \''.$_POST['dbpswd'].'\'; //数据库密码
$sql[\'name\'] = \''.$_POST['dbname'].'\'; //数据库名
$sql[\'pref\'] = \''.$_POST['dbpref'].'\'; //表名前缀
$sql[\'char\'] = \''.$_POST['dbchar'].'\'; //数据表编码
$sql[\'data\'] = array(
\'承载网址数据的表名\' => \'162100wap\',
\'承载成员档案的表名\' => \'member\',
);

//连接数据库
if (!function_exists(\'db_conn\')) {
  function db_conn() {
    global $sql, $db;
    if ($db = @mysql_connect($sql[\'host\'].\':\'.$sql[\'port\'], $sql[\'user\'], $sql[\'pass\'])) {
      if (@mysql_select_db($sql[\'name\'], $db)) {
        @mysql_query(\'SET NAMES \'.$sql[\'char\'].\'\');
        $sql[\'db_err\'] = \'\';
        return true;
      } else {
        $sql[\'db_err\'] = mysql_errno().\':\'.mysql_error().\'<br>&#25968;&#25454;&#24211;[\'.$sql[\'name\'].\']&#36830;&#25509;&#19981;&#25104;&#21151;&#65281;<a href="forsql.html" target="_blank" class="underline">&#22914;&#20309;&#35299;&#20915;&#65311;</a>\';
        return false;
      }
    } else {
      $sql[\'db_err\'] = mysql_errno().\':\'.mysql_error().\'<br>&#25968;&#25454;&#24211;&#26381;&#21153;&#22120;[\'.$sql[\'host\'].\':\'.$sql[\'port\'].\']&#36830;&#25509;&#19981;&#25104;&#21151;&#65281;<a href="forsql.html" target="_blank" class="underline">&#22914;&#20309;&#35299;&#20915;&#65311;</a>\';
      return false;
    }
  }
}

?>');

echo '<p><img src="readonly/images/ok.gif" /> 数据库配置成功！</p>';
@ob_flush();
@flush();

if ($sql['pref'] != $_POST['dbpref']) {
  foreach ($sql['data'] as $t) {
    mysql_query('ALTER TABLE `'.$sql['pref'].$t.'` RENAME `'.$_POST['dbpref'].$t.'`', $db);
  }
  //echo mysql_errno().':'.mysql_error();
  echo '<p><img src="readonly/images/ok.gif" /> 数据表更名成功！</p>';
  @ob_flush();
  @flush();

}



if ($_POST['tableset'] == 1) {
  if (!$_POST['beifen'] || count((array)$_POST['beifen']) == 0) {
    err('你没有选择数据表备份源，无法导入数据！但数据库参数配置好了，<a href="?get=sql#mysql_tables">还需要返回另行建表</a>');
  }
  $sql['type'] = $_POST['dbtype'];
  $sql['host'] = $_POST['dbhost'];
  $sql['port'] = $_POST['dbport'];
  $sql['user'] = $_POST['dbuser'];
  $sql['pass'] = $_POST['dbpswd'];
  $sql['name'] = $_POST['dbname'];
  $sql['pref'] = $_POST['dbpref'];
  $sql['char'] = $_POST['dbchar'];
  echo '<p>正在处理数据表…如长时间无反应，手动点击<a href="?get=sql#mysql_tables">建立数据库表</a></p>';
  @ob_flush();
  @flush();
  @ require ('readonly/run/post_manager_sql_table_set.php');
}

@mysql_close();

?>