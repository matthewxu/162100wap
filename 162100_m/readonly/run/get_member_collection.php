<?php
require ('authentication_member.php');
?>
<?php
if (POWER > 0) :
?>
<div class="note">提示：保存设置后，首页名站下显示收藏<br>若想删除，清空提交即可</div>
<style type="text/css">
<!--
.n_nav td { background-color:#D8D8D8; font-size:12px; }
-->
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="n_nav">
  <tr>
    <td width="60" align="center">链接名</td>
    <td align="center">网址</td>
  </tr>
</table>
    <?php

  if (!isset($sql['db_err'])) {
    db_conn();
  }
  if ($sql['db_err'] == '') {

    $result = @mysql_query('SELECT collection FROM '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' WHERE username="'.$session[0].'" LIMIT 1', $db);
    $row = @mysql_fetch_assoc($result);
    @mysql_free_result($result);
    if (!(is_array($row) && count($row) > 0)) {
      $err = '<div class="output">查不到用户档案！原因：1、无此用户；2、程序出错。</div>';
    } else {
      preg_match_all('/<a [^>]*href="([^">]*)"( class="([^">]*)")?>(.*)<\/a>/isU', $row['collection'], $matches);
      unset($row);
      $hc = count($matches[1]);
      if ($hc > 0) {
        foreach ($matches[1] as $k => $v) {
          $text .= get_links($v, $matches[4][$k], $matches[3][$k], $k);
        }
      }
      if ($hc < 10) {
        for ($i = $hc; $i < 10; $i++) {
          $text .= get_links('http://', '', '', $i);
        }
      }
    }

  } else {
    $err .= $sql['db_err'];
  }

  @mysql_close();

  echo empty($err) ? '
<form id="mainform" action="?post=collection" method="post">
  '.$text.'
  <button type="submit">提交</button>
</form>' : $err;

?>
<?php
else :
?>

<div class="output">
您上次的登陆已失效！请重新<a href="login.php?location=<?php echo urlencode(basename($_SERVER['REQUEST_URI'])); ?>">登陆</a>获取数据<br><span class="grayword">没有帐号？<a href="reg.php?location=<?php echo basename($_SERVER['REQUEST_URI']); ?>">注册一个</a>，非常简单</span>
</div>

<?php
endif;
?>




<?php

function get_links($url, $website, $style, $k) {
  return '
<div>
<input type="hidden" name="link[]" id="link_'.$k.'" title="'.$k.'" />
<input type="text" id="linkname['.$k.']" name="linkname['.$k.']" value="'.$website.'" size="6" />
<input type="text" name="linkhttp['.$k.']" value="'.$url.'" size="24" />
</div>';
}


?>

