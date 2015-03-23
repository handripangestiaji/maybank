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
-- Table structure for table `email_store`
--

DROP TABLE IF EXISTS `email_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_store` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=368 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_store`
--

LOCK TABLES `email_store` WRITE;
/*!40000 ALTER TABLE `email_store` DISABLE KEYS */;
INSERT INTO `email_store` VALUES (1,'','2014-01-17 14:10:48'),(2,'','2014-01-20 07:02:28'),(3,'eko.purnomo@cloudmotion.co','2014-01-20 09:04:21'),(4,'sikomo.eko@gmail.com','2014-01-20 09:04:21'),(5,'handri.pangestiaji@gmail.com','2014-01-20 09:04:21'),(6,'mbb.dcms.05@gmail.com','2014-01-20 16:41:33'),(7,'','2014-01-21 02:39:07'),(8,'','2014-01-21 03:49:48'),(9,'','2014-01-21 03:52:31'),(10,'','2014-01-21 03:53:54'),(11,'mbb.dcms.10@gmail.com','2014-01-21 03:55:48'),(12,'','2014-01-21 07:32:29'),(13,'','2014-01-21 07:38:21'),(14,'','2014-01-21 07:40:00'),(15,'','2014-01-21 07:40:29'),(16,'','2014-01-21 07:40:40'),(17,'','2014-01-21 07:40:54'),(18,'','2014-01-21 07:42:54'),(19,'','2014-01-21 07:43:36'),(20,'','2014-01-21 07:51:17'),(21,'','2014-01-21 07:54:57'),(22,'','2014-01-22 02:29:50'),(23,'mbb.dcms.06@gmail.com','2014-01-22 02:30:49'),(24,'','2014-01-22 02:44:54'),(25,'','2014-01-22 03:50:28'),(26,'','2014-01-22 06:48:52'),(27,'','2014-01-22 06:49:21'),(28,'','2014-01-22 06:49:54'),(29,'','2014-01-22 06:50:39'),(30,'','2014-01-22 06:57:46'),(31,'','2014-01-22 07:04:37'),(32,'','2014-01-22 08:06:20'),(33,'','2014-01-22 08:08:59'),(34,'','2014-01-22 08:12:58'),(35,'','2014-01-22 08:13:43'),(36,'','2014-01-22 08:21:16'),(37,'','2014-01-22 08:22:55'),(38,'adrianlee@gmail.com','2014-01-27 10:19:25'),(39,'eko.purnomo@icloud.com','2014-02-07 04:44:59'),(40,'','2014-02-07 04:48:37'),(41,'','2014-02-07 04:50:39'),(42,'eugene@yolkatgrey.com','2014-02-07 06:41:24'),(43,'','2014-02-07 06:49:50'),(44,'','2014-02-07 07:07:08'),(45,'','2014-02-07 08:41:47'),(46,'','2014-02-07 09:20:11'),(47,'','2014-02-11 07:18:25'),(48,'','2014-02-11 07:19:04'),(49,'','2014-02-11 11:05:26'),(50,'cabul@gmail.com','2014-02-11 11:15:29'),(51,'','2014-02-11 11:25:39'),(52,'eugene@yolkatgrey.com','2014-02-12 02:57:00'),(53,'','2014-02-12 08:22:23'),(54,'','2014-02-12 08:39:08'),(55,'','2014-02-12 08:39:20'),(56,'','2014-02-12 09:59:10'),(57,'','2014-02-12 10:23:39'),(58,'eko.purnomo@icloud.com','2014-02-13 07:31:11'),(59,'','2014-02-14 07:52:03'),(60,'','2014-02-14 08:26:51'),(61,'','2014-02-14 08:27:51'),(62,'','2014-02-14 08:34:20'),(63,'','2014-02-14 09:29:49'),(64,'eko.purnomo@icloud.com','2014-02-14 09:36:23'),(65,'','2014-02-17 03:30:17'),(66,'','2014-02-17 03:33:11'),(67,'','2014-02-17 09:55:11'),(68,'','2014-02-19 03:02:17'),(69,'','2014-02-19 07:50:03'),(70,'','2014-02-19 09:16:04'),(71,'','2014-02-19 11:41:24'),(72,'eugene.1010@gmail.com','2014-02-19 11:52:21'),(73,'','2014-02-19 11:58:33'),(74,'ria20farfi@gmail.com','2014-02-20 07:12:17'),(75,'ria20farfi@gmail.com','2014-02-20 07:12:58'),(76,'ria20farfi@gmail.com','2014-02-20 07:14:39'),(77,'ria20farfi@gmail.com','2014-02-20 08:31:51'),(78,'ria20farfi@gmail.com','2014-02-20 08:32:47'),(79,'','2014-02-21 04:41:11'),(80,'fitrazh@gmail.com','2014-02-21 08:10:28'),(81,'fitrazh@gmail.com','2014-02-21 08:12:03'),(82,'','2014-02-22 06:05:27'),(83,'','2014-02-22 06:09:36'),(84,'eugene@yolkatgrey.com','2014-02-22 06:11:14'),(85,'','2014-02-22 06:31:34'),(86,'','2014-02-24 04:11:53'),(87,'','2014-02-24 04:41:49'),(91,'','2014-02-24 08:44:06'),(92,'eugene@yolkatgrey.com','2014-02-24 10:00:47'),(93,'kiyo.yip@yolkatgrey.com','2014-02-24 10:00:47'),(94,'','2014-02-24 11:03:48'),(95,'','2014-02-24 11:08:24'),(96,'fitrazh@gmail.com','2014-02-25 03:24:31'),(97,'riawulan47@yahoo.co.id','2014-02-25 04:10:14'),(98,'tes@gmail.com','2014-02-25 04:12:21'),(99,'ria20farfi@gmail.com','2014-02-25 04:22:39'),(100,'riawulan47@yahoo.co.id','2014-02-25 04:40:28'),(101,'','2014-02-25 04:45:30'),(102,'ria20farfi@gmail.com','2014-02-25 04:46:59'),(103,'riawulan47@yahoo.co.id','2014-02-25 04:52:57'),(104,'fitrazh@gmail.com','2014-02-25 06:34:38'),(105,'riawulan47@yahoo.co.id','2014-02-25 06:36:52'),(106,'riawulan47@yahoo.co.id','2014-02-25 06:52:40'),(107,'riawulan47@yahoo.co.id','2014-02-25 06:58:26'),(108,'tes@gmail.com','2014-02-25 07:43:56'),(109,'eugene@yolkatgrey.com','2014-02-25 07:47:54'),(110,'tes@gmail.com','2014-02-25 07:48:50'),(111,'eugene@yolkatgrey.com','2014-02-25 07:49:14'),(112,'tes@gmail.com','2014-02-25 07:51:20'),(113,'tes@gmail.com','2014-02-25 07:55:01'),(114,'tes@gmail.com','2014-02-25 07:57:31'),(115,'riawulan47@yahoo.co.id','2014-02-25 08:24:56'),(116,'','2014-02-25 08:27:56'),(117,'','2014-02-25 08:28:52'),(118,'tes@gmail.com','2014-02-25 08:42:10'),(119,'tes@gmail.com','2014-02-25 08:51:08'),(120,'tes@gmail.com','2014-02-25 09:09:12'),(121,'','2014-02-25 09:19:19'),(122,'tes@gmail.com','2014-02-25 09:22:14'),(123,'eugene@yolkatgrey.com','2014-02-25 09:40:36'),(124,'eugene@yolkatgrey.com','2014-02-25 10:52:24'),(125,'fitrazh@gmail.com','2014-02-25 13:49:04'),(126,'fitrazh@gmail.com','2014-02-25 13:52:35'),(127,'fitrazh@gmail.com','2014-02-25 14:35:40'),(128,'eko.purnomo@icloud.com','2014-02-26 01:57:48'),(129,'eugene@yolkatgrey.com','2014-02-26 01:57:48'),(130,'tes@gmail.com','2014-02-26 02:32:43'),(131,'ria20farfi@gmail.com','2014-02-26 02:32:43'),(132,'tes@gmail.com','2014-02-26 05:06:03'),(133,'ria20farfi@gmail.com','2014-02-26 05:06:03'),(134,'ria20farfi@gmail.com','2014-02-26 05:24:06'),(135,'eugene@yolkatgrey.com','2014-02-26 07:29:53'),(136,'eko.purnomo@icloud.com','2014-02-26 07:29:53'),(137,'ria20farfi@gmail.com','2014-02-26 07:29:53'),(138,'eko.purnomo@icloud.com','2014-02-26 07:37:29'),(139,'eugene@yolkatgrey.com','2014-02-26 07:37:29'),(140,'ria20farfi@gmail.com','2014-02-26 07:37:29'),(141,'','2014-02-26 07:43:19'),(142,'eugene@yolkatgrey.com','2014-02-26 08:45:03'),(143,'eko.purnomo@icloud.com','2014-02-26 08:52:15'),(144,'benawv@gmail.com','2014-02-26 08:52:15'),(145,'eugene@yolkatgrey.com','2014-02-26 08:52:15'),(146,'tes@gmail.com','2014-02-27 03:52:45'),(147,'tes@gmail.com','2014-02-27 03:55:29'),(148,'tes@gmail.com','2014-02-27 04:06:47'),(149,'tes@gmail.com','2014-02-27 04:59:07'),(150,'tes@gmail.com','2014-02-27 06:54:37'),(151,'ria20farfi@gmail.com','2014-02-27 09:23:09'),(152,'fitrazh@gmail.com','2014-02-27 09:26:24'),(153,'ria20farfi@gmail.com','2014-02-27 09:27:18'),(154,'','2014-02-27 12:25:05'),(155,'','2014-02-27 14:52:30'),(156,'','2014-02-27 14:53:16'),(157,'','2014-02-27 14:54:11'),(158,'','2014-02-27 15:06:53'),(159,'ria20farfi@gmail.com','2014-02-28 10:37:43'),(160,'','2014-03-01 05:04:31'),(161,'','2014-03-01 05:05:37'),(162,'','2014-03-01 05:06:00'),(163,'tes@gmail.com','2014-03-04 02:02:07'),(164,'ria20farfi@gmail.com','2014-03-04 02:24:22'),(165,'tes@gmail.com','2014-03-04 07:48:50'),(166,'tes@gmail.com','2014-03-04 07:55:12'),(167,'tes@gmail.com','2014-03-04 08:00:07'),(168,'tes@gmail.com','2014-03-04 09:10:13'),(169,'','2014-03-04 09:45:49'),(170,'fitrazh@gmail.com','2014-03-05 02:40:45'),(171,'','2014-03-05 09:04:47'),(172,'','2014-03-05 09:08:33'),(173,'','2014-03-06 07:25:48'),(174,'','2014-03-07 07:54:58'),(175,'tes@gmail.com','2014-03-12 04:14:56'),(176,'tes@gmail.com','2014-03-12 04:16:26'),(177,'eko.purnomo@icloud.com','2014-03-12 04:47:40'),(178,'tes@gmail.com','2014-03-12 04:49:03'),(179,'tes@gmail.com','2014-03-12 04:55:59'),(180,'tes@gmail.com','2014-03-12 05:07:17'),(181,'tes@gmail.com','2014-03-12 05:08:25'),(182,'tes@gmail.com','2014-03-12 05:18:38'),(183,'tes@gmail.com','2014-03-12 05:20:28'),(184,'fitrazh@gmail.com','2014-03-13 04:59:19'),(185,'','2014-03-13 10:06:22'),(186,'ria20farfi@gmail.com','2014-03-14 04:27:38'),(187,'ria20farfi@gmail.com','2014-03-14 04:28:42'),(188,'tes@gmail.com','2014-03-14 04:28:42'),(189,'ria20farfi@gmail.com','2014-03-14 04:42:14'),(190,'ria20farfi@gmail.com','2014-03-14 04:43:54'),(191,'ria20farfi@gmail.com','2014-03-14 04:45:33'),(192,'ria20farfi@gmail.com','2014-03-14 04:50:03'),(193,'ria20farfi@gmail.com','2014-03-14 04:51:06'),(194,'ria20farfi@gmail.com','2014-03-14 04:59:27'),(195,'ria20farfi@gmail.com','2014-03-14 05:05:47'),(196,'ria20farfi@gmail.com','2014-03-14 05:09:51'),(197,'ria20farfi@gmail.com','2014-03-14 05:22:47'),(198,'riojenerio6@gmail.com','2014-03-14 05:44:43'),(199,'riojenerio6@gmail.com','2014-03-14 05:45:52'),(200,'riojenerio6@gmail.com','2014-03-14 05:50:14'),(201,'riojenerio6@gmail.com','2014-03-14 05:53:00'),(202,'tes@gmail.com','2014-03-14 06:23:17'),(203,'','2014-03-14 06:23:55'),(204,'','2014-03-14 06:25:35'),(205,'tes@gmail.com','2014-03-14 06:26:03'),(206,'riawulan47@yahoo.co.id','2014-03-14 06:48:13'),(207,'riawulan47@yahoo.co.id','2014-03-14 06:52:40'),(208,'','2014-03-14 07:02:52'),(209,'','2014-03-14 07:29:08'),(210,'','2014-03-14 08:25:32'),(211,'','2014-03-14 08:27:15'),(212,'','2014-03-14 08:27:53'),(213,'','2014-03-14 08:33:34'),(214,'tes@gmail.com','2014-03-17 04:01:05'),(215,'tes@gmail.com','2014-03-17 04:03:32'),(216,'tes@gmail.com','2014-03-17 04:05:23'),(217,'tes@gmail.com','2014-03-17 04:07:06'),(218,'tes@gmail.com','2014-03-19 07:36:24'),(219,'tes@gmail.com','2014-03-19 07:38:48'),(220,'','2014-03-21 08:44:14'),(221,'','2014-03-22 09:05:28'),(222,'','2014-03-25 08:00:53'),(223,'','2014-03-25 08:22:14'),(224,'','2014-03-25 08:31:59'),(225,'','2014-03-25 08:40:36'),(226,'nicole.lee@maybank.com.my','2014-03-25 08:41:51'),(227,'','2014-03-25 08:43:12'),(228,'eugene@yolkatgrey.com','2014-03-25 08:44:20'),(229,'nicole.lee@maybank.com.my','2014-03-25 08:44:20'),(230,'nicole.lee@maybank.com.my','2014-03-25 08:47:34'),(231,'','2014-03-25 08:55:06'),(232,'nicole.lee@maybank.com.my','2014-03-25 09:01:08'),(233,'nicole.lee@maybank.com.my','2014-03-25 09:06:08'),(234,' eugene@yolkatgrey.com','2014-03-25 09:06:08'),(235,'','2014-03-25 09:09:58'),(236,'','2014-03-25 09:19:06'),(237,'nicole.lee@maybank.com.my','2014-03-25 09:21:04'),(238,'','2014-03-25 09:22:34'),(239,'','2014-03-25 09:22:45'),(240,'','2014-03-25 09:23:25'),(241,'','2014-03-25 09:24:11'),(242,'ali.merchant@yolk.com.sg','2014-03-25 09:24:56'),(243,'','2014-03-25 09:25:08'),(244,'','2014-03-25 09:26:16'),(245,'ali.merchant@yolk.com.sg','2014-03-25 09:26:51'),(246,'','2014-03-25 09:28:19'),(247,'fitrazh@gmail.com','2014-03-25 09:28:29'),(248,'ali.merchant@yolk.com.sg','2014-03-25 09:30:01'),(249,'','2014-03-25 09:31:25'),(250,'','2014-03-25 09:32:09'),(251,'','2014-03-25 09:32:43'),(252,'','2014-03-25 09:34:24'),(253,'','2014-03-25 09:37:42'),(254,'','2014-03-25 09:38:36'),(255,'','2014-03-25 09:39:57'),(256,'','2014-03-25 09:42:03'),(257,'','2014-03-25 09:42:42'),(258,'','2014-03-25 09:44:18'),(259,'','2014-03-25 16:58:56'),(260,'nicole.lee@maybank.com.my','2014-03-25 16:59:26'),(261,'eugene@yolkatgrey.com','2014-03-25 17:01:00'),(262,'fitrazh@gmail.com','2014-03-26 08:24:44'),(263,'handri.pangestiaji@gmail.com','2014-03-26 08:24:44'),(264,'','2014-03-26 09:02:13'),(265,'','2014-03-26 09:05:51'),(266,'','2014-03-26 09:39:49'),(267,'','2014-03-26 09:57:13'),(268,'','2014-03-26 09:58:09'),(269,'','2014-03-26 09:59:42'),(270,'','2014-03-26 10:01:26'),(271,'','2014-03-26 10:10:19'),(272,'','2014-03-26 10:10:53'),(273,'','2014-03-26 12:22:03'),(274,'','2014-03-26 12:22:26'),(275,'','2014-03-26 14:57:22'),(276,'','2014-03-30 09:47:08'),(277,'','2014-03-30 11:12:14'),(278,'','2014-03-30 11:13:19'),(279,'','2014-03-30 11:16:14'),(280,'','2014-03-31 04:26:34'),(281,'','2014-03-31 04:26:53'),(282,'','2014-03-31 04:44:27'),(283,'','2014-03-31 04:44:42'),(284,'','2014-03-31 05:03:08'),(285,'','2014-03-31 05:03:38'),(286,'','2014-03-31 05:08:10'),(287,'','2014-03-31 05:08:30'),(288,'','2014-03-31 05:08:51'),(289,'','2014-03-31 05:14:13'),(290,'','2014-03-31 05:41:28'),(291,'','2014-03-31 05:41:49'),(292,'','2014-03-31 05:42:22'),(293,'','2014-03-31 07:03:43'),(294,'','2014-03-31 07:04:07'),(295,'','2014-03-31 07:04:22'),(296,'','2014-03-31 07:04:54'),(297,'','2014-03-31 07:10:51'),(298,'fitrazh@gmail.com','2014-03-31 09:57:05'),(299,'fitrazh@gmail.com','2014-03-31 10:20:51'),(300,'','2014-03-31 11:02:26'),(301,'','2014-03-31 11:02:51'),(302,'','2014-03-31 11:03:24'),(303,'','2014-03-31 11:19:48'),(304,'eko.purnomo@icloud.com','2014-03-31 11:21:18'),(305,'','2014-03-31 11:53:50'),(306,'','2014-04-01 05:04:16'),(307,'','2014-04-01 05:08:55'),(308,'','2014-04-02 07:52:56'),(309,'','2014-04-02 08:39:04'),(310,'','2014-04-02 12:12:41'),(311,'','2014-04-03 05:33:34'),(312,'','2014-04-03 05:45:25'),(313,'benawv@gmail.com','2014-04-03 08:47:04'),(314,'sikomo.eko@gmail.com','2014-04-03 08:47:04'),(315,'fitrazh@gmail.com','2014-04-03 08:47:04'),(316,'','2014-04-03 08:51:12'),(317,'','2014-04-03 08:52:25'),(318,'fitrazh@gmail.com','2014-04-03 08:54:23'),(319,' benawv@gmail.com','2014-04-03 08:54:23'),(320,' eko.purnomo@me.com','2014-04-03 08:54:23'),(321,'','2014-04-03 08:57:58'),(322,'','2014-04-03 08:59:40'),(323,'','2014-04-03 09:21:13'),(324,'','2014-04-05 12:27:13'),(325,'fitrazh@gmail.com','2014-04-07 10:49:21'),(326,'','2014-04-07 11:09:38'),(327,'fitrazh@gmail.com','2014-04-07 11:14:02'),(328,'eko.purnomo@icloud.com','2014-04-09 04:52:08'),(329,'','2014-04-10 07:19:54'),(330,'eugene@yolkatgrey.com','2014-04-22 09:54:57'),(331,'','2014-04-22 10:30:39'),(332,'','2014-04-22 10:39:35'),(333,'','2014-04-22 10:44:23'),(334,'','2014-04-22 11:26:14'),(335,'','2014-04-22 11:26:59'),(336,'eugene@yolkatgrey.com','2014-05-06 03:34:23'),(337,'','2014-05-06 03:58:31'),(338,'','2014-05-06 08:22:34'),(339,'','2014-05-07 02:58:15'),(340,'','2014-05-07 02:59:49'),(341,'','2014-05-23 10:07:42'),(342,'','2014-07-01 04:36:09'),(343,'','2014-07-01 04:36:28'),(344,'abc@gsasdail.com','2014-07-01 04:43:51'),(345,'','2014-07-01 04:46:04'),(346,'mbb.dcms.05@gmail.com','2014-07-01 04:47:43'),(347,'','2014-07-01 04:54:06'),(348,'','2014-07-05 03:41:05'),(349,'','2014-07-05 05:05:36'),(350,'','2014-07-05 08:31:12'),(351,'','2014-07-18 06:10:03'),(352,'ria20@gmail.com','2014-08-22 07:10:06'),(353,'','2014-08-22 11:10:09'),(354,'','2014-08-22 11:13:18'),(355,'','2014-09-16 07:34:35'),(356,'benawaketversa@yahoo.com','2014-09-16 07:36:13'),(357,'benawaketversa@yahoo.com','2014-09-16 07:36:29'),(358,'','2014-09-16 10:33:08'),(359,'benawaketversa@yahoo.com','2014-09-17 02:58:56'),(360,'','2014-09-17 04:28:58'),(361,'','2014-09-17 05:28:53'),(362,'','2014-09-17 05:33:34'),(363,'','2014-09-18 03:01:16'),(364,'','2014-09-18 03:02:12'),(365,'','2014-09-18 03:13:45'),(366,'','2014-10-03 07:36:41'),(367,'','2014-10-03 07:38:22');
/*!40000 ALTER TABLE `email_store` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-09 12:04:53