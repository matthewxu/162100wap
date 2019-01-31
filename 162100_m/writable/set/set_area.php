<?php


$web['area']['homepage']['name'] = array('首页功能', 'sygn', );
$web['area']['homepage']['0'] = array('名站', 'mingzhan', 50);
$web['area']['homepage']['3'] = array('推荐', 'tuijian', 24);
$web['area']['homepage']['4'] = array('实用功能', 'shiyonggongneng', 14);
$web['area']['0']['name'] = array('休闲娱乐', 'xxyl', 6);
$web['area']['0']['0'] = array('音乐', 'yinyue', 4);
$web['area']['0']['1'] = array('视频', 'shipin', 5);
$web['area']['0']['2'] = array('游戏', 'youxi', 6);
$web['area']['0']['3'] = array('小说', 'xiaoshuo', 6);
$web['area']['0']['4'] = array('交友', 'jiaoyou', 6);
$web['area']['0']['5'] = array('笑话', 'xiaohua', 4);
$web['area']['0']['6'] = array('动漫', 'dongman', 6);
$web['area']['0']['7'] = array('星座', 'xingzuo', 6);
$web['area']['0']['9'] = array('体育', 'tiyu', 6);
$web['area']['0']['10'] = array('NBA', 'NBA', 6);
$web['area']['0']['13'] = array('图片', 'tupian', 6);
$web['area']['0']['14'] = array('娱乐', 'yule', 6);
$web['area']['0']['15'] = array('聊天', 'liaotian', 6);
$web['area']['1']['name'] = array('生活服务', 'shfw', 9);
$web['area']['1']['0'] = array('购物', 'gouwu', 5);
$web['area']['1']['1'] = array('旅游', 'lvyou', 6);
$web['area']['1']['2'] = array('美食', 'meishi', 4);
$web['area']['1']['3'] = array('汽车', 'qiche', 5);
$web['area']['1']['4'] = array('婚恋', 'hunlian', 6);
$web['area']['1']['5'] = array('女性', 'nvxing', 4);
$web['area']['1']['6'] = array('生活', 'shenghuo', 4);
$web['area']['1']['8'] = array('天气', 'tianqi', 6);
$web['area']['1']['10'] = array('健康', 'jiankang', 4);
$web['area']['1']['11'] = array('快递', 'kuaidi', 6);
$web['area']['1']['12'] = array('售后', 'shouhou', 6);
$web['area']['1']['13'] = array('租车', 'zuche', 6);
$web['area']['1']['14'] = array('地图', 'ditu', 6);
$web['area']['1']['15'] = array('常用电话', 'changyongdianhua', 6);
$web['area']['2']['name'] = array('手机网络', 'sjwl', 5);
$web['area']['2']['0'] = array('手机', 'shouji', 4);
$web['area']['2']['1'] = array('数码', 'shuma', 6);
$web['area']['2']['2'] = array('软件', 'ruanjian', 4);
$web['area']['2']['3'] = array('微博', 'weibo', 6);
$web['area']['2']['5'] = array('热搜', 'resou', 6);
$web['area']['2']['6'] = array('空间', 'kongjian', 6);
$web['area']['2']['7'] = array('主题', 'zhuti', 6);
$web['area']['2']['11'] = array('邮箱', 'youxiang', 6);
$web['area']['3']['name'] = array('商业经济', 'syjj', 6);
$web['area']['3']['1'] = array('财经', 'caijing', 5);
$web['area']['3']['2'] = array('银行', 'yinxing', 6);
$web['area']['3']['3'] = array('房产', 'fangchan', 4);
$web['area']['3']['4'] = array('彩票', 'caipiao', 3);
$web['area']['3']['5'] = array('招聘', 'zhaopin', 4);
$web['area']['3']['6'] = array('保险', 'baoxian', 2);
$web['area']['4']['name'] = array('社会文化', 'shwh', 5);
$web['area']['4']['0'] = array('新闻', 'xinwen', 5);
$web['area']['4']['1'] = array('军事', 'junshi', 5);
$web['area']['4']['2'] = array('百科', 'baike', 3);
$web['area']['4']['3'] = array('教育', 'jiaoyu', 4);
$web['area']['4']['4'] = array('英语', 'yingyu', 4);
$web['area']['4']['5'] = array('考试', 'kaoshi', 4);
$web['area']['4']['8'] = array('农业', 'nongye', 6);
$web['area']['4']['11'] = array('艺术', 'yishu', 6);
$web['area']['4']['14'] = array('地方', 'difang', 6);
$web['area']['4']['15'] = array('国外', 'guowai', 6);


function get_pseudo_static_url_column($column_id) {
  global $web;
  return ($web['p_static'] == 1 && (file_exists('./.htaccess') || file_exists('./web.config') || file_exists('./httpd.ini'))) ? $column_id.'.'.$web['area'][$column_id]['name'][1] : 'column.php?clumn_id='.$column_id;
}

function get_pseudo_static_url_class($column_id, $class_id) {
  global $web;
  return ($web['p_static'] == 1 && (file_exists('./.htaccess') || file_exists('./web.config') || file_exists('./httpd.ini'))) ? $column_id.'_'.$class_id.'.'.$web['area'][$column_id][$class_id][1] : 'class.php?column_id='.$column_id.'&class_id='.$class_id;
}

?>