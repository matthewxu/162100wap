<?php
require ('authentication_manager.php');
?>
<div class="note">提示：如果你使用的版本小于官方版本，请到<a href="http://download.162100.com/" target="_blank">程序官方</a>下载升级包进行升级。</div>
<?php

$f = @file_get_contents('v.txt');
$v = '1.0';
if ($f && preg_match('/\$v\s*\=\s*\'(.*)\';/iU', $f, $matches)) {
  $v = base64_decode($matches[1]);
  if (preg_match('/\/\//', $f, $matches)) {
    $v .= 's';
    $vv = '提示：以下为商业授权版本配套的增值功能，您已购买，以表对作者辛苦的支持。谢谢！';
  } else {
    $zz = '但可购买增值（商业版）功能。';
    $vv = '提示：以下为免费开源版本配套的增值功能，如需要，请<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=184830962&amp;site=qq&amp;menu=yes" target="_blank">联系官方</a>购买，以表对作者辛苦的支持。谢谢！';
  }
}

?><div><b>当前版本：</b><?php echo $v; ?></div>
    <div><b>官方版本：</b><?php

  @ require ('readonly/function/read_file.php');

$f_162100 = read_file('http://www.162100.com/m/v.txt');
$v_162100 = '未知';
if ($f_162100 && preg_match('/\$v\s*\=\s*\'(.*)\';/iU', $f_162100, $matches_162100)) {
  $v_162100 = base64_decode($matches_162100[1]).'s';
}
 echo $v_162100; ?></div>
    <div><b>升级动作：</b><?php

if ($v_162100 == '未知') {
  echo '官方版本获取失败！<a href="javascript:void(0)" onclick="window.location.reload();">重新获取</a>或点此<a href="http://download.162100.com" target="_blank">到官方查看</a>。';
} else {
  if ((float)$v_162100 > (float)$v) {
    echo '<span class="redword">请立即升级！</span>点此<a href="http://download.162100.com/" target="_blank">下载官方升级包（或程序包）</a>，然后进行升级。';
  } else {
    echo '不必升级。';
  }
}

?></div>
<br>
<div class="note"><?php echo $vv; ?></div>
<div><b>批量导入网址功能：</b></div>
<blockquote>管理分类网址过程中，可批量导入网址。导入支持二种方式：1、直接输入网址URL采集，抓取网页中的链接，导入；2、直接粘贴代码筛选链接，导入。</blockquote>
<div><b>网址名称插入图片功能：</b></div>
<blockquote>网址名称前插入图片或以图片形式显示。支持链接调用、本地上传、直接写代码三种方式。</blockquote>
<div><b>网页缓存加速：</b></div>
<blockquote>
  将网页缓存在客户端，即使脱机（断网）仍可正常浏览你的首页；同时网页素件缓存于客户端，使网页载入速度大大加速。
</blockquote>
<div><b>网页压缩加速：</b></div>
<blockquote>
开启Gzip网页压缩技术，将较大的网页尺寸合理压缩，使网页载入速度大大加速。
</blockquote>
<div><b>去除版权文字：</b></div>
<blockquote>
可取消页头标题及页脚处标注的版权信息文字。
</blockquote>
<div><b>其它：</b></div>
<blockquote>
其它更多细节及时售后。
</blockquote>

