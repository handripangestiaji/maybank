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
-- Table structure for table `social_stream_youtube_comment`
--

DROP TABLE IF EXISTS `social_stream_youtube_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_stream_youtube_comment` (
  `post_id` bigint(20) NOT NULL,
  `google_user_id` varchar(32) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `user_id` varchar(45) DEFAULT NULL,
  `video_id` varchar(45) DEFAULT NULL,
  `youtube_post_id` bigint(20) NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `fk_social_stream_youtube_comment_social_stream_youtube1_idx` (`youtube_post_id`),
  KEY `fk_social_stream_youtube_comment_social_stream1_idx` (`post_id`),
  CONSTRAINT `fk_social_stream_youtube_comment_social_stream1` FOREIGN KEY (`post_id`) REFERENCES `social_stream` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_social_stream_youtube_comment_social_stream_youtube1` FOREIGN KEY (`youtube_post_id`) REFERENCES `social_stream_youtube` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_stream_youtube_comment`
--

LOCK TABLES `social_stream_youtube_comment` WRITE;
/*!40000 ALTER TABLE `social_stream_youtube_comment` DISABLE KEYS */;
INSERT INTO `social_stream_youtube_comment` VALUES (1515555,'110428300560330378309','Bena Waketversa','cdefgh﻿','cdefgh﻿','2014-11-08 05:37:54','woa3NwIBac77QfIEiUDM7A','ymKHdYFE7FI',1515554),(1515556,'110428300560330378309','Bena Waketversa','abcdef﻿','abcdef﻿','2014-11-08 05:36:30','woa3NwIBac77QfIEiUDM7A','ymKHdYFE7FI',1515554),(1515557,'110428300560330378309','Bena Waketversa','halo bena﻿','halo bena﻿','2014-11-07 10:40:39','woa3NwIBac77QfIEiUDM7A','ymKHdYFE7FI',1515554),(1515572,NULL,'Bena Waketversa','lah gw pikir siapa, ...','lah gw pikir siapa, si bdur... hahahha','2010-06-05 06:00:05','woa3NwIBac77QfIEiUDM7A','EMt7sFS9mOU',1515571),(1515573,NULL,'scratchieve','keren ni film anak ...','keren ni film anak negeri.','2010-06-02 03:27:31','34h3oqlXwLl4YkGtVL_vHA','EMt7sFS9mOU',1515571),(1515574,NULL,'Febriyanto Laksono','iyo masih hiduo itu ...','iyo masih hiduo itu?wkwkwk ','2013-07-18 04:44:29','a4M_Ori8Fmqetj0av2oZHw','EMt7sFS9mOU',1515571),(1515575,'110428300560330378309','Bena Waketversa','new comment﻿','new comment﻿','2014-11-07 09:41:58','woa3NwIBac77QfIEiUDM7A','EMt7sFS9mOU',1515571),(1515576,'110428300560330378309','Bena Waketversa','new comment﻿','new comment﻿','2014-11-07 07:29:09','woa3NwIBac77QfIEiUDM7A','EMt7sFS9mOU',1515571);
/*!40000 ALTER TABLE `social_stream_youtube_comment` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-09 12:16:12
