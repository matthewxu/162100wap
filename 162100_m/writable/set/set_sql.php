<?php
//数据库配置文件
$sql['type'] = 'mysql'; //服务器类型
$sql['host'] = 'localhost'; //服务器地址
$sql['port'] = '3306'; //服务器端口
$sql['user'] = ''; //数据库用户名
$sql['pass'] = ''; //数据库密码
$sql['name'] = ''; //数据库名
$sql['pref'] = 'daohang_'; //表名前缀
$sql['char'] = 'utf8'; //数据表编码
$sql['data'] = array(
'承载网址数据的表名' => '162100wap',
'承载成员档案的表名' => 'member',
);

//连接数据库
if (!function_exists('db_conn')) {
  function db_conn() {
    global $sql, $db;
    if ($db = @mysql_connect($sql['host'].':'.$sql['port'], $sql['user'], $sql['pass'])) {
      if (@mysql_select_db($sql['name'], $db)) {
        @mysql_query('SET NAMES '.$sql['char'].'');
        $sql['db_err'] = '';
        return true;
      } else {
        $sql['db_err'] = mysql_errno().':'.mysql_error().'<br>&#25968;&#25454;&#24211;['.$sql['name'].']&#36830;&#25509;&#19981;&#25104;&#21151;&#65281;<a href="forsql.html" target="_blank" class="underline">&#22914;&#20309;&#35299;&#20915;&#65311;</a>';
        return false;
      }
    } else {
      $sql['db_err'] = mysql_errno().':'.mysql_error().'<br>&#25968;&#25454;&#24211;&#26381;&#21153;&#22120;['.$sql['host'].':'.$sql['port'].']&#36830;&#25509;&#19981;&#25104;&#21151;&#65281;<a href="forsql.html" target="_blank" class="underline">&#22914;&#20309;&#35299;&#20915;&#65311;</a>';
      return false;
    }
  }
}

?>