<?php

/* 更多 */

@ require ('writable/set/set.php');
@ require ('writable/set/set_sql.php');
@ require ('writable/set/set_area.php');
if (!isset($web['html'])) {
  @ require ('writable/require/set_html.php');
}


if (!function_exists('get_m_more')) {
  function get_m_more($h_n_s, $c, $class_n = 4, $i) {
    global $web, $sql, $db, $link;
    $text = $text_class_n = '';
    $step = $step2 = 0;

    if ($web['link_type'] == 1) {
      $link = '"export.php?url=".urlencode($h[0]).""';
    } else {
      $link = '"".$h[0].""';
    }

    $text .= '
  <div class="column" name="class_title_'.$i.'" id="class_title_'.$i.'">';
    $text .= $c != '' ? '<div class="body">'.$c.'</div>' : '';

    $h_n_s = trim($h_n_s);
    $total_arr = @explode("\n", $h_n_s);
    $n = count($total_arr);
    //导入网址链接
    if ($n > 0) {
      if (is_numeric($class_n) && $class_n > 0) {
        $text_class_n = 'if ($step >= $class_n && $n > $step2) { $text .= "<br>
"; $step = 0; }';
      }
      $text .= '<div class="class" id="class_'.$i.'">';
      foreach ($total_arr as $each) {
        $step ++;
        $step2 ++;
        $h = @explode("|", trim($each));
        $text .= '<a href="'.eval('return '.$link.';').'"'.($h[2] != '' ? ' class="'.$h[2].'"':'').'>'.$h[1].'</a>';
        eval($text_class_n);
      }
      $text .= '</div>';
    } else {
      $text .= '没有网址数据！';
    }
    $text .= '</div>';
    return $text;
  }
}

function filter($text) {
  $text = trim($text);
  $text = stripslashes($text);
  //$text = htmlspecialchars($text);
  $text = preg_replace('/[\r\n\'\"\s\<\>]+/', '', $text);
  $text = str_replace('|', '&#124;', $text);
  //$text = str_replace('/', '&#47;', $text);
  return $text;
}

$_GET['column_id'] = preg_replace('/[^\w]/', '', $_GET['column_id']);
$_GET['class_id'] = preg_replace('/[^\w]/', '', $_GET['class_id']);

if (!(isset($_GET['column_id']) && array_key_exists($_GET['column_id'], $web['area']))) {
  die('&#20998;&#31867;&#73;&#68;'.$_GET['column_id'].'&#38169;&#35823;&#25110;&#32570;&#22833;&#65281;&#35831;&#37325;<a href="./">&#39318;&#39029;</a>&#37325;&#26032;&#24320;&#22987;');
}
if (!(isset($_GET['class_id']) && array_key_exists($_GET['class_id'], $web['area'][$_GET['column_id']]))) {
  die('&#26639;&#30446;&#73;&#68;'.$_GET['class_id'].'&#38169;&#35823;&#25110;&#32570;&#22833;&#65281;&#35831;&#37325;<a href="./">&#39318;&#39029;</a>&#37325;&#26032;&#24320;&#22987;');
}
$_GET['class_title'] = filter(htmlspecialchars($_GET['class_title']));
if (empty($_GET['class_title'])) {
  die('&#20998;&#31867;&#21442;&#25968;&#38169;&#35823;&#25110;&#32570;&#22833;&#65281;&#35831;&#37325;<a href="./">&#39318;&#39029;</a>&#37325;&#26032;&#24320;&#22987;');
}


$text = '';
$cssmark = 0;

if (!isset($sql['db_err'])) {
  db_conn();
}
if ($sql['db_err'] == '') {
  $result = @mysql_query('SELECT * FROM `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` WHERE column_id="'.$_GET['column_id'].'" AND class_id="'.$_GET['class_id'].'" AND class_title LIKE "'.$_GET['class_title'].'|%" LIMIT 1', $db);
  if ($row = @mysql_fetch_assoc($result)) {
    list($class_title, $class_n, $class_more) = @explode("|", $row['class_title']);
    $cssmark++;
    $text .= get_m_more($row['http_name_style'], $row['class_priority'], $class_n, $cssmark);
    unset($row);
  } else {
    $err = '数据为空或读取失败！';
  }
  @mysql_free_result($result);

} else {
  $err = $sql['db_err'];
}

@mysql_close();

echo '<?xml version="1.0" encoding="UTF-8"?>';

?><!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,shrink-to-fit=no" />
<meta name="MobileOptimized" content="320" />
<meta name="HandheldFriendly" content="true" />
<title><?php echo $web['area'][$_GET['column_id']][$_GET['class_id']][0].' - '.$class_title.' - '.$web['sitename2'], $web['code_author']; ?></title>
<base target="_blank" />
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
<div id="top"><a href="./" target="_self">首页</a> &gt; <a href="<?php echo get_pseudo_static_url_column($_GET['column_id']); ?>" target="_self"><?php echo $web['area'][$_GET['column_id']]['name'][0]; ?></a> &gt; <a href="<?php echo get_pseudo_static_url_class($_GET['column_id'], $_GET['class_id']); ?>" target="_self"><?php echo $web['area'][$_GET['column_id']][$_GET['class_id']][0]; ?></a> &gt; <?php echo $class_title; ?>
</div>
<div id="search">
  <form action="search.php" method="get">
    <input type="text" name="word" size="20" maxlength="16" /> <input type="submit" value="<?php echo $web['search_bar'][0] ? $web['search_bar'][0] : '百度一下'; ?>" name="ct_1"/>
<?php
  $n_sw = count((array)$_COOKIE['searchword']);
  if ($n_sw > 0/* || @file_get_contents('writable/ad/searchbar.php')*/) {
    echo '<div id="search_words">';
    //@ include ('writable/ad/searchbar.php');
    foreach(array_keys($_COOKIE['searchword']) as $k_sw) {
      echo '<a href="search.php?word='.urlencode($k_sw).'">'.$k_sw.'</a>';
    }
    echo '</div>';
  }
?>
  </form>
  <?php include ('writable/ad/ad_search.php'); ?>
</div>
<?php
if (!isset($err)) {
  echo $text;
} else {
  echo '
  <div class="body">'.$err.'</div>';
}
?>
<?php include ('writable/ad/ad_bottom.php'); ?>
<?php include ('writable/require/foot.php'); ?>
<?php include ('writable/require/statistics.txt'); ?>


</body>
</html>
