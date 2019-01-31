<?php
require ('authentication_manager.php');
?>
<?php

if (POWER != 5) {
  err('<script> alert("该命令必须以基本管理员身份登陆！请重登陆"); </script>');
}


err('<script> alert("该版本没有开放此功能！请联系官方购买。但你可以使用第2步进行导入"); </script>');


?>