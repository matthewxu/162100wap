<?php
require ('authentication_member.php');
?>
<?php


$myStyle = !empty($_COOKIE['myStyle']) ? $_COOKIE['myStyle'] : $web['cssfile'];
$text = '';
$cssfiles = @glob('readonly/css/*.css');
$n_all = count($cssfiles);
if ($n_all > 0) {
  foreach ($cssfiles as $style) {
    $style = basename($style, '.css');
    if ('css'.$myStyle == 'css'.$style) {
      //$v1 = ' style="border:2px #FF0000 solid;"';
      $v2 = ' checked';
    } else {
      //$v1 = ' style="border:2px #EEEEEE solid;"';
      $v2 = '';
    }
    $text .= '<div class="co"><label for="cssfile'.$style.'"><img src="readonly/css/'.$style.'.gif" /><input type="radio" name="cssfile" id="cssfile'.$style.'" value="'.$style.'"'.$v2.' /></label></div>';
  }
} else {
  $text .= '没有风格记录';
}
echo '
<style type="text/css">
<!--
.co { position:relative; width:80px; height:150px; margin:5px;display:inline-block !important;display:inline;zoom:1; }
.co input, .co img { position:absolute; left:0; top:0; }
-->
</style>
<form action="?post=style" method="post">
'.$text.'
<center style="clear:both;"><button name="submit" type="submit">保存</button></center>
</form>';


?>