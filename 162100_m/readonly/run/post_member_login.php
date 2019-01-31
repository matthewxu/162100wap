<?php
require ('authentication_member.php');
?>
<?php

/* 登陆处理 */
/* 162100.com源码 */


@ require ('readonly/function/filter.php');
@ require ('readonly/function/write_file.php');

$_POST = array_map('tirm_all', $_POST);

$loc = !empty($_REQUEST['location']) ? $_REQUEST['location'] : (!empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : './');


//注销
if ($_REQUEST['act'] == 'logout') {
  @ setcookie('usercookie', '', time() - 366 * 60 * 60, '/', '.'.$web['root']);
  @ setcookie('usercookie', '', time() - 366 * 60 * 60, '/');
  $loc = (strstr($loc, 'login.php') || strstr($loc, 'member.php')) ? './' : $loc;
  alert('注销成功，欢迎再来', $loc);


//登陆
} elseif ($_POST['act'] == 'login') {

  if (empty($_POST['username'])) {
    err('用户名不能空！');
  }
  if (empty($_POST['password']) || !preg_match('/^.{3,30}$/', $_POST['password'])) {
    err('密码长度请控制在3-30个字符之内。');
  }
  if (isset($_COOKIE['usercookie'])) {
  /*
    $session = @explode('|', $_COOKIE['usercookie']);
    err('您已经以用户名：'.$session[0].' 登陆过了！要想更换用户名登陆，请先<a href="member.php?post=login&act=logout&location=login.php">退出</a>');
	*/

    if (empty($_POST['imcode']) || !is_numeric($_POST['imcode']))
      err('必须准确填写数字验证码！（如看不到验证码，请返回刷新页面）');
    if ($_POST['imcode'] != $_COOKIE['regimcode'])
      err('验证码不符！（如看不到验证码，请返回刷新页面）');
  }

  $err = '';
  $date = gmdate("Y-m-d H:i:s", time() + (floatval($web["time_pos"]) * 3600));
  if ($_POST['save_cookie'] && ($_POST['save_cookie'] != 31536000 && $_POST['save_cookie'] != 1209600 && $_POST['save_cookie'] != 2592000)) {
    $_POST['save_cookie'] = -1;
  }
  if (!isset($sql['db_err'])) {
    db_conn();
  }
  if ($sql['db_err'] == '') {

    $result = @mysql_query('SELECT * FROM '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' WHERE username="'.str_replace('.', '&#46;', $_POST['username']).'" OR email="'.$_POST['username'].'" LIMIT 1', $db);
    $row = @mysql_fetch_assoc($result);
    @mysql_free_result($result);

    if (is_array($row) && count($row) > 0) {
      if (/*$web['stop_reg'] == 2 && */$row['check_reg'] == '1') {
        err('您的注册尚未通过审批！无法登陆。');
      }
      if ($row['check_reg'] == '2') {
        err('您的帐户已被管理员移除至黑名单。');
      }
      if ($row['check_reg'] == '3') {
        $stop_err = '您的帐户已被冻结，创收暂时关停。请等待审核认定无异常后开启。';
        //err('您的帐户已被异常关停，请等待审核后开启。');
      } elseif ($row['check_reg'] == '4') {
        $stop_err = '您的帐户已被置入系统观察队列！';
        //err('您的帐户已被置入系统观察队列！');
      }

      if (is_numeric($web['stop_login']) && $web['stop_login'] > 0 && $row['username'] != $web['manager']) {
        $stop_num = abs($row['stop_login']);
        if (is_numeric($stop_num) && $stop_num >= $web['stop_login'] && substr($row['thisdate'], 0, 10) == substr($date, 0, 10)) {
          err('您登录密码已输错'.$stop_num.'次！今天无法再登录。');
        }
      }

	  if($row['password'] == md162100($_POST['password'])){
	    $you = array(
          'name'  => $row['username'],
	      'key'   => $date.'|'.s_rand(16),
        );
        if ($you['name'] == $web['manager']) {
          if (!file_exists('writable/__temp__')) {
	        if (!@mkdir('writable/__temp__')) {
              err('上载目录writable/__temp__不存在或创建失败！请稍候重新登陆再试。');
            }
          }
          write_file('writable/__temp__/'.urlencode($you['name']).'.php', '<?php die(); ?>'.$you['key'].''); //登陆密钥记录
        }

        //@ setcookie('usercookie', ''.@implode('|',$you).'|'.$row['recommendedby'].'', time() + floatval($web['time_pos']) * 3600 + $_POST['save_cookie'], '/', '.'.$web['root']);
        //@ setcookie('usercookie', ''.@implode('|',$you).'|'.$row['recommendedby'].'', time() + floatval($web['time_pos']) * 3600 + $_POST['save_cookie'], '/');
        @ setcookie('usercookie', ''.@implode('|',$you).'|'.$row['recommendedby'].'||', time() + floatval($web['time_pos']) * 3600 + $_POST['save_cookie'], '/', '.'.$web['root']);
        @ setcookie('usercookie', ''.@implode('|',$you).'|'.$row['recommendedby'].'||', time() + floatval($web['time_pos']) * 3600 + $_POST['save_cookie'], '/');

        @mysql_query('UPDATE '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' SET thisdate="'.$date.'",session_key="'.$you['key'].'",stop_login="0" WHERE username="'.$row['username'].'" LIMIT 1', $db); //更新最后访问时间和密钥

        $yougourl = '<p><a href="./">首页</a></p><p><a href="member.php">用户中心</a></p>'.($loc!='./'?'<p><a href="'.$loc.'">先前页面：'.$loc.'</a></p>':'').'';
        
        alert('登陆成功！欢迎您 '.$you['name'].''. $yougourl.''.$err.''.$stop_err.'', substr($loc, 0, 9) == 'member.php' ? './' : $loc);
	  } else {

        if (is_numeric($web['stop_login']) && $web['stop_login'] > 0 && $row['username'] != $web['manager']) {
          if (substr($row['thisdate'], 0, 10) == substr($date, 0, 10)) { //当天
            $stop_add = abs($row['stop_login'])+1;
          } else {
            $stop_add = 1;
          }
          @mysql_query('ALTER TABLE `'.$sql['pref'].''.$sql['data']['承载成员档案的表名'].'` ADD COLUMN `stop_login` int(2) NOT NULL DEFAULT "0"');
//err(mysql_errno().':'.mysql_error());
          @mysql_query('UPDATE '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' SET thisdate="'.$date.'",stop_login="'.$stop_add.'" WHERE username="'.$row['username'].'" LIMIT 1', $db);
          $s_l_s = '<p>您已经'.$stop_add.'次输错密码。今天还剩'.($web['stop_login'] - $stop_add).'次登录机会</p>';
        }

        if ($_POST['username'] != $web['manager']) {
          err('密码不符！'.$s_l_s);
        } else {
          base_manager_login();
        }
	  }
    } else {
      if ($_POST['username'] != $web['manager']) {
        err('登陆失败！原因：1、用户尚未注册；2、表连接不成功或尚未建立！');
      } else {
        base_manager_login(1);
      }
	}
  } else {
    base_manager_login();
  }
  @mysql_close();


} elseif ($_POST['act'] == 'reg') {

  if ($web['stop_reg'] == 1) {
    err('当前系统设置为：禁止新用户注册。');
  } elseif ($web['stop_reg'] == 2) {
    $check1 = ',`check_reg`';
    $check2 = ',"1"';
    $check3 = '（此次注册需要审批，请耐心等待）。';
  } else {
    $check3 = '请保持持续热情支持['.$web['sitename'].']，并欢迎积极发表、反馈问题。';
  }

  if (!empty($session[0])) {
    err('您已经以 用户名：'.$session[0].' 登陆过了！要想更换用户名注册，请先<a href="member.php?post=login&act=logout&location='.urlencode($loc).'">退出</a>。');
  }
  /*
  if (empty($_POST['username']) || !preg_match('/^([^\x00-\x7f]|\w|\.){3,45}$/', $_POST['username'])) {
    err('提交被拒绝！用户名请用汉字、数字、英文及字符 _ 或 . 组成！长度范围为3-45字符。注：中文占3个字符，其它等占1个。即：纯中文可输入15字，英文或数字或英语符号可输入45字。');
  }
  */
  if (empty($_POST['username'])) {
    err('提交被拒绝！用户名不能空！');
  }
  if (strlen($_POST['username']) < 3 || strlen($_POST['username']) > 45) {
    err('提交被拒绝！用户名长度范围为3-45字符！');
  }
  if (preg_match('/admin|manager|管理员|版主|斑竹|访客|系统欢迎信|162100|furuijinzhao|操|temp|info|mess|mail|请输入用户名/i', $_POST['username'], $matches)) {
    err('提交被拒绝！用户名中含'.$matches[0].'，未获通过。');
  }

  $_POST['username'] = str_replace('.', '&#46;', $_POST['username']);

  if (empty($_POST['password']) || !preg_match('/^[^\s\\\]{3,30}$/', $_POST['password'])) {
    err('提交被拒绝！密码——长度请控制在3-30个字符之内。不能有空格和 \ 。');
  }
  if ($_POST['password_again'] == '') {
    err('密码重输不能留空！');
  }
  if ($_POST['password'] != $_POST['password_again']) {
    err('两次密码输得不一样！');
  }
  fil();
  
  if (!isset($sql['db_err'])) {
    db_conn();
  }
  if ($sql['db_err'] != '') {
    err($sql['db_err']);
  }
  
  if (@mysql_num_rows(@mysql_query('SELECT id FROM `'.$sql['pref'].''.$sql['data']['承载成员档案的表名'].'` WHERE username="'.$_POST['username'].'" OR email="'.$_POST['username'].'"', $db)) > 0) {
    err('此用户名已被注册！');
  }
  if (@mysql_num_rows(@mysql_query('SELECT id FROM `'.$sql['pref'].''.$sql['data']['承载成员档案的表名'].'` WHERE username="'.$_POST['email'].'" OR email="'.$_POST['email'].'"', $db)) > 0) {
    err('此邮箱已有人使用！');
  }
  /*
  发送邮件-------------------
  */
  if ($web['mail_send'] == 1) {
    @ require ('readonly/function/mail_class.php');
    $subject = "欢迎注册[".$web["sitename"]."]";
    $subject = "=?UTF-8?B?".base64_encode($subject)."?="; //此行解决utf-8编码邮件标题乱码
    $body = '　　欢迎加入['.$web["sitename"].']！<br>　　'.$check3.'<br>　　我们的站址为：<a href="'.$web['path'].'" target="_blank">'.$web['path'].'</a>，欢迎光临。<br><br><br><br><font color=#999999>如果不是您本人使用此邮箱进行的注册，您可至<a href="'.$web['path'].'" target="_blank">'.$web['path'].'</a>与管理员取得联系，我们将对冒用您邮箱的用户进行删除。</font>';
    $to = $_POST['email']; //收件人 
    $send = $smtp -> sendmail($to, $web['sender'], $subject, $body, $web['mailtype']);
    if ($send != 1) { 
      err('系统尝试连接您的邮箱['.$to.']并发送失败！原因：可能是您所填写的邮箱无效。请仔细填写并检查，或返回重试。');
    }
  }

  $date = gmdate("Y-m-d H:i:s", time() + (floatval($web["time_pos"]) * 3600));
  $check4 = '';
  //$messline = "".preg_replace("/[^\d]+/", "", $date)."|".$web['manager']."|欢迎加入".$web["sitename"]."！|欢迎加入！请保持持续热情支持".$web["sitename"]."，并欢迎积极发表、反馈问题。||| \n";

  $session_key = $date.'|'.s_rand(16);

  @mysql_query('INSERT INTO `'.$sql['pref'].''.$sql['data']['承载成员档案的表名'].'` (`username`,`password`,`email`,`regdate`,`thisdate`,`collection`,`notepad`,`face`,`memory_website`'.$check1.',`recommendedby`,`session_key`) values ("'.$_POST['username'].'","'.md162100($_POST['password']).'","'.$_POST['email'].'","'.$date.'","'.$date.'","","","",""'.$check2.',"'.$check4.'","'.$session_key.'")', $db);



  $secces = @mysql_affected_rows();
  if ($secces > 0) {
    if ($web['stop_reg'] != 2) {
      $you = array(
        'name'  => $_POST['username'],
        'key'   => $session_key,
      );
      @ setcookie('usercookie', ''.@implode('|',$you).'|', time() + floatval($web['time_pos']) * 3600 + 31536000, '/', '.'.$web['root']);
      @ setcookie('usercookie', ''.@implode('|',$you).'|', time() + floatval($web['time_pos']) * 3600 + 31536000, '/');
    }

    $yougourl = '<p><a href="./">首页</a></p><p><a href="member.php">用户中心</a></p><p>'.($loc!='./'?'<p><a href="'.$loc.'">先前页面：'.$loc.'</a></p>':'').'';

    @mysql_close();
    alert('注册成功！欢迎您 '.$you['name'].''.$check3.$yougourl.$err, $loc);

  } else {
    err('注册不成功！[原因：'.mysql_errno().':'.mysql_error().']');
  }





//找回密码
} elseif ($_REQUEST['act'] == 'foundpassword') {
  /*
  if (empty($_REQUEST['username']) || !preg_match('/^([^\x00-\x7f]|\w|\.){3,45}$/', $_REQUEST['username'])) {
    err('提交被拒绝！用户名请用汉字、数字、英文及字符 _ 或 . 组成！长度范围为3-45字符。注：中文占3个字符，其它等占1个。即：纯中文可输入15字，英文或数字或英语符号可输入45字。');
  }
  */

  if (empty($_REQUEST['username'])) {
    err('提交被拒绝！用户名不能空！');
  }
  if (strlen($_REQUEST['username']) < 3 || strlen($_REQUEST['username']) > 45) {
    err('提交被拒绝！用户名长度范围为3-45字符！');
  }

  $_REQUEST['username'] = str_replace('.', '&#46;', $_REQUEST['username']);
  if ($_REQUEST['username'] == $web['manager']) {
    err('禁止以管理员名义进行此项！管理员修改密码请到后台“基本参数管理”');
  }

  if (empty($_REQUEST['email']) || !preg_match('/^[\w\.\-]+@[\w\-]+\.[\w\.]+$/', $_REQUEST['email'])) {
    err('email必填！格式：xxx@xxx.xxx(.xx) 。');
  }
  if (!isset($sql['db_err'])) {
    db_conn();
  }
  if ($sql['db_err'] != '') {
    err($sql['db_err']);
  }

  $result = @mysql_query('SELECT email,check_reg FROM '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' WHERE username="'.$_REQUEST['username'].'" LIMIT 1', $db);
  if ($row = @mysql_fetch_assoc($result)) {
    @mysql_free_result($result);
    if ($row['check_reg'] == 1) {
      err('注册审核中！');
    } elseif ($row['check_reg'] == 2) {
      err('你已被置入黑名单！');
    } else {
      if ($row['email'] != $_REQUEST['email']) {
	    err('邮箱与注册邮箱不符！');
      } else {
        $new_psw = strtolower(s_rand(8));
@ require ('readonly/function/mail_class.php');
        $subject = "你已重置您的密码[".$web["sitename"]."]";
        $subject = "=?UTF-8?B?".base64_encode($subject)."?="; //此行解决utf-8编码邮件标题乱码
        $body = '　　你已重置您的密码，请持新密码：'.$new_psw.'登陆['.$web['sitename'].']。如需更改密码，请登陆后进入您的管理中心重设。<br><br><br><br><font color=#999999>如果不是您本人使用此邮箱进行的注册，您可至<a href="'.$web['path'].'" target="_blank">'.$web['path'].'</a>与管理员取得联系，我们将对冒用您邮箱的用户进行删除。</font>';
        $to = $_REQUEST['email']; //收件人 
        $send = $smtp -> sendmail($to, $web['sender'], $subject, $body, $web['mailtype']);
        if ($send != 1) {
          err('系统尝试连接您的邮箱['.$to.']并发送失败！原因：可能是您所填写的邮箱无效。请仔细填写并检查，或返回重试。');
        } else {
          @mysql_query('UPDATE '.$sql['pref'].''.$sql['data']['承载成员档案的表名'].' SET password="'.md162100($new_psw).'" WHERE username="'.$_REQUEST['username'].'" LIMIT 1', $db);
          err('新密码已发往你的邮箱。请前往查看。', 'ok');
        }
      }
    }
  } else {
    err('帐号不存在。');
  }
  @mysql_close();




//修改注册信息
} elseif ($_POST['act'] == 'regfilemodify') {

  //身份验证
  define('POWER', confirm_power());

  if (POWER == 0) {
    err('系统检测你未登陆，没有权限。');
  }

  if (!isset($sql['db_err'])) {
    db_conn();
  }
  if ($sql['db_err'] != '') {
    err($sql['db_err']);
  }

  //操作前再深层判断一下权限，v3.3加
  if ($session[1].'|'.$session[2] != get_session_key($db)) {
    err('经系统检验权限，你的身份密钥不符，关键操作！请重登陆修正！');
  }

  if (empty($_POST['email']) || !preg_match('/^[\w\.\-]+@[\w\-]+\.[\w\.]+$/', $_POST['email']) || strlen($_POST['email']) > 255) {
    err('email必填！格式：xxx@xxx.xxx(.xx) 。');
  }

  if ($_POST['password_new'] != '') {

    if (POWER == 5) {
      err('禁止管理员在此进行密码修改！修改密码请到管理员后台“系统参数”中进行。');
    }
    if ($_POST['password'] == '') {
      err('请输入原密码！');
	}
    $result = @mysql_query('SELECT password FROM `'.$sql['pref'].''.$sql['data']['承载成员档案的表名'].'` WHERE username="'.$session[0].'" LIMIT 1', $db);
	if ($row = @mysql_fetch_assoc($result)) {
      if (md162100($_POST['password']) != $row['password']) {
        err('原密码输入错误！与档案不符。');
	  }
      unset($row);
	} else {
	  $err .= '<br>密码修改失败（数据库读取失败）。';
	}
	@mysql_free_result($result);
    if (!preg_match('/^[^\s\\\]{3,30}$/', $_POST['password_new'])) {
      err('提交被拒绝！密码——长度请控制在3-30个字符之内。不能有空格和 \ 。');
    }
    if ($_POST['password_again'] != $_POST['password_new']) {
      err('提交被拒绝！确认密码，请确保两次密码都输入且一样。');
	}
    $pppp = 'password="'.md162100($_POST['password_new']).'",';
  }
  //fil();

  if (!empty($_POST['realname']) && !preg_match('/^([^\x00-\x7f]|[a-zA-Z]){3,45}$/', $_POST['realname'])) {
    err('真实姓名请用汉字、英文组成！长度范围为3-45字符。注：中文占3个字符，其它等占1个。即：纯中文可输入15字，英文可输入45字');
  }
  if (!empty($_POST['alipay']) && (!preg_match('/^[\w\.\-]+@[\w\-]+\.[\w\.]+$/', $_POST['alipay']) || strlen($_POST['alipay']) > 255)) {
    err('支付宝填：xxx@xxx.xxx(.xx) 格式');
  }
  if (!empty($_POST['bank']) && !preg_match('/^([^\x00-\x7f]|[a-zA-Z0-9]){14,255}$/', $_POST['bank'])) {
    err('请检查！开户银行（用中文或英文）+帐户（数字）');
  }

  if (@mysql_num_rows(@mysql_query('SELECT id FROM `'.$sql['pref'].''.$sql['data']['承载成员档案的表名'].'` WHERE email="'.$_POST['email'].'" AND username<>"'.$session[0].'"', $db)) > 0) {
    err('此邮箱已有人使用！');
  }

  if ($web['mail_send'] == 1) {
    @ require ('readonly/function/mail_class.php');
    $subject = "个人信息修改成功[".$web["sitename"]."]";
    $subject = "=?UTF-8?B?".base64_encode($subject)."?="; //此行解决utf-8编码邮件标题乱码
    $body = '　　您已成功修改了个人信息['.$web["sitename"].']！<br>　　请保持持续热情支持['.$web['sitename'].']，并欢迎积极发表、反馈问题。<br>　　我们的站址为：<a href="'.$web['path'].'" target="_blank">'.$web['path'].'</a>，欢迎光临。<br><br><br><br><font color=#999999>如果不是您本人使用此邮箱进行的注册，您可至<a href="'.$web['path'].'" target="_blank">'.$web['path'].'</a>与管理员取得联系，我们将对冒用您邮箱的用户进行删除。</font>';
    $to = $_POST['email']; //收件人
    $send = $smtp -> sendmail($to, $web['sender'], $subject, $body, $web['mailtype']);
    if ($send != 1) {
      err('系统尝试连接您的邮箱['.$to.']并发送失败！原因：可能是您所填写的邮箱无效。请仔细填写并检查，或返回重试。如有疑问可<a href="list.php?area_id=96" target="_blank">站内留言</a>。');
    }
  }
  @mysql_query('UPDATE `'.$sql['pref'].''.$sql['data']['承载成员档案的表名'].'` SET '.$pppp.'
  email="'.$_POST['email'].'",
  realname="'.$_POST['realname'].'",
  alipay="'.$_POST['alipay'].'",
  bank="'.$_POST['bank'].'"
  WHERE username="'.$session[0].'"', $db);

  $secces = @mysql_affected_rows();
  @mysql_close();
  if ($secces > 0) {
    alert('修改成功！'.$err.'', $loc);
  } else {
    //echo mysql_errno().':'.mysql_error();
    err('修改不成功！可能你未做改动。'.$err.'');
  }

} else {
  err('参数出错！');
}


function fil() {
  if (empty($_POST['email']) || !preg_match('/^[\w\.\-]+@[\w\-]+\.[\w\.]+$/', $_POST['email']) || strlen($_POST['email']) > 255) {
    err('email必填！格式：xxx@xxx.xxx(.xx) 。');
  }
  if (empty($_COOKIE['regimcode'])) {
    err('不能没有验证码！请检测你的浏览器，确保cookie未禁用。');
  }
  if (empty($_POST['imcode']) || !is_numeric($_POST['imcode']))
    err('验证码非数字！');
  if ($_POST['imcode'] != $_COOKIE['regimcode'])
    err('验证码不符！');
}

function s_rand($l) {
  $rand = '';
  $c = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ-abcdefghijklmnopqrstuvwxyz_0123456789';
  $n = strlen($c) - 1;
  for ($i = 0; $i < $l; $i++) {
    $rand .= $c[mt_rand(0, $n)];
  }
  return $rand;
}

function tirm_all($str) {
  return filter1(strtolower($str));
}

function md162100($str) {
  return substr(sha1(md5($str)), 4, 32);
}

//基础管理员任何故障下登陆
function base_manager_login($boin = 0) {
  global $web, $sql, $date, $loc, $db;
  $_POST['username'] = str_replace('.', '&#46;', $_POST['username']);
  if ($_POST['username'] == $web['manager']){
    if (md162100($_POST['password']) != $web['password']) {
      err('登陆失败！原因分析：管理员密码不符');
    }
    $you = array(
      'name'  => $_POST['username'],
      'key'   => $date.'|'.s_rand(16),
    );
    if (!file_exists('writable/__temp__')) {
	  if (!@mkdir('writable/__temp__')) {
        err('上载目录不存在！又无创建权限！登陆被禁止。请手动建立writable/__temp__目录再重登陆。');
      }
    }
    write_file('writable/__temp__/'.urlencode($you['name']).'.php', '<?php die(); ?>'.$you['key'].''); //登陆密钥记录
    @ setcookie('usercookie', ''.@implode('|',$you).'|', time() + floatval($web['time_pos']) * 3600, '/', '.'.$web['root']);
    @ setcookie('usercookie', ''.@implode('|',$you).'|', time() + floatval($web['time_pos']) * 3600, '/');

    if ($boin == 1) {
      @ require ('writable/set/set_mail.php');
      @mysql_query('INSERT INTO `'.$sql['pref'].''.$sql['data']['承载成员档案的表名'].'` (`username`,`password`,`email`,`thisdate`,`regdate`,`collection`,`notepad`,`memory_website`,`face`,`session_key`) values ("'.$web['manager'].'","'.$web['password'].'","'.($web['sender']?$web['sender']:'管理员邮箱未填写').'","'.$date.'","'.$date.'","","","","","'.$you['key'].'")', $db);
    }
    alert('以基础管理员身份登陆成功！欢迎您 '.$you['name'].'', $loc);
  } else {
    err('登陆失败！原因分析：管理员名称不符');
  }
}


?>