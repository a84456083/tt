# Host: localhost  (Version: 5.5.27)
# Date: 2013-08-20 17:28:04
# Generator: MySQL-Front 5.3  (Build 4.4)

/*!40101 SET NAMES utf8 */;

#
# Source for table "activecode"
#

DROP TABLE IF EXISTS `activecode`;
CREATE TABLE `activecode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) NOT NULL,
  `creator_uid` int(11) NOT NULL,
  `timeline` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "activecode"
#

/*!40000 ALTER TABLE `activecode` DISABLE KEYS */;
/*!40000 ALTER TABLE `activecode` ENABLE KEYS */;

#
# Source for table "assessment_checklist"
#

DROP TABLE IF EXISTS `assessment_checklist`;
CREATE TABLE `assessment_checklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `content` varchar(255) NOT NULL,
  `timeline` datetime NOT NULL,
  `uid` int(11) NOT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "assessment_checklist"
#

/*!40000 ALTER TABLE `assessment_checklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `assessment_checklist` ENABLE KEYS */;

#
# Source for table "assessment_index"
#

DROP TABLE IF EXISTS `assessment_index`;
CREATE TABLE `assessment_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) DEFAULT NULL,
  `task_type` varchar(30) NOT NULL,
  `assessment_index` varchar(128) DEFAULT NULL,
  `p_one` varchar(128) DEFAULT NULL,
  `p_two` varchar(128) DEFAULT NULL,
  `p_three` varchar(128) DEFAULT NULL,
  `p_four` varchar(128) DEFAULT NULL,
  `p_five` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "assessment_index"
#

/*!40000 ALTER TABLE `assessment_index` DISABLE KEYS */;
/*!40000 ALTER TABLE `assessment_index` ENABLE KEYS */;

#
# Source for table "attachment"
#

DROP TABLE IF EXISTS `attachment`;
CREATE TABLE `attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=file;2=image;3=doc',
  `path` varchar(255) NOT NULL,
  `tid` int(11) DEFAULT NULL,
  `fid` int(11) DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `timeline` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fid` (`fid`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "attachment"
#

/*!40000 ALTER TABLE `attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `attachment` ENABLE KEYS */;

#
# Source for table "board"
#

DROP TABLE IF EXISTS `board`;
CREATE TABLE `board` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `visible` enum('all','group','private') NOT NULL DEFAULT 'all',
  `visible_value` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "board"
#

/*!40000 ALTER TABLE `board` DISABLE KEYS */;
/*!40000 ALTER TABLE `board` ENABLE KEYS */;

#
# Source for table "board_list"
#

DROP TABLE IF EXISTS `board_list`;
CREATE TABLE `board_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `board_id` int(11) unsigned NOT NULL,
  `todos` char(100) DEFAULT NULL,
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '99',
  PRIMARY KEY (`id`),
  KEY `board_id` (`board_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "board_list"
#

/*!40000 ALTER TABLE `board_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `board_list` ENABLE KEYS */;

#
# Source for table "checklist"
#

DROP TABLE IF EXISTS `checklist`;
CREATE TABLE `checklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `content` varchar(255) NOT NULL,
  `timeline` datetime NOT NULL,
  `uid` int(11) NOT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT '0',
  `sub_tid` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "checklist"
#

/*!40000 ALTER TABLE `checklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `checklist` ENABLE KEYS */;

#
# Source for table "checklist_tpl"
#

DROP TABLE IF EXISTS `checklist_tpl`;
CREATE TABLE `checklist_tpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `version` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "checklist_tpl"
#

/*!40000 ALTER TABLE `checklist_tpl` DISABLE KEYS */;
/*!40000 ALTER TABLE `checklist_tpl` ENABLE KEYS */;

#
# Source for table "comment"
#

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `timeline` datetime DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `device` varchar(16) DEFAULT 'web',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "comment"
#

/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;

#
# Source for table "css"
#

DROP TABLE IF EXISTS `css`;
CREATE TABLE `css` (
  `uid` int(11) NOT NULL,
  `css` text,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "css"
#

/*!40000 ALTER TABLE `css` DISABLE KEYS */;
/*!40000 ALTER TABLE `css` ENABLE KEYS */;

#
# Source for table "feed"
#

DROP TABLE IF EXISTS `feed`;
CREATE TABLE `feed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` mediumtext NOT NULL,
  `uid` int(11) NOT NULL,
  `tid` int(11) NOT NULL DEFAULT '0',
  `reblog_id` int(11) NOT NULL DEFAULT '0' COMMENT '0=no_relog',
  `timeline` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=normal,1=notice,2=todo,3=user activity,4=cast',
  `device` varchar(16) DEFAULT 'web',
  `comment_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "feed"
#

/*!40000 ALTER TABLE `feed` DISABLE KEYS */;
/*!40000 ALTER TABLE `feed` ENABLE KEYS */;

#
# Source for table "iospush_message"
#

DROP TABLE IF EXISTS `iospush_message`;
CREATE TABLE `iospush_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `body` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "iospush_message"
#

/*!40000 ALTER TABLE `iospush_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `iospush_message` ENABLE KEYS */;

#
# Source for table "iospush_userdevice"
#

DROP TABLE IF EXISTS `iospush_userdevice`;
CREATE TABLE `iospush_userdevice` (
  `uid` int(11) NOT NULL,
  `device_id` varchar(32) NOT NULL,
  `push_token` varchar(71) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "iospush_userdevice"
#

/*!40000 ALTER TABLE `iospush_userdevice` DISABLE KEYS */;
/*!40000 ALTER TABLE `iospush_userdevice` ENABLE KEYS */;

#
# Source for table "keyvalue"
#

DROP TABLE IF EXISTS `keyvalue`;
CREATE TABLE `keyvalue` (
  `key` varchar(64) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "keyvalue"
#

/*!40000 ALTER TABLE `keyvalue` DISABLE KEYS */;
/*!40000 ALTER TABLE `keyvalue` ENABLE KEYS */;

#
# Source for table "message"
#

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_uid` int(11) NOT NULL COMMENT 'from_uid=0表示系统消息',
  `to_uid` int(11) NOT NULL,
  `from_delete` tinyint(1) NOT NULL DEFAULT '0',
  `to_delete` tinyint(1) NOT NULL DEFAULT '0',
  `timeline` datetime DEFAULT NULL,
  `content` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "message"
#

/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;

#
# Source for table "money_data"
#

DROP TABLE IF EXISTS `money_data`;
CREATE TABLE `money_data` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) DEFAULT NULL,
  `datatime` datetime DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT '支出，收入',
  `money` int(11) DEFAULT NULL,
  `who` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=gb2312;

#
# Data for table "money_data"
#

INSERT INTO `money_data` VALUES (1,'1','2012-11-22 00:00:00','支出',11,'梁家荣'),(2,'22','2012-11-22 00:00:00','支出',22,'梁家荣'),(3,'11','2012-11-22 00:00:00','支出',11,'11'),(4,'11','2012-11-22 00:00:00','支出',11,'11'),(5,'22','2012-11-22 00:00:00','支出',22,'22'),(6,'22','2012-11-22 00:00:00','支出',22,'22'),(7,'33','2012-11-22 00:00:00','支出',33,'33'),(8,'11','2012-11-22 00:00:00','支出',11,'11'),(9,'111','2012-11-22 00:00:00','支出',111,'111'),(10,'22','2012-11-22 00:00:00','支出',22,'22'),(11,'22','2012-11-22 00:00:00','支出',22,'222'),(12,'22','2012-11-22 00:00:00','支出',22,'222'),(13,'22','2012-11-22 00:00:00','支出',22,'22'),(14,'22','2012-11-22 00:00:00','支出',22,'22'),(16,'11','2012-11-22 00:00:00','收入',11,'111');

#
# Source for table "note"
#

DROP TABLE IF EXISTS `note`;
CREATE TABLE `note` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL,
  `content` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "note"
#

/*!40000 ALTER TABLE `note` DISABLE KEYS */;
/*!40000 ALTER TABLE `note` ENABLE KEYS */;

#
# Source for table "notice"
#

DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `to_uid` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=todo;2=feed',
  `content` varchar(255) NOT NULL,
  `data` varchar(255) DEFAULT NULL,
  `timeline` datetime DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "notice"
#

/*!40000 ALTER TABLE `notice` DISABLE KEYS */;
/*!40000 ALTER TABLE `notice` ENABLE KEYS */;

#
# Source for table "online"
#

DROP TABLE IF EXISTS `online`;
CREATE TABLE `online` (
  `uid` int(11) NOT NULL,
  `last_active` datetime NOT NULL,
  `session` varchar(32) NOT NULL,
  `device` varchar(32) DEFAULT NULL,
  `place` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `last_active` (`last_active`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "online"
#

/*!40000 ALTER TABLE `online` DISABLE KEYS */;
INSERT INTO `online` VALUES (21,'2013-08-20 16:52:28','7i7o8jmn7dvt31kmljlr3tjl42','web',NULL);
/*!40000 ALTER TABLE `online` ENABLE KEYS */;

#
# Source for table "plugin"
#

DROP TABLE IF EXISTS `plugin`;
CREATE TABLE `plugin` (
  `folder_name` varchar(32) NOT NULL,
  `on` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`folder_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "plugin"
#

/*!40000 ALTER TABLE `plugin` DISABLE KEYS */;
/*!40000 ALTER TABLE `plugin` ENABLE KEYS */;

#
# Source for table "stoken"
#

DROP TABLE IF EXISTS `stoken`;
CREATE TABLE `stoken` (
  `uid` int(11) NOT NULL,
  `token` varchar(32) NOT NULL,
  `on` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "stoken"
#

/*!40000 ALTER TABLE `stoken` DISABLE KEYS */;
/*!40000 ALTER TABLE `stoken` ENABLE KEYS */;

#
# Source for table "task_evaluate"
#

DROP TABLE IF EXISTS `task_evaluate`;
CREATE TABLE `task_evaluate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `work_hours` double(8,1) DEFAULT NULL,
  `uname` varchar(11) DEFAULT NULL,
  `evaluate_date` date DEFAULT NULL,
  `score` double(8,1) DEFAULT NULL,
  `is_evaluate` int(11) DEFAULT '0' COMMENT '0：未评分，1：已评分',
  `add_work_hours` double(8,1) DEFAULT NULL,
  `owner_uid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "task_evaluate"
#

/*!40000 ALTER TABLE `task_evaluate` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_evaluate` ENABLE KEYS */;

#
# Source for table "todo"
#

DROP TABLE IF EXISTS `todo`;
CREATE TABLE `todo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `timeline` datetime DEFAULT NULL,
  `owner_uid` int(11) DEFAULT NULL,
  `comment_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "todo"
#

/*!40000 ALTER TABLE `todo` DISABLE KEYS */;
/*!40000 ALTER TABLE `todo` ENABLE KEYS */;

#
# Source for table "todo_history"
#

DROP TABLE IF EXISTS `todo_history`;
CREATE TABLE `todo_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `content` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=action;2=comment',
  `timeline` datetime DEFAULT NULL,
  `device` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "todo_history"
#

/*!40000 ALTER TABLE `todo_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `todo_history` ENABLE KEYS */;

#
# Source for table "todo_user"
#

DROP TABLE IF EXISTS `todo_user`;
CREATE TABLE `todo_user` (
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `is_star` int(11) NOT NULL DEFAULT '0',
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `is_follow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否订阅',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=added,2=doing,3=done',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `last_action_at` datetime DEFAULT NULL,
  UNIQUE KEY `tid` (`tid`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "todo_user"
#

/*!40000 ALTER TABLE `todo_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `todo_user` ENABLE KEYS */;

#
# Source for table "url"
#

DROP TABLE IF EXISTS `url`;
CREATE TABLE `url` (
  `url` varchar(255) NOT NULL,
  `code` varchar(16) NOT NULL,
  KEY `code` (`code`),
  KEY `url` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "url"
#

/*!40000 ALTER TABLE `url` DISABLE KEYS */;
/*!40000 ALTER TABLE `url` ENABLE KEYS */;

#
# Source for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'uid',
  `name` varchar(32) NOT NULL,
  `pinyin` varchar(32) DEFAULT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL COMMENT 'md5后的值',
  `avatar_small` varchar(255) DEFAULT NULL,
  `avatar_normal` varchar(255) DEFAULT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户组',
  `timeline` datetime DEFAULT NULL,
  `settings` mediumtext,
  `is_closed` tinyint(1) NOT NULL DEFAULT '0',
  `mobile` varchar(32) DEFAULT NULL,
  `tel` varchar(32) DEFAULT NULL,
  `eid` varchar(32) DEFAULT NULL COMMENT '员工号',
  `weibo` varchar(32) DEFAULT NULL,
  `desp` text,
  `groups` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `email` (`email`),
  KEY `is_closed` (`is_closed`),
  KEY `groups` (`groups`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

#
# Data for table "user"
#

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin1','admin','member@teamtoy.netclosed-1-1366678770','be78f09576fda3e5a2c91746b18f74','','',0,'2012-11-26 17:37:03','',1,'','','','','',NULL),(2,'余健','yujian','yujian@sinobest.cn','1cc2021aca98d668ea5b226f6df9ae','http://192.168.1.35\\static\\upload\\avatar\\avatar-2.jpg',NULL,9,'2013-04-23 08:59:01',NULL,0,'13760666747','020-85574999-8226','01233','','QQ号=最顶邮箱地址',NULL),(3,'黄锦芳','huangjinfang','huangjinfang@sinobest.cn','fdedb7e21b6d0ec37e9ef26512c5d1','http://192.168.1.35\\static\\upload\\avatar\\avatar-3.jpg',NULL,9,'2013-04-23 10:01:18',NULL,0,'13662301147','8119','01279','','QQ:1131167754',NULL),(4,'阳爱春','yangaichun','yangaichun@sinobest.cn','9192293060ae65f0ce0ff35617d462',NULL,NULL,1,'2013-04-27 10:42:04',NULL,0,'13660823426','8128','01287','','QQ:594005087',NULL),(5,'詹铤伟','zhanwei','zhantingwei@sinobest.cn','26198becbb5a37d50b773c4550de9a','http://192.168.1.35\\static\\upload\\avatar\\avatar-5.jpg',NULL,1,'2013-04-27 10:42:47',NULL,0,'13570922965','8624','01520','番禺羊城通','mr.james@foxmail.com',NULL),(6,'雷静','leijing','leijing@sinobest.cn','1d05ae9ec92ac3320f99d8057581ca','http://192.168.1.35\\static\\upload\\avatar\\avatar-6.jpg',NULL,1,'2013-04-27 10:43:07',NULL,0,'13798178102','','01755','','',NULL),(7,'钟和锦','zhonghejin','zhonghejin@sinobest.cn','6342fb2ff63a3e2a7d81aef6b6cebd','http://192.168.1.35\\static\\upload\\avatar\\avatar-7.jpg',NULL,1,'2013-04-27 10:43:29',NULL,0,'15915847991','','01816','','',NULL),(8,'彭健锵','pengjian','pengjianqiang@sinobest.cn','da53c034ea5b8bc8eff18dacd34bf1','http://192.168.1.35\\static\\upload\\avatar\\avatar-8.jpg',NULL,1,'2013-04-27 10:43:48',NULL,0,'15018787551','','01826','','QQ:298048508',NULL),(9,'吴润彬','wurunbin','wurunbin@sinobest.cn','ab55366aacca957244e1f9aa53f5db','http://192.168.1.35\\static\\upload\\avatar\\avatar-9.jpg',NULL,1,'2013-04-27 10:44:10',NULL,0,'15915738209','','01827','','',NULL),(10,'赖世豪','laishihao','laishihao@sinobest.cn','b3e042dabfc58ec2a71c882c6f7e29',NULL,NULL,1,'2013-04-27 10:44:27',NULL,0,'15013105334','','01865','','',NULL),(11,'雷理超','leilichao','leilichao@sinobest.cn','598b49d46cc964c2f503193b30b499','http://192.168.1.35\\static\\upload\\avatar\\avatar-11.jpg',NULL,1,'2013-04-27 10:44:45',NULL,0,'13450461437','','01876','','QQ:763658083',NULL),(12,'潘高云','pangaoyun','pangaoyun@sinobest.cn','7321d4a3ebce3d505f14de5a061438','http://192.168.1.35\\static\\upload\\avatar\\avatar-12.jpg',NULL,1,'2013-04-27 10:45:03',NULL,0,'13539426597','','01893','','QQ104897226',NULL),(13,'熊有强13','xiongyouqiang','xiongyouqiang@sinobest.cnclosed-13-1373418555','95114c045b4f9652fcc265ab6b0046','http://192.168.1.35\\static\\upload\\avatar\\avatar-13.jpg',NULL,0,'2013-04-27 10:45:24',NULL,1,'18898416969','','90442','','',NULL),(14,'梁浩鹏','lianghaopeng','lianghaopeng@sinobest.cn','7886c3396be5a061dc5d9af627c88c',NULL,NULL,1,'2013-04-27 10:45:43',NULL,0,'18520127104','','02098','','qq:748003752',NULL),(15,'罗育权15','luoyuquan','luoyuquan@sinobest.cnclosed-15-1371518709','f931c6564a58496ed8d7d437038192','http://192.168.1.35\\static\\upload\\avatar\\avatar-15.jpg',NULL,0,'2013-04-27 10:46:04',NULL,1,'13416199386','','90467','','QQ：534845804',NULL),(16,'许江洋','xujiangyang','xujiangyang@sinobest.cn','54bbb821254831514f4ff7215f186b',NULL,NULL,9,'2013-04-27 10:46:55',NULL,0,NULL,NULL,'01408',NULL,NULL,NULL),(17,'郑刚','zhenggang','zhenggang@sinobest.cn','dc90ca7f6f55255f127cc462780dca',NULL,NULL,9,'2013-04-27 10:47:15',NULL,0,'13570257607','','00362','','',NULL),(18,'刘作蕊','liuzuorui','liuzuorui@sinobest.cn','b2022dab7d70748759852456b3404f','http://192.168.1.35\\static\\upload\\avatar\\avatar-18.jpg',NULL,1,'2013-05-06 11:40:15',NULL,0,'15521222592','8220','02001','','',NULL),(19,'代幸','daixing','daixing@sinobest.cn','0ef868227d91d611efa910c0145586',NULL,NULL,1,'2013-05-21 09:19:44',NULL,0,'13760744275','','02010','','QQ772584176',NULL),(20,'梁巨锋','liangjufeng','liangjufeng@sinobest.cn','a1e68c2961c39ef14a965c862a249e',NULL,NULL,1,'2013-05-21 09:20:12',NULL,0,'15913583690','','02011','','',NULL),(21,'梁家荣','liangjiarong','liangjiarong@sinobest.cn','146d8e829737e90915fc4ee05c4d16',NULL,NULL,9,'2013-05-21 14:00:31',NULL,0,'15521005490','','90557','','',NULL),(22,'陈友煌','chenyouhuang','chenyouhuang@sinobest.cn','ea5af083d09bf54371816ad635178a',NULL,NULL,1,'2013-05-27 09:17:24',NULL,0,'15989071203','8628','90559','陈_友煌','',NULL),(23,'刘俊所','liujunsuo','liuhongde@sinobest.cn','795b684c69a17bd3b960a9ad4efe94d4',NULL,NULL,1,'2013-07-17 14:52:59',NULL,0,NULL,NULL,'00006',NULL,NULL,NULL),(24,'张静','zhangjin','zhangjin@dream.com','ddb82c1e6c3a1f50c5f8747e07b2c5',NULL,NULL,9,'2013-05-27 09:17:24',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

#
# Source for table "user_attendance"
#

DROP TABLE IF EXISTS `user_attendance`;
CREATE TABLE `user_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(10) DEFAULT NULL,
  `score` int(3) DEFAULT '100',
  `month_comment` varchar(1024) DEFAULT NULL,
  `time_code` int(6) NOT NULL,
  `d1` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：假日与请假；0：未到的日子；1：上班；0.5：上班半天',
  `d2` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d3` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d4` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d5` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d6` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d7` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d8` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d9` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d10` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d11` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d12` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d13` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d14` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d15` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d16` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d17` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d18` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d19` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d20` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d21` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d22` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d23` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d24` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d25` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d26` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d27` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d28` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d29` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d30` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  `d31` double(2,1) NOT NULL DEFAULT '0.0' COMMENT '-1：公共假日与今天之后，0：请假，1：上班',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "user_attendance"
#


#
# Source for table "user_attendance_new"
#

DROP TABLE IF EXISTS `user_attendance_new`;
CREATE TABLE `user_attendance_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(10) DEFAULT NULL,
  `score` int(3) NOT NULL,
  `month_comment` varchar(1024) DEFAULT NULL,
  `time_code` int(6) NOT NULL,
  `d1` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '小数点左边为上午状态，右边为下午   0：事假  1：上班   2：病假   3：年假    4：正常假期   5：外勤   6：迟到    7：丧假    8：婚假     9：计划生育假    11：忘打卡    12：补休     13：旷工',
  `d2` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d3` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d4` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d5` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d6` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d7` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d8` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d9` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d10` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d11` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d12` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d13` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d14` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d15` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d16` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d17` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d18` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d19` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d20` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d21` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d22` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d23` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d24` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d25` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d26` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d27` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d28` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d29` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d30` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  `d31` double(4,2) NOT NULL DEFAULT '1.10' COMMENT '同上',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "user_attendance_new"
#

