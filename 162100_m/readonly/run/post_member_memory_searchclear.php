<?php
require ('authentication_member.php');
?>
<?php


$n = count((array)$_COOKIE['searchword']);
if ($n > 0) {
  foreach(array_keys($_COOKIE['searchword']) as $k) {
    unset($_COOKIE['searchword'][$k]);
    if (!setcookie('searchword['.$k.']', '', -1)) {
      err('Cookie删除失败！请检查您的设置');
    }
  }
}
alert('清除完毕。', '?get=memory_search');
?>