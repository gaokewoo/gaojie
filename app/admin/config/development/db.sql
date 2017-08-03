-- MySQL dump 10.13  Distrib 5.7.12, for osx10.11 (x86_64)
--
-- Host: localhost    Database: gaojie_admin
-- ------------------------------------------------------
-- Server version	5.7.12

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `log_behavior`
--

DROP TABLE IF EXISTS `log_behavior`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_behavior` (
  `log_behavior_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `portal` char(100) NOT NULL DEFAULT '' COMMENT '入口',
  `controller` char(100) NOT NULL DEFAULT '' COMMENT '控制器',
  `action` char(100) NOT NULL DEFAULT '' COMMENT '动作',
  `get` text NOT NULL COMMENT 'get参数',
  `post` text NOT NULL COMMENT 'post参数',
  `message` text NOT NULL COMMENT '信息',
  `ip` char(100) NOT NULL DEFAULT '' COMMENT 'ip地址',
  `user_agent` char(200) NOT NULL DEFAULT '' COMMENT '用户代理',
  `referer` char(255) DEFAULT NULL COMMENT 'referer',
  `manager_id` int(10) NOT NULL DEFAULT '0' COMMENT '帐号id',
  `manager_name` char(100) NOT NULL DEFAULT '' COMMENT '帐号名',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`log_behavior_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='行为日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_behavior`
--

LOCK TABLES `log_behavior` WRITE;
/*!40000 ALTER TABLE `log_behavior` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_behavior` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_crash`
--

DROP TABLE IF EXISTS `log_crash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_crash` (
  `log_crash_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '异常日志id',
  `ip` varchar(20) NOT NULL DEFAULT '' COMMENT 'IP',
  `hostname` varchar(100) NOT NULL DEFAULT '' COMMENT '服务器名',
  `level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '级别',
  `file` varchar(256) NOT NULL DEFAULT '' COMMENT '文件',
  `line` int(10) NOT NULL DEFAULT '0' COMMENT '行数',
  `message` text NOT NULL COMMENT '信息',
  `trace` text NOT NULL COMMENT '追踪信息',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`log_crash_id`),
  KEY `ip` (`ip`),
  KEY `hostname` (`hostname`),
  KEY `file` (`file`(255))
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='异常日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_crash`
--

LOCK TABLES `log_crash` WRITE;
/*!40000 ALTER TABLE `log_crash` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_crash` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manager`
--

DROP TABLE IF EXISTS `manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manager` (
  `manager_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `given_name` char(32) NOT NULL DEFAULT '' COMMENT '姓名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '员工类型 0正式员工 1实习生 2兼职 3合作方',
  `staff_id` char(20) NOT NULL DEFAULT '' COMMENT '工号',
  `email` char(100) NOT NULL DEFAULT '' COMMENT '邮件',
  `phone` char(20) NOT NULL DEFAULT '' COMMENT '电话',
  `mobile` char(18) NOT NULL DEFAULT '' COMMENT '手机',
  `weibo_uid` char(20) NOT NULL DEFAULT '' COMMENT '微博uid',
  `approve_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态，0未审核 1通过 -1拒绝',
  `login_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '登录类型，0未选择 1Staff登录 2密码登录 3机构登录',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 －1删除 0默认 1禁用',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`manager_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manager`
--

LOCK TABLES `manager` WRITE;
/*!40000 ALTER TABLE `manager` DISABLE KEYS */;
INSERT INTO `manager` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e',0,'0','gaojie','111111','15010240697','0',1,0,0,1457080773,1489547952);
/*!40000 ALTER TABLE `manager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `module_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '模块id',
  `name` char(100) NOT NULL DEFAULT '' COMMENT '模块名',
  `module` char(100) NOT NULL DEFAULT '' COMMENT '模块',
  `portal` char(100) NOT NULL DEFAULT '' COMMENT '入口文件',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 －1删除 0默认',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='模块表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES (1,'默认','','index.php',0,1457940110,1458195095);
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `privilege`
--

DROP TABLE IF EXISTS `privilege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `privilege` (
  `privilege_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '权限名',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级',
  `path` char(200) NOT NULL DEFAULT '' COMMENT '路径',
  `module_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模块id',
  `domain` char(100) NOT NULL DEFAULT '' COMMENT '域名',
  `portal` char(50) NOT NULL DEFAULT '' COMMENT '默认文件',
  `module` char(100) NOT NULL DEFAULT '' COMMENT '模块',
  `controller` char(100) NOT NULL DEFAULT '' COMMENT '控制器',
  `action` char(100) NOT NULL DEFAULT '' COMMENT '动作',
  `target` char(255) NOT NULL DEFAULT '' COMMENT '目标地址，仅外部系统填充',
  `icon` char(100) NOT NULL DEFAULT '' COMMENT '图标（用于展示)',
  `type` enum('controller','menu','navigator') NOT NULL DEFAULT 'controller' COMMENT '权限类型：控制器、菜单、导航',
  `is_display` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示：0不显示 1显示',
  `sequence` int(10) NOT NULL DEFAULT '0' COMMENT '排序(越小越靠前)',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`privilege_id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8 COMMENT='权限（动作）表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privilege`
--

LOCK TABLES `privilege` WRITE;
/*!40000 ALTER TABLE `privilege` DISABLE KEYS */;
INSERT INTO `privilege` VALUES (1,'系统',0,'0,1,',1,'','index.php','','','','','fa-wrench','menu',1,0,1458197342,1458197342),(3,'管理员管理',45,'0,45,3,',1,'','index.php','','manager','list','','','controller',1,0,1458287219,1458287219),(4,'角色管理',45,'0,45,4,',1,'','index.php','','role','list','','','controller',1,1,1458287266,1458287266),(5,'模块管理',1,'0,1,5,',1,'','index.php','','module','list','','','controller',1,2,1458287302,1458287302),(6,'权限管理',1,'0,1,9,',1,'','index.php','','privilege','list','','','controller',1,3,1458556357,1458556357),(8,'异常日志',1,'0,1,12,',1,'','index.php','','log','crash','','','controller',1,5,1458630081,1458630081),(10,'添加管理员',45,'0,45,10,',1,'','index.php','','manager','add','','','controller',0,10,1460368014,1460368014),(11,'添加管理员保存',45,'0,45,11,',1,'','index.php','','manager','save','','','controller',0,11,1460369283,1460369283),(12,'编辑管理员',45,'0,45,12,',1,'','index.php','','manager','edit','','','controller',0,12,1460369331,1460369331),(13,'编辑管理员保存',45,'0,45,13,',1,'','index.php','','manager','modify','','','controller',0,13,1460369362,1460369362),(14,'启用管理员',45,'0,45,14,',1,'','index.php','','manager','enable','','','controller',0,14,1460369476,1460369476),(15,'禁用管理员',45,'0,45,15,',1,'','index.php','','manager','disable','','','controller',0,15,1460369505,1460369505),(21,'添加角色',45,'0,45,21,',1,'','index.php','','role','add','','','controller',0,21,1460369814,1460369814),(22,'添加角色保存',45,'0,45,22,',1,'','index.php','','role','save','','','controller',0,22,1460369839,1460369839),(23,'编辑角色',45,'0,45,23,',1,'','index.php','','role','edit','','','controller',0,23,1460369864,1460369864),(24,'编辑角色保存',45,'0,45,24,',1,'','index.php','','role','modify','','','controller',0,24,1460369898,1460369898),(25,'删除角色',45,'0,45,25,',1,'','index.php','','role','delete','','','controller',0,24,1460369944,1460369944),(26,'角色成员',45,'0,45,26,',1,'','index.php','','role','members','','','controller',0,25,1460369988,1460369988),(27,'角色权限列表',45,'0,45,27,',1,'','index.php','','role','privileges','','','controller',0,26,1460370032,1460370032),(28,'添加角色权限',45,'0,45,28,',1,'','index.php','','role','addPrivilege','','','controller',0,27,1460370076,1460370076),(29,'删除角色权限',45,'0,45,29,',1,'','index.php','','role','removePrivilege','','','controller',0,29,1460370110,1460370110),(30,'添加模块',1,'0,1,35,',1,'','index.php','','module','add','','','controller',0,30,1460370300,1460370300),(31,'添加模块保存',1,'0,1,36,',1,'','index.php','','module','save','','','controller',0,31,1460370327,1460370327),(32,'编辑模块',1,'0,1,37,',1,'','index.php','','module','edit','','','controller',0,32,1460370354,1460370354),(33,'编辑模块保存',1,'0,1,38,',1,'','index.php','','module','modify','','','controller',0,33,1460370389,1460370389),(34,'删除模块',1,'0,1,39,',1,'','index.php','','module','delete','','','controller',0,34,1460370411,1460370411),(45,'账号',0,'0,45,',1,'','index.php','','','','','','menu',1,1,1482727602,1482727602),(52,'系统日志',1,'0,1,52,',1,'','index.php','','Log','behavior','','','controller',1,36,1468811247,1468811247),(127,'添加权限',1,'0,1,127,',1,'','index.php','','privilege','add','','','controller',0,4,1490855619,1490855619),(128,'保存权限',1,'0,1,128,',1,'','index.php','','privilege','save','','','controller',0,5,1490855658,1490855658),(130,'编辑权限',1,'0,1,130,',1,'','index.php','','privilege','edit','','','controller',0,6,1490856145,1490856145),(131,'编辑权限保存',1,'0,1,131,',1,'','index.php','','privilege','modify','','','controller',0,7,1490856178,1490856178);
/*!40000 ALTER TABLE `privilege` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `role_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `name` char(10) NOT NULL DEFAULT '' COMMENT '角色名称',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='角色表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'超级管理员',1457080773,1491088745);
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_manager`
--

DROP TABLE IF EXISTS `role_manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_manager` (
  `role_manager_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `manager_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`role_manager_id`)
) ENGINE=InnoDB AUTO_INCREMENT=262 DEFAULT CHARSET=utf8 COMMENT='用户角色关系表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_manager`
--

LOCK TABLES `role_manager` WRITE;
/*!40000 ALTER TABLE `role_manager` DISABLE KEYS */;
INSERT INTO `role_manager` VALUES (261,1,1,1491275269);
/*!40000 ALTER TABLE `role_manager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_privilege`
--

DROP TABLE IF EXISTS `role_privilege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_privilege` (
  `role_privilege_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `privilege_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '权限id',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`role_privilege_id`)
) ENGINE=InnoDB AUTO_INCREMENT=701 DEFAULT CHARSET=utf8 COMMENT='用户角色关系表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_privilege`
--

LOCK TABLES `role_privilege` WRITE;
/*!40000 ALTER TABLE `role_privilege` DISABLE KEYS */;
INSERT INTO `role_privilege` VALUES (1,1,1,1464938656),(3,1,3,1464938656),(4,1,4,1464938656),(5,1,5,1464938656),(6,1,6,1464938656),(8,1,8,1464938656),(9,1,9,1464938656),(10,1,10,1464938656),(11,1,11,1464938656),(12,1,12,1464938656),(13,1,13,1464938656),(14,1,14,1464938656),(15,1,15,1464938656),(16,1,16,1464938656),(17,1,17,1464938656),(18,1,18,1464938656),(19,1,19,1464938656),(20,1,20,1464938656),(21,1,21,1464938656),(22,1,22,1464938656),(23,1,23,1464938656),(24,1,24,1464938656),(25,1,25,1464938656),(26,1,26,1464938656),(27,1,27,1464938656),(28,1,28,1464938656),(29,1,29,1464938656),(30,1,30,1464938656),(31,1,31,1464938656),(32,1,32,1464938656),(33,1,33,1464938656),(34,1,34,1464938656),(35,1,35,1464938656),(45,1,45,1464938656),(88,1,52,1468811401),(106,1,53,1468812240),(108,1,54,1468812244),(112,1,47,1468821205),(113,1,49,1468821489),(116,1,48,1468826419),(119,1,55,1470214888),(120,1,58,1474875871),(121,1,56,1474876041),(123,1,61,1482728663),(127,1,66,1482979564),(128,1,67,1482979564),(129,1,68,1482979565),(130,1,69,1482987828),(131,1,70,1482987830),(133,1,71,1483066773),(558,1,128,1490855680),(559,1,127,1490855681),(560,1,131,1490856190),(561,1,130,1490856192),(584,1,139,1491036755),(585,1,140,1491036755),(659,1,50,1491036907),(660,1,51,1491036908),(695,1,133,1491220160),(696,1,134,1491220160),(697,1,135,1491220160),(698,1,136,1491220160),(699,1,137,1491220160),(700,1,138,1491220160);
/*!40000 ALTER TABLE `role_privilege` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `session_id` varchar(24) NOT NULL DEFAULT '' COMMENT 'Session id',
  `last_active` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Last active time',
  `contents` text NOT NULL COMMENT 'Session data',
  PRIMARY KEY (`session_id`),
  KEY `last_active` (`last_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会话信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-04 17:28:22
