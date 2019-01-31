<?php die(); ?> 
(
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `thisdate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `regdate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `realname` varchar(64) NOT NULL DEFAULT '',
  `alipay` varchar(255) NOT NULL DEFAULT '' COMMENT '支付宝',
  `bank` varchar(255) NOT NULL DEFAULT '' COMMENT '银行',
  `collection` text NOT NULL COMMENT '我的收藏',
  `notepad` text NOT NULL COMMENT '记事本',
  `memory_website` text NOT NULL COMMENT '浏览记录',
  `recommendedby` varchar(64) NOT NULL DEFAULT '' COMMENT '上线人',
  `face` longblob COMMENT '头像',
  `check_reg` int(2) NOT NULL DEFAULT '0' COMMENT '0 正常 1 审核中 2 黑名单 3 冻结 4 异常',
  `session_key` varchar(64) NOT NULL DEFAULT '' COMMENT '密钥',
  `login_key_qq` varchar(255) NOT NULL DEFAULT '',
  `login_key_weibo` varchar(255) NOT NULL DEFAULT '',
  `login_key_baidu` varchar(255) NOT NULL DEFAULT '',
  `login_key_162100` varchar(255) NOT NULL DEFAULT '',
  `stop_login` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (id,check_reg),
  UNIQUE username_check_reg (username,check_reg),
  UNIQUE email_check_reg (email,check_reg)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8
/*!50100 PARTITION BY LIST (check_reg)
(PARTITION p0 VALUES IN (0),
PARTITION p1 VALUES IN (1),
PARTITION p2 VALUES IN (2),
PARTITION p3 VALUES IN (3),
PARTITION p4 VALUES IN (4)
) */;
