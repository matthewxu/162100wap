<?php

/* 栏目 - 即小类 */


$time_key = 6; //每天6时采集


@ require ('writable/set/set.php');
if (!isset($sql)) {
  @ require ('writable/set/set_sql.php');
}
if (!isset($web['area'])) {
  @ require ('writable/set/set_area.php');
}

function run_URLdecode($e) {
  $text = "";
  if ($m = preg_split('/%3F/i', $e, 2)) {
    $text .= preg_match("/%[0-9A-Z]+/", $m[0]) ? urldecode($m[0]) : $m[0];
    if (count($m) == 2) {
      $text .= (!empty($m[1]) && preg_match("/(%[0-9A-Z]{4}){2,}/", $m[1])) ? '?'.urldecode($m[1]) : '?'.$m[1];
    }
  }
  return $text;
}

if (!function_exists('get_m_class')) {
  function get_m_class($h_n_s, $class_title, $c, $class_n = 4, $class_more = '', $i) {
    global $web, $sql, $db, $link;
    $text = $text_class_n = $text_class_more = '';
    $step = $step2 = 0;

    if ($web['link_type'] == 1) {
      $link = '"export.php?url=".urlencode($h[0]).""';
    } else {
      $link = '"".$h[0].""';
    }

    $text .= '
  <div class="column" name="class_title_'.$i.'" id="class_title_'.$i.'">
    <div class="column_title">'.$class_title.'</div>';

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
      if (!empty($class_more) && is_numeric($class_more) && $class_more < $n) {
        $total_arr = array_slice($total_arr, 0, $class_more);
        $text_class_more .= '<a href="more.php?column_id='.$_GET['column_id'].'&class_id='.$_GET['class_id'].'&class_title='.urlencode($class_title).'" class="more">更多…</a>';

      }

      $text .= '<div class="class" id="class_'.$i.'">';
      foreach ($total_arr as $each) {
        $step ++;
        $step2 ++;
        $h = @explode("|", trim($each));
        $text .= '<a href="'.eval('return '.$link.';').'"'.($h[2] != '' ? ' class="'.$h[2].'"':'').'>'.$h[1].'</a>';
        eval($text_class_n);
      }
      $text .= $text_class_more.'</div>';

    } else {
      $text .= '没有网址数据！';
    }
    $text .= '</div>';
    return $text;
  }
}

$_GET['column_id'] = preg_replace('/[^\w]/', '', $_GET['column_id']);
$_GET['class_id'] = preg_replace('/[^\w]/', '', $_GET['class_id']);

if (!(isset($_GET['column_id']) && array_key_exists($_GET['column_id'], $web['area']))) {
  die('&#39057;&#36947;&#73;&#68;'.$_GET['column_id'].'&#38169;&#35823;&#25110;&#32570;&#22833;&#65281;&#35831;&#37325;&#39318;&#39029;&#37325;&#26032;&#24320;&#22987;');
}
if (!(isset($_GET['class_id']) && array_key_exists($_GET['class_id'], $web['area'][$_GET['column_id']]))) {
  die('&#26639;&#30446;&#73;&#68;'.$_GET['class_id'].'&#38169;&#35823;&#25110;&#32570;&#22833;&#65281;&#35831;&#37325;<a href="./">&#39318;&#39029;</a>&#37325;&#26032;&#24320;&#22987;');
}

$text = $text__ = '';
$cssmark = 0;


if (!isset($sql['db_err'])) {
  db_conn();
}
if ($sql['db_err'] == '') {
  $result = @mysql_query('SELECT * FROM `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` WHERE column_id="'.$_GET['column_id'].'" AND class_id="'.$_GET['class_id'].'" ORDER BY id', $db);
  if (@mysql_num_rows($result) > 0) {
    while ($row = @mysql_fetch_assoc($result)) {
      if (strstr($row['class_title'], '栏目头栏') && $row['http_name_style'] == '') { //这是头栏$priority_pos_key
        $priority_pos_key = strstr($row['class_title'], '|1') ? 1 : 0;
        if ($row['class_grab'] = trim($row['class_grab'])) {
          $row['class_grab'] = preg_replace("/[\r\n]+/", "\n", $row['class_grab']);
          list($p_time_stamp, $p_time, $p_url, $p_b, $p_e, $p_b_is, $p_e_is, $p_change_rule) = @explode("\n", $row['class_grab']);
          //计算时间间隔差
          if ($p_time == '' || !is_numeric($p_time)) {
            //$time_stamp = $time_now + 100 * 365 * 24 * 60 * 60;
          } else {
            $time_now = time() + floatval($web['time_pos']) * 3600;
            $p_time = floatval($p_time);
            if ($p_time > 0) {
              $time_stamp = $time_now + $p_time * 60;
            } else {
              $p_time_temp = abs($p_time);
              $time_0 = $time_now - (gmdate('H', $time_now) * 3600 + gmdate('i', $time_now) * 60 + gmdate('s', $time_now));
              $time_stamp = $time_0 + $p_time_temp * 3600 + ($p_time_temp > abs(gmdate('H', $time_now)) ? 0 : 24 * 3600);
            }
            if ($time_now - $p_time_stamp > 0) {
              @ ini_set('track_errors', 1); 
              @ require ('readonly/function/read_file.php');
              $php_errormsg = NULL;
              if ($str_caiji = read_file($p_url)) {
			    if (function_exists('mb_detect_encoding')) {
				  $cha = mb_detect_encoding($str_caiji, array("UTF-8","ASCII","EUC-CN","CP936","BIG-5","GB2312","GBK"));
				}
                if (!$cha) {
                  if(preg_match("/charset[\s\r\n]*=[\s\r\n\'\"]*([\w\-]+)[^\>]*>/i", $str_caiji, $m_cha)){
                    $cha = $m_cha[1];
                  }
                }
                if (isset($cha) && $cha != "") {
                  if(strtolower($cha) != "utf-8"){
                    $str_caiji = @iconv($cha, "utf-8", $str_caiji);
                  }
                }

                $p_b_temp = preg_replace("/[\s\r\n]+/", " ", $p_b);
                $p_b = addcslashes($p_b_temp, '.\+*?[^]$(){}=!<>|:-"/'); //preg_quote
                $p_b = preg_replace("/[\s\r\n]+/", "[\\\s\\\\r\\\\n]+", $p_b);
                $p_b = (isset($p_b_is) && $p_b_is == 1) ? $p_b."(" : "(".$p_b;
                $p_e_temp = preg_replace("/[\s\r\n]+/", " ", $p_e);
                $p_e = addcslashes($p_e_temp, '.\+*?[^]$(){}=!<>|:-"/'); //preg_quote
                $p_e = preg_replace("/[\s\r\n]+/", "[\\\s\\\\r\\\\n]+", $p_e);
                $p_e = (isset($p_e_is) && $p_e_is == 1) ? ")".$p_e : $p_e.")";

                preg_match("/".$p_b."(.+)".$p_e."/isU", $str_caiji, $m_caiji);
                if ($php_errormsg !== NULL) {
                  //echo "<b>采集标记填写得不对！请填写准确的正则。错误代码：</b><i>[".$php_errormsg."]</i><br>";
                  $php_errormsg = NULL;
                } else {
                  if (!$m_caiji) {
                    //echo "<b>采集源URL或采集标记填写得不对！请检查。没有采集数据被存储。</b><br>";
                  } else {
                    @ require ('readonly/function/filter.php');
                    $row['class_priority'] = $m_caiji[1];

                    if ($p_change_rule = trim($p_change_rule)) {
                      $p_change_arr = @explode("{162100~mark2}", $p_change_rule);
                      $p_change_arr = array_unique(array_filter($p_change_arr));
                      if (is_array($p_change_arr) && count($p_change_arr) > 0) {
                        foreach ($p_change_arr as $p_c_key => $p_c_val) {
                          list($p_fr, $p_to) = @explode("{162100~mark1}", $p_c_val);

                          //$p_fr = trim($p_fr);
                          $p_fr = preg_replace("/[\s\r\n]+/", "[\\\s\\\\r\\\\n]+", $p_fr);
                          //$p_to = trim($p_to);

                          if ($p_fr != "") {
                            $priority_temp = preg_replace($p_fr, $p_to, $row['class_priority']);
                            if ($php_errormsg !== NULL) {
                              //echo "<b>过滤正则[".($p_c_key+1)."]填写得不对！故没有对采集到的数据进行过滤。错误代码：</b><i>[".$php_errormsg."]</i><br>";
                              $php_errormsg = NULL;
                              continue;
                            } else {
                              $row['class_priority'] = $priority_temp;
                            }
                            unset($priority_temp);
                          }
                        }
                        $row['class_priority'] = preg_replace('/<([^>]+)>/e', '"<".run_URLdecode("$1").">"', $row['class_priority']);
                        $row['class_priority'] = filter2($row['class_priority']);
                      }
                    }
                    $text_p = "".($time_stamp)."\n".$p_time."\n".$p_url."\n".$p_b_temp."\n".$p_e_temp."\n".$p_b_is."\n".$p_e_is."\n".$p_change_rule."";
                    @mysql_query('UPDATE `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` SET class_priority="'.addslashes($row['class_priority']).'",class_grab="'.addslashes($text_p).'" WHERE column_id="'.$_GET['column_id'].'" AND class_id="'.$_GET['class_id'].'" AND class_title LIKE "栏目头栏%"', $db);
                    //if (@mysql_affected_rows() > 0) {
                    //   echo '<b>栏目头栏储存失败！错误代码：</b><i>['.mysql_errno().':'.mysql_error().']</i><br>';
                    //}

                  }
                }
              } else {
                //echo "<b>采集源URL填写得不对！没有采集到数据。</b><br>";
              }
              @ ini_set('track_errors', 0); 
            }
          }
        }
        if (preg_replace('/<style.+<\/style>/isU', '', trim($row['class_priority'])) != '') {
          $text .= '
<div class="body">'.$row['class_priority'].'</div>';
        } else {
          $text .= $row['class_priority'];
        }
        continue;
      } else {
        list($class_title, $class_n, $class_more) = @explode("|", $row['class_title']);
        if ($class_title == '栏目置顶') {
          $text .= get_m_class($row['http_name_style'], '栏目置顶', $row['class_priority'], $class_n, $class_more, 'top');
          continue;
        } else {
          $cssmark++;
          $text__ .= get_m_class($row['http_name_style'], $class_title, $row['class_priority'], $class_n, $class_more, $cssmark);
	    }
      }
      unset($row);
    }
  } else {
    $err = '数据为空或读取失败！';
  }
  @mysql_free_result($result);

} else {
  $err = ''.$sql['db_err'].'';
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
<title><?php echo $web['area'][$_GET['column_id']][$_GET['class_id']][0].' - '.$web['sitename2'], $web['code_author']; ?></title>
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
a.more { color:#C0BB35; }
-->
</style>
</head>
<body>
<div id="top"><a href="./" target="_self">首页</a> &gt; <a href="<?php echo get_pseudo_static_url_column($_GET['column_id']); ?>" target="_self"><?php echo $web['area'][$_GET['column_id']]['name'][0]; ?></a> &gt; <?php echo $web['area'][$_GET['column_id']][$_GET['class_id']][0]; ?>
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
  echo !empty($priority_pos_key) ? $text__.$text : $text.$text__;
} else {
  echo '
  <div class="body">'.$err.'</div>';
}
?>
<?php include ('writable/ad/ad_bottom.php'); ?>
<?php include ('writable/require/foot.php'); ?>
<?php include ('writable/require/statistics.txt'); ?>
<?php
if ($web['link_type'] == 0) {
  @ include ('readonly/require/juejinlian.php');
}
?>


</body>
</html>
