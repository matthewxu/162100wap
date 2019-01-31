<?php
require ('authentication_member.php');
?>
<?php


$text = '';
$n_sw = count((array)$_COOKIE['searchword']);
if ($n_sw > 0/* || @file_get_contents('writable/ad/searchbar.php')*/) {
  $text .= '<form action="?post=memory_searchclear" method="post"><div id="mingz">';
  //@ include ('writable/ad/searchbar.php');
  foreach(array_keys($_COOKIE['searchword']) as $k_sw) {
    $text .= '<a href="search.php?word='.urlencode($k_sw).'">'.$k_sw.'</a>';
  }
  $text .= '</div><button name="submit" type="submit">清除</button></form>';
} else {
  $text = '<div class="output">无搜索记录！</div>';
}

echo $text;
?>
