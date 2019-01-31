<?php
require ('authentication_manager.php');
?>
<iframe id="lastFrame" name="lastFrame" frameborder="0" style="display:none;"></iframe>
<!--h5><a class="list_title_in">数据库管理</a></h5-->
<div class="note">提示：
    <ol>
      <li>请确定您的空间支持PHP+Mysql。</li>
      <li>标<span class="redword">*</span>项必填。</li>
      <li>正常情况下，虚拟主机提供商会为你分配Mysql份额，请确保上述所填与该Mysql份额各参数相同。</li>
      <li>如果分配给你的Mysql份额只有一个，那么你无法再创建第二个数据库（提交时不必点选“创建新/启动数据库”）。</li>
      <li>如果你已通过自己虚拟主机的Mysql管理后台（一般如PhpMyAdmin）对数据库进行了更改，请保持上述各项参数与之相匹配。</li>
    </ol>
</div>
<script>

function chkT(){
  if($('create').checked==true || $('tableset').checked==true){
    if (get_checkbox('beifen')==0){
	  alert('必须选择数据表备份源，以便导入数据！');
	  return false;
	}
  }
  return true;
}

</script>
<?php
$sql['sql_version'] = '未知';

$sub = $ok = $err = $chd = '';
if (!isset($sql['db_err'])) {
  db_conn();
}

if ($sql['db_err'] == '') {
  $sql['sql_version'] = @mysql_get_server_info();
  /*
  //查看分区：SELECT * FROM INFORMATION_SCHEMA.partitions WHERE TABLE_SCHEMA='web162100' AND TABLE_NAME='yzsou_reply';
  */
  $result = @mysql_query('SHOW VARIABLES LIKE "%partition%"', $db);
  $row = @mysql_fetch_assoc($result);
  $sql['sql_part'] = $row; //[Variable_name] => have_partitioning  [Value] => YES
  @mysql_free_result($result);
  unset($row);
  $eval_part = '';
  if (!($sql['sql_version'] >= '5.1' && $sql['sql_part']['Variable_name'] == 'have_partitioning' && $sql['sql_part']['Value'] == 'YES')) {
    $sql_err = '<img src="readonly/images/i.gif" /> <span class="redword">告知：你的MYSQL服务器分区功能被禁用</span>';
  } else {
    $sql_err = '<img src="readonly/images/ok.gif" /> 你的MYSQL服务器支持分区';
  }
  $sub .= '重新';
  $err .= '<img src="readonly/images/ok.gif" /> 数据库连接成功！';
  $ok = 'ok';
} else {
  $chd = ' checked="checked"';
  $err .= $sql['db_err'];
}
@mysql_close();

echo '<div class="output">'.$err.'</div>';
if (isset($sql['sql_version']) && $sql['sql_version'] < '5.0') {
  echo '<div class="siteannounce"><img src="readonly/images/i.gif" /> 服务器数据库版本（'.$sql['sql_version'].'）太低！数据可能显示不正常。本程序建设基于MySQL版本5.0以上</div>';
}

echo '
<form method="post" action="?post=sql" onsubmit="addSubmitSafe()">
  <table width="100%" border="0" cellspacing="1" cellpadding="0" id="ad_table">
    <tr>
      <th style="width:150px">参数</th>
      <th style="width:400px">值</th>
      <th>说明</th>
    </tr>
    <tr>
      <td style="width:150px;text-align:left">服务器类型</td>
      <td style="width:400px;text-align:left"><input name="dbtype" type="text" value="'.$sql['type'].'" style="width:220px" /> <span class="redword">*</span></td>
      <td style="text-align:left">一般是mysql</td>
    </tr>
    <tr>
      <td style="width:150px;text-align:left">服务器地址</td>
      <td style="width:400px;text-align:left"><input name="dbhost" type="text" value="'.$sql['host'].'" style="width:220px" /> <span class="redword">*</span></td>
      <td style="text-align:left">一般是localhost</td>
    </tr>
    <tr>
      <td style="width:150px;text-align:left">服务器端口</td>
      <td style="width:400px;text-align:left"><input name="dbport" type="text" value="'.$sql['port'].'" style="width:220px" /></td>
      <td style="text-align:left">一般是3306</td>
    </tr>
    <tr>
      <td style="width:150px;text-align:left">数据库名</td>
      <td style="width:400px;text-align:left"><input name="dbname" type="text" value="'.$sql['name'].'" style="width:220px" /> <span class="redword">*</span>
<br><script>
function chktable(o) {
  if (o.checked==true) {
    $(\'tableset\').checked=true;
    $(\'t_default\').style.display=\'block\';
  } else {
    $(\'tableset_\').checked=true;
    $(\'t_default\').style.display=\'none\';
  }
}
</script>
<input name="create" id="create" type="checkbox" class="checkbox" value="1" onclick="chktable(this)"'.$chd.' />创建新/启动数据库<br />
<input name="tableset" id="tableset" type="radio" class="radio" onclick="if(this.checked==true){/*$(\'create\').checked=true;*/$(\'t_default\').style.display=\'block\';}" value="1"'.$chd.' /> 一同建立数据表<br>';

//if ($chd == ' checked="checked"') {
  echo '<div id="t_default" style="'.($chd == ' checked="checked"'?'':'display:none;').'margin:5px 10px; color:green;"">选择数据表备份源，以便导入数据（必选）：';
  echo '<div style="padding:2px; border:1px #EEE solid; background-color:#FFFFCC;">';
  $base = @glob('writable/data/all_*', GLOB_ONLYDIR);
  $n = count($base);
  if ($n > 0) {
    $shenyu = $n == 1 ? 'return confirm(\'就剩这一个备份了，确定删除么？\');' : 'return confirm(\'确定删除该备份么？\');';
	foreach ($base as $k => $t) {
	  $tname = basename($t);
	  list($bf_type, $table_type) = @explode('_', $tname);
	  
	  echo '
	  <div name="beifen_'.$tname.'" id="beifen_start_'.$tname.'" style="border-bottom:1px #EEE solid;"><a href="?post=sql_table_del&act=del_beifen&beifen='.urlencode($t).'&m=1" onclick="'.$shenyu.'" style="float:right; margin:0 5px;" target="lastFrame">删除</a><input name="beifen" type="radio" class="radio" value="'.$t.'"'.($table_type=='default'?' checked="checked"':'').' /> '.$table_type.''.(preg_match('/^\d{14}$/', $table_type) ? '<span class="grayword">（'.preg_replace('/^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1/$2/$3 $4:$5:$6', $table_type).'备）</span>' : '').'</div>';
	}
  } else {
    echo '<b class="redword">没有数据备份源！无法导入数据！</b>';
  }
  echo '</div>';
  echo '</div>';
  unset($base, $n, $k, $t, $tname, $bf_type, $table_type, $shenyu);
  
  
  
//}

echo '
<input name="tableset" id="tableset_" type="radio" class="radio" onclick="if(this.checked==true){$(\'create\').checked=false;$(\'t_default\').style.display=\'none\';}" value="0"'.($ok == 'ok' ? ' checked' : '').' /> 不用建立数据表，我只更改数据库参数</td>
      <td style="text-align:left">字母数字（最好字母开头，别纯数字，有的服务器不支持数字开头）</td>
    </tr>
    <tr>
      <td style="width:150px;text-align:left">数据库用户名</td>
      <td style="width:400px;text-align:left"><input name="dbuser" type="text" value="'.$sql['user'].'" style="width:220px" /> <span class="redword">*</span></td>
      <td style="text-align:left">&nbsp;</td>
    </tr>
    <tr>
      <td style="width:150px;text-align:left">数据库用户密码</td>
      <td style="width:400px;text-align:left"><input name="dbpswd" type="password" value="'.$sql['pass'].'" style="width:220px" /> <input type="checkbox" name="cnp" value="1" /> 我的密码为空</td>
      <td style="text-align:left">如密码留空，点选确认</td>
    </tr>
    <tr>
      <td style="width:150px;text-align:left">数据库表名前缀</td>
      <td style="width:400px;text-align:left"><input name="dbpref" type="text" value="'.$sql['pref'].'" style="width:220px" /></td>
      <td style="text-align:left">后面必加下划线（必须字母开头）</td>
    </tr>
    <tr>
      <td style="width:150px;text-align:left">数据表编码</td>
      <td style="width:400px;text-align:left"><select name="dbchar">
          <option value="utf8" selected="selected">UTF-8</option>
        </select></td>
      <td style="text-align:left">&nbsp;</td>
    </tr>
  </table>
  <div class="red_err">特别提示：提交前请确定set目录具备写权限，因为要将配置结果写入writable/set/set_sql.php文件，否则虽提示成功，但实际仍配置失败</div>
  <table width="100%" border="0" cellspacing="1" cellpadding="0" id="ad_table">
    <tr>
      <td style="width:150px;text-align:left">&nbsp;</td>
      <td style="width:400px;text-align:left"><button type="submit" class="send2" onclick="return chkT();">'.$sub.'设置</button></td>
      <td style="text-align:left">&nbsp;</td>
    </tr>
  </table>
</form>
';

?>
<?php

$beifen_sy = array();

if ($ok == 'ok') {
  echo '<br><br>

<div class="note" id="mysql_tables">注：
<ol>
  <li>数据库（<span>版本：'.$sql['sql_version'].'</span>）。</li>
  <li>如果整体数据库太大，也可在上表中单独备份数据表。</li>
  <li>若你一旦备份了某数据表，再次恢复建立时将导入该数据表备份。</li>
</ol>
</div>';
  echo '
<table width="100%" border="0" cellspacing="1" cellpadding="0" id="ad_table">
  <tr>
    <th style="width:150px">数据表</th>
    <th style="width:400px">状态</th>
    <th>描述</th>
  </tr>
';
//if ($sub != '') {
  $rs = array();
  $step = 0;
  foreach ($sql['data'] as $key => $val) {
    $result = @mysql_query('SHOW TABLES LIKE "'.$sql['pref'].''.$val.'"', $db);
    //$result = @mysql_query('SELECT * FROM `'.$sql['pref'].''.$val.'` LIMIT 1', $db);
    if ($rs[$val] = @mysql_fetch_assoc($result)) {
      $step++;
    }
    @mysql_free_result($result);
    echo '
  <tr>
    <td style="width:150px;text-align:left">'.$sql['pref'].''.$val.'</td>
    <td style="width:400px;text-align:left">';
  if ($rs[$val]) {
    echo ''.($key=='承载成员档案的表名'?'<div class="red_err">如果主机上同时使用162100导航手机Wap版，此表共享，请谨慎操作！</div>':'').'已建 [
      <a href="?post=sql_table_del&table='.$val.'&act=del" onclick="return confirm(\'确定删除表'.$val.'么？\')">删除</a>
      <a href="?post=sql_table_del&table='.$val.'&act=empty" onclick="return confirm(\'确定清空表'.$val.'么？\')">清空</a>
      <a href="?post=sql_table_del&table='.$val.'&act=index" onclick="return confirm(\'确定更新表'.$val.'索引以优化性能么？\')">建立索引</a>
      <a href="?post=sql_table_del&table='.$val.'&act=index_del" onclick="return confirm(\'确定删除表'.$val.'索引么？\')">删除索引</a>
      <a href="?post=sql_table_del&table='.$val.'&act=reset_id" onclick="return confirm(\'确定重置表'.$val.'排序么？\')">重置主键排序</a>'.($key == '承载网址数据的表名' ? '      <a href="?post=sql_table_del&table='.$val.'&act=clear" onclick="return confirm(\'确定净化表'.$val.'，以便删除垃圾数据么？\')">净化</a>' : '').'
      <a href="?post=sql_backup&table='.$val.'" onclick="return confirm(\'确定备份表'.$val.'么？\')">备份</a> ]';
  } else {
    echo '未建';
  }
  
  $base = @glob('writable/data/{all,'.$val.'}_*', GLOB_BRACE);
  $n = count($base);
  if ($n > 0) {
  echo '<div style="margin:5px 10px; color:green;">该表有以下备份可供重建：';
  echo '<div style="padding:2px; border:1px #EEE solid; background-color:#FFFFCC;">';
    $beifen_sy[$key] = 1;
    $shenyu = $n == 1 ? 'return confirm(\'就剩这一个备份了，确定删除么？\');' : 'return confirm(\'确定删除该备份么？\');';
	foreach ($base as $k => $t) {
	  $tname = basename($t, '.sql');
	  list($bf_type, $table_type) = @explode('_', $tname);
	  
	  echo '
	  <div name="beifen_'.$tname.'" id="beifen_'.$tname.'" style="border-bottom:1px #EEE solid;"><a href="?post=sql_table_set&table='.$val.'&beifen='.urlencode($t).'" onclick="return confirm(\'确定导入么？该举动会清空现有数据\');" style="float:right; margin:0 5px;">导入</a><a href="?post=sql_table_del&act=del_beifen&beifen='.urlencode($t).'&m=1" onclick="'.$shenyu.'" style="float:right; margin:0 5px;" target="lastFrame">删除</a>'.$table_type.''.(preg_match('/^\d{14}$/', $table_type) ? '<span class="grayword">（'.preg_replace('/^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', '$1/$2/$3 $4:$5:$6', $table_type).'备）</span>' : '').'</div>';
	}
  echo '</div>';
  echo '</div>';
  } else {
    //echo '<b class="redword">该表没有备份源！请备份</b>';
  }
  unset($base, $n, $k, $t, $tname, $bf_type, $table_type, $shenyu);



  echo '</td>
    <td>'.$key.'</td>
  </tr>';
    unset($rs[$val]);

  }
  if ($step > 0) {
    echo '
  <tr>
    <td style="width:150px;text-align:left">&nbsp;</td>
    <td style="width:400px;text-align:left">'.(array_sum($beifen_sy) < count($sql['data']) ? '<div style="background-color:#FF6600;color:#FFFFFF;">没有整体备份！强烈建议备份一下</div>' : '').'<a href="?post=sql_backup" onclick="return confirm(\'确定备份数据库么？\');">整体数据库备份</a></td>
    <td>&nbsp;</td>
  </tr>';
  }
  echo '
</table>';
//}


}










?>
