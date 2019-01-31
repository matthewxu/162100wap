<?php
require ('authentication_manager.php');
?>
<?php

  /*上传图片*/
if (POWER != 5) {
  err('该命令必须以基本管理员身份登陆！请重登陆');
}
  
  function mk_dir($dir) {
    global $web;
    $split_dir = strtok($dir, "/");
    $whole_dir = '';
    while ($split_dir !== false) {
      $whole_dir .= $split_dir.'/';
      $tempo_dir = rtrim($whole_dir, '/');
      //@chmod(dirname($tempo_dir), 0777);
      eval('@chmod(dirname($tempo_dir), 0'.$web['chmod'].');');
      if (!is_dir($tempo_dir)) {
        if (!@mkdir($tempo_dir)) {
          err('操作失败！原因分析：目录 '.$dir.' 不存在或不可创建或读写，可能是权限不足。请给予目录（'.dirname($tempo_dir).'）写权限。');
          return false;
        }
      }
      //@chmod($tempo_dir, 0777);
      eval('@chmod($tempo_dir, 0'.$web['chmod'].');');
      unset($tempo_dir);
      $split_dir = strtok("/");
    }
  }


if ($_POST['imgdir'] == '' || $_POST['imgname'] == '') {
  err('图片名称、上传目录不能空！');
}

$_POST['imgname'] = preg_replace('/\.[^\.]+$/', '', $_POST['imgname']);

if (!preg_match('/^[\w]+$/', $_POST['imgname'])) {
  err('图片名称只允许输入字母、数字、下划线');
}

if (!preg_match('/^[\w\/\.]+$/', $_POST['imgdir'])) {
  err('上传目录只允许输入字母、数字、_ . /');
}

$_POST['imgdir'] = rtrim($_POST['imgdir'], '/');
mk_dir($_POST['imgdir']);

$upload_dir = $_POST['imgdir'];
//@chmod($upload_dir, 0777);
eval('@chmod($upload_dir, 0'.$web['chmod'].');');
$inis = ini_get_all();
$uploadmax = $inis['upload_max_filesize'];
/*
[global_value] => 2M
[local_value] => 2M
[access] => 6
*/

if (!is_array($_FILES['uploadfile']) || !$_FILES['uploadfile']['size']) {
  err('提示：上传logo出现空值！原因分析：1、上传图片为空 2、图片超过系统最大上传限量'.$uploadmax['global_value'].'（'.$uploadmax['local_value'].'）。');
}
$max_size = 100 * 10000;
if ($_FILES['uploadfile']['size'] > $max_size) {
  err('提示：上传logo的文件请小于'.($max_size/1000).'KB。');
}
if (!preg_match('/\.(gif|jpg|png)$/i', $_FILES['uploadfile']['name'], $im)) {
  err('提示：上传logo请选择一个有效的文件：允许的格式有（gif|jpg|png）。');
}

$upload_filename = $_POST['imgname'].'.'.strtolower($im[1]);

if ($fp = @fopen($_FILES['uploadfile']['tmp_name'], 'rb')) {
  $img_contents = @fread($fp, $_FILES['uploadfile']['size']);
  @fclose($fp);
} else {
  $img_contents = @file_get_contents($_FILES['uploadfile']['tmp_name']);
}
if (preg_match('/<\?php|eval|POST|base64_decode|base64_encode/i', $img_contents, $m_err)) {
  err('提示！禁止提交。该文件含有禁止的代码'.str_replace('?', '\?', $m_err[0]).'。');
}

if (@move_uploaded_file($_FILES['uploadfile']['tmp_name'], $upload_dir.'/'.$upload_filename)) {
  err('图片上传成功！<br><br>
图片路径为：<a href="'.$upload_dir.'/'.$upload_filename.'" target="_blank">'.$upload_dir.'/'.$upload_filename.'</a><br>
<br>
<a href="'.$upload_dir.'/'.$upload_filename.'" target="_blank"><img src="'.$upload_dir.'/'.$upload_filename.'" /></a><br>
', 'ok');
} else {
  err('提示：上传logo出现错误！请暂时停止上传。');
}




?>