<?php
require ('authentication_manager.php');
?>
<?php


/* 删除数据表、建立删除索引 */
/* 162100源码 - 162100.com */

if (POWER != 5) {
  err('该命令必须以基本管理员身份登陆！请重登陆');
}
@ require ('readonly/function/deldir.php');

if (!isset($sql['db_err'])) {
  db_conn();
}
if ($sql['db_err'] != '') {
  err($sql['db_err']);
}

if ($_GET['act'] == 'del_beifen') {
  if (empty($_GET['beifen']) || !file_exists($_GET['beifen'])) {
    err('<script> alert("备份源参数出错！"); </script>');
  }
  deldir($_GET['beifen']);
  if ($_GET['m'] == 1) {
    $tname = basename($_GET['beifen'], '.sql');
    err('<script>
  var allCheckBox = parent.document.getElementsByName("beifen_'.$tname.'");
  if (allCheckBox != null && allCheckBox.length > 0) {
    for (var i = 0; i < allCheckBox.length; i++) {
      if (allCheckBox[i] != null) {
        allCheckBox[i].innerHTML = "";
        allCheckBox[i].style.display = "none";
      }
    }
  }
  </script>');
  } else {
    alert('备份已删除！', 'webmaster_central.php?get=sql');
  }
} else {
  $_GET['table'] = trim(trim($_GET['table']), '`');
  if (empty($_GET['table']) || !in_array($_GET['table'], $sql['data'])) {
    err('数据表名传递出错。');
  }
  if ($_GET['act'] == 'reset_id') {
    if ($_GET['table'] == 'member') {
      err('该表无法重置主键排序！否则注册成员身份ID乱了。');
    }
    $step = 0;
    @mysql_query('ALTER TABLE `'.$sql['pref'].''.$_GET['table'].'` ADD `id_temp` INT(10) NOT NULL AFTER `id`', $db);
    $result = @mysql_query('SELECT id FROM `'.$sql['pref'].''.$_GET['table'].'` ORDER BY id ASC', $db);
    if (@mysql_num_rows($result) > 0) {
      while ($row = @mysql_fetch_assoc($result)) {
        $step++;
        @mysql_query('UPDATE `'.$sql['pref'].''.$_GET['table'].'` SET id_temp="'.$step.'" WHERE id="'.$row['id'].'"', $db);
        unset($row);
      }
    }
    @mysql_free_result($result);

    mysql_query('ALTER TABLE `'.$sql['pref'].''.$_GET['table'].'` DROP `id`', $db);
    mysql_query('ALTER TABLE `'.$sql['pref'].''.$_GET['table'].'` CHANGE COLUMN `id_temp` `id` INT(10) NOT NULL', $db);
    mysql_query('ALTER TABLE `'.$sql['pref'].''.$_GET['table'].'` MODIFY COLUMN `id` INT(10) NOT NULL AUTO_INCREMENT,ADD PRIMARY KEY(id)', $db);

    $out .= '数据库表格['.$_GET['table'].']重置主键排序完毕！';

  } elseif ($_GET['act'] == 'empty') {
    if ($_GET['table'] == 'member') {
      $result = @mysql_query('SELECT *, HEX(face) AS f FROM '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' WHERE username="'.$web['manager'].'" LIMIT 1', $db);
      $row = @mysql_fetch_assoc($result);
      @mysql_free_result($result);
    }
    $rs = @mysql_query('TRUNCATE TABLE '.$sql['pref'].''.$_GET['table'].'');
    if ($_GET['table'] == 'member') {
      if (isset($row) && is_array($row) && count($row) > 0) {
        @mysql_query('INSERT INTO `'.$sql['pref'].''.$sql['data']['承载成员档案的表名'].'` (`username`,`password`,`email`,`thisdate`,`regdate`,`realname`,`alipay`,`bank`,`collection`,`notepad`,`memory_website`,`recommendedby`,`face`,`check_reg`,`session_key`,`login_key_qq`,`login_key_weibo`,`login_key_baidu`,`login_key_162100`,`stop_login`) values ("'.$row['username'].'","'.$row['password'].'","'.$row['email'].'","'.$row['thisdate'].'","'.$row['regdate'].'","'.$row['realname'].'","'.$row['alipay'].'","'.$row['bank'].'","'.mysql_real_escape_string($row['collection']).'","'.mysql_real_escape_string($row['notepad']).'","'.mysql_real_escape_string($row['memory_website']).'","'.mysql_real_escape_string($row['recommendedby']).'",UNHEX("'.$row['f'].'"),"'.$row['check_reg'].'","'.$row['session_key'].'","'.$row['login_key_qq'].'","'.$row['login_key_weibo'].'","'.$row['login_key_baidu'].'","'.$row['login_key_162100'].'","'.$row['stop_login'].'")', $db);
        unset($row);
      } else {
        @ require ('writable/set/set_mail.php');
        @mysql_query('INSERT INTO `'.$sql['pref'].''.$sql['data']['承载成员档案的表名'].'` (`username`,`password`,`email`,`collection`,`notepad`,`memory_website`,`face`) values ("'.$web['manager'].'","'.$web['password'].'","'.$web['sender'].'","","","","")', $db);
        //echo mysql_errno().':'.mysql_error();
      }
    }
    $out .= '数据库表格['.$_GET['table'].']清空'.($rs ? '成功' : '失败').'！';

  } elseif ($_GET['act'] == 'clear') {
    if ($_GET['table'] == $sql['data']['承载网址数据的表名']) {
      @ require ('writable/set/set_area.php');
      $result = @mysql_query('SELECT * FROM '.$sql['pref'].''.$_GET['table'].' ORDER BY id', $db);
      $s = 0;
      while ($row = @mysql_fetch_assoc($result)) {
        if ($row['column_id'] == '' || $row['class_id'] == '' || !isset($web['area'][$row['column_id']][$row['class_id']]) || empty($row['class_title']) || (empty($row['http_name_style']) && empty($row['class_priority']))) {
          @mysql_query('DELETE FROM '.$sql['pref'].''.$sql['data']['承载网址数据的表名'].' WHERE id="'.$row['id'].'"', $db);
          if (@mysql_affected_rows() > 0) {
            $s++;
          }
        }
        unset($row);
      }
      @mysql_free_result($result);
    } else {
      err('此表不能净化！');
    }
    $out .= '数据库表格['.$_GET['table'].']净化完毕。总计删除'.$s.'无用记录。';

  } elseif ($_GET['act'] == 'index') {
    if ($_GET['table'] == $sql['data']['承载网址数据的表名']) {
      $eval_index .='@mysql_query(\'ALTER TABLE '.$sql['pref'].''.$_GET['table'].' ADD INDEX `column_id_class_id` (column_id,class_id)\')';
    } elseif ($_GET['table'] == $sql['data']['承载成员档案的表名']) {
      $eval_index .='@mysql_query(\'ALTER TABLE '.$sql['pref'].''.$_GET['table'].' ADD UNIQUE `username_check_reg` (username,check_reg)\') && @mysql_query(\'ALTER TABLE '.$sql['pref'].''.$_GET['table'].' ADD UNIQUE `email_check_reg` (email,check_reg)\')';
    }
    $out .= '数据库表格['.$_GET['table'].']建立索引'.(eval('return '.$eval_index.';') ? '成功' : '失败（索引已存在）').'！';

  } elseif ($_GET['act'] == 'index_del') {
    if ($_GET['table'] == $sql['data']['承载网址数据的表名']) {
      $eval_index .='@mysql_query(\'ALTER TABLE '.$sql['pref'].''.$_GET['table'].' DROP INDEX `column_id_class_id`\')';
    } elseif ($_GET['table'] == $sql['pref'].''.$sql['data']['承载成员档案的表名']) {
      $eval_index .='@mysql_query(\'ALTER TABLE '.$sql['pref'].''.$_GET['table'].' DROP INDEX `username_check_reg`\') && @mysql_query(\'ALTER TABLE '.$sql['pref'].''.$_GET['table'].' DROP INDEX `email_check_reg`\')';
    }
    $out .= '数据库表格['.$_GET['table'].']删除索引'.(eval('return '.$eval_index.';') ? '成功' : '失败（索引不存在）').'！';

  } elseif ($_GET['act'] == 'del') {
    $out .= '数据库表格['.$_GET['table'].']删除'.(@mysql_query('DROP TABLE IF EXISTS '.$sql['pref'].''.$_GET['table'].'') ? '成功' : '失败').'！';
  } else {
    err('参数错误！');
  }
}
@mysql_close();

alert($out, '?get=sql');


?>



