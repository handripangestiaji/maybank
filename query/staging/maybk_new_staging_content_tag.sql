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
-- Table structure for table `content_tag`
--

DROP TABLE IF EXISTS `content_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `increment` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `content_tag_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_tag`
--

LOCK TABLES `content_tag` WRITE;
/*!40000 ALTER TABLE `content_tag` DISABLE KEYS */;
INSERT INTO `content_tag` VALUES (36,'Maybank2u','2014-05-08 07:16:00',0,392266),(37,'Buy Online','2014-05-08 07:16:09',0,392266),(38,'Online Banking','2014-05-08 07:16:18',0,392266),(39,'Online Shopping','2014-05-08 07:16:38',0,392266),(40,'Mobile Banking','2014-05-08 07:16:47',0,392266),(41,'Reload','2014-05-08 07:16:56',0,392266),(42,'Top-Up','2014-05-08 07:17:11',0,392266),(43,'Mobile Prepaid Credit','2014-05-08 07:17:20',0,392266),(44,'Bills Payments','2014-05-08 07:17:29',0,392266),(45,'Credit Card Payments','2014-05-08 07:17:40',0,392266),(46,'Loan Payments','2014-05-08 07:17:54',0,392266),(47,'Recurring Payment','2014-05-08 07:18:06',0,392266),(48,'Auto Debit','2014-05-08 07:18:14',0,392266),(49,'Payees','2014-05-08 07:18:26',0,392266),(50,'Online Transfer','2014-05-08 07:18:38',0,392266),(51,'Interbank Transfer','2014-05-08 07:18:49',0,392266),(52,'Money Express','2014-05-08 07:19:00',0,392266),(53,'Withdrawal','2014-05-08 07:19:11',0,392266),(54,'ATM','2014-05-08 07:19:20',0,392266),(55,'CDM','2014-05-08 07:19:26',0,392266),(56,'Cash Deposit','2014-05-08 07:19:55',0,392266),(57,'Cheque Deposit','2014-05-08 07:20:07',0,392266),(58,'Credit Card','2014-05-08 07:20:20',0,392266),(59,'Visa Credit Card','2014-05-08 07:20:32',0,392266),(60,'Visa Gold Credit Card','2014-05-08 07:20:46',0,392266),(61,'Visa Platinum Credit Card','2014-05-08 07:20:56',0,392266),(62,'Visa Infinite','2014-05-08 07:21:07',0,392266),(63,'MasterCard Credit Card','2014-05-08 07:21:18',0,392266),(64,'MasterCard Gold Credit Card','2014-05-08 07:21:28',0,392266),(65,'MasterCard Platinum Credit Card','2014-05-08 07:21:35',0,392266),(66,'World MasterCard','2014-05-08 07:21:46',0,392266),(67,'AMEX Gold Credit Card','2014-05-08 07:22:37',0,392266),(68,'AMEX Platinum Credit Card','2014-05-08 07:22:45',0,392266),(69,'AMEX Charge Card','2014-05-08 07:23:02',0,392266),(70,'AMEX Gold Charge Card','2014-05-08 07:23:16',0,392266),(71,'AMEX Platinum Charge Card','2014-05-08 07:23:30',0,392266),(72,'ATM Card','2014-05-08 07:23:40',0,392266),(73,'Debit Card','2014-05-08 07:23:49',0,392266),(74,'Visa Debit Card','2014-05-08 07:25:59',0,392266),(75,'MasterCard Debit Card','2014-05-08 07:26:13',0,392266),(76,'AMEX Credit Card','2014-05-08 07:26:23',0,392266),(77,'Prepaid Card','2014-05-08 07:26:36',0,392266),(78,'Promotions','2014-05-08 07:26:43',0,392266),(79,'Discount','2014-05-08 07:26:49',0,392266),(80,'Privilege','2014-05-08 07:26:54',0,392266),(81,'Rewards','2014-05-08 07:27:00',0,392266),(82,'Home Loan','2014-05-08 07:27:06',0,392266),(83,'Housing Loan','2014-05-08 07:27:13',0,392266),(84,'Mortgage Loan','2014-05-08 07:27:20',0,392266),(85,'Flexi Loan','2014-05-08 07:27:27',0,392266),(86,'Property Financing','2014-05-08 07:27:36',0,392266),(87,'Shop House Financing','2014-05-08 07:27:44',0,392266),(88,'Loan Scheme','2014-05-08 07:27:50',0,392266),(89,'Overdraft','2014-05-08 07:27:56',0,392266),(90,'Personal Loan','2014-05-08 07:28:03',0,392266),(91,'Personal Term Loan','2014-05-08 07:28:11',0,392266),(92,'Vehicle','2014-05-08 07:28:18',0,392266),(93,'Car Loan','2014-05-08 07:28:26',0,392266),(94,'Hire Purchase','2014-05-08 07:28:38',0,392266),(95,'Margin Financing','2014-05-08 07:28:45',0,392266),(96,'Share Trading Financing','2014-05-08 07:28:57',0,392266),(97,'Gold Investment','2014-05-08 07:29:04',0,392266),(98,'Silver Investment','2014-05-08 07:29:11',0,392266),(99,'Share Margin Financing','2014-05-08 07:29:16',0,392266),(100,'Non Margin Financing','2014-05-08 07:29:27',0,392266),(101,'Online Stocks','2014-05-08 07:30:19',0,392266),(102,'Mobile Trading','2014-05-08 07:30:26',0,392266),(103,'Online Trading','2014-05-08 07:30:40',0,392266),(104,'Global Trading','2014-05-08 07:30:46',0,392266),(105,'Investment Centre','2014-05-08 07:30:56',0,392266),(106,'Warrants','2014-05-08 07:31:06',0,392266),(107,'eShare','2014-05-08 07:31:12',0,392266),(108,'Share Trading','2014-05-08 07:31:25',0,392266),(109,'Unit Trust','2014-05-08 07:31:31',0,392266),(110,'Equity-Linked Investment Note','2014-05-08 07:31:39',0,392266),(111,'Dual Currency Investment','2014-05-08 07:31:47',0,392266),(112,'Market Exposure Adjustable Note','2014-05-08 07:31:53',0,392266),(113,'Forex Rates','2014-05-08 07:31:58',0,392266),(114,'Personal Accident','2014-05-08 07:32:27',0,392266),(115,'Premier PA','2014-05-08 07:32:36',0,392266),(116,'Privilege PA','2014-05-08 07:34:08',0,392266),(117,'Senior PA','2014-05-08 07:35:33',0,392266),(118,'Motor Insurance','2014-05-08 07:35:44',0,392266),(119,'Air Travel Insurance','2014-05-08 07:35:57',0,392266),(120,'Domestic Travel Insurance','2014-05-08 07:36:07',0,392266),(121,'Value Savers Plan','2014-05-08 07:36:23',0,392266),(122,'Life Insurance Plan','2014-05-08 07:39:14',0,392266),(123,'Education Savers','2014-05-08 07:39:21',0,392266),(124,'Retirement Plan','2014-05-08 07:39:28',0,392266),(125,'Deposits','2014-05-08 07:39:40',0,392266),(126,'Basic Savings Account','2014-05-08 07:39:51',0,392266),(127,'Personal Savings Account','2014-05-08 07:43:38',0,392266),(128,'Basic Current Account','2014-05-08 07:43:48',0,392266),(129,'Personal Current Account','2014-05-08 07:43:58',0,392266),(130,'Corporate Current Account','2014-05-08 07:44:06',0,392266),(131,'Foreign Currency Account','2014-05-08 07:44:22',0,392266),(132,'Cash Management','2014-05-08 07:44:36',0,392266),(133,'Business Banking','2014-05-08 07:45:24',0,392266),(134,'Corporate Banking','2014-05-08 07:45:57',0,392266),(135,'Fixed Deposit Account','2014-05-08 07:46:35',0,392266),(136,'Deposit Fees','2014-05-08 07:46:51',0,392266),(137,'Deposit Rates','2014-05-08 07:47:03',0,392266),(138,'Banking Fees','2014-05-08 07:47:18',0,392266),(139,'MoneyGram','2014-05-08 07:48:34',0,392266),(140,'Online Ticketing','2014-05-08 07:48:48',0,392266),(141,'Online Merchants','2014-05-08 07:49:53',0,392266),(142,'Private Trusts','2014-05-08 07:50:44',0,392266),(143,'Corporate Trustee Services','2014-05-08 07:50:55',0,392266),(144,'Maybank Malaysian Open','2014-05-08 07:53:34',0,392266),(145,'MMO','2014-05-08 07:53:43',0,392266),(146,'Badminton','2014-05-08 07:53:52',0,392266),(147,'Golf','2014-05-08 07:53:56',0,392266),(148,'Human Resources','2014-05-08 07:55:50',0,392266),(149,'Career','2014-05-08 07:56:44',0,392266),(150,'Job','2014-05-08 07:56:53',0,392266),(151,'Vacancy','2014-05-08 07:56:59',0,392266);
/*!40000 ALTER TABLE `content_tag` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-09 12:06:46
