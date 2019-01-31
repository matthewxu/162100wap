<?php
require ('authentication_manager.php');
?>
<?php
@ set_time_limit(0);  //若配置为 0 则不限定最久时间

if (!function_exists('confirm_power')) {
  }
if (POWER != 5) {
  err('该命令必须以基本管理员身份登陆！请重登陆');
}


if (empty($_REQUEST['beifen'])) {
  err('备份源不能空！');
}
if (!file_exists($_REQUEST['beifen'])) {
  err('指定的备份源不存在！');
}

if (!empty($_GET['table'])) {
  if (!in_array($_GET['table'], $sql['data'])) {
    err('数据表名出错！');
  }
  $arr_creare = @glob($_REQUEST['beifen'].'/create_'.$_GET['table'].'.php');
  $arr_insert = @glob($_REQUEST['beifen'].'/insert_'.$_GET['table'].'_*.php');
} else {
  $arr_creare = @glob($_REQUEST['beifen'].'/create_*.php');
  $arr_insert = @glob($_REQUEST['beifen'].'/insert_*.php');
}

if (count($arr_creare) == 0) {
  err('备份源文件出错！（没有MYsql结构文件源）');
}

if ($db == NULL) {
  if (!$db = @mysql_connect($sql['host'].':'.$sql['port'], $sql['user'], "".$sql['pass']."")) {
    err('数据库服务器'.$sql['host'].'连接不成功！');
  }
  if (!@mysql_select_db($sql['name'], $db)) {
    @mysql_query('CREATE DATABASE IF NOT EXISTS '.$sql['name'].'', $db); //如果数据库不存在则创建
    if (!@mysql_select_db($sql['name'], $db)) {
      err('数据库'.$sql['name'].'连接不成功！');
    }
  }
  @mysql_query('SET NAMES '.$sql['char'].'');
}

$sql['sql_version'] = @mysql_get_server_info();
/*
//查看分区：SELECT * FROM INFORMATION_SCHEMA.partitions WHERE TABLE_SCHEMA='web162100' AND TABLE_NAME='yzsou_reply';
*/
$result = @mysql_query('SHOW VARIABLES LIKE "%partition%"', $db);
$row = @mysql_fetch_assoc($result);
$sql['sql_part'] = $row; //[Variable_name] => have_partitioning  [Value] => YES
@mysql_free_result($result);
unset($row);

if (!($sql['sql_version'] >= '5.1' && $sql['sql_part']['Variable_name'] == 'have_partitioning' && $sql['sql_part']['Value'] == 'YES')) {
  $sql_err = '<div class="siteannounce">告知：你的MYSQL服务器分区功能被禁用，可能是设置问题或被空间商禁用，数据表无法实现分区功能。虽大数据量时优化受影响，但仍可正常使用。</div>';
}


foreach ($arr_creare as $k => $v) {
  $s_table = substr(basename($v, '.php'), 7);

  $sql_ta_query = @file_get_contents($v);
  $sql_ta_query = isset($sql_err) ? preg_replace('/[\s\r\n]*\/\*.*\*\/[\s\r\n]*/sU', '', $sql_ta_query) : $sql_ta_query;
  
  if (@mysql_query('CREATE TABLE `'.$sql['pref'].''.$s_table.'` '.substr($sql_ta_query, 15).'')) {
    $out_put .= '表'.$s_table.'创建成功！ ';
  } else {
    if (@mysql_query('SELECT id FROM `'.$sql['pref'].''.$s_table.'` LIMIT 1', $db)) {
      $out_put .= '表'.$s_table.'已存在！是否：<a href="?post=sql_table_del&table='.$s_table.'&act=del" onclick="return confirm(\'确定删除表'.$s_table.'么？\')" target="_blank">删除</a> ';
    } else {
      $out_put .= '表'.$s_table.'创建失败！['.mysql_errno().':'.mysql_error().'] ';
    }
  }
}
unset($arr_creare, $k, $v, $s_table);

foreach ($arr_insert as $k => $v) {
  list($s_table, ) = @explode('_', substr(basename($v, '.php'), 7));
  if ($s_table == $sql['data']['承载成员档案的表名']) {
    $reset_member_tb = true;
  }
  @mysql_query('INSERT INTO `'.$sql['pref'].''.$s_table.'` '.substr(@file_get_contents($v), 15).'');
  echo ''.mysql_errno().':'.mysql_error().']<br />';
}
unset($arr_insert, $k, $v, $s_table);

if (isset($reset_member_tb) && $reset_member_tb == true) {
  @mysql_query('UPDATE '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' SET session_key="'.$session[1].'|'.$session[2].'" WHERE username="'.$web['manager'].'" LIMIT 1', $db);
}

@mysql_close();

err($out_put.$sql_err.'<br /><a href="?get=sql">返回数据库管理</a>', 'ok');


?>