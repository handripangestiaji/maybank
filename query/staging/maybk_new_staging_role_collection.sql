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
-- Table structure for table `role_collection`
--

DROP TABLE IF EXISTS `role_collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_collection` (
  `role_collection_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `country_code` char(3) DEFAULT NULL,
  PRIMARY KEY (`role_collection_id`),
  KEY `role_collection_country_code_idx` (`country_code`),
  CONSTRAINT `role_collection_country_code` FOREIGN KEY (`country_code`) REFERENCES `country` (`code`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_collection`
--

LOCK TABLES `role_collection` WRITE;
/*!40000 ALTER TABLE `role_collection` DISABLE KEYS */;
INSERT INTO `role_collection` VALUES (10,'Tech',392227,'2014-02-12 04:51:35','All'),(11,'Group Admin',392226,'2014-02-27 10:42:19','All'),(12,'Group Viewer',392226,'2014-03-11 11:38:05','All'),(15,'MY-Country Admin',392227,'2014-03-29 07:45:39','MY'),(16,'MY-Manager',392227,'2014-03-29 07:46:56','MY'),(17,'MY-Author',392227,'2014-03-29 07:47:12','MY'),(18,'MY-Viewer',392227,'2014-03-29 07:47:24','MY'),(21,'SG-Country Admin',392227,'2014-03-29 07:47:24','SG'),(22,'SG-Manager',392227,'2014-03-29 07:47:24','SG'),(23,'SG-Author',392227,'2014-03-29 07:47:24','SG'),(24,'SG-Viewer',392227,'2014-03-29 07:47:24','SG'),(25,'ID-Viewer',392227,'2014-03-29 07:47:24','ID'),(26,'ID-Manager',392227,'2014-03-29 07:47:24','ID'),(27,'ID-Author',392227,'2014-03-29 07:47:24','ID'),(28,'PH-Author',392227,'2014-03-29 07:47:24','PH'),(29,'PH-Manager',392227,'2014-03-29 07:47:24','PH'),(30,'PH-Viewer',392227,'2014-03-29 07:47:24','PH'),(31,'PH-CountryAdmin',392227,'2014-03-29 07:47:24','PH'),(32,'ID-CountryAdmin',392227,'2014-03-29 07:47:24','ID');
/*!40000 ALTER TABLE `role_collection` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-09 12:06:22
