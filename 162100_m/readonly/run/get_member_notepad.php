<?php
require ('authentication_member.php');
?>
<style type="text/css">
<!--
#content { width:99%; height:240px; padding:0; border:1px #EEEEEE solid; overflow:auto; overflow-y:auto; overflow-x:hidden; line-height:30px; background:url(readonly/images/img_mzline.gif); }
-->
</style>
<?php

if (POWER > 0) {
  $notepadText = preg_replace("/\r/", "", get_notepad_text());
  $userPower .= ($session[1].'|'.$session[2] == $GLOBALS['session_key']) ? '' : '<br>
<span class="redword">身份密钥不符，你需要重登陆验证！否则无法保存！<a href="?post=login&act=logout">退出</a></span>';
} else {
  $userPower = '<br>
<span class="grayword"><a href="login.php">登陆</a>不限字数永久保存。否则Cookie保存</span>';
  $notepadText = preg_replace("/\r/", "", $_COOKIE['myNotepad']);
}

function get_notepad_text() {
  global $web, $sql, $db, $session;
  if (!isset($sql['db_err'])) {
    db_conn();
  }
  if ($sql['db_err'] == '') {
    $result = @mysql_query('SELECT notepad,session_key FROM `'.$sql['pref'].''.$sql['data']['承载成员档案的表名'].'` WHERE username="'.$session[0].'" LIMIT 1', $db);
    $row = @mysql_fetch_assoc($result);
    $GLOBALS['session_key'] = $row['session_key'];
    @mysql_free_result($result);
  }
  @mysql_close();
  return $row['notepad'] ? $row['notepad'] : $_COOKIE['myNotepad'];
}
?>
<form method="post" action="?post=notepad_save">
<center style="clear:both"><b>[在线记事本]</b><?php echo $userPower; ?></center>
<center style="clear:both"><textarea name="content" id="content"><?php echo $notepadText; ?></textarea></center>
<center style="clear:both"><button type="submit">保存</button> <button type="reset">清空</button></center>
</form>

<script language="javascript" type="text/javascript">
<!--
document.getElementById('content').focus();
-->
</script>
