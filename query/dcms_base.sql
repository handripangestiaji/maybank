CREATE DATABASE  IF NOT EXISTS `dcms` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `dcms`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: dcms
-- ------------------------------------------------------
-- Server version	5.6.16

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
-- Table structure for table `app_navigation`
--

DROP TABLE IF EXISTS `app_navigation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_navigation` (
  `navigation_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `order` tinyint(4) DEFAULT NULL,
  `url_destination` varchar(45) DEFAULT NULL,
  `lang` char(2) DEFAULT NULL COMMENT 'id or en\n',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`navigation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_navigation`
--

LOCK TABLES `app_navigation` WRITE;
/*!40000 ALTER TABLE `app_navigation` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_navigation` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=197 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application_role`
--

LOCK TABLES `application_role` WRITE;
/*!40000 ALTER TABLE `application_role` DISABLE KEYS */;
INSERT INTO `application_role` VALUES (1,'Social Stream','Social Stream','Social Stream','2013-11-28 03:13:05',1,NULL),(2,'User Management','User Management','User Management','2013-11-28 03:40:05',1,NULL),(3,'Publishing Box','Publishing Box','Publishing Box','2013-11-28 03:40:30',1,NULL),(4,'Publisher','Publisher','Publisher','2013-11-28 03:40:57',1,NULL),(5,'Content Management','Content Management','Content Management','2013-12-16 11:17:35',1,NULL),(6,'Reporting','Reporting','Reporting','2013-12-16 11:17:35',1,NULL),(7,'Social Channel Management','Social Channel Management','Social Channel Management','2013-12-16 11:19:40',1,NULL),(8,'Social Stream_Channel','Channel','Social Stream','2013-12-16 11:19:40',1,1),(9,'Social Stream_Case','Case','Social Stream','2013-12-16 11:19:40',1,8),(38,'Publishing Box_Assigned_Channel','Assigned_Channel','Publishing Box',NULL,NULL,3),(39,'Publishing Box_All_Channel','All_Channel','Publishing Box',NULL,NULL,3),(40,'Publisher_Current_Channel','Current Channel','Publisher',NULL,NULL,4),(41,'Publisher_Current_Delete_Post','Delete Post','Publisher',NULL,NULL,40),(42,'Publisher_All_Channel','All Channel','Publisher',NULL,NULL,4),(43,'Publisher_All_View_Post','View Post','Publisher',NULL,NULL,42),(44,'Publisher_All_Delete_Post','Delete Post','Publisher',NULL,NULL,42),(63,'Reporting_View','View','Reporting',NULL,NULL,6),(64,'Reporting_View_Current_Channel','Current Channel','Reporting',NULL,NULL,63),(65,'Reporting_View_Own_Country','All Countrys Channel','Reporting',NULL,NULL,63),(66,'Reporting_View_All_Country','All Available Channel','Reporting',NULL,NULL,63),(67,'Reporting_Download','Download','Reporting',NULL,NULL,6),(68,'Reporting_Download_Current_Channel','Current Channel','Reporting',NULL,NULL,67),(69,'Reporting_Download_Own_Country','All Countrys Channel','Reporting',NULL,NULL,67),(70,'Reporting_Download_All_Country','All Available Channel','Reporting',NULL,NULL,67),(71,'Social Channel Management_Channel','Channel','Social Channel Management',NULL,NULL,7),(72,'Social Channel Management_Own_Country','Own Country','Social Channel Management',NULL,NULL,71),(73,'Social Channel Management_Other_Country','Other Country','Social Channel Management',NULL,NULL,71),(77,'Social Stream_Notification','Case Notification','Social Stream','2014-02-20 00:00:00',1,1),(78,'Search','Search','Search','2014-02-20 00:00:00',1,NULL),(80,'Publisher_All_Edit_Post','Edit Post','Publisher','2014-02-20 00:00:00',1,42),(85,'Social Channel Management_Country','Country','Social Channel Management','2014-02-20 00:00:00',1,7),(86,'Social Channel Management_Country_Add','Add','Social Channel Management','2014-02-20 00:00:00',1,85),(87,'Social Channel Management_Country_Delete','Delete','Social Channel Management','2014-02-20 00:00:00',1,85),(92,'Social Channel Management_Own_Country_Add','Add','Social Channel Management','2014-02-25 00:00:00',1,72),(93,'Social Channel Management_Own_Country_View','View','Social Channel Management','2014-02-25 00:00:00',1,72),(94,'Social Channel Management_Own_Country_Delete','Delete','Social Channel Management','2014-02-25 00:00:00',1,72),(95,'Social Channel Management_Other_Country_Add','Add','Social Channel Management','2014-02-25 00:00:00',1,73),(96,'Social Channel Management_Other_Country_View','View','Social Channel Management','2014-02-25 00:00:00',1,73),(97,'Social Channel Management_Other_Country_Delete','Delete','Social Channel Management','2014-02-25 00:00:00',1,73),(98,'Social Stream_Channel_General_Function','General Function','Social Stream','2014-02-25 00:00:00',1,8),(99,'Social Stream_Channel_General_Function_Own_Country','Own Country','Social Stream','2014-02-25 00:00:00',1,98),(100,'Social Stream_Channel_General_Function_All_Country','All Country','Social Stream','2014-02-25 00:00:00',1,98),(101,'Social Stream_Channel_General_Function_Own_Country_Reply','Reply','Social Stream','2014-02-25 00:00:00',1,99),(102,'Social Stream_Channel_General_Function_Own_Country_Delete','Delete','Social Stream','2014-02-25 00:00:00',1,99),(103,'Social Stream_Channel_General_Function_All_Country_Reply','Reply','Social Stream','2014-02-25 00:00:00',1,100),(104,'Social Stream_Channel_General_Function_All_Country_Delete','Delete','Social Stream','2014-02-25 00:00:00',1,100),(105,'Social Stream_Case_Own_Country','Own Country','Social Stream','2014-02-25 00:00:00',1,9),(106,'Social Stream_Case_Own_Country_AssignReassignResolved','Assign / Reassign /Resolved','Social Stream','2014-02-25 00:00:00',1,105),(107,'Social Stream_Case_All_Country','All Country','Social Stream','2014-02-25 00:00:00',1,9),(108,'Social Stream_Case_All_Country_AssignReassignResolved','Assign / Reassign /Resolved','Social Stream','2014-02-25 00:00:00',1,107),(109,'Social Stream_Facebook','Facebook','Social Stream','2014-02-25 00:00:00',1,8),(110,'Social Stream_Facebook_Own_Country','Own Country','Social Stream','2014-02-25 00:00:00',1,109),(111,'Social Stream_Facebook_All_Country','All Country','Social Stream','2014-02-25 00:00:00',1,109),(112,'Social Stream_Facebook_Own_Country_LikeUnlike','Like/Unlike','Social Stream','2014-02-25 00:00:00',1,110),(113,'Social Stream_Facebook_All_Country_LikeUnlike','Like/Unlike','Social Stream','2014-02-25 00:00:00',1,111),(114,'Social Stream_Twitter','Twitter','Social Stream','2014-02-25 00:00:00',1,8),(115,'Social Stream_Twitter_Own_Country','Own Country','Social Stream','2014-02-25 00:00:00',1,114),(116,'Social Stream_Twitter_All_Country','All Country','Social Stream','2014-02-25 00:00:00',1,114),(117,'Social Stream_Twitter_Own_Country_Retweet','Retweet','Social Stream','2014-02-25 00:00:00',1,115),(118,'Social Stream_Twitter_Own_Country_Favorite','Favorite','Social Stream','2014-02-25 00:00:00',1,115),(119,'Social Stream_Twitter_Own_Country_Follow','Follow','Social Stream','2014-02-25 00:00:00',1,115),(120,'Social Stream_Twitter_All_Country_Retweet','Retweet','Social Stream','2014-02-25 00:00:00',1,116),(121,'Social Stream_Twitter_All_Country_Favorite','Favorite','Social Stream','2014-02-25 00:00:00',1,116),(122,'Social Stream_Twitter_All_Country_Follow','Follow','Social Stream','2014-02-25 00:00:00',1,116),(123,'User Management_User','User','User Management','2014-02-25 00:00:00',1,2),(124,'User Management_Role','Role','User Management','2014-02-25 00:00:00',1,2),(125,'User Management_Group','Group','User Management','2014-02-25 00:00:00',1,2),(126,'User Management_View_Region','View By Region','User Management','2014-02-25 00:00:00',1,2),(127,'User Management_User_Own_Country','Own Country','User Management','2014-02-25 00:00:00',1,123),(128,'User Management_User_All_Country','All Country','User Management','2014-02-25 00:00:00',1,123),(129,'User Management_Role_Own_Country','Own Country','User Management','2014-02-25 00:00:00',1,124),(130,'User Management_Role_All_Country','All Country','User Management','2014-02-25 00:00:00',1,124),(131,'User Management_Group_Own_Country','Own Country','User Management','2014-02-25 00:00:00',1,125),(132,'User Management_Group_All_Country','All Country','User Management','2014-02-25 00:00:00',1,125),(133,'User Management_User_Own_Country_View','View','User Management','2014-02-25 00:00:00',1,127),(134,'User Management_User_Own_Country_Create','Create','User Management','2014-02-25 00:00:00',1,127),(135,'User Management_User_Own_Country_Edit','Edit','User Management','2014-02-25 00:00:00',1,127),(136,'User Management_User_Own_Country_Delete','Delete','User Management','2014-02-25 00:00:00',1,127),(137,'User Management_User_All_Country_View','View','User Management','2014-02-25 00:00:00',1,128),(138,'User Management_User_All_Country_Create','Create','User Management','2014-02-25 00:00:00',1,128),(139,'User Management_User_All_Country_Edit','Edit','User Management','2014-02-25 00:00:00',1,128),(140,'User Management_User_All_Country_Delete','Delete','User Management','2014-02-25 00:00:00',1,128),(141,'User Management_Role_Own_Country_View','View','User Management','2014-02-25 00:00:00',1,129),(142,'User Management_Role_Own_Country_Create','Create','User Management','2014-02-25 00:00:00',1,129),(143,'User Management_Role_Own_Country_Edit','Edit','User Management','2014-02-25 00:00:00',1,129),(144,'User Management_Role_Own_Country_Delete','Delete','User Management','2014-02-25 00:00:00',1,129),(145,'User Management_Role_All_Country_View','View','User Management','2014-02-25 00:00:00',1,130),(146,'User Management_Role_All_Country_Create','Create','User Management','2014-02-25 00:00:00',1,130),(147,'User Management_Role_All_Country_Edit','Edit','User Management','2014-02-25 00:00:00',1,130),(148,'User Management_Role_All_Country_Delete','Delete','User Management','2014-02-25 00:00:00',1,130),(149,'User Management_Group_Own_Country_View','View','User Management','2014-02-25 00:00:00',1,131),(150,'User Management_Group_Own_Country_Create','Create','User Management','2014-02-25 00:00:00',1,131),(151,'User Management_Group_Own_Country_Edit','Edit','User Management','2014-02-25 00:00:00',1,131),(152,'User Management_Group_Own_Country_Delete','Delete','User Management','2014-02-25 00:00:00',1,131),(153,'User Management_Group_All_Country_View','View','User Management','2014-02-25 00:00:00',1,132),(154,'User Management_Group_All_Country_Create','Create','User Management','2014-02-25 00:00:00',1,132),(155,'User Management_Group_All_Country_Edit','Edit','User Management','2014-02-25 00:00:00',1,132),(156,'User Management_Group_All_Country_Delete','Delete','User Management','2014-02-25 00:00:00',1,132),(157,'Social Stream_Channel_General_Function_Own_Country_View','View','Social Stream','2014-02-25 00:00:00',1,99),(158,'Social Stream_Channel_General_Function_All_Country_View','View','Social Stream','2014-02-25 00:00:00',1,100),(159,'Content Management_Campaign','Campaign','Content Management','2014-03-29 00:00:00',1,5),(160,'Content Management_Short_URL','Short URL','Content Management','2014-03-29 00:00:00',1,5),(161,'Content Management_Product','Product','Content Management','2014-03-29 00:00:00',1,5),(162,'Content Management_TAG','TAG','Content Management','2014-03-29 00:00:00',1,5),(163,'Content Management_Campaign_Own_Country','Own Country','Content Management','2014-03-29 00:00:00',1,159),(164,'Content Management_Campaign_All_Country','All Country','Content Management','2014-03-29 00:00:00',1,159),(165,'Content Management_Short_URL_Own Country','Own Country','Content Management','2014-03-29 00:00:00',1,160),(166,'Content Management_Short_URL_All_Country','All Country','Content Management','2014-03-29 00:00:00',1,160),(168,'Content Management_Product_All_Country','All Country','Content Management','2014-03-29 00:00:00',1,161),(170,'Content Management_TAG_All_Country','All Country','Content Management','2014-03-29 00:00:00',1,162),(171,'Content Management_Campaign_Own_Country_View','View','Content Management','2014-03-29 00:00:00',1,163),(172,'Content Management_Campaign_Own_Country_Create','Create','Content Management','2014-03-29 00:00:00',1,163),(173,'Content Management_Campaign_Own_Country_Delete','Delete','Content Management','2014-03-29 00:00:00',1,163),(174,'Content Management_Campaign_Own_Country_Edit','Edit','Content Management','2014-03-29 00:00:00',1,163),(175,'Content Management_Campaign_All_Country_View','View','Content Management','2014-03-29 00:00:00',1,164),(176,'Content Management_Campaign_All_Country_Create','Create','Content Management','2014-03-29 00:00:00',1,164),(177,'Content Management_Campaign_All_Country_Edit','Edit','Content Management','2014-03-29 00:00:00',1,164),(178,'Content Management_Campaign_All_Country_Delete','Delete','Content Management','2014-03-29 00:00:00',1,164),(179,'Content Management_Short_URL_Own_Country_View','View','Content Management','2014-03-29 00:00:00',1,165),(180,'Content Management_Short_URL_Own_Country_Create','Create','Content Management','2014-03-29 00:00:00',1,165),(181,'Content Management_Short_URL_Own_Country_Edit','Edit','Content Management','2014-03-29 00:00:00',1,165),(182,'Content Management_Short_URL_Own_Country_Delete','Delete','Content Management','2014-03-29 00:00:00',1,165),(183,'Content Management_Short_URL_All_Country_View','View','Content Management','2014-03-29 00:00:00',1,166),(184,'Content Management_Short_URL_All_Country_Create','Create','Content Management','2014-03-29 00:00:00',1,166),(185,'Content Management_Short_URL_All_Country_Edit','Edit','Content Management','2014-03-29 00:00:00',1,166),(186,'Content Management_Short_URL_All_Country_Delete','Delete','Content Management','2014-03-29 00:00:00',1,166),(187,'Content Management_Product_All_Country_View','View','Content Management','2014-03-29 00:00:00',1,168),(188,'Content Management_Product_All_Country_Create','Create','Content Management','2014-03-29 00:00:00',1,168),(189,'Content Management_Product_All_Country_Delete','Delete','Content Management','2014-03-29 00:00:00',1,168),(190,'Content Management_Product_All_Country_Edit','Edit','Content Management','2014-03-29 00:00:00',1,168),(191,'Content Management_TAG_All_Country_View','View','Content Management','2014-03-29 00:00:00',1,170),(192,'Content Management_TAG_All_Country_Create','Create','Content Management','2014-03-29 00:00:00',1,170),(193,'Content Management_TAG_All_Country_Edit','Edit','Content Management','2014-03-29 00:00:00',1,170),(194,'Content Management_TAG_All_Country_Delete','Delete','Content Management','2014-03-29 00:00:00',1,170),(195,'Content Management_Campaign_Own_Country_Download','Download','Content Management','2014-03-29 00:00:00',1,163),(196,'Content Management_Campaign_All_Country_Download','Download','Content Management','2014-03-29 00:00:00',1,164);
/*!40000 ALTER TABLE `application_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `case`
--

DROP TABLE IF EXISTS `case`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `case` (
  `case_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_products_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `assign_to` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `messages` varchar(255) DEFAULT NULL,
  `status` varchar(64) DEFAULT 'pending' COMMENT 'pending, read, not solved, solved\n',
  `related_conversation_count` int(11) NOT NULL DEFAULT '0',
  `case_type` varchar(64) DEFAULT 'feedback' COMMENT 'enquiry, feedback, complaint',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `post_id` bigint(20) NOT NULL,
  `solved_by` int(11) DEFAULT NULL,
  `solved_at` datetime DEFAULT NULL,
  `solved_message` varchar(255) DEFAULT NULL,
  `read` tinyint(4) NOT NULL DEFAULT '0',
  `old_case_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`case_id`),
  KEY `fk_Case_user1_idx` (`created_by`),
  KEY `fk_Case_user2_idx` (`assign_to`),
  KEY `fk_case_social_stream1_idx` (`post_id`),
  KEY `fk_case_user3_idx` (`solved_by`),
  KEY `fk_Case_content_products1_idx` (`content_products_id`),
  KEY `fk_case_old_case_id_idx` (`old_case_id`),
  CONSTRAINT `fk_Case_content_products1` FOREIGN KEY (`content_products_id`) REFERENCES `content_products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_case_old_case_id` FOREIGN KEY (`old_case_id`) REFERENCES `case` (`case_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_case_social_stream1` FOREIGN KEY (`post_id`) REFERENCES `social_stream` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Case_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Case_user2` FOREIGN KEY (`assign_to`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_case_user3` FOREIGN KEY (`solved_by`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=404 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `case`
--

LOCK TABLES `case` WRITE;
/*!40000 ALTER TABLE `case` DISABLE KEYS */;
/*!40000 ALTER TABLE `case` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=355 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `case_assign_detail`
--

LOCK TABLES `case_assign_detail` WRITE;
/*!40000 ALTER TABLE `case_assign_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `case_assign_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `case_detail`
--

DROP TABLE IF EXISTS `case_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `case_detail` (
  `case_detail_id` int(11) NOT NULL,
  `case_id` varchar(45) NOT NULL,
  PRIMARY KEY (`case_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `case_detail`
--

LOCK TABLES `case_detail` WRITE;
/*!40000 ALTER TABLE `case_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `case_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `case_related_conversation`
--

DROP TABLE IF EXISTS `case_related_conversation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `case_related_conversation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `social_stream_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `fb_comments_id` bigint(20) DEFAULT NULL,
  `fb_conversation_detail_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_case_related_conversation_case1_idx` (`case_id`),
  KEY `fk_case_related_conversation_social_stream1_idx` (`social_stream_id`),
  KEY `fk_case_related_conversation_social_stream_fb_comments1_idx` (`fb_comments_id`),
  KEY `fk_case_related_conversation_fb_conversation_idx` (`fb_conversation_detail_id`),
  CONSTRAINT `fk_case_related_conversation_case1` FOREIGN KEY (`case_id`) REFERENCES `case` (`case_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_case_related_conversation_fb_conversation` FOREIGN KEY (`fb_conversation_detail_id`) REFERENCES `social_stream_facebook_conversation_detail` (`detail_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_case_related_conversation_social_stream1` FOREIGN KEY (`social_stream_id`) REFERENCES `social_stream` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_case_related_conversation_social_stream_fb_comments1` FOREIGN KEY (`fb_comments_id`) REFERENCES `social_stream_fb_comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=468 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `case_related_conversation`
--

LOCK TABLES `case_related_conversation` WRITE;
/*!40000 ALTER TABLE `case_related_conversation` DISABLE KEYS */;
/*!40000 ALTER TABLE `case_related_conversation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `channel`
--

DROP TABLE IF EXISTS `channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `channel` (
  `channel_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `oauth_token` text NOT NULL,
  `oauth_secret` varchar(255) NOT NULL,
  `token_created_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `connection_type` varchar(45) NOT NULL COMMENT 'facebook, twitter, youtube\n',
  `social_id` varchar(255) NOT NULL COMMENT 'facebook page_id\ntwitter screen_name\n',
  `is_fb_page` tinyint(4) DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `country_code` char(3) DEFAULT NULL,
  PRIMARY KEY (`channel_id`),
  KEY `fk_channel_user1_idx` (`created_by`),
  KEY `fk_channel_country1_idx` (`country_code`),
  CONSTRAINT `fk_channel_country1` FOREIGN KEY (`country_code`) REFERENCES `country` (`code`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_channel_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `channel`
--

LOCK TABLES `channel` WRITE;
/*!40000 ALTER TABLE `channel` DISABLE KEYS */;
INSERT INTO `channel` VALUES (43,'MBB Playground','CAAI6IOzeVeUBAEZBSr2VxvP2Y54NkQXE4L3w8kSrj5a7s9t39qZCMZCl4jzc7nZAYTaiZAhhUm0eaOFEGJHx4tUtJHwmi5ZBeXu3ZBGKQumsp5HPrGPxrYXoQrG2ZCWefVUbZAtja4cQuTiGJv2EpqD4ZCwXPtCcUek256iAOSKhL9Dc7BtyEaHSNq01BZBD5RxsM9mxX2D7SJI15n0NG41QDHF','','2015-03-10 07:10:29',1,'facebook','272288926209649',0,NULL,'All');
/*!40000 ALTER TABLE `channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `channel_action`
--

DROP TABLE IF EXISTS `channel_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `channel_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_type` varchar(45) DEFAULT NULL COMMENT 'retweet, favourite, like, comment, conversation\n',
  `channel_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `stream_id_response` varchar(45) DEFAULT NULL,
  `post_id` bigint(20) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `log_text` text,
  `case_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_channel_action_channel1_idx` (`channel_id`),
  KEY `fk_channel_action_social_stream1_idx` (`post_id`),
  KEY `fk_channel_action_user1_idx` (`created_by`),
  KEY `fk_channel_aciton_case_id_idx` (`case_id`),
  CONSTRAINT `fk_channel_aciton_case_id` FOREIGN KEY (`case_id`) REFERENCES `case` (`case_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_channel_action_channel1` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`channel_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_channel_action_social_stream1` FOREIGN KEY (`post_id`) REFERENCES `social_stream` (`post_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_channel_action_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1369 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `channel_action`
--

LOCK TABLES `channel_action` WRITE;
/*!40000 ALTER TABLE `channel_action` DISABLE KEYS */;
/*!40000 ALTER TABLE `channel_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `channel_twitter_progress`
--

DROP TABLE IF EXISTS `channel_twitter_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `channel_twitter_progress` (
  `progress_id` int(11) NOT NULL AUTO_INCREMENT,
  `channel_id` int(11) NOT NULL,
  `friends_count` int(11) DEFAULT NULL,
  `status_count` int(11) DEFAULT NULL,
  `followers_count` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`progress_id`),
  KEY `fk_channel_twitter_progress_channel1_idx` (`channel_id`),
  CONSTRAINT `fk_channel_twitter_progress_channel1` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`channel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `channel_twitter_progress`
--

LOCK TABLES `channel_twitter_progress` WRITE;
/*!40000 ALTER TABLE `channel_twitter_progress` DISABLE KEYS */;
/*!40000 ALTER TABLE `channel_twitter_progress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_action`
--

DROP TABLE IF EXISTS `content_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `action_type` varchar(50) NOT NULL,
  `slug` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_action`
--

LOCK TABLES `content_action` WRITE;
/*!40000 ALTER TABLE `content_action` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_campaign`
--

DROP TABLE IF EXISTS `content_campaign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_campaign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_name` varchar(255) DEFAULT NULL,
  `description` text,
  `tag` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `increment` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `country_code` char(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `fk_content_campaign_country1_idx` (`country_code`),
  CONSTRAINT `content_campaign_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_content_campaign_country1` FOREIGN KEY (`country_code`) REFERENCES `country` (`code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_campaign`
--

LOCK TABLES `content_campaign` WRITE;
/*!40000 ALTER TABLE `content_campaign` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_campaign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_campaign_url`
--

DROP TABLE IF EXISTS `content_campaign_url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_campaign_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) DEFAULT NULL,
  `url_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_content_campaign_url_short_urls1_idx` (`url_id`),
  CONSTRAINT `fk_content_campaign_url_short_urls1` FOREIGN KEY (`url_id`) REFERENCES `short_urls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_campaign_url`
--

LOCK TABLES `content_campaign_url` WRITE;
/*!40000 ALTER TABLE `content_campaign_url` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_campaign_url` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_products`
--

DROP TABLE IF EXISTS `content_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `increment` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `country_code` char(3) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `fk_content_products_country1_idx` (`country_code`),
  KEY `fk_parent_product_idx` (`parent_id`),
  CONSTRAINT `content_products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_content_products_country1` FOREIGN KEY (`country_code`) REFERENCES `country` (`code`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_parent_product` FOREIGN KEY (`parent_id`) REFERENCES `content_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_products`
--

LOCK TABLES `content_products` WRITE;
/*!40000 ALTER TABLE `content_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_products_campaign`
--

DROP TABLE IF EXISTS `content_products_campaign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_products_campaign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) DEFAULT NULL,
  `products_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `campaign_id` (`campaign_id`),
  KEY `products_id` (`products_id`),
  CONSTRAINT `content_products_campaign_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `content_campaign` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `content_products_campaign_ibfk_2` FOREIGN KEY (`products_id`) REFERENCES `content_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_products_campaign`
--

LOCK TABLES `content_products_campaign` WRITE;
/*!40000 ALTER TABLE `content_products_campaign` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_products_campaign` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_tag`
--

LOCK TABLES `content_tag` WRITE;
/*!40000 ALTER TABLE `content_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_tag_campaign`
--

DROP TABLE IF EXISTS `content_tag_campaign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_tag_campaign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `campaign_id` (`campaign_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `content_tag_campaign_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `content_campaign` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `content_tag_campaign_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `content_tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_tag_campaign`
--

LOCK TABLES `content_tag_campaign` WRITE;
/*!40000 ALTER TABLE `content_tag_campaign` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_tag_campaign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `code` char(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES ('All','Region','2014-02-27 16:13:30');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=355 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_store`
--

LOCK TABLES `email_store` WRITE;
/*!40000 ALTER TABLE `email_store` DISABLE KEYS */;
/*!40000 ALTER TABLE `email_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fb_user_engaged`
--

DROP TABLE IF EXISTS `fb_user_engaged`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fb_user_engaged` (
  `facebook_id` varchar(32) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(64) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `retrieved_at` datetime DEFAULT NULL,
  `sex` varchar(16) DEFAULT '',
  PRIMARY KEY (`facebook_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fb_user_engaged`
--

LOCK TABLES `fb_user_engaged` WRITE;
/*!40000 ALTER TABLE `fb_user_engaged` DISABLE KEYS */;
/*!40000 ALTER TABLE `fb_user_engaged` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group`
--

DROP TABLE IF EXISTS `group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group` (
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group`
--

LOCK TABLES `group` WRITE;
/*!40000 ALTER TABLE `group` DISABLE KEYS */;
/*!40000 ALTER TABLE `group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_permission`
--

DROP TABLE IF EXISTS `group_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_permission` (
  `group_permissions_id` int(11) NOT NULL,
  `group_id` varchar(45) DEFAULT NULL,
  `permission_id` varchar(45) DEFAULT NULL,
  `value` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`group_permissions_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_permission`
--

LOCK TABLES `group_permission` WRITE;
/*!40000 ALTER TABLE `group_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `group_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `log_id` int(11) NOT NULL,
  `user_id` varchar(45) DEFAULT NULL,
  `username` int(11) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `action` varchar(45) DEFAULT NULL,
  `additional_action` varchar(45) DEFAULT NULL,
  `category` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_reply`
--

DROP TABLE IF EXISTS `page_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_reply` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) DEFAULT NULL,
  `url` int(11) DEFAULT NULL,
  `message` text,
  `social_stream_post_id` bigint(20) DEFAULT NULL,
  `conversation_detail_id` bigint(20) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL COMMENT 'conversation_detail, comment_reply, twitter_reply, direct_message',
  `post_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_page_reply_short_urls1_idx` (`url`),
  KEY `fk_page_reply_case1_idx` (`case_id`),
  KEY `fk_page_reply_social_stream_facebook_conversation_detail1_idx` (`conversation_detail_id`),
  KEY `fk_page_reply_product_idx` (`product_id`),
  KEY `fk_page_reply_social_stream1_idx` (`social_stream_post_id`),
  KEY `fk_page_reply_user_id_idx` (`user_id`),
  CONSTRAINT `fk_page_reply_case1` FOREIGN KEY (`case_id`) REFERENCES `case` (`case_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_page_reply_product` FOREIGN KEY (`product_id`) REFERENCES `content_products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_page_reply_short_urls1` FOREIGN KEY (`url`) REFERENCES `short_urls` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_page_reply_social_stream1` FOREIGN KEY (`social_stream_post_id`) REFERENCES `social_stream` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_page_reply_social_stream_facebook_conversation_detail1` FOREIGN KEY (`conversation_detail_id`) REFERENCES `social_stream_facebook_conversation_detail` (`detail_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_page_reply_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=289 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_reply`
--

LOCK TABLES `page_reply` WRITE;
/*!40000 ALTER TABLE `page_reply` DISABLE KEYS */;
/*!40000 ALTER TABLE `page_reply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission` (
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission`
--

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `media_attachment` varchar(255) DEFAULT NULL,
  `short_urls_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `messages` text,
  `time_to_post` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `url_title` varchar(255) DEFAULT '',
  `url_description` text,
  `email_me_when_sent` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_schedule_post_short_urls1_idx` (`short_urls_id`),
  KEY `fk_schedule_post_content_campaign1_idx` (`campaign_id`),
  KEY `fk_schedule_post_user1_idx` (`created_by`),
  CONSTRAINT `fk_schedule_post_content_campaign1` FOREIGN KEY (`campaign_id`) REFERENCES `content_campaign` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_schedule_post_short_urls1` FOREIGN KEY (`short_urls_id`) REFERENCES `short_urls` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_schedule_post_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_tag`
--

DROP TABLE IF EXISTS `post_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_tag` (
  `id_tag_posts` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_post_id` int(11) NOT NULL,
  `content_tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id_tag_posts`),
  KEY `fk_table1_schedule_post1_idx` (`schedule_post_id`),
  KEY `fk_table1_content_tag1_idx` (`content_tag_id`),
  CONSTRAINT `fk_table1_content_tag1` FOREIGN KEY (`content_tag_id`) REFERENCES `content_tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_table1_schedule_post1` FOREIGN KEY (`schedule_post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_tag`
--

LOCK TABLES `post_tag` WRITE;
/*!40000 ALTER TABLE `post_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_to`
--

DROP TABLE IF EXISTS `post_to`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_to` (
  `post_to_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `post_stream_id_response` varchar(255) DEFAULT NULL,
  `post_created_at` datetime DEFAULT NULL,
  `is_posted` tinyint(4) DEFAULT NULL,
  `error_messages` text,
  `channel_id` int(11) NOT NULL,
  PRIMARY KEY (`post_to_id`),
  KEY `fk_post_to_post1_idx` (`post_id`),
  KEY `fk_post_to_channel1_idx` (`channel_id`),
  CONSTRAINT `fk_post_to_channel1` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`channel_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_post_to_post1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=234 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_to`
--

LOCK TABLES `post_to` WRITE;
/*!40000 ALTER TABLE `post_to` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_to` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_activity`
--

DROP TABLE IF EXISTS `report_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `group_id` int(11) NOT NULL,
  `rolename` varchar(45) DEFAULT NULL,
  `action` text NOT NULL,
  `status` text NOT NULL,
  `country_code` varchar(5) NOT NULL,
  `time` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4728 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_activity`
--

LOCK TABLES `report_activity` WRITE;
/*!40000 ALTER TABLE `report_activity` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_performance`
--

DROP TABLE IF EXISTS `report_performance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_performance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(64) NOT NULL,
  `channel_id` varchar(45) DEFAULT NULL,
  `channel_name` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_parent_id` int(11) DEFAULT NULL,
  `total_case` int(11) DEFAULT NULL,
  `total_solved` int(11) DEFAULT NULL,
  `average_response` double DEFAULT NULL,
  `case_type` varchar(45) DEFAULT NULL,
  `user_group_id` int(11) DEFAULT NULL,
  `user_group_name` varchar(255) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `type2` varchar(45) DEFAULT NULL,
  `generated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_code` (`code`),
  KEY `report_product_id_idx` (`product_id`),
  CONSTRAINT `report_product_id` FOREIGN KEY (`product_id`) REFERENCES `content_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1428 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_performance`
--

LOCK TABLES `report_performance` WRITE;
/*!40000 ALTER TABLE `report_performance` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_performance` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `role_collection` VALUES (10,'Tech',392227,'2014-02-12 04:51:35','All');
/*!40000 ALTER TABLE `role_collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_collection_detail`
--

DROP TABLE IF EXISTS `role_collection_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_collection_detail` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_collection_id` int(11) NOT NULL,
  `app_role_id` int(11) NOT NULL,
  PRIMARY KEY (`detail_id`),
  KEY `fk_role_collection_detail_role_collection_idx` (`role_collection_id`),
  KEY `fk_role_collection_detail_application_role1_idx` (`app_role_id`),
  CONSTRAINT `fk_role_collection_detail_application_role1` FOREIGN KEY (`app_role_id`) REFERENCES `application_role` (`app_role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_role_collection_detail_role_collection` FOREIGN KEY (`role_collection_id`) REFERENCES `role_collection` (`role_collection_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10310 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_collection_detail`
--

LOCK TABLES `role_collection_detail` WRITE;
/*!40000 ALTER TABLE `role_collection_detail` DISABLE KEYS */;
INSERT INTO `role_collection_detail` VALUES (9859,10,1),(9860,10,8),(9861,10,9),(9862,10,105),(9863,10,106),(9864,10,107),(9865,10,108),(9866,10,98),(9867,10,99),(9868,10,101),(9869,10,102),(9870,10,157),(9871,10,100),(9872,10,103),(9873,10,104),(9874,10,158),(9875,10,109),(9876,10,110),(9877,10,112),(9878,10,111),(9879,10,113),(9880,10,114),(9881,10,115),(9882,10,117),(9883,10,118),(9884,10,119),(9885,10,116),(9886,10,120),(9887,10,121),(9888,10,122),(9889,10,77),(9890,10,2),(9891,10,123),(9892,10,127),(9893,10,133),(9894,10,134),(9895,10,135),(9896,10,136),(9897,10,128),(9898,10,137),(9899,10,138),(9900,10,139),(9901,10,140),(9902,10,124),(9903,10,129),(9904,10,141),(9905,10,142),(9906,10,143),(9907,10,144),(9908,10,130),(9909,10,145),(9910,10,146),(9911,10,147),(9912,10,148),(9913,10,125),(9914,10,131),(9915,10,149),(9916,10,150),(9917,10,151),(9918,10,152),(9919,10,132),(9920,10,153),(9921,10,154),(9922,10,155),(9923,10,156),(9924,10,126),(9925,10,3),(9926,10,38),(9927,10,39),(9928,10,4),(9929,10,40),(9930,10,41),(9931,10,42),(9932,10,43),(9933,10,44),(9934,10,80),(9935,10,5),(9936,10,159),(9937,10,163),(9938,10,171),(9939,10,172),(9940,10,173),(9941,10,174),(9942,10,195),(9943,10,164),(9944,10,175),(9945,10,176),(9946,10,177),(9947,10,178),(9948,10,196),(9949,10,160),(9950,10,165),(9951,10,179),(9952,10,180),(9953,10,181),(9954,10,182),(9955,10,166),(9956,10,183),(9957,10,184),(9958,10,185),(9959,10,186),(9960,10,161),(9961,10,168),(9962,10,187),(9963,10,188),(9964,10,189),(9965,10,190),(9966,10,162),(9967,10,170),(9968,10,191),(9969,10,192),(9970,10,193),(9971,10,194),(9972,10,6),(9973,10,63),(9974,10,64),(9975,10,65),(9976,10,66),(9977,10,67),(9978,10,68),(9979,10,69),(9980,10,70),(9981,10,7),(9982,10,71),(9983,10,72),(9984,10,92),(9985,10,93),(9986,10,94),(9987,10,73),(9988,10,95),(9989,10,96),(9990,10,97),(9991,10,85),(9992,10,86),(9993,10,87),(9994,10,78);
/*!40000 ALTER TABLE `role_collection_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_navigation`
--

DROP TABLE IF EXISTS `role_navigation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_navigation` (
  `role_navigation_id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `navigation_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`role_navigation_id`),
  KEY `fk_role_navigation_app_navigation1_idx` (`navigation_id`),
  KEY `fk_role_navigation_user1_idx` (`created_by`),
  KEY `fk_role_navigation_role_collection1_idx` (`role_id`),
  CONSTRAINT `fk_role_navigation_app_navigation1` FOREIGN KEY (`navigation_id`) REFERENCES `app_navigation` (`navigation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_navigation_role_collection1` FOREIGN KEY (`role_id`) REFERENCES `role_collection` (`role_collection_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_navigation_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_navigation`
--

LOCK TABLES `role_navigation` WRITE;
/*!40000 ALTER TABLE `role_navigation` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_navigation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule_post_channel`
--

DROP TABLE IF EXISTS `schedule_post_channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_post_channel` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `schedule_post_id` int(11) NOT NULL,
  `channel_channel_id` int(11) DEFAULT NULL,
  `stream_id` varchar(255) DEFAULT NULL,
  `post_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_schedule_post_channel_schedule_post1_idx` (`schedule_post_id`),
  KEY `fk_schedule_post_channel_channel1_idx` (`channel_channel_id`),
  KEY `fk_schedule_post_channel_social_stream1_idx` (`post_id`),
  CONSTRAINT `fk_schedule_post_channel_channel1` FOREIGN KEY (`channel_channel_id`) REFERENCES `channel` (`channel_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_schedule_post_channel_schedule_post1` FOREIGN KEY (`schedule_post_id`) REFERENCES `post` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_schedule_post_channel_social_stream1` FOREIGN KEY (`post_id`) REFERENCES `social_stream` (`post_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule_post_channel`
--

LOCK TABLES `schedule_post_channel` WRITE;
/*!40000 ALTER TABLE `schedule_post_channel` DISABLE KEYS */;
/*!40000 ALTER TABLE `schedule_post_channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `setting_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `value` longtext,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` VALUES (1,'Company Name',NULL),(2,'Company Description',NULL),(3,'Facebook_app_id','626863040779749'),(4,'Twitter_app_id',NULL),(5,'Instagram_app_id',NULL),(6,'Facebook_app_secret','060cdd9c32f692f8bba6849e17862620'),(7,'Facebook_dummy_access_token','CAAI6IOzeVeUBAAe7WO4CkDCigl2mnPz7ZC92HUaRXRr1WKww970PJhdfCXeGUZCZCTzappaSAlcP9xCWj6qfMrl3DZAJeYlubbh8fQTy6qDY1oPy6t8x6vsYduRrrZCrJd9u9eYQVf5xZAJGTfJtiUl1vFTMPttmfuhtZAXlgXiHiALuddr2T4csl3NtzehcEvpLr7WZBFXBZCidcpyBKnPTDYEo7AU5hQcgZD');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `short_url_tag`
--

DROP TABLE IF EXISTS `short_url_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `short_url_tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `short_urls_id` int(11) NOT NULL,
  `content_tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_short_url_tag_short_urls1_idx` (`short_urls_id`),
  KEY `fk_short_url_tag_content_tag1_idx` (`content_tag_id`),
  CONSTRAINT `fk_short_url_tag_content_tag1` FOREIGN KEY (`content_tag_id`) REFERENCES `content_tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_short_url_tag_short_urls1` FOREIGN KEY (`short_urls_id`) REFERENCES `short_urls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `short_url_tag`
--

LOCK TABLES `short_url_tag` WRITE;
/*!40000 ALTER TABLE `short_url_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `short_url_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `short_urls`
--

DROP TABLE IF EXISTS `short_urls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `short_urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `long_url` text,
  `short_code` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `increment` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text,
  `user_id` int(11) DEFAULT NULL,
  `qrcode_image` varchar(255) DEFAULT NULL,
  `country_code` char(3) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `short_code_UNIQUE` (`short_code`),
  KEY `user_id_idx` (`user_id`),
  KEY `fk_short_urls_country1_idx` (`country_code`),
  KEY `fk_short_urls_content_products1_idx` (`product_id`),
  CONSTRAINT `fk_short_urls_content_products1` FOREIGN KEY (`product_id`) REFERENCES `content_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_short_urls_country1` FOREIGN KEY (`country_code`) REFERENCES `country` (`code`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=365 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `short_urls`
--

LOCK TABLES `short_urls` WRITE;
/*!40000 ALTER TABLE `short_urls` DISABLE KEYS */;
/*!40000 ALTER TABLE `short_urls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_stream`
--

DROP TABLE IF EXISTS `social_stream`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_stream` (
  `post_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_stream_id` varchar(255) NOT NULL COMMENT 'id from facebook, twitter or youtube\n',
  `channel_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT 'conversation_fb\nstream_fb\nstream_twitter\ndm_twitter\n',
  `retrieved_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT '0',
  `replied_count` int(11) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`),
  KEY `social_stream_id` (`post_stream_id`),
  KEY `fk_social_stream_channel1_idx` (`channel_id`),
  KEY `replied_count` (`replied_count`),
  KEY `idx_type` (`type`),
  CONSTRAINT `fk_social_stream_channel1` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`channel_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1515246 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_stream`
--

LOCK TABLES `social_stream` WRITE;
/*!40000 ALTER TABLE `social_stream` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_stream` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=1515246 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_stream_facebook_conversation`
--

LOCK TABLES `social_stream_facebook_conversation` WRITE;
/*!40000 ALTER TABLE `social_stream_facebook_conversation` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_stream_facebook_conversation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_stream_facebook_conversation_detail`
--

DROP TABLE IF EXISTS `social_stream_facebook_conversation_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_stream_facebook_conversation_detail` (
  `detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `detail_id_from_facebook` varchar(255) DEFAULT NULL,
  `attachment` text,
  `messages` text,
  `sender` varchar(32) NOT NULL,
  `to` varchar(32) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `conversation_id` bigint(20) NOT NULL,
  PRIMARY KEY (`detail_id`),
  UNIQUE KEY `conversation_detail_id` (`detail_id_from_facebook`),
  KEY `fk_social_stream_facebook_conversation_detail_fb_user_engag_idx` (`sender`),
  KEY `fk_social_stream_facebook_conversation_detail_fb_user_engag_idx1` (`to`),
  KEY `fk_social_stream_facebook_conversation_detail_social_stream_idx` (`conversation_id`),
  CONSTRAINT `fk_social_stream_facebook_conversation_detail_fb_user_engagged1` FOREIGN KEY (`sender`) REFERENCES `fb_user_engaged` (`facebook_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_facebook_conversation_detail_fb_user_engagged2` FOREIGN KEY (`to`) REFERENCES `fb_user_engaged` (`facebook_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_facebook_conversation_detail_social_stream_f1` FOREIGN KEY (`conversation_id`) REFERENCES `social_stream_facebook_conversation` (`conversation_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=534889773270320 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_stream_facebook_conversation_detail`
--

LOCK TABLES `social_stream_facebook_conversation_detail` WRITE;
/*!40000 ALTER TABLE `social_stream_facebook_conversation_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_stream_facebook_conversation_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_stream_fb_comments`
--

DROP TABLE IF EXISTS `social_stream_fb_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_stream_fb_comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `comment_stream_id` varchar(64) NOT NULL,
  `from` varchar(32) NOT NULL,
  `comment_content` text,
  `created_at` datetime DEFAULT NULL,
  `retrieved_at` datetime DEFAULT NULL,
  `like_count` int(11) DEFAULT NULL,
  `user_likes` tinyint(4) DEFAULT '0',
  `hierarchy` tinyint(4) DEFAULT NULL,
  `comment_id` varchar(64) DEFAULT NULL,
  `attachment` text,
  `is_read` tinyint(1) DEFAULT '0' COMMENT '1 = read\n0 = unread',
  `post_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `comment_stream_id_UNIQUE` (`comment_stream_id`),
  KEY `fk_social_stream_facebook_comments_facebook_user_engagged1_idx` (`from`),
  KEY `fk_social_stream_fb_comments_social_stream_fb_post1_idx` (`post_id`),
  CONSTRAINT `fk_social_stream_facebook_comments_facebook_user_engagged1` FOREIGN KEY (`from`) REFERENCES `fb_user_engaged` (`facebook_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_social_stream_fb_comments_social_stream_fb_post1` FOREIGN KEY (`post_id`) REFERENCES `social_stream_fb_post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_social_stream_fb_comment_id` FOREIGN KEY (`id`) REFERENCES `social_stream` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1515227 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_stream_fb_comments`
--

LOCK TABLES `social_stream_fb_comments` WRITE;
/*!40000 ALTER TABLE `social_stream_fb_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_stream_fb_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_stream_fb_conversation_participant`
--

DROP TABLE IF EXISTS `social_stream_fb_conversation_participant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_stream_fb_conversation_participant` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fb_user_id` varchar(32) NOT NULL,
  `conversation_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_social_stream_fb_conversation_participant_fb_user_engagg_idx` (`fb_user_id`),
  KEY `fk_social_stream_fb_conversation_participant_social_stream__idx` (`conversation_id`),
  CONSTRAINT `fk_social_stream_fb_conversation_participant_fb_user_engagged1` FOREIGN KEY (`fb_user_id`) REFERENCES `fb_user_engaged` (`facebook_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_fb_conversation_participant_social_stream_fa1` FOREIGN KEY (`conversation_id`) REFERENCES `social_stream_facebook_conversation` (`conversation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_stream_fb_conversation_participant`
--

LOCK TABLES `social_stream_fb_conversation_participant` WRITE;
/*!40000 ALTER TABLE `social_stream_fb_conversation_participant` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_stream_fb_conversation_participant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_stream_fb_likes`
--

DROP TABLE IF EXISTS `social_stream_fb_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_stream_fb_likes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL,
  `facebook_id` varchar(32) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `retrieved_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_social_stream_facebook_likes_social_stream_facebook_post_idx` (`post_id`),
  KEY `fk_social_stream_facebook_likes_facebook_user_engagged1_idx` (`facebook_id`),
  CONSTRAINT `fk_social_stream_facebook_likes_facebook_user_engagged1` FOREIGN KEY (`facebook_id`) REFERENCES `fb_user_engaged` (`facebook_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_stream_facebook_likes_social_stream_facebook_post1` FOREIGN KEY (`post_id`) REFERENCES `social_stream_fb_post` (`post_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_stream_fb_likes`
--

LOCK TABLES `social_stream_fb_likes` WRITE;
/*!40000 ALTER TABLE `social_stream_fb_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_stream_fb_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_stream_fb_post`
--

DROP TABLE IF EXISTS `social_stream_fb_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_stream_fb_post` (
  `post_id` bigint(20) NOT NULL,
  `post_content` text,
  `author_id` varchar(32) NOT NULL,
  `attachment` text,
  `enggagement_count` int(11) DEFAULT NULL,
  `total_likes` int(11) DEFAULT NULL,
  `user_likes` tinyint(4) NOT NULL DEFAULT '0',
  `total_comments` int(11) DEFAULT NULL,
  `total_shares` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_customer_post` tinyint(4) NOT NULL DEFAULT '0',
  `post_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = published\n2 = removed\n',
  PRIMARY KEY (`post_id`),
  KEY `fk_social_stream_fb_post_fb_user_engaged1_idx` (`author_id`),
  CONSTRAINT `fk_social_stream_facebook_social_stream1` FOREIGN KEY (`post_id`) REFERENCES `social_stream` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_social_stream_fb_post_fb_user_engaged1` FOREIGN KEY (`author_id`) REFERENCES `fb_user_engaged` (`facebook_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_stream_fb_post`
--

LOCK TABLES `social_stream_fb_post` WRITE;
/*!40000 ALTER TABLE `social_stream_fb_post` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_stream_fb_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_stream_notification`
--

DROP TABLE IF EXISTS `social_stream_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_stream_notification` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `social_stream_post_id` bigint(20) NOT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `read_at` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_social_stream_notification_social_stream1_idx` (`social_stream_post_id`),
  KEY `fk_social_stream_notification_user1_idx` (`user_id`),
  CONSTRAINT `fk_social_stream_notification_social_stream1` FOREIGN KEY (`social_stream_post_id`) REFERENCES `social_stream` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_social_stream_notification_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_stream_notification`
--

LOCK TABLES `social_stream_notification` WRITE;
/*!40000 ALTER TABLE `social_stream_notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_stream_notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_stream_twitter`
--

DROP TABLE IF EXISTS `social_stream_twitter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_stream_twitter` (
  `post_id` bigint(20) NOT NULL,
  `type` varchar(32) DEFAULT NULL COMMENT 'Direct Messages, User Timeline, Mentions Timeline',
  `retweeted` tinyint(4) NOT NULL DEFAULT '0',
  `favorited` tinyint(4) DEFAULT NULL,
  `in_reply_to` bigint(20) DEFAULT NULL,
  `twitter_entities` text,
  `text` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `retweet_count` int(11) DEFAULT NULL,
  `geolocation` text,
  `is_following` tinyint(4) DEFAULT '1',
  `source` varchar(255) DEFAULT NULL,
  `twitter_user_id` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL COMMENT 'mentions, direct_message, hashtags, homefeed, own_post\n',
  PRIMARY KEY (`post_id`),
  KEY `fk_social_stream_twitter_social_stream_twitter1_idx` (`in_reply_to`),
  KEY `fk_social_stream_twitter_twitter_user_engaged1_idx` (`twitter_user_id`),
  KEY `idx_type` (`type`) USING BTREE,
  CONSTRAINT `fk_social_stream_twitter_social_stream1` FOREIGN KEY (`post_id`) REFERENCES `social_stream` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_social_stream_twitter_social_stream_twitter1` FOREIGN KEY (`in_reply_to`) REFERENCES `social_stream_twitter` (`post_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_social_stream_twitter_twitter_user_engaged1` FOREIGN KEY (`twitter_user_id`) REFERENCES `twitter_user_engaged` (`twitter_user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_stream_twitter`
--

LOCK TABLES `social_stream_twitter` WRITE;
/*!40000 ALTER TABLE `social_stream_twitter` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_stream_twitter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_stream_youtube`
--

DROP TABLE IF EXISTS `social_stream_youtube`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_stream_youtube` (
  `post_id` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `thumbnail_default` varchar(255) DEFAULT NULL,
  `thumbnail_high` varchar(255) DEFAULT NULL,
  `video_id` varchar(255) DEFAULT NULL,
  `player_web` text,
  `player_mobile` text,
  `rating` int(11) DEFAULT '0',
  `like_count` int(11) DEFAULT '0',
  `rating_count` int(11) DEFAULT '0',
  `favorite_count` int(11) DEFAULT '0',
  `comment_count` int(11) DEFAULT '0',
  `view_count` int(11) DEFAULT '0',
  `etag` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `uploaded` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  CONSTRAINT `fk_social_stream_youtube_social_stream1` FOREIGN KEY (`post_id`) REFERENCES `social_stream` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_stream_youtube`
--

LOCK TABLES `social_stream_youtube` WRITE;
/*!40000 ALTER TABLE `social_stream_youtube` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_stream_youtube` ENABLE KEYS */;
UNLOCK TABLES;

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
/*!40000 ALTER TABLE `social_stream_youtube_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stream_facebook`
--

DROP TABLE IF EXISTS `stream_facebook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stream_facebook` (
  `stream_facebook_id` int(11) NOT NULL,
  `channel_id` varchar(45) NOT NULL,
  PRIMARY KEY (`stream_facebook_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stream_facebook`
--

LOCK TABLES `stream_facebook` WRITE;
/*!40000 ALTER TABLE `stream_facebook` DISABLE KEYS */;
/*!40000 ALTER TABLE `stream_facebook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stream_google_plus`
--

DROP TABLE IF EXISTS `stream_google_plus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stream_google_plus` (
  `stream_google_plus_id` int(11) NOT NULL,
  `channel_id` varchar(45) NOT NULL,
  PRIMARY KEY (`stream_google_plus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stream_google_plus`
--

LOCK TABLES `stream_google_plus` WRITE;
/*!40000 ALTER TABLE `stream_google_plus` DISABLE KEYS */;
/*!40000 ALTER TABLE `stream_google_plus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stream_twitter`
--

DROP TABLE IF EXISTS `stream_twitter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stream_twitter` (
  `stream_twitter_id` int(11) NOT NULL,
  `channel_id` varchar(45) NOT NULL,
  PRIMARY KEY (`stream_twitter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='	';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stream_twitter`
--

LOCK TABLES `stream_twitter` WRITE;
/*!40000 ALTER TABLE `stream_twitter` DISABLE KEYS */;
/*!40000 ALTER TABLE `stream_twitter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stream_youtube`
--

DROP TABLE IF EXISTS `stream_youtube`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stream_youtube` (
  `stream_youtube_id` int(11) NOT NULL,
  `channel_id` varchar(45) NOT NULL,
  PRIMARY KEY (`stream_youtube_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stream_youtube`
--

LOCK TABLES `stream_youtube` WRITE;
/*!40000 ALTER TABLE `stream_youtube` DISABLE KEYS */;
/*!40000 ALTER TABLE `stream_youtube` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id_tags` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_tags`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `twitter_direct_messages`
--

DROP TABLE IF EXISTS `twitter_direct_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twitter_direct_messages` (
  `post_id` bigint(20) NOT NULL,
  `entities` text,
  `text` varchar(255) DEFAULT NULL,
  `sender` bigint(20) NOT NULL,
  `recipient` bigint(20) NOT NULL,
  `type` varchar(16) DEFAULT 'inbox' COMMENT 'inbox, outbox',
  PRIMARY KEY (`post_id`),
  KEY `fk_twitter_direct_messages_social_stream1_idx` (`post_id`),
  KEY `fk_twitter_direct_messages_twitter_user_engaged1_idx` (`sender`),
  KEY `fk_twitter_direct_messages_twitter_user_engaged2_idx` (`recipient`),
  CONSTRAINT `fk_twitter_direct_messages_social_stream1` FOREIGN KEY (`post_id`) REFERENCES `social_stream` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_twitter_direct_messages_twitter_user_engaged1` FOREIGN KEY (`sender`) REFERENCES `twitter_user_engaged` (`twitter_user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_twitter_direct_messages_twitter_user_engaged2` FOREIGN KEY (`recipient`) REFERENCES `twitter_user_engaged` (`twitter_user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twitter_direct_messages`
--

LOCK TABLES `twitter_direct_messages` WRITE;
/*!40000 ALTER TABLE `twitter_direct_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `twitter_direct_messages` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Table structure for table `twitter_user_engaged`
--

DROP TABLE IF EXISTS `twitter_user_engaged`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twitter_user_engaged` (
  `twitter_user_id` bigint(20) NOT NULL,
  `screen_name` varchar(255) DEFAULT NULL,
  `profile_image_url` text,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `statuses_count` int(11) DEFAULT NULL,
  `friends_count` int(11) DEFAULT NULL,
  `followers_count` int(11) DEFAULT NULL,
  `verified_account` tinyint(4) DEFAULT NULL COMMENT '1 = verified , 0 = unverified',
  `time_zone` varchar(255) DEFAULT NULL,
  `following` tinyint(4) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `retrieved_at` datetime DEFAULT NULL,
  PRIMARY KEY (`twitter_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twitter_user_engaged`
--

LOCK TABLES `twitter_user_engaged` WRITE;
/*!40000 ALTER TABLE `twitter_user_engaged` DISABLE KEYS */;
/*!40000 ALTER TABLE `twitter_user_engaged` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL DEFAULT 'maybank_salt',
  `description` text,
  `image_url` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `timezone` varchar(63) NOT NULL DEFAULT 'Asia/Jakarta',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `location` varchar(255) DEFAULT NULL,
  `web_address` varchar(255) DEFAULT NULL,
  `country_code` char(3) DEFAULT NULL,
  `is_hidden` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  KEY `user_created_by_idx` (`created_by`),
  KEY `fk_user_role_collection1_idx` (`role_id`),
  KEY `fk_user_app_group1_idx` (`group_id`),
  KEY `fk_user_country1_idx` (`country_code`),
  CONSTRAINT `fk_user_app_group1` FOREIGN KEY (`group_id`) REFERENCES `user_group` (`group_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_user_country1` FOREIGN KEY (`country_code`) REFERENCES `country` (`code`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_user_role_collection1` FOREIGN KEY (`role_id`) REFERENCES `role_collection` (`role_collection_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=392269 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (392187,'robbi','tes','robbin','robbi@nowhere.com','2013-12-12 09:59:33',NULL,'35481a2220e3de8604ac0c5f18d324b8','1386842373','testing',NULL,10,25,'Asia/Jakarta',1,'','','All',0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_forgot_password`
--

DROP TABLE IF EXISTS `user_forgot_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_forgot_password` (
  `forgot_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  PRIMARY KEY (`forgot_id`),
  KEY `fk_user_forgot_password_user1_idx` (`user_id`),
  CONSTRAINT `fk_user_forgot_password_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_forgot_password`
--

LOCK TABLES `user_forgot_password` WRITE;
/*!40000 ALTER TABLE `user_forgot_password` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_forgot_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `country_code` char(3) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  KEY `fk_user_group_user1_idx` (`created_by`),
  KEY `fk_user_group_country_idx` (`country_code`),
  CONSTRAINT `fk_user_group_country` FOREIGN KEY (`country_code`) REFERENCES `country` (`code`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_user_group_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group`
--

LOCK TABLES `user_group` WRITE;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
INSERT INTO `user_group` VALUES (25,'Region Group','2014-01-21 07:26:08',1,'All',NULL);
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group_detail`
--

DROP TABLE IF EXISTS `user_group_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_group_detail` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL,
  `allowed_channel` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`detail_id`),
  KEY `fk_user_group_detail_user_group1_idx` (`user_group_id`),
  KEY `fk_user_group_detail_channel1_idx` (`allowed_channel`),
  CONSTRAINT `fk_user_group_detail_channel1` FOREIGN KEY (`allowed_channel`) REFERENCES `channel` (`channel_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_group_detail_user_group1` FOREIGN KEY (`user_group_id`) REFERENCES `user_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group_detail`
--

LOCK TABLES `user_group_detail` WRITE;
/*!40000 ALTER TABLE `user_group_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_group_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_login_activity`
--

DROP TABLE IF EXISTS `user_login_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_login_activity` (
  `login_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `login_time` datetime DEFAULT NULL,
  `logout_time` datetime DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`login_id`),
  KEY `fk_user_login_activity_user1_idx` (`user_id`),
  CONSTRAINT `fk_user_login_activity_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1937 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_login_activity`
--

LOCK TABLES `user_login_activity` WRITE;
/*!40000 ALTER TABLE `user_login_activity` DISABLE KEYS */;
INSERT INTO `user_login_activity` VALUES (1936,392187,'2015-03-10 07:08:52',NULL,NULL);
/*!40000 ALTER TABLE `user_login_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_password_change_log`
--

DROP TABLE IF EXISTS `user_password_change_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_password_change_log` (
  `log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `old_password` varchar(255) NOT NULL,
  `new_password` varchar(255) NOT NULL,
  `new_salt` varchar(255) DEFAULT NULL,
  `old_salt` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `fk_user_password_change_log_user1_idx` (`user_id`),
  CONSTRAINT `fk_user_password_change_log_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_password_change_log`
--

LOCK TABLES `user_password_change_log` WRITE;
/*!40000 ALTER TABLE `user_password_change_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_password_change_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'dcms'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-10 14:13:03
