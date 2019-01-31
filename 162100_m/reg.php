<?php
@ require('writable/set/set.php');
@ require('readonly/function/imcode.php');

echo '<?xml version="1.0" encoding="UTF-8"?>';
?><!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,shrink-to-fit=no" />
<meta name="MobileOptimized" content="320" />
<meta name="HandheldFriendly" content="true" />
<title>注册 - <?php echo $web['sitename2'], $web['code_author']; ?></title>
<style type="text/css">
<!--
<?php
if (isset($_COOKIE['myStyle']) && file_exists('readonly/css/'.$_COOKIE['myStyle'].'.css')) {
  $cssf = $_COOKIE['myStyle'];
} else {
  $cssf = $web['cssfile'] ? $web['cssfile'] : 1;
}
@ require ('readonly/css/'.$cssf.'.css');
unset($cssf);

?>
-->
</style>
</head>
<body>
<div id="top"><a href="./" target="_self">首页</a> &gt; 注册</div>
<div id="search">当前设置：<?php
echo '<span class="redword">';
if ($web['stop_reg'] == 1) {
  $disabled = ' disabled';
  echo '<b>×</b> 关闭新用户注册';
} elseif ($web['stop_reg'] == 2) {
  echo '<b>！</b> 注册需审核';
} else {
  echo '<b>√</b> 开放注册';
}
echo '</span>';
?>
  <br>
  已有帐号？<a href="login.php">立即登录</a> </div>
<div class="body">
  <form action="member.php?post=login" method="post" onsubmit="return postChk()">
    <table width="100%" border="0" cellpadding="3" cellspacing="0">
      <tr>
        <td align="right">用户名</td>
        <td align="left"><input name="username" id="username" type="text" size="15" maxlength="64"<?php echo $disabled; ?> /></td>
      </tr>
      <tr>
        <td align="right">邮箱</td>
        <td align="left"><input name="email" id="email" type="text" size="15" maxlength="200"<?php echo $disabled; ?> /></td>
      </tr>
      <tr>
        <td align="right">密码</td>
        <td align="left"><input name="password" id="password" type="password" size="15" maxlength="40"<?php echo $disabled; ?> /></td>
      </tr>
      <tr>
        <td align="right">重输密码</td>
        <td align="left"><input name="password_again" id="password_again" type="password" size="15" maxlength="40"<?php echo $disabled; ?> /></td>
      </tr>
      <tr>
        <td align="right">验证码</td>
        <td align="left"><input name="imcode" id="imcode" type="text" onblur="postChk()" style="width:68px;float:left;margin-right:3px;" maxlength="6"<?php echo $disabled; ?> />
            <?php echo $imcode; ?></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td align="left"><button name="submit" type="submit"<?php echo $disabled; ?>>注册</button></td>
      </tr>
    </table>
    <input type="hidden" name="act" value="reg" />
    <input name="location" id="location" type="hidden" value="<?php echo !empty($_REQUEST['location']) ? htmlspecialchars($_REQUEST['location']) : htmlspecialchars($_SERVER['HTTP_REFERER']); ?>" />
  </form>
</div>
<?php include ('writable/require/foot.php'); ?>
<?php include ('writable/require/statistics.txt'); ?>

</body>
</html>
