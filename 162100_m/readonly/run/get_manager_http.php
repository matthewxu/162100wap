<?php
require ('authentication_manager.php');
?>
<style type="text/css">
<!--
#area { font-size:12px; }
.area_ { margin-bottom:10px; padding:5px; border:1px #CCCCCC solid; background-color:#FEFBEC; }
#ad_table  a.class_name { margin-left:12px; margin-right:12px; line-height:200%; display:inline-block !important; display:inline; zoom:1; }
.httpo { width:310px; display:inline-block !important; display:inline; zoom:1; vertical-align:middle; overflow:hidden; }

#pldr, #toulan { width:100%; display:none;
 position:fixed !important; position:absolute; top:0; left:0; z-index:97; text-align:center; overflow:hidden;
}
#pldr_in, #toulan_in { width:880px; background-color:#EFEFEF; padding:10px; text-align:left; }
.n_nav td { line-height:normal; background-color:#D8D8D8; font-size:12px; }
.n_img { width:60px; display:inline-block !important; display:inline; zoom:1; vertical-align:middle; overflow:hidden; cursor:pointer; }
#p_pldr_tb { border:1px #666666 solid; }
#p_pldr_tb td { font-size:12px; padding:3px; }
-->
</style>
<style type="text/css">
.file_o { width:24px; height:16px; position:absolute; z-index:4; overflow:hidden; background-color:#FFFFFF; filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0); -moz-opacity:0; -khtml-opacity:0; opacity:0; cursor:pointer; }
.file_b { }
</style>
<script language="javascript" type="text/javascript">
<!--
//添加链接
function addLink(class_title,linkname,linkhttp){
  var tar=document.getElementsByName('link['+class_title+']');
  var end=tar.length;
  num=(end>0) ? parseInt(tar[end-1].title)+1 : 0;

  var par=$('links_'+class_title+'');
  var newDiv=document.createElement('DIV');
  //newDiv.id='link['+class_title+']';
  newDiv.title=num;
  newDiv.style.marginBottom='5px';
  newDiv.innerHTML='\
<input type="hidden" name="link['+class_title+']" title="'+num+'" />\
<span class="n_img"><span id="n_img['+class_title+']['+num+']"></span><a href="javascript:void(0)" onclick="inNimg(\'['+class_title+']['+num+']\')" title="插入链接形式图片">链</a> <a href="javascript:void(0)" class="file_b" onmouseover="addFile(this,\''+class_title+'\',\''+num+'\');">上传</a></span>\
<input type="hidden" name="linkimg['+class_title+']['+num+']" id="linkimg['+class_title+']['+num+']" />\
<input type="hidden" name="linkimgold['+class_title+']['+num+']" id="linkimgold['+class_title+']['+num+']" />\
<input type="text" id="linkname['+class_title+']['+num+']" name="linkname['+class_title+']['+num+']" style="width:100px;" value="'+linkname+'" /> \
<span style="background-color:#FF6600; border-bottom:1px #FFFFFF solid;"><input name="color['+class_title+']['+num+']" type="radio" class="radio" value="redword" title="套红" onclick="addClass(this, \'linkname['+class_title+']['+num+']\', \'redword\');" /></span>\
<span style="background-color:#009900; border-bottom:1px #FFFFFF solid;"><input name="color['+class_title+']['+num+']" type="radio" class="radio" value="greenword" title="套绿" onclick="addClass(this, \'linkname['+class_title+']['+num+']\', \'greenword\');" /></span>\
<span style="background-color:#CCCCCC; border-bottom:1px #333333 solid;"><input name="color['+class_title+']['+num+']" type="radio" class="radio" value="underline" title="下划线" onclick="addClass(this, \'linkname['+class_title+']['+num+']\', \'underline\');" /></span>\
<span style="background-color:#CCCCCC; border-bottom:1px #FFFFFF solid;"><input name="color['+class_title+']['+num+']" type="radio" class="radio" value="" title="恢复默认" onclick="addClass(this, \'linkname['+class_title+']['+num+']\', \'\');" checked /></span> \
<span class="httpo"><input type="text" name="linkhttp['+class_title+']['+num+']" size="45" value="'+linkhttp+'" onFocus="checkLength(this);" /></span> \
<span name="linktype['+class_title+']"><input name="linktype['+class_title+']['+num+']" type="checkbox" class="checkbox" value="js" /></span><?php echo $web['link_type'] != 1 ? '中转' : '直接'; ?>链接 \
<button type="button" style="width:20px;padding:0;overflow:hidden;" title="删除" onclick="removeOption(this)">╳</button> \
<button type="button" style="width:20px;padding:0;overflow:hidden;" title="插入" onclick="insertLink(this,\''+class_title+'\')">↖</button> \
<button type="button" style="width:20px;padding:0;overflow:hidden;" title="上移" onclick="upLink(this,\''+class_title+'\')">↑</button> \
<button type="button" style="width:20px;padding:0;overflow:hidden;" title="上移" onclick="downLink(this,\''+class_title+'\')">↓</button>';
  par.insertBefore(newDiv,null);
  num=num+1;
}

//插入
function insertLink(obj,class_title){
  var tar=obj.parentNode;
  var par=$('links_'+class_title+'');
  var newDiv=document.createElement('DIV');
  num=(new Date()).valueOf();
  newDiv.id='link['+class_title+']';
  newDiv.title=num;
  newDiv.style.marginBottom='5px';
  newDiv.innerHTML='\
<input type="hidden" name="link['+class_title+']" title="'+num+'" />\
<span class="n_img"><span id="n_img['+class_title+']['+num+']"></span><a href="javascript:void(0)" onclick="inNimg(\'['+class_title+']['+num+']\')" title="插入链接形式图片">链</a> <a href="javascript:void(0)" class="file_b" onmouseover="addFile(this,\''+class_title+'\',\''+num+'\');">上传</a></span>\
<input type="hidden" name="linkimg['+class_title+']['+num+']" id="linkimg['+class_title+']['+num+']" />\
<input type="hidden" name="linkimgold['+class_title+']['+num+']" id="linkimgold['+class_title+']['+num+']" />\
<input type="text" id="linkname['+class_title+']['+num+']" name="linkname['+class_title+']['+num+']" style="width:100px;" /> \
<span style="background-color:#FF6600; border-bottom:1px #FFFFFF solid;"><input name="color['+class_title+']['+num+']" type="radio" class="radio" value="redword" title="套红" onclick="addClass(this, \'linkname['+class_title+']['+num+']\', \'redword\');" /></span>\
<span style="background-color:#009900; border-bottom:1px #FFFFFF solid;"><input name="color['+class_title+']['+num+']" type="radio" class="radio" value="greenword" title="套绿" onclick="addClass(this, \'linkname['+class_title+']['+num+']\', \'greenword\');" /></span>\
<span style="background-color:#CCCCCC; border-bottom:1px #333333 solid;"><input name="color['+class_title+']['+num+']" type="radio" class="radio" value="underline" title="下划线" onclick="addClass(this, \'linkname['+class_title+']['+num+']\', \'underline\');" /></span>\
<span style="background-color:#CCCCCC; border-bottom:1px #FFFFFF solid;"><input name="color['+class_title+']['+num+']" type="radio" class="radio" value="" title="恢复默认" onclick="addClass(this, \'linkname['+class_title+']['+num+']\', \'\');" checked /></span> \
<span class="httpo"><input type="text" name="linkhttp['+class_title+']['+num+']" size="45" onFocus="checkLength(this);" /></span> \
<span name="linktype['+class_title+']"><input name="linktype['+class_title+']['+num+']" type="checkbox" class="checkbox" value="js" /></span><?php echo $web['link_type'] != 1 ? '中转' : '直接'; ?>链接 \
<button type="button" style="width:20px;padding:0;overflow:hidden;" title="删除" onclick="removeOption(this)">╳</button> \
<button type="button" style="width:20px;padding:0;overflow:hidden;" title="插入" onclick="insertLink(this,\''+class_title+'\')">↖</button> \
<button type="button" style="width:20px;padding:0;overflow:hidden;" title="上移" onclick="upLink(this,\''+class_title+'\')">↑</button> \
<button type="button" style="width:20px;padding:0;overflow:hidden;" title="上移" onclick="downLink(this,\''+class_title+'\')">↓</button>';
  par.insertBefore(newDiv,tar);
}

//排序：链接 向上
function upLink(obj,class_title){
  var tar=obj.parentNode;
  var par=$('links_'+class_title+'');
  var prevObj=tar.previousSibling;
  while(prevObj!=null && prevObj.nodeType!=1){
    prevObj=prevObj.previousSibling;
  }
  if(prevObj==null){
    alert('已是最上级！');
    return;
  }else{
    try{par.insertBefore(tar,prevObj);}catch(err){alert('向上移动失败！请稍候再试');return;}
    //par.removeChild(tar);
  }
}

//排序：链接 向下
function downLink(obj,class_title){
  var tar=obj.parentNode;
  var par=$('links_'+class_title+'');
  var nextObj=tar.nextSibling;
  while(nextObj!=null && nextObj.nodeType!=1){
    nextObj=nextObj.nextSibling;
  }
  if(nextObj==null){
    alert('已是最下级！');
    return;
  }
  var endObj;
  if(nextObj!=null){
    var nextnextObj=nextObj.nextSibling;
    while(nextnextObj!=null && nextnextObj.nodeType!=1){
      nextnextObj=nextnextObj.nextSibling;
    }
    var endObj=nextnextObj!=null?nextnextObj:null;
  }else{
    endObj=null;
  }
  try{par.insertBefore(tar,endObj);}catch(err){alert('向下移动失败！请稍候再试');return;}
  //par.removeChild(tar);
}


//添加栏目分类
function addColumn(){
  var tar=document.getElementsByName('class[]');
  var par=$('area');
  var end=tar.length;
  num=(end>0) ? parseInt(tar[end-1].title)+1 : 0;
  var newDiv=document.createElement('DIV');
  newDiv.id='class[]';
  newDiv.title=num;
  newDiv.className='area_';
  newDiv.innerHTML='<input type="hidden" name="class[]" title="'+num+'" /> \
	<div style="margin-bottom:5px;"><b>栏目分类</b><input type="text" name="class_title['+num+']" value="" size="8" /></div> \
    <div style="margin-bottom:5px;margin-left:20px;">分类头栏(代码)<textarea id="class_priority['+num+']" name="class_priority['+num+']" rows="4" cols="70"></textarea> [<a href="javascript:void(0)" onclick="prevFLTL(\'class_priority['+num+']\');return false;">预览</a>]</div> \
    栏目页面以<input type="text" name="class_n['+num+']" value="4" size="1" onblur="if(isNaN(this.value)||this.value<2||this.value>8){alert(\'请填2-8的整数，默认是4\');this.value=\'4\';}" title="填2-8的整数" />列显示链接（留空则自然排列）；链接量大时，显示<input type="text" name="class_more['+num+']" value="" size="1" />条链接，以更多链接到新页面显示全部（留空直接显示全部） <table width="100%" border="0" cellspacing="1" cellpadding="0" class="n_nav">\
  <tr>\
    <td width="130" align="center" colspan="3">链接名</td>\
    <td width="300" align="center" rowspan="2">网址</td>\
    <td width="100" align="center" rowspan="2"><a href="javascript:void(0)" onclick="allChoose2(\'linktype['+num+']\',1,1);return false;">全选</a>-<a href="javascript:void(0)" onclick="allChoose2(\'linktype['+num+']\',1,0);return false;">反选</a>-<a href="javascript:void(0)" onclick="allChoose2(\'linktype['+num+']\',0,0);return false;">不选</a></td>\
    <td width="100" align="center" rowspan="2">操作</td>\
  </tr>\
  <tr>\
    <td width="60" align="center">图片</td>\
    <td width="100" align="center">名称-纯图片可空</td>\
    <td width="60" align="center">套色</td>\
  </tr>\
</table><div id="links_'+num+'"></div> \
    <button type="button" onClick="addLink(\''+num+'\',\'\',\'\');">添加网址</button> \
    <button type="button" onClick="addBatchLink(\''+num+'\');">批量导入网址</button> \
    <button type="button" onclick="removeOption(this);">删除此栏目分类</button> \
    <button type="button" onclick="insertColumn(this);">↖插入栏目分类</button> \
    <button type="button" onclick="upColumn(this);">↑上移栏目分类</button> \
    <button type="button" onclick="downColumn(this);">↓下移栏目分类</button> ';
  par.insertBefore(newDiv,null);

  num=num+1;
}

//插入栏目分类
function insertColumn(obj){
  var tar=obj.parentNode;
  var par=$('area');
  //var par=tar.parentNode;
  num=(new Date()).valueOf();
  var newDiv=document.createElement('DIV');
  newDiv.id='class[]';
  newDiv.title=num;
  newDiv.className='area_';
  newDiv.innerHTML='<input type="hidden" name="class[]" title="'+num+'" /> \
	<div style="margin-bottom:5px;"><b>栏目分类</b><input type="text" name="class_title['+num+']" value="" size="8" /></div> \
    <div style="margin-bottom:5px;margin-left:20px;">分类头栏(代码)<textarea id="class_priority['+num+']" name="class_priority['+num+']" rows="4" cols="70"></textarea> [<a href="javascript:void(0)" onclick="prevFLTL(\'class_priority['+num+']\');return false;">预览</a>]</div> \
    栏目页面以<input type="text" name="class_n['+num+']" value="4" size="1" onblur="if(isNaN(this.value)||this.value<2||this.value>8){alert(\'请填2-8的整数，默认是4\');this.value=\'4\';}" title="填2-8的整数" />列显示链接（留空则自然排列）；链接量大时，显示<input type="text" name="class_more['+num+']" value="" size="1" />条链接，以更多链接到新页面显示全部（留空直接显示全部） <table width="100%" border="0" cellspacing="1" cellpadding="0" class="n_nav">\
  <tr>\
    <td width="130" align="center" colspan="3">链接名</td>\
    <td width="300" align="center" rowspan="2">网址</td>\
    <td width="100" align="center" rowspan="2"><a href="javascript:void(0)" onclick="allChoose2(\'linktype['+num+']\',1,1);return false;">全选</a>-<a href="javascript:void(0)" onclick="allChoose2(\'linktype['+num+']\',1,0);return false;">反选</a>-<a href="javascript:void(0)" onclick="allChoose2(\'linktype['+num+']\',0,0);return false;">不选</a></td>\
    <td width="100" align="center" rowspan="2">操作</td>\
  </tr>\
  <tr>\
    <td width="60" align="center">图片</td>\
    <td width="100" align="center">名称-纯图片可空</td>\
    <td width="60" align="center">套色</td>\
  </tr>\
</table><div id="links_'+num+'"></div> \
    <button type="button" onClick="addLink(\''+num+'\',\'\',\'\');">添加网址</button> \
    <button type="button" onClick="addBatchLink(\''+num+'\');">批量导入网址</button> \
    <button type="button" onclick="removeOption(this);">删除此栏目分类</button> \
    <button type="button" onclick="insertColumn(this);">↖插入栏目分类</button> \
    <button type="button" onclick="upColumn(this);">↑上移栏目分类</button> \
    <button type="button" onclick="downColumn(this);">↓下移栏目分类</button> ';
  par.insertBefore(newDiv,tar);
}

//排序：栏目分类 向上
function upColumn(obj){
  var par=$('area');
  var tar=obj.parentNode;
  var prevObj=tar.previousSibling;
  while(prevObj!=null && prevObj.nodeType!=1){
    prevObj=prevObj.previousSibling;
  }
  if(prevObj==null || prevObj.id=='zt_obj' || prevObj.id=='tl_obj'){
    alert('已是最上级！');
    return;
  }else{
    try{par.insertBefore(tar,prevObj);}catch(err){alert('向上移动失败！请稍候再试');return;}
    //par.removeChild(tar);
  }
}

//排序：栏目分类 向下
function downColumn(obj){
  var par=$('area');
  var tar=obj.parentNode;
  var nextObj=tar.nextSibling;
  while(nextObj!=null && nextObj.nodeType!=1){
    nextObj=nextObj.nextSibling;
  }
  if(nextObj==null){
    alert('已是最下级！');
    return;
  }
  var endObj;
  if(nextObj!=null){
    var nextnextObj=nextObj.nextSibling;
    while(nextnextObj!=null && nextnextObj.nodeType!=1){
      nextnextObj=nextnextObj.nextSibling;
    }
    var endObj=nextnextObj!=null?nextnextObj:null;
  }else{
    endObj=null;
  }
  try{par.insertBefore(tar,endObj);}catch(err){alert('向下移动失败！请稍候再试');return;}
  //par.removeChild(tar);
}

//删除
function removeOption(obj){
  if(obj.innerHTML=='╳'){
    var v='链接';
  }else{
    var v='栏目分类';
  }
  var tar=obj.parentNode;
  var par=tar.parentNode;
  //if(confirm('确定删除此'+v+'吗？！')){
    try{
      tar.style.position='relative';
      tar.innerHTML+='<div style="padding:0 5px; position:absolute; top:100%; left:0; background-color:#FF6600; color:#FFFFFF;">已删除此'+v+'</div>';
      setTimeout(function(){par.removeChild(tar);},500);
    }catch(err){
    }
  //}
}


function addClass(o,objID,className){
  if(o.checked==true){
    $(objID).className=className;
  }
}

function addBatchLink(class_title){
  addSubmitSafe(1);

  $('pldr_v').style.display='none';

  par=$('pldr');
  par.style.display='block';

  var parShowH=document.documentElement.clientHeight; //屏幕高
  var thisH=par.offsetHeight;
  thisH=thisH>parShowH?parShowH:thisH;

  var ie6=!-[1,]&&!window.XMLHttpRequest;

  if(ie6){
    var t=(Math.max(document.body.scrollTop,document.documentElement.scrollTop)+(parShowH-thisH)/2);
  }else{
    var t=(parShowH-thisH)/2;
  }
  par.style.marginTop=t+'px';
 
  $('pldr_title').innerHTML=decodeURIComponent(class_title);

  $('pldr_2').disabled=false;
  $('pldr_2').innerHTML='开始导入';
}

function chkPldr(theForm){
  var pv=theForm.pldr_url.value.replace(/^[\s\r\n]+|[\s\r\n]+$/,'');
  if(pv=='' || pv=='http://'){
    alert('URL不能空！');
    return false;
  }
  return true;
}

function shaixuan(){
  var pc=$('pldr_code');
  var m=pc.value.match(/<a .+?<\/a>/ig);
  var tt='';
  if(m && m.length>0){
    for(var i=0; i<m.length; i++){
      tt+=m[i].replace(/<a [^>]*href=[\"\']?([^\"\'\>\s]+)[\"\']?[^>]*>(.+?)<\/a>/ig,"<a href=\"$1\">$2</a>")+"\n";
    }
  }else{
    alert('没有链接被筛选！');
    return;
  }
  pc.value=tt;
}

function guolv(){
  $('pldr_guolv').innerHTML='过滤中…';
  $('pldr_guolv').disabled=true;
  var pc=$('pldr_code');
  var m=pc.value.match(/<a .+?<\/a>/ig);
  if(m && m.length>0){
    var g = document.getElementsByName('p_pldr_fr[]');
    var t = document.getElementsByName('p_pldr_to[]');
    if (g != null && g.length > 0) {
      for (var i = 0; i < g.length; i++){
        if (g[i] != null && g[i] != 'undefined' && g[i].value != '') {
          g[i].value = g[i].value.replace(/^\s+|\s+$/g, '');
          g[i].value = g[i].value.replace(/^\/+/, '/').replace(/\/+([a-zA-Z]*)$/, '/$1');
          if (!g[i].value.match(/^\/.+\/[a-zA-Z]*$/)) {
            alert('过滤正则['+i+']有误！');
            continue;
          }
          eval('try { pc.value = pc.value.replace('+g[i].value+', \''+t[i].value+'\'); } catch (err) {alert(err.message);}');
        }

      }
    }
  } else {
    alert('没有链接！');
  }
  $('pldr_guolv').innerHTML='过滤链接';
  $('pldr_guolv').disabled=false;
}


function daoru(){
  $('pldr_2').innerHTML='导入中…';
  $('pldr_2').disabled=true;

  var pc=$('pldr_code');
  var m=pc.value.match(/<a .+?<\/a>/ig);
  if(m && m.length>0){
    var class_title=encodeURIComponent($('pldr_title').innerHTML);
    var tar=document.getElementsByName('link['+class_title+']');
    var end=tar.length;
    num=(end>0) ? parseInt(tar[end-1].title) : 0;
    location.href='#linkname['+class_title+']['+num+']';

    for(var i=0; i<m.length; i++){
      var l=null;
      if(l=m[i].match(/<a [^>]*href=[\"\']?([^\"\'\>\s]+)[\"\']?[^>]*>(.+?)<\/a>/i)){
        l[1]=l[1].replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;").replace(/\'/g,"&#039;");
        l[2]=l[2].replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;").replace(/\'/g,"&#039;");
        addLink(class_title,l[2],l[1]);
      }
    }
    $('pldr_v').style.display='inline';

    //escPldr();
    setTimeout("escPldr();",2000);

  }else{
    alert('没有链接被导入！');
  }
  $('pldr_2').disabled=false;
  $('pldr_2').innerHTML='开始导入';


}

function escPldr(){
  $('pldr').style.display='none';
  $('pldr_v').style.display='none';
  delSubmitSafe();
}

function allChoose2(o, v1, v2) {
  var a = document.getElementsByName(o);
    for (var i = 0; i < a.length; i++){
      if (getFirstChild(a[i]).checked == false) getFirstChild(a[i]).checked = v1;
      else getFirstChild(a[i]).checked = v2;
  }
}

function getFirstChild(obj) { 
var result = obj.firstChild; 
while (!result.tagName) { 
result = result.nextSibling; 
} 
return result; 
} 

function prevFLTL(obj){
  addSubmitSafe(1);
  if($(obj)==null){
    alert('参数出错！');
    escFLTL();
    return false;
  }
  if($(obj).value.replace(/^[\s\r\n]+|[\s\r\n]+$/,'')==''){
    alert('没有内容！');
    escFLTL();
    return false;
  }

  var w = $('toulan_code').contentWindow;
  w.document.open();
  w.document.writeln('<html><head></head><body style="background-color:#FFFFFF">');
  w.document.writeln($(obj).value);
  w.document.writeln('</body></html>');
  w.document.close();

  par=$('toulan');
  par.style.display='block';

  var parShowH=document.documentElement.clientHeight; //屏幕高
  var thisH=par.offsetHeight;
  var t=0;
  if(thisH>parShowH){
    $('toulan_in').style.height=parShowH+'px';
    $('toulan_in').style.overflow='auto';
  }else{
    var ie6=!-[1,]&&!window.XMLHttpRequest;
    if(ie6){
      var t=(Math.max(document.body.scrollTop,document.documentElement.scrollTop)+(parShowH-thisH)/2);
    }else{
      var t=(parShowH-thisH)/2;
    }
    par.style.marginTop=t+'px';
  }


}

function escFLTL(){
  par=$('toulan');
  par.style.display='none';
  par.style.marginTop='auto';
  $('toulan_in').style.height='auto';
  $('toulan_in').style.overflow='auto';
  $('toulan_code').contentWindow.document.body.innerHTML='';
  delSubmitSafe();
}

/*
function addCaiJiP(){
  $("priority").innerHTML = "\n\
$p_url='"+$("p_url").value+"';\n\
$p_b='"+$("p_b").value+"';\n\
$p_e='"+$("p_e").value+"';\n\
$p_b_is="+($("p_b_is").checked==true?1:0)+";\n\
$p_e_is="+($("p_e_is").checked==true?1:0)+";\n\
$p_url = filter($p_url);\n\
$p_b = preg_replace('/[\\\s\\r\\n]+/', '[\\\s\\r\\n]+', preg_quote($p_b));\n\
$p_b = $p_b_is == 1 ? $p_b.'(' : '('.$p_b;\n\
$p_e = preg_replace('/[\\\s\\r\\n]+/', '[\\\s\\r\\n]+', preg_quote($p_e));\n\
$p_e = $p_e_is == 1 ? ')'.$p_e : $p_e.')';\n\
if (preg_match('/'.$p_b.'(.*)'.$p_e.'/isU', read_file($p_url), $m_caiji)) {\n\
  echo $m_caiji[1];\n\
}\n\
";
}
*/
function addPChange(o){
  var par=$(o);
  var newDiv=document.createElement('DIV');
  newDiv.innerHTML='<input type="text" name="'+o+'_fr[]" size="40" /> To <input type="text" name="'+o+'_to[]" size="40" />';
  par.insertBefore(newDiv,null);

}
-->
</script>
<div id="pldr">
<?php
if (!@file_exists('readonly/run/post_manager_pldr.php')) {
  $no_pldr1 = ' disabled="disabled"';
  $no_pldr2 = '<b class="redword">（此版本未开放此功能，请<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=184830962&amp;site=qq&amp;menu=yes" target="_blank">联系官方</a>购买）</b>';
}
?>
  <div id="pldr_in"><p><a style="float:right;" href="javascript:void(0);" onClick="escPldr();">关闭</a><center><b>批量导入[<span id="pldr_title"></span>]网址</b></center></p>
    <form action="?post=pldr" method="post" target="lastFrame" onSubmit="return chkPldr(this);">
      <p><b>第1步：直接输入URL，抓取网页代码/采集链接</b>（提示：如果你已手动获取了网页代码，可直接进行第2步）——<br>
          <input type="text" name="pldr_url" id="pldr_url" size="60" value="http://"<?php echo $no_pldr1; ?> />
          <button type="submit" id="pldr_1"<?php echo $no_pldr1; ?>>抓取代码</button><?php echo $no_pldr2; ?>
      </p>
    </form>
    <p><b>第2步：抓取或手动粘贴代码于下框中</b>（提示：代码中含&lt;a href=XXX&gt;XXX&lt;/a&gt;才有用）——<br>
        <label>
        <textarea name="pldr_code" id="pldr_code" style="width:99%; height:180px;"></textarea>
        </label>
    </p>
    <p>
      <button type="button" onClick="shaixuan();">筛选链接</button> | <button type="button" onClick="$('pldr_code').value='';$('pldr_v').style.display='none';">清空</button>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="p_pldr_tb">
  <tr>
    <td>过滤链接：<a href="javascript:void(0)" onclick="addPChange('p_pldr');return false;">添加规则</a></td>
    <td id="p_pldr">例1：<span class="greenword">/&lt;a[\s\r\n]+href=&quot;\/j\.php\?url=(.+)&amp;.+&quot;/ig</span> To <span class="greenword">&lt;a href="$1"</span><br>
例2：<span class="greenword">/^.*(123)\.php\?a=([^&amp;]+).*$/ig</span> To <span class="greenword">$1/$2</span><div><input type="text" name="p_pldr_fr[]" size="40" /> To <input type="text" name="p_pldr_to[]" size="40" /></div><div><input type="text" name="p_pldr_fr[]" size="40" /> To <input type="text" name="p_pldr_to[]" size="40" /></div></td>
    <td><button type="button" id="pldr_guolv" onClick="guolv();">过滤链接</button></td>
  </tr>
</table>
     <button type="button" id="pldr_2" class="send2" onClick="daoru();">开始导入</button>
       <b id="pldr_v" class="redword">导入成功！</b>
    </p>
  </div>
</div>
<div id="toulan"><div id="toulan_in"><a style="float:right;" href="javascript:void(0);" onClick="escFLTL();">关闭</a><center><b>预览</b></center><br><iframe id="toulan_code" name="toulan_code" allowtransparency="true" width="100%" height="480" frameborder="0" marginwidth="0" marginheight="0"></iframe></div></div>

<?php
@ require ('writable/set/set_area.php');

$title = '<a href="?get=http" class="list_title_in">管理网址</a>';
$__text = $_text = $text_ = $text = $eval_ = '';
$text_p = $row_ = array();





function filter($text) {
  $text = trim($text);
  $text = stripslashes($text);
  //$text = htmlspecialchars($text);
  $text = preg_replace('/[\r\n\'\"\s\<\>]+/', '', $text);
  $text = str_replace('|', '&#124;', $text);
  return $text;
}

function get_m($class_title = '', $http_name_style = '', $class_priority = '', $class_n = 4, $class_more = '', $step = 0) {
  global $web, $dis, $dis2, $text_p;
  $text = '';
  $tp = urlencode($class_title);

  $end = 0;
  $class_n = !empty($class_n) && is_numeric($class_n) && $class_n >= 2 && $class_n <= 8 ? $class_n : 4;

  $text = '
<div id="class[]" class="area_" title="'.$step.'"><input type="hidden" name="class[]" title="'.$step.'" />
  <div style="margin-bottom:5px"><b>栏目分类</b><input type="text" name="class_title['.$tp.']" value="'.htmlspecialchars($class_title).'" size="8" /></div>
  <div style="margin-bottom:5px;margin-left:20px;">分类头栏(代码)<textarea name="class_priority['.$tp.']" id="class_priority['.$tp.']" rows="4" cols="70">'.htmlspecialchars($class_priority).'</textarea> [<a href="javascript:void(0)" onclick="prevFLTL(\'class_priority['.$tp.']\');return false;">预览</a>]</div>
  栏目页面以<input type="text" name="class_n['.$tp.']" value="'.$class_n.'" size="1" onblur="if(isNaN(this.value)||this.value<2||this.value>8){alert(\'请填2-8的整数，默认是4\');this.value=\'4\';}" title="填2-8的整数" />列显示链接（留空则自然排列）；链接量大时，显示<input type="text" name="class_more['.$tp.']" value="'.((!empty($class_more) && is_numeric($class_more)) ? $class_more : '').'" size="1" />条链接，以更多链接到新页面显示全部（留空直接显示全部）
  ';
  //if ($http_name_style = trim($http_name_style)) {
    $http_name_style = trim($http_name_style);
    $http_name_style = preg_replace("/[\r\n]+/", "\n", $http_name_style);
    $text .= '<table width="100%" border="0" cellspacing="1" cellpadding="0" class="n_nav">
  <tr>
    <td width="130" align="center" colspan="3">链接名</td>
    <td width="300" align="center" rowspan="2">网址</td>
    <td width="100" align="center" rowspan="2"><a href="javascript:void(0)" onclick="allChoose2(\'linktype['.$tp.']\',1,1);return false;">全选</a>-<a href="javascript:void(0)" onclick="allChoose2(\'linktype['.$tp.']\',1,0);return false;">反选</a>-<a href="javascript:void(0)" onclick="allChoose2(\'linktype['.$tp.']\',0,0);return false;">不选</a></td>
    <td width="100" align="center" rowspan="2">操作</td>
  </tr>
  <tr>
    <td width="60" align="center">图片</td>
    <td width="100" align="center">名称-纯图片可空</td>
    <td width="60" align="center">套色</td>
  </tr>
</table>
';
    $text .= '<div id="links_'.$tp.'">';
	$alllinkarr = explode("\n", $http_name_style);
	$alllinkarr = array_filter($alllinkarr);
    $alllinkarr_n = count($alllinkarr);
	$end = $alllinkarr_n > $end ? $alllinkarr_n : $end;
    for ($key = 0; $key < $end; $key++) {
      $h = explode("|", trim($alllinkarr[$key]));
      if (preg_match('/<img [^>]*src\s*=\s*[\"\']?([^\"\'\s\<\>]+)[\"\']?[^>]*>/i', $h[1], $m_img)) {
        $n_img = $m_img[0];
        $h[1] = preg_replace('/<img [^>]+>/i', '', $h[1]);
      }
	  $text .= '
<div id="link['.$tp.']" style="margin-bottom:5px;color:#969696;" title="'.$key.'">
<input type="hidden" name="link['.$tp.']" title="'.$key.'" />

<span class="n_img"><span id="n_img['.$tp.']['.$key.']">'.(!empty($n_img)?preg_replace('/\/?\>/', 'onmouseover="showBig(this);" />', $n_img).'<br><a href="javascript:void(0)" onclick="delFile(\'['.$tp.']['.$key.']\');" title="删除图片">×</a>':'').'</span>
<a href="javascript:void(0)" onclick="inNimg(\'['.$tp.']['.$key.']\')" title="插入链接形式图片">链</a>
<a href="javascript:void(0)" class="file_b" onmouseover="addFile(this,\''.$tp.'\',\''.$key.'\');">上传</a>
</span>
<input type="hidden" name="linkimg['.$tp.']['.$key.']" id="linkimg['.$tp.']['.$key.']" value="'.htmlspecialchars($n_img).'" />
<input type="hidden" name="linkimgold['.$tp.']['.$key.']" id="linkimgold['.$tp.']['.$key.']" value="'.$m_img[1].'" />

<input type="text" id="linkname['.$tp.']['.$key.']" name="linkname['.$tp.']['.$key.']" class="'.$h[2].'" style="width:100px;" value="'.htmlspecialchars($h[1]).'" />
<span style="background-color:#FF6600; border-bottom:1px #FFFFFF solid;"><input name="color['.$tp.']['.$key.']" type="radio" class="radio" value="redword"'.($h[2]=='redword'?' checked':'').' title="套红" onclick="addClass(this, \'linkname['.$tp.']['.$key.']\', \'redword\');" /></span><span style="background-color:#009900; border-bottom:1px #FFFFFF solid;"><input name="color['.$tp.']['.$key.']" type="radio" class="radio" value="greenword"'.($h[2]=='greenword'?' checked':'').' title="套绿" onclick="addClass(this, \'linkname['.$tp.']['.$key.']\', \'greenword\');" /></span><span style="background-color:#CCCCCC; border-bottom:1px #333333 solid;"><input name="color['.$tp.']['.$key.']" type="radio" class="radio" value="underline"'.($h[2]=='underline'?' checked':'').' title="下划线" onclick="addClass(this, \'linkname['.$tp.']['.$key.']\', \'underline\');" /></span><span style="background-color:#CCCCCC; border-bottom:1px #FFFFFF solid;"><input name="color['.$tp.']['.$key.']" type="radio" class="radio" value=""'.($h[2]==''?' checked':'').' title="恢复默认" onclick="addClass(this, \'linkname['.$tp.']['.$key.']\', \'\');" /></span>
<span class="httpo"><input type="text" name="linkhttp['.$tp.']['.$key.']" size="45" onFocus="checkLength(this);" value="'.htmlspecialchars($h[0]).'" /></span>
<span name="linktype['.$tp.']"><input name="linktype['.$tp.']['.$key.']" type="checkbox" class="checkbox" value="js"'.($h[3]=='js'?' checked':'').' /></span>'.($web['link_type'] != 1 ? '中转' : '直接').'链接
<button type="button" style="width:20px;padding:0;overflow:hidden;" title="删除" onclick="'.$dis.'removeOption(this)">╳</button>
<button type="button" style="width:20px;padding:0;overflow:hidden;" title="插入" onclick="'.$dis.'insertLink(this,\''.$tp.'\')">↖</button>
<button type="button" style="width:20px;padding:0;overflow:hidden;" title="上移" onclick="upLink(this,\''.$tp.'\')">↑</button>
<button type="button" style="width:20px;padding:0;overflow:hidden;" title="上移" onclick="downLink(this,\''.$tp.'\')">↓</button>


</div>';
      //$text .= ($key + 1) % $class_n == 0 ? '<hr />' : '';
      unset($m_img, $n_img, $n_name);
    }
    $text .= '</div>';
    $text .= '<button type="button" onClick="'.$dis.'addLink(\''.$tp.'\',\'\',\'\');">添加网址</button>';
    $text .= '<button type="button" onClick="'.$dis.'addBatchLink(\''.$tp.'\');">批量导入网址</button>';
    $text .= '<button type="button" onclick="'.$dis2.'removeOption(this);">删除此栏目分类</button> <button type="button" onclick="'.$dis2.'insertColumn(this);">↖插入栏目分类</button>';
    $text .= '<button type="button" onclick="upColumn(this);">↑上移栏目分类</button><button type="button" onclick="downColumn(this);">↓下移栏目分类</button>';
    $text .= '</div>';
  //}
  return $text;
}

function get_caiji($str) {
  $text = $p_time_ = $p_time0 = $p_time1 = '';

/*
  preg_match('/\$p_url[\s\r\n]*=[\s\r\n]*\'(.*)\'[\s\r\n]*\;/i', $str, $m_p_url);
  preg_match('/\$p_b[\s\r\n]*=[\s\r\n]*\'(.*)\'[\s\r\n]*\;/i', $str, $m_p_b);
  preg_match('/\$p_b_is[\s\r\n]*=[\s\r\n]*(0|1)[\s\r\n]*\;/i', $str, $m_p_b_is);
  preg_match('/\$p_e[\s\r\n]*=[\s\r\n]*\'(.*)\'[\s\r\n]*\;/i', $str, $m_p_e);
  preg_match('/\$p_e_is[\s\r\n]*=[\s\r\n]*(0|1)[\s\r\n]*\;/i', $str, $m_p_e_is);
  $text .= '
<br>
<b>以采集方式操纵栏目头栏：</b><br>
采集源URL：<input type="text" id="p_url" size="40" value="'.$m_p_url[1].'"><br>
采集前标记：<textarea id="p_b" rows="2" cols="40">'.$m_p_b[1].'</textarea> 输出时（<input type="checkbox" id="p_b_is" value="1"'.($m_p_b_is[1]=='1'?' checked="checked"':'').' />不）含此标记代码<br>
采集后标记：<textarea id="p_e" rows="2" cols="40">'.$m_p_e[1].'</textarea> 输出时（<input type="checkbox" id="p_e_is" value="1"'.($m_p_e_is[1]=='1'?' checked="checked"':'').' />不）含此标记代码<br>
<button type="button" onclick="addCaiJiP();">确定</button>
';
*/
  $str = trim($str);
  //if ($str) {
    $str = preg_replace("/[\r\n]+/", "\n", $str);
    list($p_time_stamp, $p_time, $p_url, $p_b, $p_e, $p_b_is, $p_e_is, $p_change_rule) = @explode("\n", $str);
    if ($p_time == '' || !is_numeric($p_time)) {
      $p_time_ = ' checked="checked"';
    } else {
      if ($p_time > 0) {
        $p_time1 = ' checked="checked"';
        $p_time_val = abs($p_time);
        $p_time_key = '';
      } else {
        $p_time0 = ' checked="checked"';
        $p_time_val = '';
        $p_time_key = abs($p_time);
      }
    }
  //}
  $text .= '
<div class="area_" style="margin-top:5px">
<b>'.($str ? '<span class="redword">当前</span>' : '').'以采集方式操纵栏目头栏：</b>注：本程序为智能采集，即用户端浏览过程中自动按时效采集、更新、保存最新数据<br>
<b class="redword">重要提示！此处各项要么不填，要么必须仔细填好！否则影响程序运行。</b><br>
系统记录的用户端触发采集时间点：'.((isset($p_time_stamp) && is_numeric($p_time_stamp)) ? gmdate('Y/m/d H:i:s', $p_time_stamp).' <a href="'.get_pseudo_static_url_class($_GET['column_id'], $_GET['class_id']).'" target="_blank">刷新数据（时效戳）</a>' : '无').'<br>
采集刷新时效：<input type="radio" name="p_time" id="p_time_" value="" onclick="$(\'p_time_key\').value=$(\'p_time_val\').value=\'\';"'.$p_time_.'>采集完成后，永不必刷新

<input type="radio" name="p_time" id="p_time0" value="0" onclick="$(\'p_time_val\').value=\'\';"'.$p_time0.'>以天，每天<input type="text" name="p_time_key" id="p_time_key" size="5" value="'.$p_time_key.'" onclick="$(\'p_time_\').checked=$(\'p_time1\').checked=false;$(\'p_time0\').checked=true;" onblur="isDigit(this,\''.$p_time_key.'\',1);">时

<input type="radio" name="p_time" id="p_time1" value="1" onclick="$(\'p_time_key\').value=\'\';"'.$p_time1.'>以<input type="text" name="p_time_val" id="p_time_val" size="5" value="'.$p_time_val.'" onclick="$(\'p_time_\').checked=$(\'p_time0\').checked=false;$(\'p_time1\').checked=true;" onblur="isDigit(this,\''.$p_time_val.'\',0);">分钟间隔<br>
采集源URL：<input type="text" name="p_url" size="60" value="'.htmlspecialchars($p_url).'"> <span class="redword">*</span><br>
采集前唯一标记：<textarea name="p_b" rows="2" cols="40">'.htmlspecialchars($p_b).'</textarea> 输出时（<input type="checkbox" name="p_b_is" value="1"'.($p_b_is==1?' checked="checked"':'').' />不）含此标记代码<br>
采集后唯一标记：<textarea name="p_e" rows="2" cols="40">'.htmlspecialchars($p_e).'</textarea> 输出时（<input type="checkbox" name="p_e_is" value="1"'.($p_e_is==1?' checked="checked"':'').' />不）含此标记代码<br>
对采集到的数据的替换、过滤规则： <button type="button" onclick="addPChange(\'p_change\')">增加</button><br>
  <div id="p_change">';

    if ($p_change_rule = trim($p_change_rule)) {
      $p_change_arr = @explode("{162100~mark2}", $p_change_rule);
      $p_change_arr = array_unique(array_filter($p_change_arr));
      if (is_array($p_change_arr) && count($p_change_arr) > 0) {
        foreach ($p_change_arr as $p_c_val) {
          list($p_fr, $p_to) = @explode("{162100~mark1}", $p_c_val);
          if ($p_fr = trim($p_fr)) {
            $text .= '
    <div><input type="text" name="p_change_fr[]" size="40" value="'.htmlspecialchars($p_fr).'" /> To <input type="text" name="p_change_to[]" size="40" value="'.htmlspecialchars($p_to).'" /></div>';
          }
        }
      }
    }

  $text .= '
    <div><input type="text" name="p_change_fr[]" size="40" /> To <input type="text" name="p_change_to[]" size="40" /></div>
  </div>
注1：请书写标准的PHP正则！否则程序将自动跳出、放弃执行。<br>
注2：程序会自动URLdecode解码。<br>
例1：<span class="greenword">/&lt;a[\s\r\n]+href=&quot;\/j\.php\?url=(.+)&amp;.+&quot;/isU</span> To <span class="greenword">&lt;a href="\1"</span><br>
例2：<span class="greenword">/^.*(123)\.php\?a=([^&amp;]+).*$/i</span> To <span class="greenword">$1/$2</span>
</div>
';
  return $text;
}



if (!isset($sql['db_err'])) {
  db_conn();
}
if ($sql['db_err'] == '') {

  if (array_key_exists($_GET['column_id'], $web['area']) && array_key_exists($_GET['class_id'], $web['area'][$_GET['column_id']])) {

    $title .= ' &gt; '.$web['area'][$_GET['column_id']][$_GET['class_id']][0].'';
    $priority_link = '"<div class=\"note\" style=\"background-color:#FFFF00;\">对此栏目进行预览：<br>动态（<a href=\"class.php?column_id='.$_GET['column_id'].'&class_id='.$_GET['class_id'].'\" target=\"_blank\"><u>class.php?column_id='.$_GET['column_id'].'&class_id='.$_GET['class_id'].'</u></a>）<br>伪静态（<a href=\"'.get_pseudo_static_url_class($_GET['column_id'], $_GET['class_id']).'\" target=\"_blank\"><u>'.get_pseudo_static_url_class($_GET['column_id'], $_GET['class_id']).'</u></a> 前提是基本参数管理中开启了伪静态）</div>"';


    $text .= '<div id="area">';
    $result = @mysql_query('SELECT * FROM `'.$sql['pref'].''.$sql['data']['承载网址数据的表名'].'` WHERE column_id="'.$_GET['column_id'].'" AND class_id="'.$_GET['class_id'].'" ORDER BY id', $db);
    //if (@mysql_num_rows($result) > 0) {
      $step = 0;
      while ($row = @mysql_fetch_assoc($result)) {
        //if (is_array($row) && count($row) > 0) {
          $class_title_ = $row['class_title'];
          list($row['class_title'], $row['class_n'], $row['class_more']) = @explode("|", $class_title_);
          $tp = urlencode($row['class_title']);

          $priority_link_ = eval('return '.$priority_link.';');
          $__text_caiji = $row['class_grab'];
          if (strstr($class_title_, '栏目头栏') && $row['http_name_style'] == '') { // && trim($row['class_priority']) != ''这是头栏
            $priority_pos_key = strstr($class_title_, '|1') ? ' checked="checked"' : '';
            $__text = $row['class_priority'];
            continue;
          } else {
            $row_[$tp] = $row;
            if ($row['class_title'] == '栏目置顶') {
              $eval_ .= '
	          $_text .= get_m($row_["'.$tp.'"]["class_title"], $row_["'.$tp.'"]["http_name_style"], $row_["'.$tp.'"]["class_priority"], $row_["'.$tp.'"]["class_n"], $row_["'.$tp.'"]["class_more"]); ';
              continue;
            } else {
	          $step++;
              $eval_ .= '
	          $text_ .= get_m($row_["'.$tp.'"]["class_title"], $row_["'.$tp.'"]["http_name_style"], $row_["'.$tp.'"]["class_priority"], $row_["'.$tp.'"]["class_n"], $row_["'.$tp.'"]["class_more"], \''.$step.'\'); ';
            }
          }
        //}
        unset($row, $tp);
      }
      eval($eval_);
      unset($row_);

      $text .= '<div class="area_" id="zt_obj" style="background-color:#FFFFCC;">对于调整栏目分类时产生的无用的图片，勾选此选项<input type="checkbox" name="img_keep" value="1" checked="checked" />予以保留，否则删除它们</div>';
      $text .= '<div class="area_" id="tl_obj"><b>栏目头栏</b>(代码)<textarea name="priority" id="priority" rows="4" cols="70">'.htmlspecialchars($__text).'</textarea>
[<a href="javascript:void(0)" onclick="prevFLTL(\'priority\');return false;">预览</a>][<a href="javascript:void(0)" onclick="$(\'priority\').value=$(\'priority\').innerHTML=\'\';return false;">清空</a>]<input type="checkbox" name="priority_pos" value="1"'.$priority_pos_key.' />置于下部'.get_caiji($__text_caiji).'</div>';
      $text .= $_text.$text_;

      unset($__text_caiji, $__text, $_text, $text_, $text_p);
    //}
    @mysql_free_result($result);
//************************************
    $text .= '</div>';
    $text .= '<button type="button" onClick="'.$dis2.'addColumn();">添加栏目分类</button> <button type="submit" onclick="if(document.getElementsByName(\'class[]\').length==0 && $(\'priority\').value==\'\'){return confirm(\'您已清空的栏目分类，此举将执行删除动作，点确定继续，否则点取消\');}" class="send2">提交</button> <input type="checkbox" id="subt" checked="checked" />在弹出的新页面提交，避免检查出填写错误而导致数据丧失，白写了';

  } else {
    $title .= ' &gt; 所有分类';
    $detail = array();
    $text .= '
    <table width="100%" border="0" cellpadding="0" cellspacing="1" id="ad_table">
    <tr>
    <th width="20%">频道</th>
    <th width="80%">栏目</th>
    </tr>
';
    foreach ((array)$web['area'] as $column_id => $column) {
      $column = (array)$column;
      $class_w = (string)$column_id == 'homepage' ? ' class="redword"' : '';

      $text .= '
      <tr>
      <td width="20%"'.$class_w.'>'.$column['name'][0].'</td>
      <td width="80%">';
      unset($column['name']);
      $text .= '';
      foreach ($column as $class_id => $class) {
        $text .= '<a href="?get=http&column_id='.$column_id.'&class_id='.$class_id.'" class="class_name">'.$column[$class_id][0].'</a>';
        @mysql_free_result($result);
        unset($class_id, $class);
      }
      unset($column_id, $column);
      $text .= '</td>
      </tr>';
    }
    $text .= '
      </table>';
  }


} else {
  $err .= $sql['db_err'];
}

@mysql_close();

?>
<h5><?php echo $title; ?></h5><?php echo $priority_link_; ?>
<div class="note">提示：
  <ol>
    <li>链接请以代码书写，必须注意书写规范，否则系统将自动过滤掉。</li>
    <li>修改分类或栏目名请到“栏目分类管理”。</li>
    <li>当前系统设置：<span class="redword"><?php echo $web['link_type'] != 1 ? '直接' : '中转'; ?>链接</span>。</li>
    <li><b>栏目头栏</b>？就是在栏目页面上部额外显示的内容（代码）。不加就留空。</li>
    <li><b>分类头栏</b>？就是在栏目分类上部额外显示的内容（代码）。不加就留空。</li>
    <li>链接名可以直接加入图片代码（图片代码，如&lt;img src=&quot;...&quot; /&gt; ），或手动链接或上传。</li>
    <li><b>若上传图片后，务必进行提交入库，以免产生垃圾（图片）文件。</b></li>
    <li>关于删除栏目数据——清空所有数据后提交即可达到删除。</li>
  </ol>
</div>

<iframe id="lastFrame" name="lastFrame" style="display:none;"></iframe>
<form id="mainform" action="?post=http&column_id=<?php echo $_GET['column_id']; ?>&class_id=<?php echo $_GET['class_id']; ?>" method="post" enctype="multipart/form-data" onsubmit="if($('subt').checked==true){this.target='_blank';}else{this.target='_self';}">
<input id="uploadimg" type="file" class="file_o" />
<input name="act" type="hidden" />
<input name="up" type="hidden" />
  <?php echo $text, $err; ?>
</form>
<script language="javascript" type="text/javascript">
<!--

function inNimg(obj){
  if(ml=prompt('请输入图片路径：','')){
    ml=ml.replace(/\"\'\<\>\s\\/,'');
    if(!ml.match(/^http(s)?\:\/\//i)){
      alert('网址格式不对！请以http://或https://开头');
      return false;
    }
    $('n_img'+obj).innerHTML='<img src="'+ml+'" onmouseover="showBig(this);" /><br><a href="javascript:void(0)" onclick="delFile(\''+obj+'\');">×</a>';
    $('linkimg'+obj).value='<img src="'+ml+'" />';
    delFile(obj);
  }
}

function addFile(obj,type,n){
  fileInput=document.getElementById("uploadimg");
  if(fileInput!=null){
    var w,h,l,t;
    l=obj.offsetLeft;
    t=obj.offsetTop;
    while(obj=obj.offsetParent){
      t+=obj.offsetTop;
      /*if(obj==document.body)break;*/
      l+=obj.offsetLeft;
    }
    fileInput.style.display="inline";
    fileInput.style.left=(l-3)+"px";
    fileInput.style.top=(t-3)+"px";
    fileInput.style.zIndex=99;
    fileInput.name='uploadfile_'+type+'_'+n+'';
    fileInput.onclick=function(){return true;}
    fileInput.onchange=function(){
      addSubmitSafe();
      $('mainform').target='lastFrame';
      $('mainform').act.value='up';
      $('mainform').up.value=type+'_'+n;
      $('mainform').submit();
    }
  }
}

function delFile(obj){
  $('lastFrame').src='manager.php?post=http&act=del&id='+encodeURIComponent(obj)+'&imgurl='+encodeURIComponent($('linkimgold'+obj+'').value)+'';
  //$('n_img'+obj).innerHTML='';
  //$('linkimg'+obj).value='';
}


function showBig(obj){
  var w=obj.offsetWidth;
  if(w>60){
    obj.parentNode.style.overflow='visible';
    obj.parentNode.parentNode.style.overflow='visible';
    obj.onmouseout=function(){
      this.parentNode.style.overflow='hidden';
      this.parentNode.parentNode.style.overflow='hidden';
    }
  }
}

function checkLength(obj){
  var iCount=obj.value.replace(/[^\u0000-\u00ff]/g,"aa").length;
  var oldSize=obj.size;
  var newObj=obj;
  if(iCount>oldSize){
    newObj.parentNode.style.overflow='visible';
    newObj.size=iCount;
    while(obj=obj.offsetParent){
      obj.parentNode.style.overflow='visible';
    }
    newObj.onblur=function(){
      this.parentNode.style.overflow='hidden';
      this.size=oldSize;
    }
  }
}



-->
</script>
















