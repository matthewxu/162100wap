<?php
require ('authentication_member.php');
?>
<style type="text/css">
<!--
.iface_s { text-align:center; }
.iface_s img { padding:2px; border:5px #D8D8D8 solid; }
-->
</style>
<div class="iface_s"><img src="userface.php" /></div>
<?php
foreach ($power_url as $k => $v) {
  $text_menu .= '<li><a href="?get='.$k.$u__.'">'.$v.'</a></li>';
  unset($u__);
}

echo '<ul>'.$text_menu.'</ul>';
?>
