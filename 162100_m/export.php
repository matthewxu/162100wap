<?php
header('content-type:text/html; charset=utf-8');


$_GET['url'] = preg_replace('/[\s\r\n\<\>\"\']+/', '', $_GET['url']);

if (!empty($_GET['url'])) {
  @ require ('writable/set/set.php');

/*
  if (strpos($_GET['url'], 'http') === 0) {
    if ($_SERVER['HTTP_REFERER']) {
      $web['sitehttp'] = 'http://'.(!empty($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']);  //站点网址
      if (strpos(htmlspecialchars($_SERVER['HTTP_REFERER']), $web['sitehttp']) !== 0) {
        die('error!');
      }
    } else {
      echo '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,shrink-to-fit=no" />
<meta name="MobileOptimized" content="320" />
<meta name="HandheldFriendly" content="true" />
<title>页面跳转：</title>
<meta HTTP-EQUIV="REFRESH" content="30;URL='.$_GET['url'].'" />
<style type="text/css">
<!--
body { text-align:center; }
h2 { font-size:14px; color:#FF6600; }
.box { margin:50px auto; width:600px; background-color:#FFFFCC; border:1px dashed #339933; }
.in { line-height:30px; font-size:12px; }
-->
</style></head>
<body>
<div class="box">
<h2>提示：页面即将跳转至…</h2>
<div class="in">
<a href="'.$_GET['url'].'">'.$_GET['url'].'</a><br>
<a href="'.$_GET['url'].'">点击进入</a> <a href="javascript:void(0);" onclick="window.close();">关闭</a>
</div>
</div>
</body>
</html>';
      die;
    }
  }
*/

  //header('location: '.$_GET['url'].'');

  echo '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>跳转提示：</title>
</head>
<body>
<a href="'.$_GET['url'].'" id="a">正在进入...</a>
';
  @ include ('readonly/require/juejinlian.php');
  echo '
<script>
function clickButton(id) {
            if (document.all) {
                document.getElementById(id).click();
            }
            else {
                var evt = document.createEvent("MouseEvents");
                evt.initEvent("click", true, true);
                document.getElementById(id).dispatchEvent(evt);
            }
        }
clickButton("a");
</script>
</body>
</html>
';

  @ require ('writable/set/set_sql.php');
  @ require ('readonly/function/confirm_power.php');
  define('POWER', confirm_power());
  if (POWER > 0) {

    if (!isset($sql['db_err'])) {
      db_conn();
    }
    if ($sql['db_err'] == '') {

      $result = @mysql_query('SELECT memory_website FROM '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' WHERE username="'.$session[0].'" LIMIT 1', $db);
      $row = @mysql_fetch_assoc($result);
      @mysql_free_result($result);

      if (!empty($_GET['url']) && !empty($_GET['site'])) {
        @ require ('readonly/function/filter.php');

        $_GET['url'] = preg_replace('/^(https?:\/\/[^\/]+)\/?$/', '$1/', filter1($_GET['url']));
        $_GET['site'] = filter1(strip_tags($_GET['site']));
        $text = '<span><a href="'.$_GET['url'].'">'.$_GET['site'].'</a></span>';
        $text = $text.preg_replace('/<(li|span)><a [^>]*=\"'.preg_quote($_GET['url'], '/').'\".+<\/(li|span)>/iU', '', $row['memory_website']);
        //if (!empty($row['memory_website'])) {
          if (strlen($text) > 40000) {
            $text = substr($text, 0, 40000);
            $text = preg_replace('/<\/(li|span)>.*$/iU', '</(li|span)>', $text);
          }
        //}
        $text = addslashes($text);
        @mysql_query('UPDATE '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' SET memory_website="'.$text.'" WHERE username="'.$session[0].'" LIMIT 1', $db);
      }
    }
    @mysql_close();

  }













} else {
  header('location: ./main.php');
}







?>