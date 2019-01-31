<?php

/* 频道 - 即大类 */


@ require ('writable/set/set.php');
@ require ('writable/set/set_sql.php');
@ require ('writable/set/set_area.php');

if (isset($_GET['column_id'])) {
  //$_GET['column_id'] = preg_replace('/[^\w]/', '', $_GET['column_id']);

  if (!array_key_exists($_GET['column_id'], $web['area'])) {
    die('&#20998;&#31867;&#73;&#68;&#38169;&#35823;&#25110;&#32570;&#22833;&#65281;&#35831;&#37325;<a href="./">&#39318;&#39029;</a>&#37325;&#26032;&#24320;&#22987;');
  }
  $title = $web['area'][$_GET['column_id']]['name'][0];
  $text = '';
  $cssmark = $mark = 0;
  if (!isset($sql['db_err'])) {
    db_conn();
  }
  if ($sql['db_err'] == '') {
    $column_py = $web['area'][$_GET['column_id']]['name'][1];
    unset($web['area'][$_GET['column_id']]['name']);
    foreach ($web['area'][$_GET['column_id']] as $class_id => $class) {
	  $cssmark++;
	  $text .= '
  <div class="column">
        <div class="column_title"><a href="'.get_pseudo_static_url_class($_GET['column_id'], $class_id).'">'.$class[0].'</a></div>';
      $result = @mysql_query('SELECT * FROM `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` WHERE column_id="'.$_GET['column_id'].'" AND class_id="'.$class_id.'" AND class_title NOT LIKE "栏目置顶%" AND class_title NOT LIKE "栏目头栏%" ORDER BY id', $db);
      if (@mysql_num_rows($result) > 0) {
        $text .= '<div class="class">';
        while ($row = @mysql_fetch_assoc($result)) {
	      $mark++;
          list($class_title, , ) = @explode('|', $row['class_title']);
          $text .= '<a href="'.get_pseudo_static_url_class($_GET['column_id'], $class_id).'#class_title_'.$mark.'">'.$class_title.'</a>';
          unset($row);
        }
	    $mark = 0;
        $text .= '</div>';
      } else {
        $text .= $_GET['column_id'].' - '.$class_id.' 的数据为空或读取失败！';
      }
      @mysql_free_result($result);

        $text .= '
      </div>
';
    }
  } else {
    $err = $sql['db_err'];
  }
  @mysql_close();

} else {
  $title = '网站地图';
  $cssmark = 0;
  foreach ((array)$web['area'] as $column_id => $column) {
    $cssmark++;
    $column = (array)$column;
    $text .= '
  <div class="column">
  <div class="column_title"><a href="'.get_pseudo_static_url_column($column_id).'">'.$column['name'][0].'</a></div>
  <div class="class">';
    unset($column['name']);
    foreach ($column as $class_id => $class) {
      $text .= '<a href="'.get_pseudo_static_url_class($column_id, $class_id).'">'.$class[0].'</a>';
    }
    $text .= '</div>';
  }
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
?><!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,shrink-to-fit=no" />
<meta name="MobileOptimized" content="320" />
<meta name="HandheldFriendly" content="true" />
<title><?PHP echo $title.' - '.$web['sitename2'], $web['code_author']; ?></title>
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
.column .class a { margin:0 5px; color:#000000; display:inline-block !important; display:inline; zoom:1; }
-->
</style>
</head>
<body>
<div id="top"><a href="./">首页</a> &gt; <?php echo $title; ?></div>
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
<?php echo !empty($text) ? $text : '<div class="body">'.$err.'</div>'; ?>
<?php include ('writable/ad/ad_bottom.php'); ?>
<?php include ('writable/require/foot.php'); ?>
<?php include ('writable/require/statistics.txt'); ?>


</body>
</html>
