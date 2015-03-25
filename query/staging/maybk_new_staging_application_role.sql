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
-- Table structure for table `application_role`
--

DROP TABLE IF EXISTS `application_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `application_role` (
  `app_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_friendly_name` varchar(255) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `role_group` varchar(128) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`app_role_id`),
  KEY `fk_application_role_application_role1_idx` (`parent_id`),
  CONSTRAINT `fk_application_role_application_role1` FOREIGN KEY (`parent_id`) REFERENCES `application_role` (`app_role_id`) ON DELETE CASCADE ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application_role`
--

LOCK TABLES `application_role` WRITE;
/*!40000 ALTER TABLE `application_role` DISABLE KEYS */;
INSERT INTO `application_role` VALUES (1,'Social Stream','Social Stream','Social Stream','2013-11-28 03:13:05',1,NULL),(2,'User Management','User Management','User Management','2013-11-28 03:40:05',1,NULL),(3,'Publishing Box','Publishing Box','Publishing Box','2013-11-28 03:40:30',1,NULL),(4,'Publisher','Publisher','Publisher','2013-11-28 03:40:57',1,NULL),(5,'Content Management','Content Management','Content Management','2013-12-16 11:17:35',1,NULL),(6,'Reporting','Reporting','Reporting','2013-12-16 11:17:35',1,NULL),(7,'Social Channel Management','Social Channel Management','Social Channel Management','2013-12-16 11:19:40',1,NULL),(8,'Social Stream_Channel','Channel','Social Stream','2013-12-16 11:19:40',1,1),(9,'Social Stream_Case','Case','Social Stream','2013-12-16 11:19:40',1,8),(38,'Publishing Box_Assigned_Channel','Assigned_Channel','Publishing Box',NULL,NULL,3),(39,'Publishing Box_All_Channel','All_Channel','Publishing Box',NULL,NULL,3),(40,'Publisher_Current_Channel','Current Channel','Publisher',NULL,NULL,4),(41,'Publisher_Current_Delete_Post','Delete Post','Publisher',NULL,NULL,40),(42,'Publisher_All_Channel','All Channel','Publisher',NULL,NULL,4),(43,'Publisher_All_View_Post','View Post','Publisher',NULL,NULL,42),(44,'Publisher_All_Delete_Post','Delete Post','Publisher',NULL,NULL,42),(63,'Reporting_View','View','Reporting',NULL,NULL,6),(64,'Reporting_View_Current_Channel','Current Channel','Reporting',NULL,NULL,63),(65,'Reporting_View_Own_Country','All Countrys Channel','Reporting',NULL,NULL,63),(66,'Reporting_View_All_Country','All Available Channel','Reporting',NULL,NULL,63),(67,'Reporting_Download','Download','Reporting',NULL,NULL,6),(68,'Reporting_Download_Current_Channel','Current Channel','Reporting',NULL,NULL,67),(69,'Reporting_Download_Own_Country','All Countrys Channel','Reporting',NULL,NULL,67),(70,'Reporting_Download_All_Country','All Available Channel','Reporting',NULL,NULL,67),(71,'Social Channel Management_Channel','Channel','Social Channel Management',NULL,NULL,7),(72,'Social Channel Management_Own_Country','Own Country','Social Channel Management',NULL,NULL,71),(73,'Social Channel Management_Other_Country','Other Country','Social Channel Management',NULL,NULL,71),(77,'Social Stream_Notification','Case Notification','Social Stream','2014-02-20 00:00:00',1,1),(78,'Search','Search','Search','2014-02-20 00:00:00',1,NULL),(80,'Publisher_All_Edit_Post','Edit Post','Publisher','2014-02-20 00:00:00',1,42),(85,'Social Channel Management_Country','Country','Social Channel Management','2014-02-20 00:00:00',1,7),(86,'Social Channel Management_Country_Add','Add','Social Channel Management','2014-02-20 00:00:00',1,85),(87,'Social Channel Management_Country_Delete','Delete','Social Channel Management','2014-02-20 00:00:00',1,85),(92,'Social Channel Management_Own_Country_Add','Add','Social Channel Management','2014-02-25 00:00:00',1,72),(93,'Social Channel Management_Own_Country_View','View','Social Channel Management','2014-02-25 00:00:00',1,72),(94,'Social Channel Management_Own_Country_Delete','Delete','Social Channel Management','2014-02-25 00:00:00',1,72),(95,'Social Channel Management_Other_Country_Add','Add','Social Channel Management','2014-02-25 00:00:00',1,73),(96,'Social Channel Management_Other_Country_View','View','Social Channel Management','2014-02-25 00:00:00',1,73),(97,'Social Channel Management_Other_Country_Delete','Delete','Social Channel Management','2014-02-25 00:00:00',1,73),(98,'Social Stream_Channel_General_Function','General Function','Social Stream','2014-02-25 00:00:00',1,8),(99,'Social Stream_Channel_General_Function_Own_Country','Own Country','Social Stream','2014-02-25 00:00:00',1,98),(100,'Social Stream_Channel_General_Function_All_Country','All Country','Social Stream','2014-02-25 00:00:00',1,98),(101,'Social Stream_Channel_General_Function_Own_Country_Reply','Reply','Social Stream','2014-02-25 00:00:00',1,99),(102,'Social Stream_Channel_General_Function_Own_Country_Delete','Delete','Social Stream','2014-02-25 00:00:00',1,99),(103,'Social Stream_Channel_General_Function_All_Country_Reply','Reply','Social Stream','2014-02-25 00:00:00',1,100),(104,'Social Stream_Channel_General_Function_All_Country_Delete','Delete','Social Stream','2014-02-25 00:00:00',1,100),(105,'Social Stream_Case_Own_Country','Own Country','Social Stream','2014-02-25 00:00:00',1,9),(106,'Social Stream_Case_Own_Country_AssignReassignResolved','Assign / Reassign /Resolved','Social Stream','2014-02-25 00:00:00',1,105),(107,'Social Stream_Case_All_Country','All Country','Social Stream','2014-02-25 00:00:00',1,9),(108,'Social Stream_Case_All_Country_AssignReassignResolved','Assign / Reassign /Resolved','Social Stream','2014-02-25 00:00:00',1,107),(109,'Social Stream_Facebook','Facebook','Social Stream','2014-02-25 00:00:00',1,8),(110,'Social Stream_Facebook_Own_Country','Own Country','Social Stream','2014-02-25 00:00:00',1,109),(111,'Social Stream_Facebook_All_Country','All Country','Social Stream','2014-02-25 00:00:00',1,109),(112,'Social Stream_Facebook_Own_Country_LikeUnlike','Like/Unlike','Social Stream','2014-02-25 00:00:00',1,110),(113,'Social Stream_Facebook_All_Country_LikeUnlike','Like/Unlike','Social Stream','2014-02-25 00:00:00',1,111),(114,'Social Stream_Twitter','Twitter','Social Stream','2014-02-25 00:00:00',1,8),(115,'Social Stream_Twitter_Own_Country','Own Country','Social Stream','2014-02-25 00:00:00',1,114),(116,'Social Stream_Twitter_All_Country','All Country','Social Stream','2014-02-25 00:00:00',1,114),(117,'Social Stream_Twitter_Own_Country_Retweet','Retweet','Social Stream','2014-02-25 00:00:00',1,115),(118,'Social Stream_Twitter_Own_Country_Favorite','Favorite','Social Stream','2014-02-25 00:00:00',1,115),(119,'Social Stream_Twitter_Own_Country_Follow','Follow','Social Stream','2014-02-25 00:00:00',1,115),(120,'Social Stream_Twitter_All_Country_Retweet','Retweet','Social Stream','2014-02-25 00:00:00',1,116),(121,'Social Stream_Twitter_All_Country_Favorite','Favorite','Social Stream','2014-02-25 00:00:00',1,116),(122,'Social Stream_Twitter_All_Country_Follow','Follow','Social Stream','2014-02-25 00:00:00',1,116),(123,'User Management_User','User','User Management','2014-02-25 00:00:00',1,2),(124,'User Management_Role','Role','User Management','2014-02-25 00:00:00',1,2),(125,'User Management_Group','Group','User Management','2014-02-25 00:00:00',1,2),(126,'User Management_View_Region','View By Region','User Management','2014-02-25 00:00:00',1,2),(127,'User Management_User_Own_Country','Own Country','User Management','2014-02-25 00:00:00',1,123),(128,'User Management_User_All_Country','All Country','User Management','2014-02-25 00:00:00',1,123),(129,'User Management_Role_Own_Country','Own Country','User Management','2014-02-25 00:00:00',1,124),(130,'User Management_Role_All_Country','All Country','User Management','2014-02-25 00:00:00',1,124),(131,'User Management_Group_Own_Country','Own Country','User Management','2014-02-25 00:00:00',1,125),(132,'User Management_Group_All_Country','All Country','User Management','2014-02-25 00:00:00',1,125),(133,'User Management_User_Own_Country_View','View','User Management','2014-02-25 00:00:00',1,127),(134,'User Management_User_Own_Country_Create','Create','User Management','2014-02-25 00:00:00',1,127),(135,'User Management_User_Own_Country_Edit','Edit','User Management','2014-02-25 00:00:00',1,127),(136,'User Management_User_Own_Country_Delete','Delete','User Management','2014-02-25 00:00:00',1,127),(137,'User Management_User_All_Country_View','View','User Management','2014-02-25 00:00:00',1,128),(138,'User Management_User_All_Country_Create','Create','User Management','2014-02-25 00:00:00',1,128),(139,'User Management_User_All_Country_Edit','Edit','User Management','2014-02-25 00:00:00',1,128),(140,'User Management_User_All_Country_Delete','Delete','User Management','2014-02-25 00:00:00',1,128),(141,'User Management_Role_Own_Country_View','View','User Management','2014-02-25 00:00:00',1,129),(142,'User Management_Role_Own_Country_Create','Create','User Management','2014-02-25 00:00:00',1,129),(143,'User Management_Role_Own_Country_Edit','Edit','User Management','2014-02-25 00:00:00',1,129),(144,'User Management_Role_Own_Country_Delete','Delete','User Management','2014-02-25 00:00:00',1,129),(145,'User Management_Role_All_Country_View','View','User Management','2014-02-25 00:00:00',1,130),(146,'User Management_Role_All_Country_Create','Create','User Management','2014-02-25 00:00:00',1,130),(147,'User Management_Role_All_Country_Edit','Edit','User Management','2014-02-25 00:00:00',1,130),(148,'User Management_Role_All_Country_Delete','Delete','User Management','2014-02-25 00:00:00',1,130),(149,'User Management_Group_Own_Country_View','View','User Management','2014-02-25 00:00:00',1,131),(150,'User Management_Group_Own_Country_Create','Create','User Management','2014-02-25 00:00:00',1,131),(151,'User Management_Group_Own_Country_Edit','Edit','User Management','2014-02-25 00:00:00',1,131),(152,'User Management_Group_Own_Country_Delete','Delete','User Management','2014-02-25 00:00:00',1,131),(153,'User Management_Group_All_Country_View','View','User Management','2014-02-25 00:00:00',1,132),(154,'User Management_Group_All_Country_Create','Create','User Management','2014-02-25 00:00:00',1,132),(155,'User Management_Group_All_Country_Edit','Edit','User Management','2014-02-25 00:00:00',1,132),(156,'User Management_Group_All_Country_Delete','Delete','User Management','2014-02-25 00:00:00',1,132),(157,'Social Stream_Channel_General_Function_Own_Country_View','View','Social Stream','2014-02-25 00:00:00',1,99),(158,'Social Stream_Channel_General_Function_All_Country_View','View','Social Stream','2014-02-25 00:00:00',1,100),(159,'Content Management_Campaign','Campaign','Content Management','2014-03-29 00:00:00',1,5),(160,'Content Management_Short_URL','Short URL','Content Management','2014-03-29 00:00:00',1,5),(161,'Content Management_Product','Product','Content Management','2014-03-29 00:00:00',1,5),(162,'Content Management_TAG','TAG','Content Management','2014-03-29 00:00:00',1,5),(163,'Content Management_Campaign_Own_Country','Own Country','Content Management','2014-03-29 00:00:00',1,159),(164,'Content Management_Campaign_All_Country','All Country','Content Management','2014-03-29 00:00:00',1,159),(165,'Content Management_Short_URL_Own Country','Own Country','Content Management','2014-03-29 00:00:00',1,160),(166,'Content Management_Short_URL_All_Country','All Country','Content Management','2014-03-29 00:00:00',1,160),(168,'Content Management_Product_All_Country','All Country','Content Management','2014-03-29 00:00:00',1,161),(170,'Content Management_TAG_All_Country','All Country','Content Management','2014-03-29 00:00:00',1,162),(171,'Content Management_Campaign_Own_Country_View','View','Content Management','2014-03-29 00:00:00',1,163),(172,'Content Management_Campaign_Own_Country_Create','Create','Content Management','2014-03-29 00:00:00',1,163),(173,'Content Management_Campaign_Own_Country_Delete','Delete','Content Management','2014-03-29 00:00:00',1,163),(174,'Content Management_Campaign_Own_Country_Edit','Edit','Content Management','2014-03-29 00:00:00',1,163),(175,'Content Management_Campaign_All_Country_View','View','Content Management','2014-03-29 00:00:00',1,164),(176,'Content Management_Campaign_All_Country_Create','Create','Content Management','2014-03-29 00:00:00',1,164),(177,'Content Management_Campaign_All_Country_Edit','Edit','Content Management','2014-03-29 00:00:00',1,164),(178,'Content Management_Campaign_All_Country_Delete','Delete','Content Management','2014-03-29 00:00:00',1,164),(179,'Content Management_Short_URL_Own_Country_View','View','Content Management','2014-03-29 00:00:00',1,165),(180,'Content Management_Short_URL_Own_Country_Create','Create','Content Management','2014-03-29 00:00:00',1,165),(181,'Content Management_Short_URL_Own_Country_Edit','Edit','Content Management','2014-03-29 00:00:00',1,165),(182,'Content Management_Short_URL_Own_Country_Delete','Delete','Content Management','2014-03-29 00:00:00',1,165),(183,'Content Management_Short_URL_All_Country_View','View','Content Management','2014-03-29 00:00:00',1,166),(184,'Content Management_Short_URL_All_Country_Create','Create','Content Management','2014-03-29 00:00:00',1,166),(185,'Content Management_Short_URL_All_Country_Edit','Edit','Content Management','2014-03-29 00:00:00',1,166),(186,'Content Management_Short_URL_All_Country_Delete','Delete','Content Management','2014-03-29 00:00:00',1,166),(187,'Content Management_Product_All_Country_View','View','Content Management','2014-03-29 00:00:00',1,168),(188,'Content Management_Product_All_Country_Create','Create','Content Management','2014-03-29 00:00:00',1,168),(189,'Content Management_Product_All_Country_Delete','Delete','Content Management','2014-03-29 00:00:00',1,168),(190,'Content Management_Product_All_Country_Edit','Edit','Content Management','2014-03-29 00:00:00',1,168),(191,'Content Management_TAG_All_Country_View','View','Content Management','2014-03-29 00:00:00',1,170),(192,'Content Management_TAG_All_Country_Create','Create','Content Management','2014-03-29 00:00:00',1,170),(193,'Content Management_TAG_All_Country_Edit','Edit','Content Management','2014-03-29 00:00:00',1,170),(194,'Content Management_TAG_All_Country_Delete','Delete','Content Management','2014-03-29 00:00:00',1,170),(195,'Content Management_Campaign_Own_Country_Download','Download','Content Management','2014-03-29 00:00:00',1,163),(196,'Content Management_Campaign_All_Country_Download','Download','Content Management','2014-03-29 00:00:00',1,164),(197,'Reporting_User_Performance','User Performance','Reporting','2014-09-18 00:00:00',1,6),(198,'Reporting_User_Activity','User Activity','Reporting','2014-09-18 00:00:00',1,6);
/*!40000 ALTER TABLE `application_role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-09 12:06:24