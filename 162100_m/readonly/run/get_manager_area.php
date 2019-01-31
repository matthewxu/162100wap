<?php
require ('authentication_manager.php');
?>
<style type="text/css">
<!--
.newcolumn { width:100%; float:left; clear:both; margin-left:0; }
.newclass { /*display:inline-block !important; display:inline; zoom:1;*/ }
-->
</style>
<script type="text/javascript">
<!--
//添加栏目
function addClass(class_title, indexIs){
  //class_title=parseInt(class_title);
  var tar=document.getElementsByName('class['+class_title+']');
  var end=tar.length;
  num=(end>0) ? parseInt(tar[end-1].title)+1 : 0;
  var par=$('class_'+class_title+'');
  var newDiv=document.createElement('DIV');
  newDiv.id='class_'+class_title+'_'+num+'';
  newDiv.className='newclass';
  newDiv.title=num;
  newDiv.innerHTML=' <input type="hidden" name="class['+class_title+']" title="'+num+'" />\
  <input type="text" name="class_name['+class_title+']['+num+']" size="8" /><button type="button" onclick="javascript:removeOption(this);">╳</button> 首页展显<input type="text" name="class_show['+class_title+']['+num+']" size="1" value="6" />网址，留空显示全部'+(indexIs=='homepage'?' <input type="checkbox" name="class_p_show['+class_title+']['+num+']" value="1" checked="checked" />不显示栏目名':'')+'';
  par.insertBefore(newDiv, null);
  num=num+1;
}

//添加频道
function addColumn(column_id){
  if(column_id!='' && column_id=='homepage'){
    num=column_id;
    var column_name='首页功能';
  }else{
    var date=new Date();
    var num1=date.getFullYear()+''+(date.getMonth()+1).toString().replace(/^(\d{1})$/,'0$1')+''+date.getDate().toString().replace(/^(\d{1})$/,'0$1')+''+date.getHours().toString().replace(/^(\d{1})$/,'0$1')+''+date.getMinutes().toString().replace(/^(\d{1})$/,'0$1')+'';
    var num2=date.getSeconds().toString().replace(/^(\d{1})$/,'0$1');
    if($('class_'+num1+num2+'')==null){
      num=num1+num2;
    }else{
      num=num1+((parseInt(num2)+1).toString().replace(/^(\d{1})$/,'0$1'));
    }
    var column_name='';
  }
  var par=$('area'+column_id);
  var newDiv=document.createElement('DIV');
  newDiv.id='column_'+num+'';
  newDiv.style.marginBottom='7px';
  newDiv.title=num;
  newDiv.innerHTML='<input type="hidden" name="column[]" title="'+num+'" />\
  <strong>频道</strong> <input type="text" name="column_name['+num+']" size="8" value="'+column_name+'" /> 首页展显<input type="text" name="column_show['+num+']" size="1" value="4" />个栏目，留空显示全部<br>\
  <div id="class_'+num+'" class="newcolumn"></div><div style="height:0px; overflow:hidden;clear:both;"></div>\
  <button type="button" onclick="javascript:addClass(\''+num+'\');">为此频道添加栏目</button>\
  <button type="button" onclick="javascript:removeOption(this);">删除此频道</button>\
  <button type="button" onclick="javascript:upColumn(this);" title="上移">↑</button>\
  <button type="button" onclick="javascript:downColumn(this);" title="下移">↓</button>\
';
  par.insertBefore(newDiv, null);
  //num=num+1;
}

//排序：栏目分类 向上
function upColumn(obj){
  var par=$('area');
  var tar=obj.parentNode;
  var prevObj=tar.previousSibling;
  while(prevObj!=null && prevObj.nodeType!=1){
    prevObj=prevObj.previousSibling;
  }
  if(prevObj==null){
    alert('已是最上级！');
    return;
  }
  try{par.insertBefore(tar,prevObj);}catch(err){alert('向上移动失败！请稍候再试');return;}
  //par.removeChild(tar);

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

//删除栏目
function removeOption(obj){
  var tar=obj.parentNode;
  var par=tar.parentNode;
  if(confirm('确定删除此频道吗？！')){
    try{
      par.removeChild(tar);
    }catch(err){
    }
  }
}

function frTo(fid){
  if($('class_name_fr')==null || $('class_name_to')==null){
    alert('出错！暂停此项');
    return false;
  }
  var fr=$('class_name_fr').value;
  var to=$('class_name_to').value;
  if(fr==''){
    alert('请选择起始小类！');
    return false;
  }
  if(to==''){
    alert('请选择目标小类！');
    return false;
  }
  if(fr==to){
    alert('不能重名！');
    return false;
  }
  if($('class_'+fr+'')==null){
    alert('起始小类不存在！');
    return false;
  }
  if($('class_'+to+'')==null){
    alert('目标小类不存在！');
    return false;
  }
  return true;
}

-->
</script>
<div class="note">提示：
  <ol>
      <li>网址分类数量及名称默认程序都已设置好，建议不要更改；如需更改，只更改名称即可。</li>
    <li>以下信息必须认真填写，尽量不要用特殊符号，如 \ : ; * ? ' &lt; &gt; | ，必免导致错误。</li>
  </ol>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top">
    <td width="440" align="left"><form id="mainform" action="?post=area" method="post" onsubmit="if($('subt').checked==true){this.target='_blank';}else{this.target='_self';}">
        <?php
@ require('writable/set/set_area.php');

$text = array();
foreach ((array)$web['area'] as $fid => $f) {
  if (!empty($f) && count($f) > 0) {
    $text[$fid] .= '
  <div id="column_'.$fid.'" style="margin-bottom:7px" title="'.$fid.'">
    <input type="hidden" name="column[]" title="'.$fid.'" value="'.$f['name'][0].'" />
    <strong>频道</strong> <input type="text" name="column_name['.$fid.']" value="'.$f['name'][0].'" size="8" />'.(is_numeric($fid) && $fid !== 'homepage'?' 首页展显<input type="text" name="column_show['.$fid.']" size="1" value="'.(abs($f['name'][2]) >= 1 ? abs($f['name'][2]) : '').'" />个栏目，留空显示全部' : '').'<br>
    <div id="class_'.$fid.'" class="newcolumn">';
    $opti .= '<optgroup label="'.$f['name'][0].'">';
    
    unset($web['area'][$fid]['name']);
    foreach ((array)$web['area'][$fid] as $cid => $c) {
      if (!empty($c) && count($c) >= 2) {
        $text[$fid] .= '<div id="class_'.$fid.'_'.$cid.'" class="newclass" title="'.$cid.'">
	  <input type="hidden" name="class['.$fid.']" title="'.$cid.'" />
      <input type="text" name="class_name['.$fid.']['.$cid.']" value="'.$c[0].'" size="8" /><button
 type="button" onclick="javascript:removeOption(this);">╳</button> 首页展显<input type="text" name="class_show['.$fid.']['.$cid.']" size="1" value="'.(abs($c[2]) >= 1 ? abs($c[2]) : '').'" />网址'.(!is_numeric($fid) && $fid == 'homepage'?' <input type="checkbox" name="class_p_show['.$fid.']['.$cid.']" value="1"'.(isset($c[3])&&$c[3]==1?' checked="checked"':'').' />展示栏目头栏':'，留空显示全部').' <a href="?get=http&column_id='.$fid.'&class_id='.$cid.'" title="管理此频道下的网址">管理</a> &nbsp; </div>';
        $opti .= '<option value="'.$fid.'_'.$cid.'">'.$c[0].'</option>';
      }
    }
    $text[$fid] .= '
    </div>
    <div style="height:0px; overflow:hidden;clear:both;"></div>
    <button type="button" onclick="javascript:addClass(\''.$fid.'\', \''.(($fid == 'homepage') ? 'homepage' : '').'\');" style="clear:right">为此频道添加栏目</button>
    '.(is_numeric($fid) ? '
    <button type="button" onclick="javascript:removeOption(this);">删除此频道</button>
    <button type="button" onclick="javascript:upColumn(this);" title="上移">↑</button>
    <button type="button" onclick="javascript:downColumn(this);" title="下移">↓</button>' : '').'
  </div>
';
    $opti .= '</optgroup>';
    unset($fid);
  }
}
?>
      <div id="areaindex"><?php echo $text['homepage'] ? $text['homepage'] : '<button type="button" onclick="addColumn(\'homepage\');"><b>添加频道[首页功能]</b></button>'; ?></div>
      <br>
      <div id="area"><?php
unset($text['homepage']);
echo count($text) > 0 ? @implode('', $text) : '<div style="color:#FF6600">您还未设置频道！请先添加频道</div>';
unset($web, $text);
?></div>
      <br>
      <button type="button" onclick="addColumn('');"><b>添加频道</b></button> <a href="?get=http">管理频道、栏目及分类下的网址请点此&gt;&gt;</a>
      <br>
      <br>
  <div class="red_err">特别提示：提交前请确定set目录具备写权限，因为要将配置结果写入writable/set/set_area.php文件，否则虽提示成功，但实际仍配置失败</div>
      <button type="submit" class="send2" onclick="javascript:return confirm('确定提交吗？！');">提交设置</button> <input type="checkbox" id="subt" checked="checked" />在弹出的新页面提交，避免检查出填写错误而导致数据丧失，白写了
    </form></td>
    <td style="border-left:1px #E5E5E5 solid; padding-left:10px;"><form id="mainform2" action="?post=area_c" method="post" onsubmit="return frTo()">
      批量转移分类网址：<br>
      <select name="class_name_fr" id="class_name_fr" style="width:100px">
        <option value="">请选择</option>
        <?php echo $opti; ?>
      </select>
      &harr;
      <select name="class_name_to" id="class_name_to" style="width:100px">
        <option value="">请选择</option>
        <?php echo $opti; ?>
      </select>
      <input type="checkbox" class="checkbox" name="type" value="1" checked="checked" />
      互换转移<br>

      <button type="submit" onclick="addSubmitSafe();">提交</button>
      <br><br>
<br>
<br>
注：此功能只是整体转换各频道栏目分类下属网址，对应频道名调整请在左侧进行。
    </form></td>
  </tr>
</table>
