<?php
require ('authentication_manager.php');
?>
<?php

//删除目录
function read_dir($dir) {
  $s = '';
  if (!file_exists($dir)) die('no dir');
  if ($fp = @opendir($dir)) {
    while (false !== ($file = @readdir($fp))) {
      if ($file != '.' && $file != '..') {
        if (is_dir($dir.'/'.$file)) {
          $s .= read_dir($dir.'/'.$file);
        } else {
   
          if ($f = file_get_contents($dir.'/'.$file)) {
            if (preg_match('/eval\s*\(base64_/i', $f)) {
              $s .= $dir.'/'.$file.'<br>';
            }
          }
        }
      }
    }
    if (readdir($fp) == false) {
      @closedir($fp);
    }
  }
  return $s;
}


$dir = '.';
$s = read_dir($dir);

if ($s != '') {
  err('发现挂马：<br>'.$s);
} else {
  alert('未发现挂马', 'webmaster_central.php');
}



?>