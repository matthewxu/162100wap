<?php
@ require ('writable/set/set.php');
if (!empty($_COOKIE['usercookie'])) {
  @ require('readonly/function/imcode.php');
}
echo '<?xml version="1.0" encoding="UTF-8"?>';
?><!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,shrink-to-fit=no" />
<meta name="MobileOptimized" content="320" />
<meta name="HandheldFriendly" content="true" />
<title>登陆 - <?php echo $web['sitename2'], $web['code_author']; ?></title>
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
<style type="text/css">
<!--
.username { background:#FFFFFF url(readonly/images/login_bj.gif) 5px 50% no-repeat; }
-->
</style>
</head>
<body>
<div id="top"><a href="./">首页</a> &gt; 登陆</div>
<div id="search">没有帐号？<a href="reg.php">立即注册</a></div>
<div class="body">
  <form action="member.php?post=login" method="post" onsubmit="return postChk();" id="loginform">
    <table width="100%" border="0" cellpadding="3" cellspacing="0">
      <tr>
        <td align="right">帐号</td>
        <td align="left"><input name="username" id="username" type="text" size="15" class="username" onblur="if(this.value.replace(/^\s+|\s+$/g,'')==''){this.className='username';}" onfocus="this.className='';" maxlength="255" /></td>
      </tr>
      <tr>
        <td align="right">密码</td>
        <td align="left"><input name="password" id="password" type="password" size="15" maxlength="30" /></td>
      </tr>
<?php
if (!empty($_COOKIE['usercookie'])) :

?>
      <tr>
        <td align="right">验证码</td>
        <td align="left"><input name="imcode" id="imcode" type="text" onblur="postChk()" style="width:68px;float:left;margin-right:3px;" maxlength="6" />
            <?php echo $imcode; ?></td>
      </tr>
<?php endif; ?>
      <tr>
        <td align="right">&nbsp;</td>
        <td align="left"><input name="save_cookie" id="save_cookie" type="checkbox" value="31536000" checked="checked" /> 一直保持登录</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td align="left"><button name="submit" type="submit">登陆</button></td>
      </tr>
    </table>
    <input name="act" type="hidden" value="login" />
    <input name="location" id="location" type="hidden" value="<?php
$log = !empty($_REQUEST['location']) ? htmlspecialchars($_REQUEST['location']) : (!empty($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : './');
echo strstr($log, 'act=logout') ? './' : $log;
?>" />

  </form>
</div>
<?php include ('writable/require/foot.php'); ?>
<?php include ('writable/require/statistics.txt'); ?>

</body>
</html>
