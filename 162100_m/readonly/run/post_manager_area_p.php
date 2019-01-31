<?php
require ('authentication_manager.php');
?>
<?php

//栏目分类设置——拼音纠错
if (POWER != 5) {
  err('该命令必须以基本管理员身份登陆！请重登陆');
}
@ require ('writable/set/set_area.php');
@ require ('readonly/function/filter.php');
@ require ('readonly/function/pinyin.php');

$area_new = '';

foreach ($web['area'] as $fid => $f) {
  if (isset($_POST['column_correct'][$fid])) {
    $fpy = empty($_POST['column_correct'][$fid]) ? pinyin($f['name'][0], true) : $_POST['column_correct'][$fid];
  } else {
    $fpy = $web['area'][$fid]['name'][1];
  }
  $area_new .= '
$web[\'area\'][\''.$fid.'\'][\'name\'] = array(\''.$f['name'][0].'\', \''.$fpy.'\', '.(abs($f['name'][2]) >= 1 ? abs($f['name'][2]) : '').');';

  unset($web['area'][$fid]['name']);
  foreach ($web['area'][$fid] as $cid => $c) {
    if (isset($_POST['class_correct'][$fid][$cid])) {
      $cpy = empty($_POST['class_correct'][$fid][$cid]) ? pinyin($c[0]) : $_POST['class_correct'][$fid][$cid];
    } else {
      $cpy = $web['area'][$fid][$cid][1];
    }
    $area_new .= '
$web[\'area\'][\''.$fid.'\'][\''.$cid.'\'] = array(\''.$c[0].'\', \''.$cpy.'\', '.(abs($c[2]) >= 1 ? abs($c[2]) : '').''.(!is_numeric($fid) && isset($c[3]) && $c[3] == 1 ? ', 1' : '').');';
  }
}

//$area_new['sybm'] = $web['area']['sybm'];

$text = '<?php

'.$area_new.'


function get_pseudo_static_url_column($column_id) {
  global $web;
  return ($web[\'p_static\'] == 1 && (file_exists(\'./.htaccess\') || file_exists(\'./web.config\') || file_exists(\'./httpd.ini\'))) ? $column_id.\'.\'.$web[\'area\'][$column_id][\'name\'][1] : \'column.php?clumn_id=\'.$column_id;
}

function get_pseudo_static_url_class($column_id, $class_id) {
  global $web;
  return ($web[\'p_static\'] == 1 && (file_exists(\'./.htaccess\') || file_exists(\'./web.config\') || file_exists(\'./httpd.ini\'))) ? $column_id.\'_\'.$class_id.\'.\'.$web[\'area\'][$column_id][$class_id][1] : \'class.php?column_id=\'.$column_id.\'&class_id=\'.$class_id;
}

?>';
@ require ('readonly/function/write_file.php');
write_file('writable/set/set_area.php', $text);




alert('多音字校正完毕！频道、栏目已设置好。', '?get=area');






?>