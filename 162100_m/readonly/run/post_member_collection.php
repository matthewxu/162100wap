<?php
require ('authentication_member.php');
?>
<?php
//栏目分类设置
if (POWER == 0) {
  err('请登陆或注册帐号！先');
}

$_POST['linkhttp'] = array_unique(array_filter((array)$_POST['linkhttp']));
$text = '';

//if (count($_POST['linkhttp']) == 0) {
//  err('数据为空！<br>问题分析：<br>1、您可能未填写<br>2、参数传递出错。');
//} else {
@ require ('readonly/function/filter.php');
  foreach ((array)$_POST['linkhttp'] as $k => $v) {
    $v = preg_replace('/^(https?:\/\/[^\/]+)\/?$/', '$1/', filter1($v));
    $_POST['linkname'][$k] = filter1(strip_tags($_POST['linkname'][$k]), true);
    if (!empty($v) && !empty($_POST['linkname'][$k])) {
      $text .= '<span><a href="'.$v.'">'.$_POST['linkname'][$k].'</a></span>';
    }
  }
//}


if (strlen($text) > 40000) {
  err('自定义收藏数据量过大（大于40000字节）！请减小数据库的数据量');
}

if (!isset($sql['db_err'])) {
  db_conn();
}
if ($sql['db_err'] != '') {
  err($sql['db_err']);
}

//操作前再深层判断一下权限
if ($session[1].'|'.$session[2] != get_session_key()) {
  err('经系统检验权限，你的身份密钥不符，关键操作！请重登陆修正！');
}

@mysql_query('UPDATE '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' SET collection="'.addslashes($text).'" WHERE username="'.$session[0].'" LIMIT 1', $db);
if (@mysql_affected_rows() > 0) {
  $s = 1;
}
@mysql_close();


alert('设置'.(isset($s)?'成功！请浏览首页“收藏”':'失败！请返回检查').'', '?get=collection');




?>