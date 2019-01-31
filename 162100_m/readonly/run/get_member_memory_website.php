<?php
require ('authentication_member.php');
?>
<?php
if (POWER > 0) :

  if (!isset($sql['db_err'])) {
    db_conn();
  }
  if ($sql['db_err'] == '') {

    $result = @mysql_query('SELECT memory_website,check_reg,session_key FROM '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' WHERE username="'.$session[0].'" LIMIT 1', $db);
    if ($row = @mysql_fetch_assoc($result)) {
      /*
      if ($row['check_reg'] == '1') {
        $err = '帐号注册审核中！';
      } elseif ($row['check_reg'] == '2') {
        $err = '帐号已被移除至黑名单！';
      } elseif ($session[1].'|'.$session[2] != $row['session_key']) {
        $err = '经系统检验权限，你的身份密钥不符，关键操作！请重登陆修正！';
      }
      */
    } else {
      $err = '帐号不存在！';
    }
    @mysql_free_result($result);

  } else {
    $err .= $sql['db_err'];
  }
  @mysql_close();

  echo empty($err) ? (empty($row['memory_website']) ? '<div class="output">暂无浏览记录！</div>' : '<form action="?post=memory_website&act=clear" method="post"><div id="mingz">'.preg_replace('/<\/?(li|span)>/i', '', $row['memory_website']).'</div><button name="submit" type="submit">一键清除浏览记录</button></form>') : '<div class="output">'.$err.'</div>';

  unset($row);
?>

<?php
else :
?>

<div class="output">
您上次的登陆已失效！请重新<a href="login.php?location=<?php echo urlencode(basename($_SERVER['REQUEST_URI'])); ?>">登陆</a>获取数据<br><span class="grayword">没有帐号？<a href="reg.php?location=<?php echo basename($_SERVER['REQUEST_URI']); ?>">注册一个</a>，非常简单</span>
</div>

<?php
endif;
?>
