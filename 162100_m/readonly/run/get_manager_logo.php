<?php
require ('authentication_manager.php');
?>
<script language="javascript" type="text/javascript">
<!--
// 只允许输入数字
function chkT(){
  if($('imgname').value==''){
    alert("图片名称不能空！");
    return false;
  }
  if(!/^[\w]+$/.test($('imgname').value.replace(/\.[a-zA-Z]+$/,''))){
    alert("图片名称只允许输入字母、数字、下划线！");
    return false;
  }
  if($('imgdir').value==''){
    alert("上传目录不能空！");
    return false;
  }
  if(!/^[\w\/]+$/.test($('imgdir').value)){
    alert("上传目录只允许输入字母、数字、下划线、/！");
    return false;
  }
  addSubmitSafe();
  return true;
}
-->
</script>


<!--h5><a class="list_title_in">上载图片（Logo）</a></h5-->
<div class="note">提示：<br>
<ol>
  <li>为方便在线更改各类图片，如你添加的广告代码中需要引用图片，可用该功能灵活、方便的调用。</li>
  <li>请选jpg、gif、png格式，尺寸小于2M。当然，您也可以手动制作好图片，存到你希望的目录中。</li>
  <li>系统自用图片保存在目录：readonly/images，后天增加的图片建议上传目录：writable/__web__/images</li>
  <li><b class="redword">logo路径为：writable/__web__/images/logo.gif</b></li>
  <li>也可新建目录。注意图片名称和上传目录只能填字母、数字、下划线。</li>
</ol>
</div>
<form action="?post=logo" enctype="multipart/form-data" method="post" onsubmit="return chkT(this)">
  <table width="100%" border="0" cellspacing="5" cellpadding="0">
    <tr valign="top">
      <td width="200" align="right">图片位置：</td>
      <td><input name="uploadfile" type="file" class="file"></td>
    </tr>
    <tr valign="top">
      <td width="200" align="right">图片名称：</td>
      <td><input name="imgname" id="imgname" type="text" size="40" /></td>
    </tr>
    <tr valign="top">
      <td width="200" align="right">上传目录：</td>
      <td><input name="imgdir" id="imgdir" type="text" size="40" value="writable/__web__/images" /></td>
    </tr>
    <tr valign="top">
      <td width="200" align="right">&nbsp;</td>
      <td style="padding-top:5px;"><button type="submit">上传</button></td>
    </tr>
  </table>
</form>