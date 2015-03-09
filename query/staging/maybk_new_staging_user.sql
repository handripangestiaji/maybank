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
INSERT INTO `user` VALUES (392183,'tester','Eko Purnomo','DCMS User','eko.purnomo@icloud.com','2013-11-27 09:00:43',NULL,'6c0cb8597cec2523f5fce5f90acb140f','1385542843','YEAHHH!! ',NULL,10,25,'Asia/Jakarta',1,'','','All',1),(392185,'handri','Handri Pangestiaji','handri','handri.pangestiaji@gmail.com','2013-12-11 04:47:30',392183,'be2253e23c2520361560e81da2737286','1386737250','','media/dynamic/me.jpg',10,25,'Asia/Jakarta',1,'Indonesia','','ID',0),(392187,'robbi','tes','robbin','sikomo.eko@gmail.com','2013-12-12 09:59:33',NULL,'35481a2220e3de8604ac0c5f18d324b8','1386842373','testing',NULL,10,25,'Asia/Jakarta',1,'','','All',0),(392208,'fitrazh','fit','fit display name','fitrazh@gmail.com','2014-01-17 03:06:39',392187,'5aea91b959899f28acdc310af5eaac98','1389927999','',NULL,10,25,'Asia/Jakarta',1,'','','All',0),(392209,'aroon_ramsey','TEST Country Admin','TCA','eko.purnomo@cloudmotion.co','2014-01-17 06:51:54',392183,'0aed3a70e1c43766725b7f26c03dc960','1389941514','True.',NULL,21,10,'Asia/Singapore',1,'Bogor','http://cloudmotion.co','SG',1),(392226,'eugene','Eugene Teo','Eugene','eugene@yolkatgrey.com','2014-02-11 06:22:28',392183,'6c212b52312ed1f77d484dff772b23b6','1392099748','Eugene Profile',NULL,11,25,'Asia/Kuala_Lumpur',1,'Kuala Lumpur Malaysia','','All',0),(392227,'0000001','MY Admin','MY Admin 01','mbb.dcms.01@gmail.com','2014-02-11 06:31:28',392226,'420cea983a6bcbe42dc27448df017041','1392100288','',NULL,15,28,'Asia/Kuala_Lumpur',1,'','','MY',0),(392228,'0000002','MY Manager 02','MY Manager 02','mbb.dcms.02@gmail.com','2014-02-11 06:32:29',392226,'7d89421321735e5cab83e82024085d96','1392100349','',NULL,16,28,'Asia/Kuala_Lumpur',1,'','','MY',0),(392229,'0000003','MY Author 03','MY Author 03','mbb.dcms.03@gmail.com','2014-02-11 06:33:20',392226,'00323d647e4f754eb7f6d15e1f993e5b','1392100400','',NULL,17,28,'Asia/Kuala_Lumpur',1,'','','MY',0),(392230,'0000004','MY Viewer 04','MY Viewer 04','mbb.dcms.04@gmail.com','2014-02-11 06:34:46',392226,'b04724792ac9f6f4564b64c309f75a7a','1392100486','',NULL,18,28,'Asia/Kuala_Lumpur',1,'','','MY',0),(392231,'0000005','SG Admin 05','SG Admin 05','mbb.dcms.05@gmail.com','2014-02-11 06:35:38',392226,'a278235f4ef72f843935cd9dbbb7234d','1392100538','',NULL,21,10,'Asia/Singapore',1,'','','SG',0),(392232,'0000006','Manager SG','SG Manager 06','mbb.dcms.06@gmail.com','2014-02-11 06:36:04',392226,'6d2eff509cd4ac3ecb9ba427ad4dc494','1392100564','',NULL,22,10,'Asia/Singapore',1,'','','SG',0),(392233,'0000007','SG Author 07','SG Author 07','mbb.dcms.07@gmail.com','2014-02-11 06:36:32',392226,'ed0c52a1601f3f72a5ced6b7638b91e1','1392100592','',NULL,23,10,'Asia/Singapore',1,'','','SG',0),(392234,'0000008','SG Viewer','SG Viewer 08','mbb.dcms.08@gmail.com','2014-02-11 06:37:45',392226,'0f59990ceb48686df057696d5ffdc4c1','1392100665','',NULL,24,10,'Asia/Singapore',1,'','','SG',0),(392235,'0000009','ID Admin','ID Admin 09','mbb.dcms.09@gmail.com','2014-02-11 06:39:00',392226,'fb4b3fa2184358b8db43a9b93b64cf0c','1392100740','',NULL,32,2,'Asia/Jakarta',1,'','','ID',0),(392236,'0000010',' Manager','ID Manager 10','mbb.dcms.10@gmail.com','2014-02-11 06:39:38',392226,'13d07c5f8ecb5967fa1008abc737b378','1392100778','',NULL,26,2,'Asia/Jakarta',1,'','','ID',0),(392237,'0000011','ID Author','ID Author 11','mbb.dcms.11@gmail.com','2014-02-11 06:40:24',392226,'d5bae920867d57a2a4ef0edb88c79c7b','1392100824','',NULL,27,2,'Asia/Jakarta',1,'','','ID',0),(392238,'0000012','ID Viewer','ID Viewer 12','mbb.dcms.12@gmail.com','2014-02-11 06:40:56',392226,'5d7542de9aecd3f7bf52b33481f2972c','1392100856','',NULL,25,2,'Asia/Jakarta',1,'','','ID',0),(392239,'0000013','PH Admin','PH Admin 13','mbb.dcms.13@gmail.com','2014-02-11 06:41:31',392226,'a9087bf003c3917d17caa42fd7ba44db','1392100891','',NULL,31,21,'Asia/Manila',1,'','','PH',0),(392240,'0000014','PH Manager','PH Manager 14','mbb.dcms.14@gmail.com','2014-02-11 06:42:03',392226,'c2c8233917f5cb0bac8baaa7017f44f9','1392100923','',NULL,29,21,'Asia/Manila',1,'','','PH',0),(392241,'0000015','PH Author','PH Author 15','mbb.dcms.15@gmail.com','2014-02-11 06:42:33',392226,'a536c1767fb8bca31a1a6fa98dc55992','1392100953','',NULL,28,21,'Asia/Manila',1,'','','PH',0),(392242,'0000016','PH Viewer','PH Viewer 16','mbb.dcms.16@gmail.com','2014-02-11 06:43:11',392226,'70e820d397eea5716125608eaf95e765','1392100991','',NULL,30,21,'Asia/Manila',1,'','','PH',0),(392246,'b0001','bena','benawv','benawv@gmail.com','2014-02-21 04:01:05',392183,'651f6178c416896ef11a02d8b4313bc8','1392955265','I\'m good....',NULL,15,28,'Asia/Jakarta',1,'Indonesia','','MY',0),(392253,'wulan','wulan','wulans','riawulan47@yahoo.co.id','2014-02-25 03:58:32',392187,'8cdc82525a9005ae7b3c27ce5541c3a9','1393300712','yoo mari',NULL,11,2,'Asia/Jakarta',1,'','','ID',0),(392254,'ria','ria wulansari','ria','ria20farfi@gmail.com','2014-02-25 04:18:54',392187,'0c22bbe284fc6b9b11d9cb45c2600c07','1393301934','clever',NULL,12,25,'Asia/Jakarta',1,'','','All',0),(392259,'basil','Basil Yong','Basyong','basil.yong@yolkatgrey.com','2014-03-13 10:31:20',392226,'d43b1ccff5f2fc1555efdd9850d1ac15','1394706680','',NULL,10,25,'Asia/Kuala_Lumpur',1,'','','All',0),(392260,'rio','rio jenerio rjw','riokun','riojenerio6@gmail.com','2014-03-14 04:14:38',392187,'c1f2b1b74500d630f29ca8e9aeb5d934','1394770478','test case',NULL,11,2,'Asia/Jakarta',1,'','','ID',0),(392262,'Tested','Testy','Testy','yee.yeong@yolk.com.sg','2014-03-25 07:19:52',392227,'f2e9b06e142e4d72c1192c74aad0787d','1395731992','Hello World!',NULL,15,28,'Asia/Kuala_Lumpur',1,'','','MY',0),(392266,'Nicole','Nicole Lee Sook Yee','Nicole Lee','nicole.lee@maybank.com.my','2014-04-22 09:22:59',392227,'396a534df7e50d7669c2d196d1024605','1398154979','',NULL,11,28,'Asia/Kuala_Lumpur',1,'','','All',0),(392267,'google','Eko Purnomo','Google Username','eko.purnomo@me.com','2014-05-02 10:36:19',392227,'1c5d6469f6e17f7b52914477ca675994','1399023379','',NULL,10,28,'Asia/Kuala_Lumpur',1,'Indonesia','http://eko.cloudmotion.co','MY',0),(392268,'azahan','azahan','azahan','azahan.azad@maybank.com.my','2014-05-04 05:24:28',392226,'74e7b01f9053a4125391c15e483b70e2','1399177468','',NULL,11,25,'Asia/Kuala_Lumpur',1,'','','All',0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-09 12:18:29
