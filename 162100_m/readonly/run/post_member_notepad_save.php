<?php
require ('authentication_member.php');
?>
<?php
//过滤主题
function filter1($text) {
  $text = trim($text);
  //$text = stripslashes($text);
  $text = htmlspecialchars($text);
  $text = preg_replace("/\r\n/", "\n", $text);
  $text = preg_replace("/\r/", "", $text);
  $text = str_replace('\"', '&quot;', $text);
  $text = str_replace('\'', '&#039;', $text);
  $text = str_replace('\\', '&#92;', $text);
  return $text;
}
@ require ('readonly/function/cutstr.php');
$content = cutstr(filter1($_POST['content']), 50000);

if (POWER > 0) {
  if (!isset($sql['db_err'])) {
    db_conn();
  }
  if ($sql['db_err'] == '') {
    //操作前再深层判断一下权限
    if ($session[1].'|'.$session[2] == get_session_key()) {
      @mysql_query('UPDATE `'.$sql['pref'].''.$sql['data']['承载成员档案的表名'].'` SET notepad="'.addslashes($content).'" WHERE username="'.$session[0].'" LIMIT 1', $db);
    }
  }
  @mysql_close();
}

if (!setcookie('myNotepad', cutstr($content, 5000), time() + floatval($web['time_pos']) * 3600 + 365*24*60*60)) {
  err('Cookie保存失败！请检查您的设置');
}
alert('保存完毕。', '?get=notepad');
?>