CREATE DATABASE  IF NOT EXISTS `maybank_v2` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `maybank_v2`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: maybank_v2
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
) ENGINE=InnoDB AUTO_INCREMENT=424 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=375 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=487 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=1413 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=375 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=235 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=5050 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=1382 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=12448 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=368 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=1515644 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=1414124 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=534889773270162 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=1515521 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=1960 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `youtube_reply`
--

DROP TABLE IF EXISTS `youtube_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `youtube_reply` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `reply_to_post_id` bigint(20) NOT NULL,
  `text` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `content_products_id` int(11) DEFAULT NULL,
  `response_post_id` text,
  `user_id` int(11) NOT NULL,
  `is_replied_by_user` tinyint(14) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-09 11:21:36
