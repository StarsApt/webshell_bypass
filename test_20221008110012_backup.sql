-- MySQL dump 10.13  Distrib 5.7.26, for Win64 (x86_64)
--
-- Host: localhost    Database: test
-- ------------------------------------------------------
-- Server version	5.7.26

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
-- Table structure for table `moyu_cache`
--

DROP TABLE IF EXISTS `moyu_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moyu_cache` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `owner` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `space` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `upload` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=258 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moyu_cache`
--

LOCK TABLES `moyu_cache` WRITE;
/*!40000 ALTER TABLE `moyu_cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `moyu_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moyu_config`
--

DROP TABLE IF EXISTS `moyu_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moyu_config` (
  `k` varchar(32) NOT NULL,
  `v` text,
  PRIMARY KEY (`k`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moyu_config`
--

LOCK TABLES `moyu_config` WRITE;
/*!40000 ALTER TABLE `moyu_config` DISABLE KEYS */;
INSERT INTO `moyu_config` VALUES ('admin_user','admin'),('admin_pass','bb0871c971688caa1a4ffd86883dd312'),('title','Stars Anti'),('keywords','Stars Anti'),('description','Stars Anti'),('qunhao',''),('kfqq','无名'),('qqjump','1'),('hx','0'),('wd','0'),('mzphp','1'),('zym','0'),('sizekb','50'),('GongGao','新增jsp webshell免杀功能。暂时免杀安全狗，D盾，云锁，其它WAF自己测试功能。--2022年6月1日更新。<br/>\r\n新增php webshell免杀功能。暂时免杀安全狗，D盾，云锁，其它WAF自己测试功能。--2022年5月31日更新。\r\n'),('zhushi',''),('adminlogin','2022-10-08 10:52:47');
/*!40000 ALTER TABLE `moyu_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moyu_daili`
--

DROP TABLE IF EXISTS `moyu_daili`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moyu_daili` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(150) NOT NULL,
  `pass` varchar(150) NOT NULL,
  `qq` varchar(20) DEFAULT NULL,
  `rmb` int(100) NOT NULL DEFAULT '0',
  `last` datetime DEFAULT NULL,
  `dlip` varchar(15) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `citylist` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moyu_daili`
--

LOCK TABLES `moyu_daili` WRITE;
/*!40000 ALTER TABLE `moyu_daili` DISABLE KEYS */;
INSERT INTO `moyu_daili` VALUES (1,'test123','123456','1231254534',888,'2022-10-08 08:52:23','4.91.95.10',1,NULL),(2,'hack2026','Stars Anti.','123456',100,'2022-06-02 15:18:11','172.30.0.89',1,NULL),(3,'lj','a123456@','123456',0,NULL,NULL,1,NULL),(4,'chen','123321ab','824211592',18,'2022-06-02 19:49:08','22.80.192.97',1,NULL),(5,'whoareyou','a123456','',100,NULL,NULL,1,NULL),(6,'qwer123','qwerasdf','874581112',0,'2022-06-02 18:25:37','103.17.155.1',1,NULL),(7,'power5','1!2@3#','2237918535',0,'2022-06-02 22:28:19','4.78.106.58',1,NULL),(8,'660012','660012','660012',0,'2022-06-08 19:58:06','223.104.27.8',1,NULL),(9,'ww','a123456@','',50,'2022-06-23 11:55:52','8.18.184.87',1,NULL),(10,'Pn5el00','mSA$vw$5Ols0I6@#','240258629',50,'2022-06-16 11:41:06','1.18.243.15',1,NULL),(11,'ww','a123456@','',20,'2022-06-23 11:55:52','6.18.184.87',1,'');
/*!40000 ALTER TABLE `moyu_daili` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moyu_km`
--

DROP TABLE IF EXISTS `moyu_km`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moyu_km` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `km` text,
  `money` varchar(30) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moyu_km`
--

LOCK TABLES `moyu_km` WRITE;
/*!40000 ALTER TABLE `moyu_km` DISABLE KEYS */;
INSERT INTO `moyu_km` VALUES (1,'lye2pe805h','10','0'),(2,'19u4z4vsd4','10','0'),(3,'idueh4f6kb','10','0'),(4,'tvaii58sb0','10','0'),(5,'rjzxabet2u','10','0'),(6,'0ez948g8wk','10','0'),(7,'n20yu9q1c6','10','0'),(8,'c8c6krsno9','10','0'),(9,'k6txnbekeb','10','0'),(10,'gp0scesbva','10','0'),(11,'xgxrwuzs9b','10','0'),(12,'qb6oktzdk1','10','0'),(13,'abpddhwzgr','10','0'),(14,'4z34i3t3hd','10','0'),(15,'m7fznj3x4m','10','0'),(16,'aved3bu1tw','10','0'),(17,'83lal9u1kn','10','0'),(18,'dwv6dy4rnl','10','0'),(19,'ntovimar6n','10','0'),(20,'zopnrwxt5p','10','0');
/*!40000 ALTER TABLE `moyu_km` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moyu_pay`
--

DROP TABLE IF EXISTS `moyu_pay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moyu_pay` (
  `trade_no` varchar(64) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `zid` int(11) unsigned NOT NULL DEFAULT '1',
  `tid` int(11) NOT NULL,
  `input` text NOT NULL,
  `num` int(11) unsigned NOT NULL DEFAULT '1',
  `addtime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `money` varchar(32) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `user` varchar(32) DEFAULT NULL,
  `inviteid` int(11) unsigned DEFAULT NULL,
  `domain` varchar(64) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trade_no`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moyu_pay`
--

LOCK TABLES `moyu_pay` WRITE;
/*!40000 ALTER TABLE `moyu_pay` DISABLE KEYS */;
/*!40000 ALTER TABLE `moyu_pay` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-08 11:00:13
