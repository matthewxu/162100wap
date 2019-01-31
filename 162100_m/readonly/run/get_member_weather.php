<?php
require ('authentication_member.php');
?>
<form action="member.php?post=weather" method="post" target="_self">
<input id="weather_fr" name="weather_fr" type="hidden" />
  
<?php
@ require ('readonly/weather/getweather_step.php');
$system_weather_from = $web['weather_from'];
$web['weather_from'] = (!empty($_COOKIE['weatherfrom']) && is_dir('readonly/weather/'.$_COOKIE['weatherfrom'])) ? $_COOKIE['weatherfrom'] : $web['weather_from'];

if ($w_f = @glob('readonly/weather/*', GLOB_ONLYDIR)) {
  foreach($w_f as $w_type) {
    $w_type = basename($w_type);
    $w_set = $system_weather_from==$w_type ? '<span class="grayword">（系统默认）</span>':'';

    $wfr_title = @file_get_contents('readonly/weather/'.$w_type.'/title.txt');
    $wfr_title = $wfr_title ? $wfr_title : $w_type;
    echo '
  <p>'.$wfr_title.''.$w_set.'<br />
    <img src="readonly/weather/'.$w_type.'/thumb.jpg" /><br />
';
    if ($web['weather_from'] == $w_type) {
      echo '
    <button type="button" onclick="alert(\'已选择该模式了\'); return false" class="greenword">√已选择该样式</button>
';
    } else {
      echo '
    <button type="submit" onclick="document.getElementById(\'weather_fr\').value=\''.$w_type.'\'">选择该样式</button>
';
    }
    echo '</p>';
  }
  unset($w_f, $w_type);
} else {
  echo '没有天气模式记录';
}

?>
</form>
