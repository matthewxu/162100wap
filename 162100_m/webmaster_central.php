<?php


/* 管理员控制台 */

/*
* 程序名称：162100手机Wap网址导航
* 作者：162100.com
* 邮箱：162100.com@163.com
* 网址：http://www.162100.com，http://www.2dh.cn
* ＱＱ：184830962
* 声明：禁止侵犯版权或程序转发的行为，否则我方将追究法律责任
*/

@ require ('writable/set/set.php');
@ require ('writable/set/set_sql.php');

@ require ('readonly/function/confirm_power.php');
define('POWER', confirm_power());

$post = !empty($_POST['post']) ? $_POST['post'] : (!empty($_GET['post']) ? $_GET['post'] : false);
$post = preg_replace('/[\.\/]+|eval|base64_/i', '', $post);
if (!empty($post)) {

  if ($post == 'weather') {
    @ ob_start();
  }

  //输出信息
  function alert($text = '', $href) {
    global $post;
    if ($post == 'weather') {
      @ ob_end_flush();
    }
    echo '
    <p><img src="readonly/images/ok.gif" /> '.$text.'</p>
    <p>或点击以下链接进入...<a href="'.$href.'">'.$href.'</a></p>
    </td>
  </tr>
</table>
<style type="text/css">
<!--
#transition { background:#FFFFFF; }
-->
</style>
<script language="javascript" type="text/javascript">
<!--
setTimeout("location.href=\''.$href.'\';",5000);
-->
</script>
</body>
</html>';
    die;
  }

  //输出错误
  function err($text = '', $src = 'i') {
    global $post;
    if ($post == 'weather') {
      @ ob_end_flush();
    }
    echo '
    <p><img src="readonly/images/'.$src.'.gif" /> '.$text.'</p>
    <p>点此可<a href="javascript:window.history.back();">返回</a></p>
    </td>
  </tr>
</table>
<style type="text/css">
<!--
#transition { background:#FFFFFF; }
-->
</style>
</body>
</html>';
    die;
  }
/*
  if ($_SERVER['HTTP_REFERER'] && strpos($_SERVER['HTTP_REFERER'], $web['sitehttp']) !== 0) {
    err('跨域操作越权！');
  }
*/
  echo '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,shrink-to-fit=no" />
<meta name="MobileOptimized" content="320" />
<meta name="HandheldFriendly" content="true" />
<title>程序执行</title>
<style type="text/css">
<!--
html { height:100%; text-align:center; }
body { height:100%; margin:0; padding:0 5px; line-height:200%; background:url(readonly/images/loading.gif) 50% 50% no-repeat; }
#transition { text-align:center; }
-->
</style>
</head>
<body>';

  echo '
<table id="transition" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>';
  if ($post != false && file_exists('readonly/run/post_manager_'.$post.'.php')) {
    @ require ('readonly/run/post_manager_'.$post.'.php');
  } else {
    err('命令错误或功能尚未开通！');
  }
  echo '
<style type="text/css">
<!--
#transition { background:#FFFFFF; }
-->
</style>
    </td>
  </tr>
</table>
</body>
</html>';


  //echo str_repeat(' ', 4096);
  //@ob_flush();
  //@flush();

  die;
}












































$power_url = array(
  'upgrade'         => '在线升级',
  'chadu'           => '查木马',
  'set'             => '基本参数管理',
  'sql'             => '数据库参数管理',
  'area'            => '栏目分类管理',
  'mail'            => '邮箱参数',
  'logo'            => '上传图片（LOGO）',
  'style'           => '自助创建风格',
  'http'            => '网址管理',
  'modify'          => '在线修改文件',
  'foot'            => '编辑页脚',
  'modify'          => '在线修改文件',
  'manager_access_del'           => '一键清除过期天气数据',
  'member'                       => '成员管理',
  'member_check_reg'             => '用户注册审批及违规成员',
  'member_bulk_mail'             => '群发邮件',
  'weather'             => '天气预报设置',
);

if ($_GET['get'] == 'sql') {
  header('Cache-Control:no-cache,must-revalidate');
  header('Pragma:no-cache');
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
?><!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,shrink-to-fit=no" />
<meta name="MobileOptimized" content="320" />
<meta name="HandheldFriendly" content="true" />
<title>管理员中心<?php

if (array_key_exists($_GET['get'], $power_url)) {
  echo ' - '.$power_url[$_GET['get']];
  $nav = '<a href="webmaster_central.php">管理员控制台</a> &gt; '.$power_url[$_GET['get']].'';

} else {
  $_GET['get'] = 'door';
  $nav = '管理员控制台';
}

echo ' - '.$web['sitename2'], $web['code_author'];
?></title>
<style type="text/css">
<!--
<?php
if (isset($_COOKIE['myStyle']) && file_exists('readonly/css/'.$_COOKIE['myStyle'].'.css')) {
  $cssf = $_COOKIE['myStyle'];
} else {
  $cssf = $web['cssfile'] ? $web['cssfile'] : 1;
}
@ require ('readonly/css/'.$cssf.'.css');
unset($cssf);

?>
#submit_safe{
	position:fixed !important;
	position:absolute;
	top:0;
	left:0;
	z-index:95;
	width:100%;
	height:100%;
	background-color:#666666;
	filter:progid:DXImageTransform.Microsoft.Alpha(opacity=50);
	-moz-opacity:0.5;
	-khtml-opacity:0.5;
	opacity:0.5;
	text-align:center;
	zoom:1
}
#submit_safe_in{
	width:400px;
	padding:10px
}
.menu{
	margin:auto;
	border:1px #D4D4D4 solid;
	background-color:#FFFFFF;
	font-size:14px
}
.menu_left{
	padding:10px;
	line-height:29px;
	padding-right:0;
	text-align:left
}
.menu_right{
	width:748px;
	line-height:180%;
	padding-left:10px;
	text-align:left;
	border-left:1px #D4D4D4 solid
}
.menu_right a{
	color:#003366;
	text-decoration:underline;
}
.menu ul {
	margin:0 auto;
	padding:0
}

.menu li{
	margin:0;
	padding:0;
	margin-left:24px
}
#bar_id_{
	position:relative;
	height:28px;
	line-height:normal;
	margin:0;
	list-style:none
}
#bar_id_ a{
	width:146px;
	height:28px;
	line-height:29px;
	padding-left:23px;
	position:absolute;
	background-color:#FFFFFF;
	border:1px #D4D4D4 solid;
	border-right:none;
	top:0;
	left:0;
	z-index:10px;
	overflow:hidden
}
.menu_title{
	font-size:14px;
	font-weight:bold
}
.column_title_{
	padding:0 14px;
	line-height:29px;
	text-align:left;
	font-weight:bold
}

#ad_table { background-color:#D8D8D8; }
#ad_table th { background-color:#EEEEEE; text-align:center; }
#ad_table td { background-color:#FFFFFF; text-align:left; }
#ad_table th, #ad_table td { padding:5px 10px; font-size:12px; line-height:normal; word-wrap:break-word; word-break:break-all; }
h5 { margin:0; margin-bottom:10px; }
h5 a { padding:2px 6px; text-align:center; text-decoration:none; }
h5 a.list_title_in { background-color:#FF9966; color:#FFFFFF; border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px; }
.note { margin-bottom:10px; padding:3px 6px; font-size:12px; overflow:hidden; clear:both;border:#D4D4D4 1px solid;color:#333333; }
.send2 { font-size:16px; font-weight:bold; }

.red_err {background-color:yellow;font-size:12px; line-height:normal; }
-->
</style>
<script language="javascript" type="text/javascript">
<!--
function $(objId){return document.getElementById(objId);}
//遮罩
function addSubmitSafe(){var parShowH=document.documentElement.clientHeight;var thisH=13+20;if($('submit_safe')==null){var s=document.createElement('DIV');s.id='submit_safe';document.body.appendChild(s);var ie6=!-[1,]&&!window.XMLHttpRequest;if(ie6){var parBodyH=document.body.offsetHeight;parBodyH=parBodyH<parShowH?parShowH:parBodyH;var parScTop=Math.max(document.body.scrollTop,document.documentElement.scrollTop);var t=(parScTop+(parShowH-thisH)/2);s.style.height=parBodyH+'px'}else{var t=(parShowH-thisH)/2}s.innerHTML='<div id="submit_safe_in" style="margin-top:'+t+'px;"><span style="background-color:#FFFFFF;">&#x8BF7;&#x7A0D;&#x5019; &#x2026;</span></div>';if(arguments[0]==1){return}s.onmousedown=function(){s.innerHTML='<div id="submit_safe_in" style="margin-top:'+t+'px;" style="color:#FFFFFF;"><span style="background-color:#FFFFFF;">&#x6B63;&#x5728;&#x5173;&#x95ED;&#x906E;&#x7F69; &#x2026;</span></div>';setTimeout('delSubmitSafe();',3000)}}}
//遮罩去除
function delSubmitSafe(){while($('submit_safe')!=null){document.body.removeChild($('submit_safe'))}}
//只允许输入数字s：0要求大于0，1不必大于0；t：小数点代表货币型数字
function isDigit(obj,starVal,s,t){var ye=false;var d=r1=r2='';if(typeof(s)!='undefined'){if(s==0){}else{ye=true;if(obj.value=='0'||obj.value==''){obj.value='0';return}}}if(ye==false){d='大于0的';r1=' || obj.value <= 0';r2='\-?'}if(typeof(t)!='undefined'&&t=='.'){var t='isNaN(obj.value)'+r1;var b=''+d+'货币类型数值'}else{var t='!/^'+r2+'([1-9]|[1-9][0-9]+)$/.test(obj.value)';var b=''+d+'整数'}if(eval(t)){alert('你输入的值不对，只允许输入'+b+'！');obj.value=starVal;obj.focus()}}
//管理三件套
function allChoose(o,v1,v2){var a=document.getElementsByName(o);for(var i=0;i<a.length;i++){if(a[i].checked==false)a[i].checked=v1;else a[i].checked=v2}}
function get_checkbox(id){var article=0;var allCheckBox=document.getElementsByName(id);if(allCheckBox!=null&&allCheckBox.length>0){for(var i=0;i<allCheckBox.length;i++){if(allCheckBox[i].checked==true&&allCheckBox[i].disabled==false){article++}}}return article}
function chk(form,input,manageType){if(get_checkbox('id[]')==0){alert('数据为空或尚未点选！');return false}if(confirm('确定'+input.innerHTML+'吗？')){form.limit.value=manageType;addSubmitSafe();form.submit()}return false}
-->
</script>
</head>
<body>
<?php
//php加载函数要比加载类要快一些，建议使用函数判断

/**	
 *判断是否是通过手机访问
 *
 */
function isMobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset($_SERVER['HTTP_VIA'])) {
        //找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    //判断手机发送的客户端标志,兼容性有待提高
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array(
            'nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    //协议法，因为有可能不准确，放到最后判断
    if (isset($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

if (isMobile()) {
  echo '<div style="background-color:#FF6600; color:#FFFFCC; text-align:center;">请使用电脑进行管理员操作！</div>';
} else {
  echo '
<style>
.menu { width:960px; }
</style>
';
}
?>
<div id="top"><a href="./">首页</a> &gt; <?php echo $nav; ?></div>
<div id="search">
<?php

if (POWER == 5) {
  echo '欢迎您：<b class="redword">管理员</b> <a href="member.php?post=login&act=logout">退出</a> | 上次登陆'.$session[1].'';
}
echo $GLOBALS['session_err'];


?>
</div>
<div class="body">
  <table width="100%" border="0" cellspacing="10" cellpadding="0" class="menu">
    <tr valign="top">
<?php
if (POWER == 5) :

function get_en_url($d) {
  //$arr = @explode('/', $d);
  //$arr = array_map('urlencode', $arr);
  //return @implode('%2F', $arr);
  return urlencode(base64_encode($d));
}

?>
      <td class="menu_left" valign="top">
          <div class="menu_title">在线升级</div>
          <ul>
            <li><a id="bar-upgrade" href="?get=upgrade">在线升级</a></li>
            <li><a href="?post=chadu">查木马</a></li>
          </ul>
          <div class="menu_title">系统设置</div>
          <ul>
            <li><a id="bar-set" href="?get=set">基本参数管理</a></li>
            <li><a id="bar-sql" href="?get=sql">数据库管理</a></li>
            <li><a id="bar-mail" href="?get=mail">邮箱参数</a></li>
            <li><a id="bar-logo" href="?get=logo">上载LOGO</a></li>
          </ul>
          <div class="menu_title">系统功能</div>
          <ul>
            <li><a id="bar-writable/require/about.txt" href="?get=modify&otherfile=<?php echo get_en_url('writable/require/about.txt'); ?>">编辑关于我们</a></li>
            <li><a id="bar-style" href="?get=style">自助创建风格</a></li>
            <li><a id="bar-writable/require/badword.txt" href="?get=modify&otherfile=<?php echo get_en_url('writable/require/badword.txt'); ?>">过滤词汇</a></li>
          </ul>
          <div class="menu_title">数据管理</div>
          <ul>
            <li><a id="bar-area" href="?get=area">频道、栏目管理</a></li>
            <li><a id="bar-http" href="?get=http" title="包含首页邮箱登陆、团购频道等">分类、网址管理</a></li>
          </ul>
        <div class="menu_title">编辑广告</div>
        <ul>
          <li><a id="bar-writable/ad/ad_search.php" href="?get=modify&otherfile=<?php echo get_en_url('writable/ad/ad_search.php'); ?>">搜索下部广告</a></li>
          <li><a id="bar-writable/ad/ad_bottom.php" href="?get=modify&otherfile=<?php echo get_en_url('writable/ad/ad_bottom.php'); ?>">页面底部广告</a></li>
          </li>
        </ul>
        <div class="menu_title">编辑页脚[代码]</div>
        <ul>
          <li><a id="bar-foot_index" href="?get=foot&act=foot_index">首页页脚</a></li>
          <li><a id="bar-foot" href="?get=foot&act=foot">公用页脚</a></li>
          <li><a id="bar-writable/require/icp.txt" href="?get=modify&otherfile=<?php echo get_en_url('writable/require/icp.txt'); ?>">ICP备案号</a></li>
          <li title="可将淘宝客或掘金链代码加入此处"><a id="bar-writable/require/statistics.txt" href="?get=modify&otherfile=<?php echo get_en_url('writable/require/statistics.txt'); ?>">加入统计代码</a><br>
          </li>
        </ul>
        <div class="menu_title">天气预报数据</div>
        <ul>
          <li><a id="bar-weather" href="?get=weather">天气预报设置</a></li>
        </ul>
        <div class="menu_title">用户管理</div>
        <ul>
          <li><a id="bar-member" href="?get=member">成员管理</a></li>
          <li><a id="bar-member_check_reg" href="?get=member_check_reg">注册审批及违规成员</a></li>
          <li><a id="bar-member_bulk_mail" href="?get=member_bulk_mail">群发邮件</a><br>
          </li>
        </ul>
        <!--div class="menu_title">修改文件[代码]</div>
        <ul>
          <li><a id="bar-modify" href="?get=modify">在线修改文件</a></li>
          <li><a id="bar-.htaccess" href="?get=modify&otherfile=<?php echo get_en_url('.htaccess'); ?>">修改.htaccess</a> </li>
        </ul--></td>
      <td class="menu_right"><?php
  if (file_exists('readonly/run/get_manager_'.$_GET['get'].'.php')) {
    @ require ('readonly/run/get_manager_'.$_GET['get'].'.php');
    if ($_GET['get'] == 'modify') {
      $_GET['otherfile'] = base64_decode($_GET['otherfile']);
      $bar_id = !empty($_GET['otherfile']) ? base64_decode($_GET['otherfile']) : 'modify';
    } elseif ($_GET['get'] == 'foot') {
      $bar_id = $_GET['act'];
    } else {
      $bar_id = $_GET['get'];
    }
    echo '<script> try { if ($("bar_id_") != null) { $("bar_id_").id = ""; } $("bar-'.$bar_id.'").parentNode.id = "bar_id_"; } catch (err) {} </script>';
  } else {
    echo '<b class="redword">！</b> 文件readonly/run/get_manager_'.$_GET['get'].'.php不见了！请检查。点此<a href="webmaster_central.php">回到管理员中心</a>。';
  }

?>

      </td>
<?php
else :
?>
<td><div class="output"><b class="redword">！</b> 请以基本管理员身份<a href="login.php" style="color:#0000CC; text-decoration:underline;">登陆</a>，以获得管理权限。</div>      </td>
<?php
endif;
?>
    </tr>
  </table>
</div>

<!--公用页脚-->
<?php include ('writable/require/foot.php'); ?>
</div>
</body>
</html>