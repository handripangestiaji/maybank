CREATE DATABASE  IF NOT EXISTS `maybk_new_staging` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `maybk_new_staging`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: maybank.cjfesjlc1cr5.ap-southeast-1.rds.amazonaws.com    Database: maybk_new_staging
-- ------------------------------------------------------
-- Server version	5.6.19-log

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
-- Table structure for table `social_stream_facebook_conversation`
--

DROP TABLE IF EXISTS `social_stream_facebook_conversation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_stream_facebook_conversation` (
  `conversation_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `snippet` varchar(255) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `message_count` int(11) DEFAULT NULL,
  `unread_count` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '1 = show\n0 = hide\n\n',
  PRIMARY KEY (`conversation_id`),
  CONSTRAINT `fk_social_stream_facebook_conversation_social_stream1` FOREIGN KEY (`conversation_id`) REFERENCES `social_stream` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1515620 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_stream_facebook_conversation`
--

LOCK TABLES `social_stream_facebook_conversation` WRITE;
/*!40000 ALTER TABLE `social_stream_facebook_conversation` DISABLE KEYS */;
INSERT INTO `social_stream_facebook_conversation` VALUES (1245679,'test','2014-08-20 04:28:25',60,0,1),(1245680,'test engagement','2014-09-09 08:02:06',41,0,1),(1245681,'I care 2 more lines..\n\nthis line number 2 you know?  \n\nhttp://maybk.co/1f271b','2014-04-07 09:41:11',36,0,1),(1245682,'engquiry','2014-04-07 07:56:55',29,0,1),(1245683,'PM PM PM PM.... U read my PM?','2015-02-04 10:27:09',15,0,1),(1245684,'dont do anything... ','2014-03-13 05:01:58',3,0,1),(1245685,'are you sure>> http://maybk.co/ae7b78','2014-04-03 04:38:13',4,0,1),(1245686,'Yeah... so very private... shhhhhh.','2014-03-25 09:27:41',2,0,1),(1245687,'Action taken- case resolved. ','2013-07-09 08:03:11',9,0,1),(1245688,'Reply to test case, and it\'s done. ','2013-04-26 02:32:12',9,0,1),(1245689,NULL,'2014-04-02 07:25:27',3,0,1),(1245690,'done ','2013-01-28 21:37:58',6,0,1),(1245966,'tengil !','2014-09-10 03:44:24',10,0,1),(1248681,'PM reply with image','2014-03-26 07:24:32',3,0,1),(1248695,NULL,'2014-03-25 09:18:38',6,0,1),(1248845,'Hey there!','2014-03-25 09:40:52',4,0,1),(1258888,'Hi Ms Syam,\r\n\r\nThanks for the inquiry. We will get the team to assist you shortly. ','2013-06-04 02:31:30',5,0,1),(1258889,'#Nicole reply to Granzon Playground - MB2 message\n\nNoted with thanks!','2013-03-06 03:08:29',3,0,1),(1262542,'Can you give me some money? LOL!','2014-04-03 07:47:10',3,0,1),(1406527,'How is the refresher course in Singapore?','2014-07-01 02:41:21',1,0,1),(1414123,'I would like to know what happened to my treatspoints they went missing.','2014-07-05 08:09:17',1,0,1),(1515619,'really?','2015-02-04 10:25:15',3,0,1);
/*!40000 ALTER TABLE `social_stream_facebook_conversation` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-09 12:06:33
