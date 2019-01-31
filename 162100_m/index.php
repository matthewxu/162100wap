<?php

/* 首页 */
 
/*
* 程序名称：162100手机Wap网址导航
* 作者：162100.com
* 邮箱：162100.com@163.com
* 网址：http://www.162100.com，http://www.2dh.cn
* ＱＱ：184830962
* 声明：禁止侵犯版权或程序转发的行为，否则我方将追究法律责任
*/


@ require ('writable/set/set.php');
@ require ('writable/set/set_area.php');
@ require ('writable/set/set_sql.php');
@ include ('readonly/weather/getweather.php');

function get_i($http, $link, $class_name = '', $class_show = '') {
  global $web;
  $text = '';
  if ($http = trim($http)) {
    $text .= $class_name;
    $class_show = ($class_show != '' && is_numeric($class_show) && $class_show > 0) ? $class_show : 1000000;
    $http_arr = @explode("\n", $http, $class_show + 1);
    $http_end = $http_arr[$class_show];
    unset($http_arr[$class_show]);
    foreach ($http_arr as $e) {
      $step ++;
      $step2 ++;
      $h = @explode("|", trim($e));
      $text .= '<a href="'.eval('return '.$link.';').'"'.($h[2] != '' ? ' class="'.$h[2].'"' : '').'>'.$h[1].'</a>';
    }
    if (isset($http_end) && !empty($http_end)) {
      //若想后面显示“更多”，打开下行
      //$text .= '&#8230;';
    }
    unset($http_end);
  }
  return $text;
}



$text = $text_ = $text_session = '';
$column_show = 0;
$link = $web['link_type'] == 1 ? '"export.php?url=".urlencode($h[0])."&site=".urlencode($h[1]).""' : '"".$h[0].""';



if ($_COOKIE['cookieconfirm'] == 1) {
  @ require ('readonly/function/confirm_power.php');
  define('POWER', confirm_power());
  $text_session .= '<div id="top">';
  if (POWER > 0) {
    $text_session .= ''.$session[0].' <a href="member.php">管理</a> <a href="member.php?get=collection">收藏</a> <a href="member.php?get=memory_website">已浏览</a> <a href="member.php?post=login&act=logout">退出</a>';
  } else {
    $text_session .= '<a href="login.php?location=.%2F">登陆</a> <a href="reg.php?location=.%2F">注册</a>';
  }
  $text_session .= '</div>';
} else {
  setcookie('cookieconfirm', 1, time() + 365 * 24 * 60 * 60); //+8*3600
  $text_session .= '<style> #top { padding:0; margin:0; } #weather { top:0; } </style><a name="top" id="top"></a>';
}


if (!isset($sql['db_err'])) {
  db_conn();
}
if ($sql['db_err'] == '') {
  //获取我的收藏
  if (POWER > 0) {
    $result = @mysql_query('SELECT collection FROM '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' WHERE username="'.$session[0].'" LIMIT 1', $db);
    $row = @mysql_fetch_assoc($result);
    @mysql_free_result($result);
    if (is_array($row) && count($row) > 0) {
      $row['collection'] = preg_replace('/<\/?(li|span)>/i', '', $row['collection']);
      $row['collection'] = trim($row['collection']);
      $text .= !empty($row['collection']) ? '<div id="collection"><a class="class_name"><b>收藏</b></a>'.$row['collection'].'</div>' : '';
    }
  }
  //获取首页版面频道
  if (!empty($web['area']['homepage'])) {
    $text .= '<div id="mingz">';
    $web['area']['homepage']['name'][2] = (is_numeric($web['area']['homepage']['name'][2]) && $web['area']['homepage']['name'][2] > 0) ? $web['area']['homepage']['name'][2] : 1000000;
    foreach ($web['area']['homepage'] as $class_id => $class) {
      if ($class_id === 'name') continue;
      $column_show ++;
      $result = @mysql_query('SELECT * FROM `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` WHERE column_id="homepage" AND class_id="'.$class_id.'" AND class_title NOT LIKE "栏目置顶%" AND class_title NOT LIKE "栏目头栏%" ORDER BY id LIMIT 1', $db);
      if ($row = @mysql_fetch_assoc($result)) {
        $text .= '<div>'.get_i($row['http_name_style'], $link, '<a class="class_name" href="'.get_pseudo_static_url_class('homepage', $class_id).'"><b>'.$class[0].'</b></a>', $class[2]).'</div>';
      } else {
        $text .= '['.$web['area']['homepage'][$class_id][0].']数据导入失败！<br>';
      }
      @mysql_free_result($result);
      unset($row);
      unset($class_id, $class);
      if ($column_show >= $web['area']['homepage']['name'][2]) break; //显几层？
    }
    $text .= '</div>';
  }
  unset($web['area']['homepage']);
  $column_show = 0;

  //获取其它频道栏目
  foreach ((array)$web['area'] as $column_id => $column) {
    $column['name'][2] = (is_numeric($column['name'][2]) && $column['name'][2] > 0) ? $column['name'][2] : 1000000;
    $text_ .= '<div class="column">';
    $text_ .= '<div class="column_title"><a href="'.get_pseudo_static_url_column($column_id).'">'.$column['name'][0].'&#8230;</a></div>';
    foreach ((array)$column as $class_id => $class) {
      if ($class_id === 'name') continue;
      $column_show ++;
      $text_ .= '<div class="class">';
      $result = @mysql_query('SELECT * FROM `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` WHERE column_id="'.$column_id.'" AND class_id="'.$class_id.'" AND class_title NOT LIKE "栏目置顶%" AND class_title NOT LIKE "栏目头栏%" ORDER BY id LIMIT 1', $db);
      if ($row = @mysql_fetch_assoc($result)) {
        $text_ .= get_i($row['http_name_style'], $link, '<a class="class_title" href="'.get_pseudo_static_url_class($column_id, $class_id).'">'.$class[0].'</a>', $class[2]);
      } else {
        $text_ .= '['.$web['area'][$column_id][$class_id][0].']数据导入失败！<br>';
      }
      @mysql_free_result($result);
      unset($row);
      unset($column[$class_id]);
      unset($class_id, $class);
      $text_ .= '</div>';
      if ($column_show >= $column['name'][2]) break; //显几层？
    }
    unset($column['name']);
    if (count($column) > 0) {
      $text_ .= '<div class="class_title_other">';
      foreach ($column as $class_id => $class) {
        $text_ .= '<a href="'.get_pseudo_static_url_class($column_id, $class_id).'">'.$class[0].'</a>';
        unset($class_id, $class);
      }
      $text_ .= '</div>';
    }
    $text_ .= '</div>';
    unset($column_id, $column);
    $column_show = 0;
  }
} else {
  die($sql['db_err']);
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
<title><?php echo $web['sitename'], $web['code_author']; ?></title>
<meta name="description" content="<?php echo $web['description']; ?>">
<meta name="keywords" content="<?php echo $web['keywords']; ?>">
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
#top { text-align:center; }
#logo { margin-top:10px;  text-align:center; }
#weather { padding:0 5px; margin-bottom:10px; }
#weather a {}
.column {}
.class { height:28px; overflow:hidden; /*white-space:nowrap;*/ }
#bottom { padding:5px; margin-bottom:10px; }
#bottom a { color:#9DC1F6; margin-right:10px; display:inline-block !important; display:inline; zoom:1; }
#bottom a.bottom_title { margin:0; color:#666666; }
-->
</style>
</head>
<body><?php echo $text_session; ?><div id="logo"><img src="writable/__web__/images/logo.gif" /></div>
<div id="search">
  <form action="search.php" method="get">
    <input type="text" name="word" size="20" maxlength="16" />
    <input type="submit" value="<?php echo $web['search_bar'][0] ? $web['search_bar'][0] : '百度一下'; ?>" name="ct_1"/>
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
  <?php @ include ('writable/ad/ad_search.php'); ?>
</div>
<?php
echo $text;
unset($text);
?>
<?php
@ob_flush();
@flush();
?>
<?php
//加载天气
echo $weather;
?>
<?php
@ob_flush();
@flush();
?>
<?php
echo $text_;
unset($text_);
?>
<?php @ include ('writable/ad/ad_bottom.php'); ?>
<?php @ include ('writable/require/foot_index.php'); ?>
<?php @ include ('writable/require/statistics.txt'); ?>
<?php
if ($web['link_type'] == 0) {
  @ include ('readonly/require/juejinlian.php');
}
?>

</body>
</html>
