<?php

@ require ('writable/set/set.php');
header("content-type: text/html; charset=utf-8");


@ $_GET['word'] = trim($_GET['word']);


//处理搜索记录
function run_memory() {
  global $web;
  if (!$_GET['word']) {
    return;
  }
  $limit = 30;
  if (isset($_COOKIE['searchword'][$_GET['word']])) {
    unset($_COOKIE['searchword'][$_GET['word']]);
  }
  $_COOKIE['searchword'][$_GET['word']] = 1;
  $n = count((array)$_COOKIE['searchword']);
  if ($n > $limit) {
    $d = array_slice($_COOKIE['searchword'], 0, $n - $limit, true);
    foreach(array_keys($d) as $k) {
      unset($_COOKIE['searchword'][$k]);
      @ setcookie('searchword['.$k.']', '', -1);
    }
  }
  @ setcookie('searchword['.$_GET['word'].']', 1, time() + floatval($web['time_pos']) * 3600 + 31536000);
}

run_memory();


header('location: '.($web['search_bar'][1] ? $web['search_bar'][1] : 'http://m.baidu.com/s?word=').''.urlencode($_GET['word']).'');
















?>