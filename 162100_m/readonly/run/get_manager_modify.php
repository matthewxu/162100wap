<?php
require ('authentication_manager.php');
?>
<?php

/* 在线修改文件 */
/* 162100源码 - 162100.com */

$title = '<a class="list_title_in">在线修改文件</a>';

//遍历
function dirtree($the_path) {
  $text_d = $text_f = array();
  $text = '';
  if ($fp = @opendir($the_path)) {
    while (false !== ($file = @readdir($fp))) {
      $cf = '';
      if ($file == '.' || $file == '..' || $file == 'images' || $file == 'cert') continue;
      if (is_dir($the_path.'/'.$file)) {
        if ($file == 'css')             $cf = '<span class="grayword">（风格文件库）</span>';
		elseif ($file == 'data')        $cf = '<span class="grayword">（数据文件库）</span>';
        elseif ($file == 'run')         $cf = '<span class="grayword">（执行文件库，关键）</span>';
        elseif ($file == 'inc')         $cf = '<span class="grayword">（引用文件库）</span>';
        elseif ($file == 'images')      $cf = '<span class="grayword">（图片目录，不能编辑）</span>';
		elseif ($file == 'function')    $cf = '<span class="grayword">（函数文件库，关键）</span>';
        elseif ($file == 'ad')          $cf = '<span class="grayword">（广告文件库）</span>';
        elseif ($file == 'set')         $cf = '<span class="grayword">（配置文件库，关键）</span>';
        elseif ($file == 'writable/__temp__')    $cf = '<span class="grayword">（临时目录，转移空间时可放弃其中数据）</span>';
        elseif ($file == 'writable/__web__')     $cf = '<span class="grayword">（后天生成的文件，如专题的素材存放目录）</span>';

        $text_d[] = '<a href="?get=modify&otherfile='.get_en_url(ltrim($the_path.'/'.$file, './')).'" class="greenword">目录：'.ltrim($the_path.'/'.$file, './').''.$cf.'</a><br>';
      }
      if (is_file($the_path.'/'.$file)) {
        if ($file == 'set.php')         $cf = '<span class="grayword">（系统参数文件）</span>';
		elseif ($file == 'set_sql.php') $cf = '<span class="grayword">（数据库参数文件）</span>';
        elseif ($file == 'index.html')   $cf = '<span class="grayword">（静态首页）</span>';
        elseif ($file == 'index.php')   $cf = '<span class="grayword">（动态首页）</span>';
        elseif ($file == 'login.php' || $file == 'login_current.php')   $cf = '<span class="grayword">（登陆页）</span>';
        elseif ($file == 'reg.php' || $file == 'reg_current.php')   $cf = '<span class="grayword">（注册页）</span>';
        elseif ($file == 'member.php' || $file == 'member_current.php')   $cf = '<span class="grayword">（用户控制台首页）</span>';
        elseif ($file == 'webmaster_central.php')   $cf = '<span class="grayword">（管理员控制台首页）</span>';
        $text_f[] = '<a href="?get=modify&otherfile='.get_en_url(ltrim($the_path.'/'.$file, './')).'">文件：'.ltrim($the_path.'/'.$file, './').''.$cf.'</a><br>';
      }
    }
    @closedir($fp);
  }

  if (is_array($text_d) && count($text_d) > 0) {
    @natcasesort($text_d);
    $text .= @implode('', $text_d);
  }
  if (is_array($text_f) && count($text_f) > 0) {
    @natcasesort($text_f);
    $text .= @implode('', $text_f);
  }
  
  return $text != '' ? $text : '该目录为空';
}
?>
<?php
$text = '';
$thefile = base64_decode($_GET['otherfile']);
switch ($thefile) {
  case 'writable/ad/ad_search.php' :
    $title .= ' &gt; 搜索下部广告位';
    break;
  case 'writable/ad/ad_bottom.php' :
    $title .= ' &gt; 页面底部广告位';
    break;
  default :
    $title .= ' &gt; '.$thefile.'';

}
?>

<h5><?php echo $title; ?></h5>

<?php
if (!empty($thefile) && is_file($thefile)) :
  if (file_exists($thefile)) {

    $file = @file_get_contents($thefile);
    if (function_exists('mb_detect_encoding')) {
      $cha = mb_detect_encoding($file, array("UTF-8","ASCII","EUC-CN","CP936","BIG-5","GB2312","GBK"));
    }
    if (!$cha) {
      if(preg_match("/charset[\s\r\n]*=[\s\r\n\'\"]*([\w\-]+)[^\>]*>/i", $file, $m_cha)){
	    $cha = $m_cha[1];
      }
    }
    if (isset($cha) && $cha != "") {
      if(strtolower($cha) != "utf-8"){
        $file = @iconv($cha, "utf-8", $file);
      }
    }

    $file = str_replace('&', '&amp;', $file);
    $file = str_replace('<', '&lt;', $file);
    $file = str_replace('>', '&gt;', $file);
?>
<style type="text/css">
#hanghao { width:42px; background-color:#6699CC; color:#FFFFFF; overflow:hidden; text-align:right; resize:none; }
#content { width:98%; overflow:auto; resize:none; }
</style>
<div class="note">提示：
  <ol>
    <li>在此在线修改文件请务必谨慎，这将关系到网站能否正常运行；或本地手动修改该文件，然后上传。</li>
    <li>请准确输入文件路径！！！或点击下面列表依次进行。</li>
  </ol>
</div>
<form action="?post=modify" method="post" id="Zmodifyform" onsubmit="addSubmitSafe()">
  &lt;<a href="?get=modify&otherfile=<?php echo get_en_url(dirname($thefile)); ?>">上级目录</a>&gt;<br>
  <span class="red">请用代码书写</span> <?php echo $thefile; ?> <b>代码：</b><?php echo preg_match('/\.js$/i', $thefile) ? '<span class="red">此文件为JS文件，请用javascript语言编写</span>' : ''; ?><br>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" id="ccode">
	<tr>
		<td width="42" valign="top"><textarea id="hanghao" rows="40" disabled></textarea></td>
		<td><div style="width:710px; display:inline-block !important; display:inline; zoom:1;"><textarea name="content" id="content" rows="40" wrap="off" onkeyup="keyUp();"><?php echo $file; ?></textarea></div><br>
<button type="button" style="width:150px;" onclick="toL();" title="延长">↓</button>
<button type="button" style="width:150px;" onclick="toW();" title="加宽" id="toWO">→</button><?php echo $pac; ?>


</td>
	</tr>
  </table>
  <br>
  程序检测该文件编码为：<input type="text" size="10" name="charset" value="<?php echo $cha; ?>" />
  <input type="hidden" name="thefile" value="<?php echo $thefile; ?>" />
  <div class="red_err">特别提示：提交前请确定<?php echo dirname($thefile); ?>目录具备写权限，因为重写此文件</div>
  <button type="submit" onclick="return confirm('提交吗？请确定无误后再执行');" class="send2">修改完，提交</button>

</form>
<script language="javascript">

function keyUp(){
	var obj=$("content");
	var str=obj.value;	
	str=str.replace(/\r/gi,"");
	str=str.split("\n");
	n=str.length;
	line(n);
}
function line(n){
    var num="";
	var lineobj=$("hanghao");
	for(var i=1;i<=n;i++){
		num+=i+"\n";
	}
	lineobj.value=num;
	num="";
}
function autoScroll(){
	$("hanghao").scrollTop=$("content").scrollTop;
	setTimeout("autoScroll()",20);
}

if(document.all){
  window.attachEvent('onload',keyUp);
  window.attachEvent('onload',autoScroll);
}else{
  window.addEventListener("load",keyUp,false);
  window.addEventListener("load",autoScroll,false);
}

function toL(){ 
  $('content').rows += 20;
  $('hanghao').rows += 20;
}

function toW(){
  var obj=$('content');
  var oldW=obj.offsetWidth;
  var nowW=obj.scrollWidth;

  newObj=obj;
  if(nowW>oldW){
    obj.parentNode.style.overflow='visible';
    obj.style.width=nowW+'px';
    while(newObj=newObj.offsetParent){
      newObj.parentNode.style.overflow='visible';
    }

    var cc=$('ccode');
    var l=cc.offsetLeft;
    var t=cc.offsetTop;
    while(cc=cc.offsetParent){
      t+=cc.offsetTop;
      l+=cc.offsetLeft;
    }
    document.body.scrollLeft=l;
    window.scrollTo(l,t);

    $('toWO').onclick=function(){toO();};
    $('toWO').title='恢复原宽';
    $('toWO').innerHTML='←';
    
    obj.onblur=function(){
      toO();
    }
  }
}
function toO(){
  var obj=$('content');
  obj.parentNode.style.overflow='hidden';
  obj.style.width='98%';
  $('toWO').onclick=function(){toW();};
  $('toWO').title='加宽';
  $('toWO').innerHTML='→';
}

</script>

<?php
  } else {
    echo '出错了！文件不存在！';
  }
else:

echo ($thefile && file_exists($thefile) && $thefile != '.') ? '&lt;<a href="?get=modify&otherfile='.get_en_url(dirname($thefile)).'">上级目录</a>&gt;<br>' : '';
echo dirtree($thefile ? $thefile : '.');
endif;

?>
