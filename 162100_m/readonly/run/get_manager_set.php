<?php
require ('authentication_manager.php');
?>
<iframe id="lFrame" name="lFrame" frameborder="0" scrolling="No" style="display:none;"></iframe>
<!--h5><a class="list_title_in">基本参数管理</a></h5-->
<div class="note">提示：以下信息必须认真填写，尽量不要用特殊符号，如 \ : ; * ? ' &lt; &gt; | ，必免导致错误。</div>
<form action="?post=set" method="post">
  <table width="100%" border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td width="200" align="right">&nbsp;</td>
      <td><b>管理员帐户</b><br>
          <div class="red_err">注！请在配置完数据库参数后才能更改此项，以便和数据库中的名字同步更改<br />
如果想与162100网址导航3号（即电脑版）程序共享管理员，需满足以下条件<br />
<ol>
<li>同一域内（根域名相同）</li>
<li>同一主机</li>
<li>同名数据库，且《承载成员档案的表名》也相同</li>
<li>设成相同的管理员名和密码</li>
</ol>
否则各管各的</div></td>
    </tr>
    <tr>
      <td width="200" align="right">基础管理员名称：</td>
      <td><input type="text" name="manager" value="<?php echo $web['manager']; ?>" size="30" /></td>
    </tr>
    <tr>
      <td width="200" align="right">基础管理员密码：</td>
      <td><input type="text" name="password" value="" size="30" />
        ，留空默认原密码，否则更新原密码</td>
    </tr>
    <tr>
      <td width="200" align="right">&nbsp;</td>
      <td><p><b>站点基本设置</b></p></td>
    </tr>
    <tr>
      <td width="200" align="right">站点名称：</td>
      <td><input type="text" name="sitename" value="<?php echo $web['sitename']; ?>" size="30" maxlength="" /></td>
    </tr>
    <tr>
      <td width="200" align="right">站点简称：</td>
      <td><input type="text" name="sitename2" value="<?php echo $web['sitename2']; ?>" size="30" maxlength="" /></td>
    </tr>
    <tr>
      <td width="200" align="right">站点简介：</td>
      <td><textarea name="description" cols="40" rows="3"><?php echo $web['description']; ?></textarea></td>
    </tr>
    <tr>
      <td width="200" align="right">关键字：</td>
      <td><textarea name="keywords" cols="40" rows="3"><?php echo $web['keywords']; ?></textarea></td>
    </tr>
    <tr>
      <td width="200" align="right">口号：</td>
      <td><textarea name="slogan" cols="40" rows="3"><?php echo preg_replace('/<br>|<br\s*\/>/i',"\n",$web['slogan']); ?></textarea></td>
    </tr>
    <tr>
      <td width="200" align="right">网站logo：</td>
      <td><a href="?get=logo" target="_blank">上载Logo</a></td>
    </tr>
    <tr>
      <td width="200" align="right">&nbsp;</td>
      <td><p><b>站点其它设置</b></p></td>
    </tr>
    <tr>
      <td width="200" align="right">关于我们：</td>
      <td><a href="?get=modify&amp;otherfile=<?php echo get_en_url('writable/require/about.txt'); ?>" target="_blank">编辑关于我们</a></td>
    </tr>
    <tr>
      <td width="200" align="right">全局文件权限：</td>
      <td><input type="text" name="chmod" value="0<?php echo !empty($web['chmod']) ? $web['chmod'] : '777'; ?>" size="5" />
        ，0777为最高权限</td>
    </tr>
    <tr>
      <td width="200" align="right">服务器时区调整：</td>
      <td><div class="note">
        <select name="time_pos" id="time_pos">
          <option value="-12国际日期变更线西">(GMT-12.00)国际日期变更线西</option>
          <option value="-11中途岛，萨摩亚群岛">(GMT-11.00)中途岛，萨摩亚群岛</option>
          <option value="-10夏威夷">(GMT-10.00)夏威夷</option>
          <option value="-9阿拉斯加">(GMT-9.00)阿拉斯加</option>
          <option value="-8太平洋时间（美国和加拿大）；蒂华纳">(GMT-8.00)太平洋时间（美国和加拿大）；蒂华纳</option>
          <option value="-7奇瓦瓦，拉巴斯，马扎特兰">(GMT-7.00)奇瓦瓦，拉巴斯，马扎特兰</option>
          <option value="-7山地时间（美国和加拿大）">(GMT-7.00)山地时间（美国和加拿大）</option>
          <option value="-7亚利桑那">(GMT-7.00)亚利桑那</option>
          <option value="-6瓜达拉哈拉，墨西哥城，蒙特雷">(GMT-6.00)瓜达拉哈拉，墨西哥城，蒙特雷</option>
          <option value="-6萨斯喀彻温">(GMT-6.00)萨斯喀彻温</option>
          <option value="-6中部时间（美国和加拿大）">(GMT-6.00)中部时间（美国和加拿大）</option>
          <option value="-6中美洲">(GMT-6.00)中美洲</option>
          <option value="-5波哥大，利马，基多">(GMT-5.00)波哥大，利马，基多</option>
          <option value="-5东部时间（美国和加拿大）">(GMT-5.00)东部时间（美国和加拿大）</option>
          <option value="-5印第安那州（东部）">(GMT-5.00)印第安那州（东部）</option>
          <option value="-4大西洋时间（加拿大）">(GMT-4.00)大西洋时间（加拿大）</option>
          <option value="-4加拉加斯，拉巴斯">(GMT-4.00)加拉加斯，拉巴斯</option>
          <option value="-4圣地亚哥">(GMT-4.00)圣地亚哥</option>
          <option value="-3纽芬兰">(GMT-3.00)纽芬兰</option>
          <option value="-3巴西利亚">(GMT-3.00)巴西利亚</option>
          <option value="-3布宜诺斯艾利斯，乔治敦">(GMT-3.00)布宜诺斯艾利斯，乔治敦</option>
          <option value="-3格陵兰">(GMT-3.00)格陵兰</option>
          <option value="-2中大西洋">(GMT-2.00)中大西洋</option>
          <option value="-1佛得角群岛">(GMT-1.00)佛得角群岛</option>
          <option value="-1亚速尔群岛">(GMT-1.00)亚速尔群岛</option>
          <option value="0格林威治标准时间，都柏林，爱丁堡，伦敦，里斯本">(GMT)格林威治标准时间，都柏林，爱丁堡，伦敦，里斯本</option>
          <option value="0卡萨布兰卡，蒙罗维亚">(GMT)卡萨布兰卡，蒙罗维亚</option>
          <option value="1阿姆斯特丹，柏林，伯尔尼，罗马，斯德哥尔摩，维也纳">(GMT+1.00)阿姆斯特丹，柏林，伯尔尼，罗马，斯德哥尔摩，维也纳</option>
          <option value="1贝尔格莱德，布拉迪斯拉发，布达佩斯，卢布尔雅那，布拉格">(GMT+1.00)贝尔格莱德，布拉迪斯拉发，布达佩斯，卢布尔雅那，布拉格</option>
          <option value="1布鲁塞尔，哥本哈根，马德里，巴黎">(GMT+1.00)布鲁塞尔，哥本哈根，马德里，巴黎</option>
          <option value="1萨拉热窝，斯科普里，华沙，萨格勒布">(GMT+1.00)萨拉热窝，斯科普里，华沙，萨格勒布</option>
          <option value="1中非西部">(GMT+1.00)中非西部</option>
          <option value="2布加勒斯特">(GMT+2.00)布加勒斯特</option>
          <option value="2哈拉雷，比勒陀利亚">(GMT+2.00)哈拉雷，比勒陀利亚</option>
          <option value="2赫尔辛基，基辅，里加，索非亚，塔林，维尔纽斯">(GMT+2.00)赫尔辛基，基辅，里加，索非亚，塔林，维尔纽斯</option>
          <option value="2开罗">(GMT+2.00)开罗</option>
          <option value="2雅典，贝鲁特，伊斯坦布尔，明斯克">(GMT+2.00)雅典，贝鲁特，伊斯坦布尔，明斯克</option>
          <option value="2耶路撒冷">(GMT+2.00)耶路撒冷</option>
          <option value="3巴格达">(GMT+3.00)巴格达</option>
          <option value="3科威特，利雅得">(GMT+3.00)科威特，利雅得</option>
          <option value="3莫斯科，圣彼得堡，伏尔加格勒">(GMT+3.00)莫斯科，圣彼得堡，伏尔加格勒</option>
          <option value="3内罗毕">(GMT+3.00)内罗毕</option>
          <option value="3德黑兰">(GMT+3.00)德黑兰</option>
          <option value="4阿布扎比，马斯喀特">(GMT+4.00)阿布扎比，马斯喀特</option>
          <option value="4巴库，第比利斯，埃里温">(GMT+4.00)巴库，第比利斯，埃里温</option>
          <option value="4.5喀布尔">(GMT+4.30)喀布尔</option>
          <option value="5叶卡捷琳堡">(GMT+5.00)叶卡捷琳堡</option>
          <option value="5伊斯兰堡，卡拉奇，塔什干">(GMT+5.00)伊斯兰堡，卡拉奇，塔什干</option>
          <option value="5.5马德拉斯，加尔各答，孟买，新德里">(GMT+5.30)马德拉斯，加尔各答，孟买，新德里</option>
          <option value="5.75加德满都">(GMT+5.45)加德满都</option>
          <option value="6阿拉木图，新西伯利亚">(GMT+6.00)阿拉木图，新西伯利亚</option>
          <option value="6阿斯塔纳，达卡">(GMT+6.00)阿斯塔纳，达卡</option>
          <option value="6斯里哈亚华登尼普拉">(GMT+6.00)斯里哈亚华登尼普拉</option>
          <option value="6仰光">(GMT+6.30)仰光</option>
          <option value="7克拉斯诺亚尔斯克">(GMT+7.00)克拉斯诺亚尔斯克</option>
          <option value="7曼谷，河内，雅加达">(GMT+7.00)曼谷，河内，雅加达</option>
          <option value="8北京，重庆，香港特别行政区，乌鲁木齐，台北">(GMT+8.00)北京，重庆，香港特别行政区，乌鲁木齐，台北</option>
          <option value="8吉隆坡，新加坡">(GMT+8.00)吉隆坡，新加坡</option>
          <option value="8珀斯">(GMT+8.00)珀斯</option>
          <option value="8伊尔库茨克，乌兰巴图">(GMT+8.00)伊尔库茨克，乌兰巴图</option>
          <option value="9大坂，东京，札幌">(GMT+9.00)大坂，东京，札幌</option>
          <option value="9汉城">(GMT+9.00)汉城</option>
          <option value="9雅库茨克">(GMT+9.00)雅库茨克</option>
          <option value="9.5阿德莱德">(GMT+9.30)阿德莱德</option>
          <option value="9.5达尔文">(GMT+9.30)达尔文</option>
          <option value="10布里斯班">(GMT+10.00)布里斯班</option>
          <option value="10符拉迪沃斯托克（海参崴）">(GMT+10.00)符拉迪沃斯托克（海参崴）</option>
          <option value="10关岛，莫尔兹比港">(GMT+10.00)关岛，莫尔兹比港</option>
          <option value="10霍巴特">(GMT+10.00)霍巴特</option>
          <option value="10堪塔拉，墨尔本，悉尼">(GMT+10.00)堪塔拉，墨尔本，悉尼</option>
          <option value="11马加丹，索罗门群岛，新喀里多尼亚">(GMT+11.00)马加丹，索罗门群岛，新喀里多尼亚</option>
          <option value="12奥克兰，惠灵顿">(GMT+12.00)奥克兰，惠灵顿</option>
          <option value="12斐济，堪察加半岛，马绍尔群岛">(GMT+12.00)斐济，堪察加半岛，马绍尔群岛</option>
          <option value="13努库阿洛法">(GMT+13.00)努库阿洛法</option>
        </select>
        <script type="text/javascript">
<!--
document.getElementById('time_pos').value='<?php echo $web['time_pos']; ?>';
-->
  </script>
        <br>
        <font color="green">这是服务器时区时间：<?php echo $here_date = date('Y/m/d H:i:s'); ?></font><br>
        <font color="blue">这是北京时区时间：<?php echo $beijing_date = gmdate('Y/m/d H:i:s', time() + (floatval($web['time_pos']) * 3600)); ?></font><br>
        <font color="red">
          <?php if ($here_date != $beijing_date){ echo '二者时间差别为'.((strtotime($here_date) - strtotime($beijing_date)) / 3600).'小时，可根据此进行调整'; } else { echo '二者相同'; } ?>
        </font></div></td>
    </tr>
    <tr>
      <td width="200" align="right">网址链接：</td>
      <td><div class="note"><input type="radio" name="link_type" value="1"<?php echo $web['link_type'] == 1 ? ' checked' : ''; ?> />
        中转链接（通过export.php?url=链接路径）<br>
<input type="radio" name="link_type" value="0"<?php echo !$web['link_type'] ? ' checked' : ''; ?> />
        直接链接（注：选择此项，将无法记录浏览记录）</div></td>
    </tr>
    <tr>
      <td width="200" align="right">伪静态：</td>

      <td><div class="note">
<?php
if (@file_exists('./.htaccess')) {
  $wjt_Apache = ' checked="checked"';
  $wjt_IIS7 =
  $wjt_IIS6 =
  $wjt_close = '';
} elseif (@file_exists('./web.config')) {
  $wjt_IIS7 = ' checked="checked"';
  $wjt_Apache =
  $wjt_IIS6 =
  $wjt_close = '';
} elseif (@file_exists('./httpd.ini')) {
  $wjt_IIS6 = ' checked="checked"';
  $wjt_Apache =
  $wjt_IIS7 =
  $wjt_close = '';
} else {
  $wjt_Apache =
  $wjt_IIS7 =
  $wjt_IIS6 = '';
  $wjt_close = ' checked="checked"';

}
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
  $wjt = '系统判断您当前的服务器类型可能为IIS';
} else {
  $wjt = '系统判断您当前的服务器类型可能为Apache';
}

?><input type="radio" id="p_static_Apache" name="p_static" value="Apache"<?php echo $wjt_Apache; ?> /> 开启（适用Apache <span id="p_Apache"><a href="?post=pstatic&act=Apache" target="lFrame" onclick="this.parentNode.innerHTML='检测中...请勿关闭';">检测</a></span>）<br />
<input type="radio" id="p_static_IIS7" name="p_static" value="IIS7"<?php echo $wjt_IIS7; ?> /> 开启（适用IIS7.0及以上 <span id="p_IIS7"><a href="?post=pstatic&act=IIS7" target="lFrame" onclick="this.parentNode.innerHTML='检测中...请勿关闭';">检测</a></span>）<br />
<input type="radio" id="p_static_IIS6" name="p_static" value="IIS6"<?php echo $wjt_IIS6; ?> /> 开启（适用IIS6.0 <span id="p_IIS6"><a href="?post=pstatic&act=IIS6" target="lFrame" onclick="this.parentNode.innerHTML='检测中...请勿关闭';">检测</a></span>）<br />
<input type="radio" name="p_static" value="close"<?php echo $wjt_close; ?> /> 关闭（其它环境目前均不支持）<br /><?php echo $wjt; ?><br />
<span class="redword">注：因服务器众多差异，本程序无法保证伪静态规则完全适用您的服务器，如在开启过程中导致程序瘫痪，请用FTP删除根目录中下述文件：<br />
Apache对应.htaccess<br />
IIS7.0对应web.config<br />
IIS6.0对应httpd.ini<br />
或将上述文件全部删除，即可使网站恢复正常。
<div style="background-color:#FF6600; color:#FFFFFF;">因服务器差异，执行此项很容易造成程序故障，故源码暂时关闭此功能，如需要请联系作者索要开启方法。</div>

</span>
</div></td>
    </tr>
    <tr id="search_bar">
      <td width="200" align="right">搜索引擎：</td>
      <td><div class="note" style="background-color:#FFFFCC">名称：
              <input type="text" name="search_bar[0]" value="<?php echo $web['search_bar'][0]; ?>" size="8" maxlength="16" />
        <br>
        URL：
        <input type="text" name="search_bar[1]" value="<?php echo $web['search_bar'][1]; ?>" size="48" maxlength="400" />
      </div></td>
    </tr>
    <tr>
      <td width="200" align="right">前台风格：</td>
      <td><div class="note">
        <?php
	if ($cssfiles = @glob('readonly/css/*.css')) {
	  foreach ($cssfiles as $style) {
        $style = basename($style, '.css');
	    echo '<input type="radio" name="cssfile" value="'.$style.'"'.($style == $web['cssfile'] ? ' checked' : '').' />样式'.$style.' ';
	  }
	}
	?>
      </div></td>
    </tr>
    <tr>
      <td width="200" align="right">编辑404转向：</td>
      <td><a href="?get=modify&amp;otherfile=<?php echo get_en_url('.htaccess'); ?>" target="_blank">在线修改.htaccess规则</a></td>
    </tr>
    <tr>
      <td width="200" align="right">&nbsp;</td>
      <td><p><b>用户注册</b></p></td>
    </tr>
    <tr>
      <td width="200" align="right">用户注册及发送邮件：</td>
      <td><div class="note">
        <input type="radio" class="radio" name="stop_reg" value="0"<?php echo $web['stop_reg'] != 1 && $web['stop_reg'] != 2 ? ' checked' : ''; ?> />
        开启注册
        <input type="radio" class="radio" name="stop_reg" value="1"<?php echo $web['stop_reg'] == 1 ? ' checked' : ''; ?> />
        禁止注册
        <input type="radio" class="radio" name="stop_reg" value="2"<?php echo $web['stop_reg'] == 2 ? ' checked' : ''; ?> />
        注册审核<br>
        <input type="checkbox" class="checkbox" name="mail_send" value="1"<?php echo $web['mail_send'] == 1 ?' checked':''; ?> />
        注册及修改档案向用户发送邮件（<a href="?get=mail" target="_blank">修改邮件发送函数（参数）</a>）</div></td>
    </tr>
    <tr>
      <td width="200" align="right">&nbsp;</td>
      <td><p><b>用户登录</b></p></td>
    </tr>
    <tr>
      <td width="200" align="right">用户登录密码输错限制：</td>
      <td>每日最多限输错
          <input type="text" name="stop_login" value="<?php echo abs($web['stop_login']); ?>" size="5" onblur="isDigit(this,'<?php echo $web['stop_login']; ?>',1);" />
        次登录（填0不限定）</td>
    </tr>
    <tr>
      <td width="200">&nbsp;</td>
      <td><div class="red_err">特别提示：提交前请确定set目录具备写权限，因为要将配置结果写入writable/set/set.php文件</div></td>
    </tr>
    <tr>
      <td width="200">&nbsp;</td>
      <td style="padding-top:5px;"><button type="submit" onclick="if(confirm('确定提交吗？！')){addSubmitSafe();return true;}else{return false;}" class="send2">提交</button></td>
    </tr>
  </table>
</form>
