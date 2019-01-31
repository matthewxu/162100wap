<?php
require ('authentication_manager.php');
?>
<?php
if (POWER != 5) {
  err('该命令必须以基本管理员身份登陆！请重登陆');
}

if (!get_magic_quotes_gpc()) {
  $_POST['content'] = addslashes($_POST['content']);
} else {
  $_POST['content'] = $_POST['content'];
}

if ($_POST['act'] == 'foot') {
  $_POST['content'] = '
<!--公用页脚-->
<div id="foot">
  <!--foot-->'.$_POST['content'].'<!--/foot-->
  <div id="foot_v"><a href="#top">Top</a></div>
</div>';

} elseif ($_POST['act'] == 'foot_index') {
  $_POST['content'] = '
<!--首页页脚-->
<div id="foot">
  <!--foot-->'.$_POST['content'].'<!--/foot-->
  <div id="foot_v"><?php @ require(\'v.txt\'); ?> <a href="#top">Top</a> <a href="http://www.miibeian.gov.cn/"><?php @ require(\'writable/require/icp.txt\'); ?></a> </div>
</div>';

} else {
  err('传递的文件参数出错！');
}

if (!file_exists('writable/require/'.$_POST['act'].'.php')) {
  err('待修改的文件不存在或参数传递出错！');
}
@ require ('readonly/function/write_file.php');
write_file('writable/require/'.$_POST['act'].'.php', stripslashes($_POST['content']));

alert('页脚编辑完成！', 'webmaster_central.php');



?>