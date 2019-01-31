<?php
require ('authentication_manager.php');
?>
<?php

/* 管理员管理执行 */
/* 162100源码 - 162100.com */
if (POWER != 5) {
  err('该命令必须以管理员身份！');
}

function filter($text) {
  return (!preg_match('/[\s\"\']|^$/', $text) && $text != '');
}

$_POST['id'] = array_unique((array)$_POST['id']);
//$_POST['id'] = array_filter($_POST['id'], 'filter');

//$_POST['id'] = array_filter($_POST['id']);
//$_POST['id'] = preg_grep('/^\d+$/', $_POST['id']);
//print_r($_POST['id']);die;

if (count($_POST['id']) == 0) {
  err('参数出错！<br>问题分析：<br>1、您可能未点选<br>2、参数传递出错。');
}

if (!isset($sql['db_err'])) {
  db_conn();
}
if ($sql['db_err'] != '') {
  err($sql['db_err']);
}

$_POST['id'] = str_replace('.', '&#46;', $_POST['id']);
$_POST['id'] = str_replace($web['manager'], '', $_POST['id']);
$_POST['id'] = array_filter($_POST['id']);


if (count($_POST['id']) == 0) {
  err('没有选中项！（不含管理员）');
}

$id_key = '(username="'.implode('" OR username="', $_POST['id']).'")';

if ($_POST['limit'] == 'punished') {
  @mysql_query('UPDATE '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' SET check_reg="2" WHERE '.$id_key.'', $db);

} elseif ($_POST['limit'] == 'abnormal') {
  @mysql_query('UPDATE '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' SET check_reg="3" WHERE '.$id_key.'', $db);
} elseif ($_POST['limit'] == 'warn') {
  @mysql_query('UPDATE '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' SET check_reg="4" WHERE '.$id_key.'', $db);
} elseif ($_POST['limit'] == 'del') {
  @mysql_query('DELETE FROM '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' WHERE '.$id_key.'', $db);

} else {
  err('命令错误！');
}

$o = @mysql_affected_rows();
@mysql_close();

if ($o > 0) {

} else {
  
  $out .= '<span class="gray">（程序执行不完全或不成功！['.mysql_errno().':'.mysql_error().']）</span>';
}

alert('执行完毕。'.$out, '?get=member');




?>