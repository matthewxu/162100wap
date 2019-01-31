<?php
require ('authentication_manager.php');
?>
<?php

/* 邮箱参数 */
/* 162100源码 - 162100.com */
@ require ('writable/set/set_mail.php');


?>
<!--h5><a class="list_title_in">邮箱参数</a></h5-->
<div class="note"> 注：
  <ol>
      <li>请确定您的邮箱支持smtp。</li>
    <li>设定此邮箱一般会在用户注册、更改档案、及邮件群发中使用。</li>
    <li>发送邮件项可在“系统参数”中开启或关闭。</li>
    <li>以下各项都要填。</li>
  </ol>
</div>
  <form action="?post=mail" id="regform" method="post">
  <table width="100%" border="0" cellspacing="1" cellpadding="0" id="ad_table">
      <tr>
        <th style="width:180px">参数</th>
        <th style="width:250px">值</th>
        <th>说明</th>
      </tr>
        <tr>
          <td style="width:180px;text-align:left;">smtp服务器的地址</td>
          <td style="width:250px;text-align:left;"><input type="text" name="smtpserver" style="width:220px;" value="<?php echo $web['smtpserver']; ?>" size="255" /></td>
          <td style="text-align:left">如smtp.163.com</td>
        </tr>
        <tr>
          <td style="width:180px;text-align:left;">smtp服务器的端口</td>
          <td style="width:250px;text-align:left;"><input type="text" name="port" style="width:220px;" value="<?php echo $web['port']; ?>" size="255" /></td>
          <td style="text-align:left">一般是25</td>
        </tr>
        <tr>
          <td style="width:180px;text-align:left;">您登陆smtp服务器的用户名</td>
          <td style="width:250px;text-align:left;"><input type="text" name="smtpuser" style="width:220px;" value="<?php echo $web['smtpuser']; ?>" size="255" /></td>
          <td style="text-align:left">如162100.com@163.com</td>
        </tr>
        <tr>
          <td style="width:180px;text-align:left;">您登陆smtp服务器的密码</td>
          <td style="width:250px;text-align:left;"><input type="password" name="smtppwd" style="width:220px;" value="<?php echo $web['smtppwd']; ?>" size="255" /></td>
          <td style="text-align:left">&nbsp;</td>
        </tr>
        <tr>
          <td style="width:180px;text-align:left;">邮件的类型</td>
          <td style="width:250px;text-align:left;"><input type="text" name="mailtype" style="width:220px;" value="<?php echo $web['mailtype']; ?>" size="255" /></td>
          <td style="text-align:left">可选值是TXT或HTML，TXT表示是纯文本的邮件，HTML表示是html格式的邮件</td>
        </tr>
        <tr>
          <td style="width:180px;text-align:left;">发件人</td>
          <td style="width:250px;text-align:left;"><input type="text" name="sender" style="width:220px;" value="<?php echo $web['sender']; ?>" size="255" /></td>
          <td style="text-align:left">发件人，一般要与您登陆smtp服务器的用户名相同，否则可能会因为smtp服务器的设置导致发送失败</td>
        </tr>
      </table>
  <div class="red_err">特别提示：提交前请确定set目录具备写权限，因为要将配置结果写入writable/set/set_mail.php文件，否则虽提示成功，但实际仍配置失败</div>
  <table width="100%" border="0" cellspacing="1" cellpadding="0" id="ad_table">
        <tr>
          <td style="width:180px;text-align:left;">&nbsp;</td>
          <td style="width:250px;text-align:left;"><button type="submit" onclick="if(confirm('确定提交吗？！')){addSubmitSafe();return true;}else{return false;}" class="send2">提交</button></td>
          <td style="text-align:left">&nbsp;</td>
        </tr>
      </table>
  </form>
