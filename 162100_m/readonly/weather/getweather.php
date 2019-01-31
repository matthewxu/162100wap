<?php
//ob_start();
@ ini_set('display_errors', false);
@ error_reporting(E_ERROR | E_WARNING | E_PARSE);
//header("content-type: text/html; charset=gb2312");
$GLOBALS['WEATHER_BORN'] = 0;
$GLOBALS['WEATHER_DATA'] = (basename(dirname($_SERVER['PHP_SELF'])) == 'weather' ? '../../' : './').'';
$web['chmod'] = !isset($web['chmod']) ? 755 : $web['chmod'];
$web['time_pos'] = 8;

//require ($GLOBALS['WEATHER_DATA'].'writable/set/set.php');
require ($GLOBALS['WEATHER_DATA'].'readonly/function/read_file.php');
require ($GLOBALS['WEATHER_DATA'].'readonly/function/write_file.php');
require ($GLOBALS['WEATHER_DATA'].'readonly/weather/getweather_step.php');

//$web['time_pos'] = isset($web['time_pos']) ? $web['time_pos'] : 8;
$web['weather_from'] = (!empty($_COOKIE['weatherfrom']) && is_dir($GLOBALS['WEATHER_DATA'].'readonly/weather/'.$_COOKIE['weatherfrom'])) ? $_COOKIE['weatherfrom'] : $web['weather_from'];


require ($GLOBALS['WEATHER_DATA'].'readonly/weather/'.$web['weather_from'].'/getweather.php');




















?>