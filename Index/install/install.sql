DROP TABLE IF EXISTS `moyu_config`;
CREATE TABLE `moyu_config` (
  `k` varchar(32) NOT NULL,
  `v` text,
  PRIMARY KEY (`k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `moyu_config` VALUES ('admin_user', 'admin');
INSERT INTO `moyu_config` VALUES ('admin_pass', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `moyu_config` VALUES ('title', '陌屿加密系统');
INSERT INTO `moyu_config` VALUES ('keywords', '陌屿云加密,高端的加密系统。');
INSERT INTO `moyu_config` VALUES ('description', '陌屿加密系统支持,服务器,虚拟主机,在线搭建。');
INSERT INTO `moyu_config` VALUES ('kfqq', '2763994904');
INSERT INTO `moyu_config` VALUES ('qqjump', '1');
INSERT INTO `moyu_config` VALUES ('hx', '0');
INSERT INTO `moyu_config` VALUES ('wd', '0');
INSERT INTO `moyu_config` VALUES ('mzphp', '0');
INSERT INTO `moyu_config` VALUES ('zym', '0');
INSERT INTO `moyu_config` VALUES ('sizekb', '50');
INSERT INTO `moyu_config` VALUES ('GongGao', '本系统授权20一位</p>需要联系: 2763994904');
INSERT INTO `moyu_config` VALUES ('zhushi', '');

DROP TABLE IF EXISTS `moyu_daili`;
CREATE TABLE `moyu_daili` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(150) NOT NULL,
  `pass` varchar(150) NOT NULL,
  `qq` varchar(20) default NULL,
  `rmb` decimal(10,2) NOT NULL DEFAULT '0.00',
  `last` datetime default NULL,
  `dlip` varchar(15) default NULL,   
  `active` int(1) default NULL,
  `citylist` varchar(150) default NULL,  
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `moyu_km`;
CREATE TABLE `moyu_km` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `km` text,
  `money` varchar(30) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `moyu_pay`;
CREATE TABLE `moyu_pay` (
  `trade_no` varchar(64) NOT NULL,
  `type` varchar(20) NULL,
  `zid` int(11) unsigned NOT NULL DEFAULT '1',
  `tid` int(11) NOT NULL,
  `input` text NOT NULL,
  `num` int(11) unsigned NOT NULL DEFAULT '1',
  `addtime` datetime NULL,
  `endtime` datetime NULL,
  `name` varchar(64) NULL,
  `money` varchar(32) NULL,
  `ip` varchar(20) NULL,
  `user` varchar(32) DEFAULT NULL,
  `inviteid` int(11) unsigned DEFAULT NULL,
  `domain` varchar(64) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trade_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `moyu_cache`;
CREATE TABLE `moyu_cache`  (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `owner` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `space` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `upload` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;