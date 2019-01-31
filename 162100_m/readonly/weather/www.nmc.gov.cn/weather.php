<?php
header("content-type: text/html; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<?php
if (!empty($_GET['area'])) {
?>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,shrink-to-fit=no" />
<meta name="MobileOptimized" content="320" />
<meta name="HandheldFriendly" content="true" />
<?php
}
?>
<title>天气</title>
<link href="readonly/css/<?php echo $web['cssfile']; ?>.css" rel="stylesheet" type="text/css" id="my_style">
<style type="text/css">
<!--
html { text-align:center!important; }
.body { width:auto!important; }
#tq { margin-bottom:10px; background-color:#EEEEEE; color:#999999; height:30px; line-height:30px; clear:both; padding:0 10px; text-align:left; font-weight:bold; }
#tq a {color:#336699; text-decoration:underline; font-size:12px; }
#search_weather { text-align:center; color:#999999; clear:both; }
#city162100 { color: #66CCFF; font-size:24px; font-weight:bold; }
-->
</style>
<style>
body { max-width:1216px!important; margin:0 auto!important; }
</style>
</head>
<body>
<div id="tq"><table width="100%" align="left" cellspacing="0" cellpadding="0" border="0"><tr><td width="180">天气预报  [ <a href="?area=china" style="font-size:16px;">更换城市&raquo;</a> ]</td><td>
<form id="wform" action="weather.php" method="post" target="_self">
<input id="weather_fr" name="weather_fr" type="hidden">

<div style="position:relative; font-size:12px;">
            <div style="cursor:pointer"> [ <a href="javascript:void(0)" id="optionName" onclick="document.getElementById('optionMenu').style.display=''; return false;">切换天气频道</a><span class="mainmore" onmouseover="document.getElementById('optionMenu').style.display='';">&raquo;</span> ]</div>
            <ul id="optionMenu" onmouseover="this.style.display='';" onmouseout="this.style.display='none';" style="position:absolute; top:20px; left:0; z-index:99; padding:5px 10px; background-color:#FFFFFF; border:1px #D8D8D8 solid; display:none;">
<?php
if ($w_f = @glob('readonly/weather/*', GLOB_ONLYDIR)) {
  foreach($w_f as $w_type) {
    $w_type = basename($w_type);
    $w_set = $system_weather_from==$w_type ? '（系统默认）':'';
    $wfr_title = @file_get_contents('readonly/weather/'.$w_type.'/title.txt');
    $wfr_title = $wfr_title ? $wfr_title : $w_type;
    if ($web['weather_from'] == $w_type) {
      echo '
<li><span>当前天气源：'.$wfr_title.''.$w_set.'</span></li>';
    } else {
      echo '
<li><a href="javascript:void(0)" onclick="document.getElementById(\'weather_fr\').value=\''.$w_type.'\'; document.getElementById(\'wform\').submit(); return false;">切换到：'.$wfr_title.''.$w_set.'</a></li>';
    }
    unset($w_type, $wfr_title);
  }
}
unset($w_f, $w_type);
?>
            </ul>
          </div>
</form>
</td>
</tr>
</table>
</div>

<?php


$text = '';
if (empty($_GET['area'])) {
  $_GET['type'] = 2;
  echo '
  <link rel="stylesheet" type="text/css" href="http://image.nmc.cn/static2/site/nmc/themes/basic/css/basic.css?v=2.0_2017092502"> 
  <link rel="stylesheet" type="text/css" href="http://image.nmc.cn/static2/site/nmc/themes/basic/css/product_list.css?v=2.0"> 
  <link rel="stylesheet" type="text/css" href="http://image.nmc.cn/static2/site/nmc/themes/basic/css/forecast.css?v=2.0">
<style>
body { min-width:1216px!important; }
</style>
';

  @ require ('readonly/weather/getweather.php');

  echo $weather;


} else {

    require ('readonly/weather/'.$web['weather_from'].'/getweather_seek.php');
    $text .= '<div id="search_weather">国内城市</div>';
    if (empty($_GET['province']) || !isset($seek['china'][$_GET['province']])) {
      $text_capital = $text_province = '';
      foreach ($seek['china'] as $k => $v) {
        $temp_capital = array_keys($v);
        list($temp_capital_, $py_capital, $pys_capital) = explode('|', $temp_capital[0]);
        $text_capital .= '<li><a href="?city='.urlencode($temp_capital_).'">'.$temp_capital_.'</a></li>';
        unset($temp_capital);
        $text_province .= '<li><a href="?area=china&province='.urlencode($k).'">'.$k.'</a></li>';
      }
      $text .= '<div class="column"><div class="column_title">省会城市</div><div class="class"><ul>'.$text_capital.'</ul></div></div><div class="column"><div class="column_title">各省查找</div><div class="class"><ul>'.$text_province.'</ul></div></div>';
    } else {
      if (empty($_GET['metropolis']) || !isset($seek['china'][$_GET['province']][$_GET['metropolis']])) {
        $text_metropolis = '';
        foreach ($seek['china'][$_GET['province']] as $k => $v) {
          list($temp_metropolis_, $py_metropolis, $pys_metropolis) = explode('|', $k);
          $text_metropolis .= '<ul><li><a href="?city='.urlencode($temp_metropolis_).'">'.$temp_metropolis_.'</a></li>';
          foreach ($v as $city) {
            list($temp_city_, $py_city, $pys_city) = explode('|', $city);
            $text_metropolis .= '<li><a href="?city='.urlencode($temp_city_).'" class="grayword">'.$temp_city_.'</a></li>';
          }
          $text_metropolis .= '</ul>';
        }
        $text .= '<div class="column"><div class="column_title"><a href="?area=china">国内</a> &gt; '.$_GET['province'].'</div><div class="class">'.$text_metropolis.'</div></div>';

      } else {
        $text_city = '<li><a href="?city='.urlencode($_GET['metropolis']).'">'.$_GET['metropolis'].'</a></li>';
        foreach ($seek['china'][$_GET['province']][$_GET['metropolis']] as $k => $v) {
          list($temp_city_, $py_city, $pys_city) = explode('|', $v);
          $text_city .= '<li><a href="?city='.urlencode($temp_city_).'">'.$temp_city_.'</a></li>';
        }
        $text .= '<div class="column"><div class="column_title"><a href="?area=china">国内</a> &gt; <a href="?area=china&province='.urlencode($_GET['province']).'">'.$_GET['province'].'</a> &gt; '.$_GET['metropolis'].'</div><div class="class"><ul>'.$text_city.'</ul></div></div>';
      }
    }

  echo $text;
}


?>
</body>
</html>
<?php
@ ob_end_flush();
?>