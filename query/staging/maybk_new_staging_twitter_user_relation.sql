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
-- Table structure for table `twitter_user_relation`
--

DROP TABLE IF EXISTS `twitter_user_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twitter_user_relation` (
  `relation_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `channel_id` int(11) NOT NULL,
  `twitter_user_id` bigint(20) NOT NULL,
  `is_following` tinyint(4) DEFAULT '0',
  `is_follower` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`relation_id`),
  KEY `fk_twitter_user_friends_channel1_idx` (`channel_id`),
  KEY `fk_twitter_user_friends_twitter_user_engaged1_idx` (`twitter_user_id`),
  CONSTRAINT `fk_twitter_user_friends_channel1` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`channel_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_twitter_user_friends_twitter_user_engaged1` FOREIGN KEY (`twitter_user_id`) REFERENCES `twitter_user_engaged` (`twitter_user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twitter_user_relation`
--

LOCK TABLES `twitter_user_relation` WRITE;
/*!40000 ALTER TABLE `twitter_user_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `twitter_user_relation` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-09 12:15:01