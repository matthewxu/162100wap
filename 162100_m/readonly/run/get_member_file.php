<?php
require ('authentication_member.php');
?>
<?php
if (POWER > 0) :

?>
<script language="javascript" type="text/javascript">
<!--
function $(objId){return document.getElementById(objId);}
function getCookie(name){var arr=document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));if(arr!=null&&arr!=false){return decodeURIComponent(arr[2])}else{return false}}
//提交检测
function postChk(){
  if($('email').value=='' || !$('email').value.match(/^[\w\.\-]+@[\w\-]+\.[\w\.]+$/)){
    $('email_err').innerHTML=showErr('email必填！填：xxx@xxx.xxx(.xx) 格式');
	//$('email').focus();
    return false;
  } else {
    $('email_err').innerHTML='√';
  }
  var po=$('password');
  var pn=$('password_new');
  if(po.value!='' || pn.value!=''){
    if(po.value.length>30 || po.value.length<3){
      $('password_err').innerHTML=showErr('原密码长度是3-30字符！');
	  //$('password').focus();
      return false;
    } else {
      $('password_err').innerHTML='√';
    }
    if(pn.value.length>30 || pn.value.length<3){
      $('password_new_err').innerHTML=showErr('新密码长度是3-30字符！');
	  //$('password_new').focus();
      return false;
    } else {
      $('password_new_err').innerHTML='√';
    }
    if(pn.value!=$('password_again').value){
      $('password_again_err').innerHTML=showErr('两次密码输得不一样！');
	  //$('password_again').focus();
      return false;
    } else {
      $('password_again_err').innerHTML='√';
    }
  }

  var realname=$('realname');
  if(realname.value!='' && !realname.value.match(/^([^\x00-\x7f]|[a-zA-Z]){3,45}$/)){
    alert('真实姓名请用汉字、英文组成！长度范围为3-45字符');
	realname.focus();
    return false;
  }
  var bank=$('bank');
  if(bank.value!='' && !bank.value.match(/^([^\x00-\x7f]|[a-zA-Z0-9]){14,255}$/)){
    alert('请检查！开户银行（用中文或英文）+帐户（数字）');
	$('bank').focus();
    return false;
  }
  var alipay=$('alipay');
  if(alipay.value!='' && !alipay.value.match(/^[\w\.\-]+@[\w\-]+\.[\w\.]+$/)){
    alert('支付宝填：xxx@xxx.xxx(.xx) 格式');
	$('alipay').focus();
    return false;
  }
/*
  if($('imcode').value!=getCookie('regimcode')){
    $('imcode_err').innerHTML=showErr('请准确填写验证码！');
	//$('imcode').focus();
    return false;
  } else {
    $('imcode_err').innerHTML='√';
  }
*/
  return true;
}

function openWB(){
  $('realname_').style.display=
  $('bank_').style.display=
  $('wangwanw').style.display='';
  $('wb__').style.display='none';
}
function closeWB(){
  $('realname_').style.display=
  $('bank_').style.display=
  $('wangwanw').style.display='none';
  $('wb__').style.display='';
}

function showErr(text){
  return '<div style="background-color:#FF6600;color:#FFFF00;clear:both;">'+text+'</div>';
}

-->
</script>
<?php
  if (!isset($sql['db_err'])) {
    db_conn();
  }
  if ($sql['db_err'] == '') {

    $result = @mysql_query('SELECT * FROM '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' WHERE username="'.$session[0].'" LIMIT 1', $db);
    if ($row = @mysql_fetch_assoc($result)) {
      if ($row['check_reg'] == '1') {
        $err = '帐号注册审核中！';
      } elseif ($row['check_reg'] == '2') {
        $err = '帐号已被移除至黑名单！';
      } elseif ($session[1].'|'.$session[2] != $row['session_key']) {
        $err = '经系统检验权限，你的身份密钥不符，关键操作！请重登陆修正！';
      }
    } else {
      $err = '帐号不存在！';
    }
    @mysql_free_result($result);

  } else {
    $err .= $sql['db_err'];
  }
  @mysql_close();

  if (empty($err)) {
    echo '
    <form action="?post=login" method="post" target="_self" onsubmit="return postChk()">
      <table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
          <td align="right">邮箱</td>
          <td align="left"><input name="email" id="email" type="text" size="15" maxlength="200" value="'.$row['email'].'" /> <span id="email_err" class="redword">*</span></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left" style="font-size:12px" class="grayword">可修改您的邮箱</td>
        </tr>
        <tr>
          <td align="right">原密码</td>
          <td align="left"><input name="password" id="password" type="password" size="15" maxlength="40" /> <span id="password_err"></span></td>
        </tr>
        <tr>
          <td align="right">新密码</td>
          <td align="left"><input name="password_new" id="password_new" type="password" size="15" maxlength="40" /> <span id="password_new_err"></span></td>
        </tr>
        <tr>
          <td align="right">重输新密码</td>
          <td align="left"><input name="password_again" id="password_again" type="password" size="15" maxlength="40" /> <span id="password_again_err"></span></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left" style="font-size:12px" class="grayword">不填则默认原密码</td>
        </tr>
        <tr id="wb__">
          <td align="right">&nbsp;</td>
          <td align="left"><a href="javascript:void(0)" onclick="openWB();return false;">完善我的银行帐户'.($_GET['form'] == 'yes' ? '，以便获得收入' : '').'</a></td>
        </tr>
        <tr id="realname_" style="display:none;">
          <td align="right">真实姓名</td>
          <td align="left"><input name="realname" id="realname" type="text" size="15" maxlength="40" value="'.$row['realname'].'" /></td>
        </tr>
        <tr id="bank_" style="display:none;">
          <td align="right">银行、帐号</td>
          <td align="left"><input name="bank" id="bank" type="text" size="15" maxlength="40" value="'.$row['bank'].'" /></td>
        </tr>
        <tr id="wangwanw" style="display:none;">
          <td align="right">支付宝帐号</td>
          <td align="left"><input name="alipay" id="alipay" type="text" size="15" maxlength="40" value="'.$row['alipay'].'" /></td>
        </tr>
        <!-- tr>
          <td align="right">验证码</td>
          <td align="left"><input name="imcode" id="imcode" type="text" style="width:68px;float:left;margin-right:3px;" maxlength="6" /> <span id="imcode_err" class="redword">*</span></td>
        </tr -->
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><button name="submit" type="submit">提交修改</button></td>
        </tr>
      </table>
      <input name="location" id="location" type="hidden" value="'.basename($_SERVER['REQUEST_URI']).'" />
      <input type="hidden" name="act" value="regfilemodify" />
    </form>
';
    unset($row);
  } else {
    echo '<div class="output">'.$err.'</div>';
  }
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

