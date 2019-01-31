<?php
@ require ('writable/set/set.php');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?><!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,shrink-to-fit=no" />
<meta name="MobileOptimized" content="320" />
<meta name="HandheldFriendly" content="true" />
<title>关于本站 - <?php echo $web['sitename2'], $web['code_author']; ?></title>
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
<div id="top"><a href="./" target="_self">首页</a> &gt; 关于本站</div>
<div class="body"><?php include ('writable/require/about.txt'); ?></div>
<?php include ('writable/ad/ad_bottom.php'); ?>
<?php include ('writable/require/foot.php'); ?>
<?php include ('writable/require/statistics.txt'); ?>

</body>
</html>