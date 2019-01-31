<?php
require ('authentication_manager.php');
?>
<?php

/* 管理成员 */
/* 162100源码 - 162100.com */


if ($_GET['order'] != 'username' && $_GET['order'] != 'regdate') {
  $_GET['order'] = 'id';
}
if ($_GET['username']) {
  $_GET['username'] = strtolower(trim($_GET['username']));
  if (preg_match('/^([^\x00-\x7f]|\w|\.){3,45}$/', $_GET['username'])) {
    $_GET['username'] = str_replace('.', '&#46;', $_GET['username']);
    $eval = ' (username LIKE "%'.$_GET['username'].'%") AND'; //走索引的话 (username LIKE "'.$_GET['username'].'%") AND
    $search_r = ' - 搜索结果';
  } elseif (preg_match('/^[\w\.\-]+@[\w\.\-]+\.[\w\.]+$/', $_GET['username'])) {
    $eval = ' (email LIKE "%'.$_GET['username'].'%") AND'; //走索引的话 (email LIKE "'.$_GET['username'].'%") AND
    $search_r = ' - 搜索结果';
  } else {
    $search_r = ' <span class="redword">您的输入词不合法！</span>';
  }
}

?>
<?php

function getPower($v) {
  global $web;
  if ($v == $web['manager']) {
    return '<span class="redword">管理员</span>';
  } else {
    return '';
  }
}

$n = 0;
if (!isset($sql['db_err'])) {
  db_conn();
}
if ($sql['db_err'] == '') {

  $result = @mysql_query('SELECT COUNT(id) AS total FROM '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' WHERE'.$eval.' check_reg="0"', $db);
  $row = @mysql_fetch_assoc($result);
  $n = abs($row['total']);
  @mysql_free_result($result);
  unset($row);
@ require ('readonly/function/get_page.php');
  if ($n > 0) :
    $text .= '
<table width="100%" border="0" cellpadding="0" cellspacing="1" id="ad_table">
    <tr>
      <th width="12">&nbsp;</th>
      <th>用户名<select name="order" id="order" onchange="location.href=\'?get=member&p='.$p.'&username='.urlencode($_GET['username']).'&pn='.$_GET['pn'].'&order=\'+this.value+\'\';">
    <option value="regdate">按注册时间查看</option>
    <option value="username"'.($_GET['order'] == 'username' ? ' selected="selected"' : '').'>按帐户名查看</option>
  </select></th>
      <th colspan="2">详细</th>
    </tr>
';
    $p = get_page($n); //页数
    $seek = $web['pagesize'] * ($p-1);
	  $result = @mysql_query('SELECT * FROM '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' WHERE'.$eval.' check_reg="0" ORDER BY '.$_GET['order'].' DESC LIMIT '.$seek.','.$web['pagesize'].'', $db);

    while ($row = @mysql_fetch_assoc($result)) {
      $text .= '
    <tr valign="top">
    <td width="12"><input name="id[]" id="id[]" type="checkbox" class="checkbox" value="'.$row['username'].'" /></td>
    <td>'.(!empty($row['face']) ? '<img src="userface.php?u='.urlencode($row['username']).'" align="left" />' : '').''.$row['username'].''.getPower($row['username']).'<br><br>（推广）ID：<b>'.$row['id'].'</b>，上线：'.($row['recommendedby'] != '' ? $row['recommendedby'].' <a href="?get=member&username='.urlencode($row['recommendedby']).'&pn='.$_GET['pn'].'&order='.$_GET['order'].'">&raquo;</a>' : '无').'</td>
    <td width="200">邮箱：'.$row['email'].'<br>
    注册日期：'.$row['regdate'].'<br>
    最后访问：'.$row['thisdate'].'
    </td>
    <td width="200">
    真实姓名：'.$row['realname'].'<br>
    银行帐号：'.$row['bank'].'<br>
    支付宝帐号：'.$row['alipay'].'
    </td>
    </tr>
    ';
    }
    $text .= '
    </table>';

    @mysql_free_result($result);

    $text .= get_page_foot($n, $web['pagesize'], $p, '?get=member&username='.urlencode($_GET['username']).'&order='.$_GET['order'].'&pn='.$_GET['pn'].'&p=');


  else :
    $err .= '没有记录！或已被删除。';
  endif;

} else {
  $err .= $sql['db_err'];
}

@mysql_close();

?>
<!--h5><a href="?get=member" class="list_title_in">注册成员（<?php echo $n; ?>）</a><?php echo $search_r; ?></h5-->
<form method="post" id="manageform" action="?post=member">
  <div class="note">
    <input name="username" id="usernamebox" type="text" value="<?php echo $_GET['username']; ?>" size="20" />
    <button type="button" onclick="location.href='?get=member&username='+encodeURIComponent($('usernamebox').value)+''">搜索会员|邮箱</button>
    <br>
    <a href="javascript:void(0)" onclick="allChoose('id[]',1,1);return false;">全选</a> - <a href="javascript:void(0)" onclick="allChoose('id[]',1,0);return false;">反选</a> - <a href="javascript:void(0)" onclick="allChoose('id[]',0,0);return false;">不选</a>
    <button name="act" type="button" onclick="chk(this.form,this,'del')">删除</button>
    <button name="act" type="button" onclick="chk(this.form,this,'punished')">置入黑名单</button>
    <button name="act" type="button" onclick="chk(this.form,this,'abnormal')" disabled="disabled">冻结</button>
    <button name="act" type="button" onclick="chk(this.form,this,'warn')">警告</button>
  </div>
  <?php echo $text, $err; ?>
  <input type="hidden" name="limit" />
</form>
