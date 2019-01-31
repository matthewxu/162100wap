<?php
require ('authentication_manager.php');
?>
<?php
//栏目分类设置
if (POWER != 5) {
  err('该命令必须以基本管理员身份登陆！请重登陆');
}










if ($_GET['act'] == 'del') {
  if (!empty($_GET['imgurl']) && file_exists($_GET['imgurl'])) {
    @unlink($_GET['imgurl']);
  }
  err('<script>
try{
  parent.$("n_img'.$_GET['id'].'").innerHTML="";
  parent.$("linkimg'.$_GET['id'].'").value="";
  parent.$("linkimgold'.$_GET['id'].'").value="";
}catch(e){}
</script>');


}




if ($_POST['act'] == 'up') {
  $err1 = '<script> alert("';
  $err2 = '"); </script>';
}
@ require ('writable/set/set_area.php');

if (!(isset($_GET['column_id']) && array_key_exists($_GET['column_id'], $web['area']))) {
  err($err1.'频道参数缺失或错误'.$err2);
}
if (!(isset($_GET['class_id']) && array_key_exists($_GET['class_id'], $web['area'][$_GET['column_id']]))) {
  err($err1.'栏目参数缺失或错误'.$err2);
}



if ($_POST['act'] == 'up') {
  err('<script>
try{
  parent.$("mainform").act.value="";
}catch(e){}
parent.delSubmitSafe();
alert("该版本没有开放此功能！请联系官方购买。\n但你可以用链接形式插入图片，或直接写入图片代码"); </script>');
}









$text_del = 0;
$text_caiji = '';
$eval_caiji = $text_p = '';
$p_b = $p_e = NULL;

if (!empty($_POST['p_url'])) {
  if (!preg_match("/^https?:\/\//i", $_POST['p_url'])) {
    err('采集源URL填写不对！应以http://或https://开头');
  }
  if (empty($_POST['p_b']) && empty($_POST['p_e'])) {
    err('采集前后标记必填一项！');
  }
  $text_caiji = '采集也成功执行完毕。';
  $time_step = time() + floatval($web['time_pos']) * 3600;


  if (!isset($_POST['p_time']) || !is_numeric($_POST['p_time']) || $_POST['p_time'] == '') {
    $_POST["p_time"] = "";
    $time_stamp = $time_step + 100 * 365 * 24 * 60 * 60;
  } else {
    if ($_POST['p_time'] == 1) {
      if (!abs($_POST['p_time_val']) > 0) {
        err('采集时效若以分钟为间隔必须大于0啊！');
      } else {
        $_POST['p_time'] = abs($_POST['p_time_val']);
        $time_stamp = $time_step + $_POST['p_time'] * 60;
      }
    } else {
      $_POST['p_time_key'] = abs($_POST['p_time_key']);
      $_POST['p_time'] = $_POST['p_time_key'] > 0 ? '-'.$_POST['p_time_key'] : 0;
      $time_0 = $time_step - (gmdate('H', $time_step) * 3600 + gmdate('i', $time_step) * 60 + gmdate('s', $time_step));
      $time_stamp = $time_0 + $_POST['p_time_key'] * 3600 + ($_POST['p_time_key'] > abs(gmdate('H', $time_step)) ? 0 : 24 * 3600);
    }
  }

  $eval_caiji = '
  $php_errormsg = NULL;
  $_POST["p_url"] = filter($_POST["p_url"]);
  if ($str_caiji = read_file($_POST["p_url"])) {

    if (function_exists("mb_detect_encoding")) {
      $cha = mb_detect_encoding($str_caiji, array("UTF-8","ASCII","EUC-CN","CP936","BIG-5","GB2312","GBK"));
    }
    if (!$cha) {
      if(preg_match("/charset[\s\r\n]*=[\s\r\n\'\"]*([\w\-]+)[^\>]*>/i", $str_caiji, $m_cha)){
	    $cha = $m_cha[1];
      }
    }
    if (isset($cha) && $cha != "") {
      if(strtolower($cha) != "utf-8"){
        $str_caiji = @iconv($cha, "utf-8", $str_caiji);
      }
    }

    $_POST["p_b"] = preg_replace("/[\s\r\n]+/", " ", $_POST["p_b"]);
    $_POST["p_b"] = get_magic_quotes_gpc() ? stripslashes($_POST["p_b"]) : $_POST["p_b"];
    $p_b = addcslashes($_POST["p_b"], \'.\+*?[^]$(){}=!<>|:-"/\'); //preg_quote
    $p_b = preg_replace("/[\s\r\n]+/", "[\\\s\\\\r\\\\n]+", $p_b);
    $p_b = (isset($_POST["p_b_is"]) && $_POST["p_b_is"] == 1) ? $p_b."(" : "(".$p_b;
    $_POST["p_e"] = preg_replace("/[\s\r\n]+/", " ", $_POST["p_e"]);
    $_POST["p_e"] = get_magic_quotes_gpc() ? stripslashes($_POST["p_e"]) : $_POST["p_e"];
    $p_e = addcslashes($_POST["p_e"], \'.\+*?[^]$(){}=!<>|:-"/\'); //preg_quote
    $p_e = preg_replace("/[\s\r\n]+/", "[\\\s\\\\r\\\\n]+", $p_e);
    $p_e = (isset($_POST["p_e_is"]) && $_POST["p_e_is"] == 1) ? ")".$p_e : $p_e.")";

    preg_match("/".$p_b.".+".$p_e."/isU", $str_caiji, $m_caiji);
    if ($php_errormsg !== NULL) {
      $text_caiji = "<b>采集标记填写得不对！请填写准确的正则。错误代码：</b><i>[".$php_errormsg."]</i><br>";
      $php_errormsg = NULL;
    } else {
      if (!$m_caiji) {
        $text_caiji = "<b>采集源URL或采集标记填写得不对！请检查。没有采集数据被存储。</b><br>";
      } else {
        $_POST["priority"] = $m_caiji[1];
        $_POST["p_change_fr"] = array_filter($_POST["p_change_fr"]);
        $_POST["p_change_to"] = array_filter($_POST["p_change_to"]);
        if ($_POST["p_change_fr"] && $_POST["p_change_to"]) {
          $text_caiji = "";
          foreach((array)$_POST["p_change_fr"] as $p_key => $p_val) {
            $p_val = get_magic_quotes_gpc() ? stripslashes($p_val) : $p_val;
            $p_val = trim($p_val);
            $p_val = preg_replace("/[\s\r\n]+/", "[\\\s\\\\r\\\\n]+", $p_val);
            $p_val = preg_replace("/\{162100\~mark\d+\}/i", "", $p_val);
            $_POST["p_change_to"][$p_key] = get_magic_quotes_gpc() ? stripslashes($_POST["p_change_to"][$p_key]) : $_POST["p_change_to"][$p_key];
            $_POST["p_change_to"][$p_key] = trim($_POST["p_change_to"][$p_key]);
            $_POST["p_change_to"][$p_key] = preg_replace("/\{162100\~mark\d+\}/i", "", $_POST["p_change_to"][$p_key]);
            if ($p_val != "") {
              $priority_temp = preg_replace(\'\'.$p_val.\'\', \'\'.$_POST[\'p_change_to\'][$p_key].\'\', $_POST["priority"]);
              if ($php_errormsg !== NULL) {
                $text_caiji .= "<b>过滤正则[".($p_key+1)."]填写得不对！故没有对采集到的数据进行过滤。错误代码：</b><i>[".$php_errormsg."]</i><br>";
                $php_errormsg = NULL;
                continue;
              } else {
                $_POST["priority"] = $priority_temp;
                $p_change_arr[] = $p_val."{162100~mark1}".$_POST["p_change_to"][$p_key];
              }
              unset($priority_temp);
            }
          }
          $_POST["priority"] = preg_replace(\'/<([^>]+)>/e\', \'"<".run_URLdecode("$1").">"\', $_POST["priority"]);
          $text_caiji = $text_caiji == "" ? "采集也成功执行完毕。" : $text_caiji;
        }
        $text_p = "".$time_stamp."\n".$_POST["p_time"]."\n".$_POST["p_url"]."\n".$_POST["p_b"]."\n".$_POST["p_e"]."\n".((isset($_POST["p_b_is"]) && $_POST["p_b_is"] == 1) ? 1 : 0)."\n".((isset($_POST["p_e_is"]) && $_POST["p_e_is"] == 1) ? 1 : 0)."".(isset($p_change_arr) && is_array($p_change_arr) && count($p_change_arr) > 0 ? "\n".@implode("{162100~mark2}", $p_change_arr) : "")."";
      }
    }

  } else {
    $text_caiji = "<b>采集源URL填写得不对！没有采集到数据。</b><br>";
  }
';

  
} else {
  $text_caiji = '未填写采集源URL，未进行采集。';
}


function run_URLdecode($e) {
  $text = "";
  if ($m = preg_split('/%3F/i', $e, 2)) {
    $text .= preg_match("/%[0-9A-Z]+/", $m[0]) ? urldecode($m[0]) : $m[0];
    if (count($m) == 2) {
      $text .= (!empty($m[1]) && preg_match("/(%[0-9A-Z]{4}){2,}/", $m[1])) ? '?'.urldecode($m[1]) : '?'.$m[1];
    }
  }
  return $text;
}















if (!isset($sql['db_err'])) {
  db_conn();
}
if ($sql['db_err'] != '') {
  err($sql['db_err']);
}

//为旧版列增加长度
@mysql_query('ALTER TABLE `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` MODIFY COLUMN column_id VARCHAR(32)', $db);
@mysql_query('ALTER TABLE `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` MODIFY COLUMN http_name_style LONGTEXT', $db);

@ require ('readonly/function/filter.php');


$beiarr = $imarro = $imarrn = array();
$imgreg = '/<img [^>]*src\s*=\s*"?(writable/__web__\/images\/'.$_GET['column_id'].'_'.$_GET['class_id'].'\/[^\/\"\s]+)"?/i';
$result = @mysql_query('SELECT * FROM `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` WHERE column_id="'.$_GET['column_id'].'" AND class_id="'.$_GET['class_id'].'"', $db);// ORDER BY id
if (@mysql_num_rows($result) > 0) {
  while ($row = @mysql_fetch_assoc($result)) {
    preg_match_all($imgreg, $row['http_name_style'], $m1);
    preg_match_all($imgreg, $row['class_priority'], $m2);
    $imarro = @array_merge($imarro, $m1[1], $m2[1]);
    $beiarr[$row['id']] = $row['id'];
    unset($row, $m1, $m2);
  }
}
@mysql_free_result($result);

$_POST['class_title'] = (array)$_POST['class_title'];

if (count($_POST['class_title']) > 0) {
  if (count($_POST['class_title']) > count(array_unique($_POST['class_title']))) {
    err('栏目分类名称不能空也不能有重名！');
  }
  if (count($_POST['class_title']) > count(array_filter(preg_replace('/^\s+|\s+$/', '', $_POST['class_title'])))) {
    err('栏目分类名称不能有空值！');
  }

  foreach ($_POST['class_title'] as $class_title_old => $class_title_new) {
    if (/*$class_title_new == '栏目置顶' || */$class_title_new == '栏目头栏') {
      err('栏目分类名称不能为“栏目头栏”！与系统默认词冲突！');
    }
    $class_priority = stripslashes_($_POST['class_priority'][$class_title_old]); //分类头栏
    $h_n_s = get_http_name_style($class_title_old);
    $class_n = (!empty($_POST['class_n'][$class_title_old]) && is_numeric($_POST['class_n'][$class_title_old]) && $_POST['class_n'][$class_title_old] >= 2 && $_POST['class_n'][$class_title_old] <= 8) ? $_POST['class_n'][$class_title_old] : 4;
    $class_more = (!empty($_POST['class_more'][$class_title_old]) && is_numeric($_POST['class_more'][$class_title_old])) ? $_POST['class_more'][$class_title_old] : '';

    @mysql_query('INSERT INTO `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` (`column_id`,`class_id`,`class_title`,`http_name_style`,`class_priority`,`class_grab`) VALUES ("'.$_GET['column_id'].'","'.$_GET['class_id'].'","'.filter($class_title_new).'|'.$class_n.'|'.$class_more.'","'.$h_n_s.'","'.mysql_real_escape_string($class_priority).'","")', $db);
    preg_match_all($imgreg, $img_t, $m1);
    preg_match_all($imgreg, $class_priority, $m2);
    $imarrn = @array_merge($imarrn, $m1[1], $m2[1]);

    unset($class_title_old, $class_title_new, $class_priority, $h_n_s, $class_n, $class_more, $img_t, $m1, $m2);
  }

} else {
  $text_del ++;
  @mysql_query('DELETE FROM `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` WHERE column_id="'.$_GET['column_id'].'" AND class_id="'.$_GET['class_id'].'" AND NOT (class_title LIKE "栏目头栏%" AND http_name_style="" AND class_priority<>"")', $db); //删除除头栏之外的分类列表
}



@ require ('readonly/function/read_file.php');

@ ini_set('track_errors', 1); 


//$_POST['priority'] = filter2($_POST['priority']);
$_POST['priority'] = stripslashes_($_POST['priority']);

eval($eval_caiji);

if ((!empty($_POST['priority']) && trim($_POST['priority']) != '') || !empty($text_p)) {
  @mysql_query('INSERT INTO `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` (`column_id`,`class_id`,`class_title`,`http_name_style`,`class_priority`,`class_grab`) VALUES ("'.$_GET['column_id'].'","'.$_GET['class_id'].'","栏目头栏'.(!empty($_POST['priority_pos']) ? '|1' : '').'","","'.mysql_real_escape_string($_POST['priority']).'","'.mysql_real_escape_string($text_p).'")', $db);
  //echo mysql_errno().':'.mysql_error();
  $now_id = @mysql_insert_id();
  if (!is_numeric($now_id) || $now_id == 0) {
    $text_caiji = '<b>栏目头栏储存失败！错误代码：</b><i>['.mysql_errno().':'.mysql_error().']</i><br>';
  }
} else {
  $text_del ++;
  @mysql_query('DELETE FROM `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` WHERE column_id="'.$_GET['column_id'].'" AND class_id="'.$_GET['class_id'].'" AND class_title LIKE "栏目头栏%" AND (http_name_style="" AND class_priority<>"")', $db); // AND class_priority<>""
}
@ ini_set('track_errors', 0); 

if (count($beiarr) > 0) {
  foreach ($beiarr as $id) {
    if ($id && is_numeric($id) && $id > 0) {
      @mysql_query('DELETE FROM `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` WHERE id="'.$id.'"', $db);
    }
  }
}

/*
//重置MYSQL ID
@mysql_query('ALTER TABLE `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` DROP `id`', $db);
@mysql_query('ALTER TABLE `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` ADD `id` INT(10) NOT NULL FIRST', $db);
@mysql_query('ALTER TABLE `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` MODIFY COLUMN `id` INT(10) NOT NULL AUTO_INCREMENT,ADD PRIMARY KEY(id)', $db);
*/

@mysql_close();

if ($text_del == 2) {
  $out_text = '栏目数据删除成功！';
  deldir('writable/__web__/images/'.$_GET['column_id'].'_'.$_GET['class_id'].'');
} else {
  $out_text = '栏目设置成功！';
}

echo '<p><img src="readonly/images/ok.gif" /> '.$out_text.'</p>';
@ob_flush();
@flush();

if (!(isset($_POST['img_keep']) && $_POST['img_keep'] == 1)) {
  if (count($imarro) > 0) {
    foreach ($imarro as $im) {
      if (!in_array($im, $imarrn)) {
        @unlink($im);
      }
    }
  }
}

if (!$text_caiji || $text_caiji == '采集也成功执行完毕。' || $text_caiji == '未填写采集源URL，未进行采集。') {
  alert($text_caiji, '?get=http&column_id='.$_GET['column_id'].'&class_id='.$_GET['class_id'].'');
} else {
  err($text_caiji);
}


function filter($text) {
  $text = trim($text);
  $text = stripslashes($text);
  //$text = htmlspecialchars($text);
  $text = preg_replace('/[\r\n\'\"\s\<\>]+/', '', $text);
  $text = str_replace('|', '&#124;', $text);
  //$text = str_replace('/', '&#47;', $text);
  return $text;
}

function get_http_name_style($class_title_old) {
  global $img_t, $h_n_s_n;
  $text = $fr_v = $img_t = '';
/*
  if ($_GET['column_id'] == 'homepage' && $_GET['class_id'] == 4) {
    $fr_v = base64_decode("aHR0cDovL3d3dy4xNjIxMDAuY29tL3wxNjIxMDDnvZHlnYDlr7zoiKp8cmVkd29yZHw=")."\n".base64_decode("aHR0cDovL3d3dy5mdXJ1aWppbnpoYW8uY29tL3zmsojpmLPkv53mtIHlhazlj7h8fA==")."\n".base64_decode("aHR0cDovL3d3dy4yZGguY24vfDLlr7zoiKp8fA==")."\n".base64_decode("aHR0cDovL3d3dy5yZTIuY24vfOeDreeIsee9kXx8")."\n";
  }
*/
  $h_n_s_n = count((array)$_POST['linkname'][$class_title_old]);
  if ($h_n_s_n > 0) {
    foreach ((array)$_POST['linkname'][$class_title_old] as $key => $v) {
      //$val = strtolower($_POST["linkhttp"][$class_title_old][$key]);
      $val = $_POST["linkhttp"][$class_title_old][$key];
/*
      if ($fr_v != '' && (eval('return '.base64_decode('c3Ryc3RyKCR2YWwsICJmdXJ1aWppbnpoYW8uY29tIikgfHwgc3Ryc3RyKCR2YWwsICIxNjIxMDAuY29tIikgfHwgc3Ryc3RyKCR2YWwsICIyZGguY24iKSB8fCBzdHJzdHIoJHZhbCwgInJlMi5jbiIp').';'))) {
        continue;
      }
*/

      $v = $_POST['linkimg'][$class_title_old][$key].' '.trim($v);
      if (trim($v) != '') {
        $img_t .= $v;
        $text .= preg_replace("/^(https?:\/\/[^\/]+)\/?$/", "\\1/", filter($val))."|".mysql_real_escape_string(filter2($v))."|".filter(trim($_POST["color"][$class_title_old][$key]))."|".filter(trim($_POST["linktype"][$class_title_old][$key]))."\n";
      }
      unset($val, $key, $v, $h_n_s_n);
    }
  }

  //return $fr_v.$text;
  return $text;
}



//删除目录
function deldir($dir) {
  if (empty($dir) || !file_exists($dir)) return;
  if ($fp = @opendir($dir)) {
    while (false !== ($file = @readdir($fp))) {
      if ($file != '.' && $file != '..') {
        if (is_dir($dir.'/'.$file)) {
          deldir($dir.'/'.$file);
        } else {
          @unlink($dir.'/'.$file);
        }
      }
    }
    if (readdir($fp) == false) {
      @closedir($fp);
      if (@rmdir($dir)) {
        return true;
      }
    }
  }
}


function addslashes_($str) {
  if (!get_magic_quotes_gpc()) { //get_magic_quotes_runtime()
    $str = addslashes($str);
  }
  return $str;
}








?>