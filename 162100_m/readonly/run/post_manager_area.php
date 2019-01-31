<?php
require ('authentication_manager.php');
?>
<?php

//栏目分类设置
if (POWER != 5) {
  err('该命令必须以基本管理员身份登陆！请重登陆');
}
@ require ('writable/set/set_area.php');
@ require ('readonly/function/filter.php');
@ require ('readonly/function/pinyin.php');
$_POST['column_name'] = (array)$_POST['column_name'];

$text_correct = $text_chongfu = '';
//print_r($_POST['column_name']);die;
$area_new = $arr_chongfu_f = $arr_chongfu_c = $arr_py_column = $arr_py_class = array();
if (count($_POST['column_name']) > 0) {
  if (count($_POST['column_name']) > count(array_unique($_POST['column_name']))) {
    err('新频道名称不能有重名！');
  }
  if (count($_POST['column_name']) > count(array_filter(preg_replace('/^\s+|\s+$/', '', $_POST['column_name'])))) {
    err('新频道名称不能有空值！');
  }
  foreach ($_POST['column_name'] as $fid => $f) {
    $f = filter1($f);
    $column_py = pinyin($f, true); //频道取拼音第一个字母
    if (isset($arr_py_column[$column_py])) {
      //list($fid_, $f_) = @explode('>', $arr_py_column[$column_py]);
      $arr_chongfu_f[$column_py] = 1;
    }
    $arr_py_column[$column_py][] = '
<div style="color:blue;">频道：<input type="text" size="10" name="column_correct['.$fid.']" value="'.$column_py.'" /> '.$f.'</div>';

    $area_new[$fid]['name'] = array($f, $column_py); //新分类名称
    $area_new[$fid]['name'][2] = abs($_POST['column_show'][$fid]) >= 1 ? abs($_POST['column_show'][$fid]) : '';

    if (isset($duoyin_mark[$f])) {
      $text_correct .= '
<div>频道：<input type="text" size="10" name="column_correct['.$fid.']" value="'.$column_py.'" /> '.$f.'（首字母：'.$duoyin_mark[$f].'）</div>';
    }

	$_POST['class_name'][$fid] = (array)$_POST['class_name'][$fid];
    if (count($_POST['class_name'][$fid]) > 0) {
      if (count($_POST['class_name'][$fid]) > count(array_unique($_POST['class_name'][$fid]))) {
        err('新栏目['.$f.']的分类不能有重名！');
      }
      if (count($_POST['class_name'][$fid]) > count(array_filter(preg_replace('/^\s+|\s+$/', '', $_POST['class_name'][$fid])))) {
        err('新栏目['.$f.']的分类不能有空值！');
      }

      foreach ($_POST['class_name'][$fid] as $cid => $c) {
        $c = filter1($c);
        $class_py = pinyin($c);
        if (isset($arr_py_class[$class_py])) {
          //list($fid_, $cid_, $c_) = @explode('>', $arr_py_class[$class_py]);
          $arr_chongfu_c[$class_py] = 1;
        }
        $arr_py_class[$class_py][] = '
<div style="color:blue;">&nbsp;&nbsp;&nbsp;&nbsp;栏目：<input type="text" size="10" name="class_correct['.$fid.']['.$cid.']" value="'.$class_py.'" /> '.$c.'</div>';

        $area_new[$fid][$cid] = array($c, $class_py, (abs($_POST['class_show'][$fid][$cid]) >= 1 ? abs($_POST['class_show'][$fid][$cid]) : ''));
        if (!is_numeric($fid) && abs($_POST['class_p_show'][$fid][$cid]) == 1) {
          $area_new[$fid][$cid][3] = 1;
        }
        if (isset($duoyin_mark[$c])) {
          $text_correct .= '
<div>&nbsp;&nbsp;&nbsp;&nbsp;栏目：<input type="text" size="10" name="class_correct['.$fid.']['.$cid.']" value="'.$class_py.'" /> '.$c.'（'.$duoyin_mark[$c].'）</div>';
        }
      }
    } else {
      err('新栏目['.$f.']的版区不能没有分类！');
	}
  }
}

//$area_new['mingz'] = $web['area']['mingz'];
//$area_new['homepage'] = $web['area']['homepage'];

if (count($arr_chongfu_f) > 0) {
  foreach (array_keys($arr_chongfu_f) as $f_py) {
    $arr_py_column[$f_py] = array_filter(array_unique($arr_py_column[$f_py]));
    if (count($arr_py_column[$f_py]) > 1) {
      $text_chongfu .= @implode('', $arr_py_column[$f_py]);
    }
  }
}
if (count($arr_chongfu_c) > 0) {
  foreach (array_keys($arr_chongfu_c) as $c_py) {
    $arr_py_class[$c_py] = array_filter(array_unique($arr_py_class[$c_py]));
    if (count($arr_py_class[$c_py]) > 1) {
      $text_chongfu .= @implode('', $arr_py_class[$c_py]);
    }
  }
}



if ($text_correct != '' || $text_chongfu != '') {
  $text_correct = '<form action="?post=area_p" method="post" style="border:1px #FF6600 solid; padding:5px; color:#FF6600;">'.($text_correct != '' ? '<p><b>重要！发现频道名或栏目名有多音字，请进行校正，再提交</b></p>'.$text_correct : '').($text_chongfu != '' ? '<p><b style="color:blue;">重要！发现频道名或栏目名有拼音重名，请进行校正，再提交</b></p>'.$text_chongfu : '').'<button type="submit">提交</button> <button type="button" onclick="location.href=window.history.back();">放弃</button> </form>';
} else {
  if ($web['area'] == $area_new) {
    err("您对版区设置未做任何更改！");
  }
}

if (!$area_new) {
  $errr = '<br><span class="redword">注：你的设置已造成全部频道、栏目被清空</span>';
}

$text = '<?php
$web[\'area\'] = '.var_export($area_new, true).';

function get_pseudo_static_url_column($column_id) {
  global $web;
  return ($web[\'p_static\'] == 1 && (file_exists(\'./.htaccess\') || file_exists(\'./web.config\') || file_exists(\'./httpd.ini\'))) ? $column_id.\'.\'.$web[\'area\'][$column_id][\'name\'][1] : \'column.php?column_id=\'.$column_id;
}

function get_pseudo_static_url_class($column_id, $class_id) {
  global $web;
  return ($web[\'p_static\'] == 1 && (file_exists(\'./.htaccess\') || file_exists(\'./web.config\') || file_exists(\'./httpd.ini\'))) ? $column_id.\'_\'.$class_id.\'.\'.$web[\'area\'][$column_id][$class_id][1] : \'class.php?column_id=\'.$column_id.\'&class_id=\'.$class_id;
}

?>';

//print_r($area_new);die;
@ require ('readonly/function/write_file.php');
write_file('writable/set/set_area.php', $text);





err('频道、栏目设置成功！'.$errr.$text_correct.'', 'ok');

?>