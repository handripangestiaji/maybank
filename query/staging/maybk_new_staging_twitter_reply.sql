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
-- Table structure for table `twitter_reply`
--

DROP TABLE IF EXISTS `twitter_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twitter_reply` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `reply_to_post_id` bigint(20) NOT NULL,
  `text` varchar(140) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `image_to_post` varchar(255) DEFAULT NULL,
  `reply_type` varchar(45) DEFAULT NULL,
  `content_products_id` int(11) DEFAULT NULL,
  `response_post_id` bigint(20) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `is_replied_by_user` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_twitter_reply_social_stream1_idx` (`reply_to_post_id`),
  KEY `fk_twitter_reply_content_products1_idx` (`content_products_id`),
  KEY `fk_twitter_reply_social_stream2_idx` (`response_post_id`),
  KEY `fk_twitter_reply_user1_idx` (`user_id`),
  CONSTRAINT `fk_twitter_reply_content_products1` FOREIGN KEY (`content_products_id`) REFERENCES `content_products` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `fk_twitter_reply_social_stream1` FOREIGN KEY (`reply_to_post_id`) REFERENCES `social_stream` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_twitter_reply_social_stream2` FOREIGN KEY (`response_post_id`) REFERENCES `social_stream` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_twitter_reply_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twitter_reply`
--

LOCK TABLES `twitter_reply` WRITE;
/*!40000 ALTER TABLE `twitter_reply` DISABLE KEYS */;
/*!40000 ALTER TABLE `twitter_reply` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-09 12:06:49
