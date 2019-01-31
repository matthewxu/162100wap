<?php
require ('authentication_manager.php');
?>
<?php

/* 屏蔽IP */
/* 162100源码 - 162100.com */


if (POWER < 5) {
  err('该命令必须以管理员身份登陆！请重登陆。');
}


@unlink('readonly/data/.htaccess');
@unlink('readonly/data/web.config');
@unlink('readonly/data/httpd.ini');

if (empty($_REQUEST['act']) || ($_REQUEST['act'] != 'Apache' && $_REQUEST['act'] != 'IIS6' && $_REQUEST['act'] != 'IIS7')) {
  err('参数出错！');
}

$arr = array();
foreach (array('Apache' => '.htaccess', 'IIS7' => 'web.config', 'IIS6' => 'httpd.ini') as $k => $v) {
  if (file_exists('./'.$v.'')) {
    $arr[$k] = $v;
    @unlink('./'.$v.'');
  }
  unset($k, $v);
}

$url = 'readonly/data/'.$_REQUEST['act'].'/1_2.meishi';
$a = get_headers($web['path'].$url, 1);
$h = $a[0];

if (strstr($h, '200')) {
  echo '<script> try { parent.$("p_'.$_REQUEST['act'].'").innerHTML="此项伪静态检测成功，可以选它。<a href=\"?post=pstatic&act='.$_REQUEST['act'].'\" target=\"lFrame\" onclick=\"this.parentNode.innerHTML=\'检测中...请勿关闭\';\">重新检测</a>"; } catch(err) {} try { parent.$("p_static_'.$_REQUEST['act'].'").checked="checked"; } catch(err) {} </script>';
} else {
  echo '<script> try { parent.$("p_'.$_REQUEST['act'].'").innerHTML="此项伪静态检测不成功，不可以选它。<a href=\"?post=pstatic&act='.$_REQUEST['act'].'\" target=\"lFrame\" onclick=\"this.parentNode.innerHTML=\'检测中...请勿关闭\';\">重新检测</a>"; } catch(err) {} try { parent.$("p_static_'.$_REQUEST['act'].'").checked=false; } catch(err) {} </script>';
}


if (count($arr) > 0) {
  foreach ($arr as $k => $v) {
    @copy('readonly/data/'.$k.'/'.$v.'', './'.$v.'');
    unset($k, $v);
  }
}
err('');




?>