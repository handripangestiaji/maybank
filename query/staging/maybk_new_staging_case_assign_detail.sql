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
-- Table structure for table `case_assign_detail`
--

DROP TABLE IF EXISTS `case_assign_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `case_assign_detail` (
  `case_assign_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(32) DEFAULT 'account',
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_group_assign` tinyint(4) NOT NULL DEFAULT '0',
  `case_id` int(11) NOT NULL,
  PRIMARY KEY (`case_assign_id`),
  KEY `fk_case_assign_detail_user1_idx` (`user_id`),
  KEY `fk_case_assign_detail_case1_idx` (`case_id`),
  CONSTRAINT `fk_case_assign_detail_case1` FOREIGN KEY (`case_id`) REFERENCES `case` (`case_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_case_assign_detail_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=368 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `case_assign_detail`
--

LOCK TABLES `case_assign_detail` WRITE;
/*!40000 ALTER TABLE `case_assign_detail` DISABLE KEYS */;
INSERT INTO `case_assign_detail` VALUES (40,'user',NULL,'',0,77),(47,'user',NULL,'',0,84),(50,'user',NULL,'cabul@gmail.com',0,87),(51,'user',NULL,'',0,88),(52,'user',392226,'eugene@yolkatgrey.com',0,89),(54,'user',NULL,'',0,91),(56,'user',NULL,'',0,93),(57,'user',NULL,'',0,94),(59,'user',NULL,'',0,96),(60,'user',NULL,'',0,97),(61,'user',NULL,'',0,98),(62,'user',NULL,'',0,99),(63,'user',NULL,'',0,100),(65,'user',NULL,'',0,102),(70,'user',NULL,'',0,107),(80,'user',392208,'fitrazh@gmail.com',0,117),(81,'user',392208,'fitrazh@gmail.com',0,118),(82,'user',NULL,'',0,119),(83,'user',NULL,'',0,120),(84,'user',392226,'eugene@yolkatgrey.com',0,121),(91,'user',NULL,'',0,128),(94,'user',NULL,'',0,130),(96,'user',392208,'fitrazh@gmail.com',0,132),(97,'user',392253,'riawulan47@yahoo.co.id',0,133),(98,'user',392187,'tes@gmail.com',0,134),(99,'user',392254,'ria20farfi@gmail.com',0,135),(104,'user',392208,'fitrazh@gmail.com',0,140),(108,'user',392187,'tes@gmail.com',0,144),(111,'user',392226,'eugene@yolkatgrey.com',0,147),(112,'user',392187,'tes@gmail.com',0,148),(116,'user',NULL,'',0,152),(117,'user',NULL,'',0,153),(120,'user',392187,'tes@gmail.com',0,156),(123,'user',392226,'eugene@yolkatgrey.com',0,159),(124,'user',392226,'eugene@yolkatgrey.com',0,161),(125,'user',392208,'fitrazh@gmail.com',0,162),(126,'user',392208,'fitrazh@gmail.com',0,163),(130,'user',392187,'tes@gmail.com',0,166),(131,'user',392254,'ria20farfi@gmail.com',0,166),(135,'user',392226,'eugene@yolkatgrey.com',0,169),(137,'user',392254,'ria20farfi@gmail.com',0,169),(142,'user',392226,'eugene@yolkatgrey.com',0,172),(148,'user',392187,'tes@gmail.com',0,176),(151,'user',392254,'ria20farfi@gmail.com',0,179),(152,'user',392208,'fitrazh@gmail.com',0,180),(153,'user',392254,'ria20farfi@gmail.com',0,181),(154,'user',NULL,'',0,182),(156,'user',NULL,'',0,186),(157,'user',NULL,'',0,187),(158,'user',NULL,'',0,188),(159,'user',392254,'ria20farfi@gmail.com',0,189),(160,'user',NULL,'',0,193),(163,'user',392187,'tes@gmail.com',0,197),(165,'user',392187,'tes@gmail.com',0,199),(169,'user',NULL,'',0,203),(170,'user',392208,'fitrazh@gmail.com',0,204),(171,'user',NULL,'',0,205),(172,'user',NULL,'',0,206),(173,'user',NULL,'',0,207),(174,'user',NULL,'',0,208),(175,'user',392187,'tes@gmail.com',0,209),(176,'user',392187,'tes@gmail.com',0,210),(179,'user',392187,'tes@gmail.com',0,213),(186,'user',392254,'ria20farfi@gmail.com',0,220),(187,'user',392254,'ria20farfi@gmail.com',0,221),(188,'user',392187,'tes@gmail.com',0,221),(194,'user',392254,'ria20farfi@gmail.com',0,233),(196,'user',392254,'ria20farfi@gmail.com',0,235),(202,'user',392187,'tes@gmail.com',0,241),(204,'user',NULL,'',0,243),(206,'user',392253,'riawulan47@yahoo.co.id',0,245),(207,'user',392253,'riawulan47@yahoo.co.id',0,246),(211,'user',NULL,'',0,250),(212,'user',NULL,'',0,251),(213,'user',NULL,'',0,254),(214,'user',392187,'tes@gmail.com',0,255),(215,'user',392187,'tes@gmail.com',0,256),(217,'user',392187,'tes@gmail.com',0,258),(218,'user',392187,'tes@gmail.com',0,259),(219,'user',392187,'tes@gmail.com',0,260),(221,'user',NULL,'',0,262),(228,'user',392226,'eugene@yolkatgrey.com',0,269),(231,'user',NULL,'',0,271),(234,'user',NULL,' eugene@yolkatgrey.com',0,273),(235,'user',NULL,'',0,274),(244,'user',NULL,'',0,287),(245,'user',NULL,'ali.merchant@yolk.com.sg',0,288),(246,'user',NULL,'',0,289),(247,'user',392208,'fitrazh@gmail.com',0,290),(248,'user',NULL,'ali.merchant@yolk.com.sg',0,291),(253,'user',NULL,'',0,296),(254,'user',NULL,'',0,297),(256,'user',NULL,'',0,299),(257,'user',NULL,'',0,300),(258,'user',NULL,'',0,301),(262,'user',392208,'fitrazh@gmail.com',0,305),(263,'user',392185,'handri.pangestiaji@gmail.com',0,305),(264,'user',NULL,'',0,306),(265,'user',NULL,'',0,308),(267,'user',NULL,'',0,310),(268,'user',NULL,'',0,311),(269,'user',NULL,'',0,313),(270,'user',NULL,'',0,316),(271,'user',NULL,'',0,317),(272,'user',NULL,'',0,318),(275,'user',NULL,'',0,321),(276,'user',NULL,'',0,322),(277,'user',NULL,'',0,323),(278,'user',NULL,'',0,324),(279,'user',NULL,'',0,326),(284,'user',NULL,'',0,337),(285,'user',NULL,'',0,338),(286,'user',NULL,'',0,339),(289,'user',NULL,'',0,342),(293,'user',NULL,'',0,346),(294,'user',NULL,'',0,347),(298,'user',392208,'fitrazh@gmail.com',0,351),(299,'user',392208,'fitrazh@gmail.com',0,352),(300,'user',NULL,'',0,353),(301,'user',NULL,'',0,354),(303,'user',NULL,'',0,356),(304,'user',392183,'eko.purnomo@icloud.com',0,357),(305,'user',NULL,'',0,358),(306,'user',NULL,'',0,359),(308,'user',NULL,'',0,361),(309,'user',NULL,'',0,362),(311,'user',NULL,'',0,364),(312,'user',NULL,'',0,365),(313,'user',392246,'benawv@gmail.com',0,366),(315,'user',392208,'fitrazh@gmail.com',0,366),(318,'user',392208,'fitrazh@gmail.com',0,369),(319,'user',NULL,' benawv@gmail.com',0,369),(320,'user',NULL,' eko.purnomo@me.com',0,369),(321,'user',NULL,'',0,370),(322,'user',NULL,'',0,371),(325,'user',392208,'fitrazh@gmail.com',0,374),(326,'user',NULL,'',0,375),(330,'user',392226,'eugene@yolkatgrey.com',0,379),(331,'user',NULL,'',0,380),(332,'user',NULL,'',0,381),(336,'user',392226,'eugene@yolkatgrey.com',0,385),(337,'user',NULL,'',0,386),(338,'user',NULL,'',0,387),(339,'user',NULL,'',0,388),(340,'user',NULL,'',0,389),(341,'user',NULL,'',0,390),(342,'user',NULL,'',0,391),(343,'user',NULL,'',0,392),(344,'user',NULL,'abc@gsasdail.com',0,393),(345,'user',NULL,'',0,394),(346,'user',392231,'mbb.dcms.05@gmail.com',0,395),(347,'user',NULL,'',0,396),(348,'user',NULL,'',0,397),(349,'user',NULL,'',0,398),(350,'user',NULL,'',0,399),(351,'user',NULL,'',0,400),(352,'user',NULL,'ria20@gmail.com',0,401),(353,'user',NULL,'',0,402),(354,'user',NULL,'',0,403),(355,'user',NULL,'',0,404),(356,'user',NULL,'benawaketversa@yahoo.com',0,405),(357,'user',NULL,'benawaketversa@yahoo.com',0,406),(358,'user',NULL,'',0,407),(359,'user',NULL,'benawaketversa@yahoo.com',0,408),(360,'user',NULL,'',0,409),(361,'user',NULL,'',0,410),(362,'user',NULL,'',0,411),(363,'user',NULL,'',0,412),(364,'user',NULL,'',0,413),(365,'user',NULL,'',0,414),(366,'user',NULL,'',0,415),(367,'user',NULL,'',0,416);
/*!40000 ALTER TABLE `case_assign_detail` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-09 12:06:20
