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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `channel`
--

LOCK TABLES `channel` WRITE;
/*!40000 ALTER TABLE `channel` DISABLE KEYS */;
INSERT INTO `channel` VALUES (5,'MBB Playground','CAAFm2lqzuUgBADF4ycrcjZAZCIIqutZBNnqS7kOIkk9NZCwWsbCdmwq9QSSn8rO74aGsOB4k8D3CdlGeWEAej83HhHhyjZAVleTwZA1sA7WXMPhK9HZA1Ygn0wOzJkovTZACrmytVh9P8bDZAgtTf2NreqNi7qYCmDDAWZARpFfzZCToxekQeACmHcV','','2014-07-01 04:57:49',1,'facebook','272288926209649',0,NULL,'All'),(17,'CloudMotion.Co','CAAFm2lqzuUgBAABqDgazPMrxVNwzhux6eQfiK3c8i8xqRVYhvZBv1zZBPZCPsDv6jUNwN9lmTodQ3rFckZBtyP86qXMZANjKbaP6DlFHhEOEkARACPAtxwj4mZCz5Wxf3VPzZC7ghLF8kat2EkbiraJ0alXopOZBZBZBPMvNuUZAjDqvAsy9ruyydza','','2014-03-24 07:37:19',1,'facebook','120872647998141',0,NULL,'MY'),(18,'Kacang Puteh','CAAFm2lqzuUgBABeiAN4BZCe3X7iypURwrZA9bS7VrQhsroSlUguFdJpv61bpC1EykqX2yDQT8hrITNCDvmOZBM1KHfldCsJ94tuISO3no03dZAvWKXsjpwTEcWf8SCJZA77JAvb2KUXbqqIXNA7jDWtc4USZBlHxuIsvqIFLKm93vkIxZAIAQRRu8xZCTPDy2rAZD','','2014-04-03 00:48:24',1,'facebook','133681290063909',0,NULL,'SG'),(32,'MBB Playground 2','CAAFm2lqzuUgBAMTSJqZC65pfxlLwmBNU329lqd9ugDiCbhlKNdQrVRXZCCWuj4EpkZAdfUZApNy57woTf4I7OoRlq481PFYloKuZCWnadtgBTrULPuMjxRMO7qEAzJ7nptRQDtYOYZCvb1hpMy0Hq8aUqgjM9xKPVTrrK84YVgnswhQHle4im4UwqIyg6m63YZD','','2014-03-30 08:30:15',1,'facebook','475008982547522',0,NULL,'ID'),(35,'Malaysian [Frames]','CAAFm2lqzuUgBAOxZCUfNqFYZBS6RP8syxMGC17SwcCwvzXOMYpSfpWtLoP9lbL3h2DG9enO7Gh0QXas81y6ZCBqBSr5qSA7hCdFqZC7QgQEdIOrZANd8e4KdjnUOkQ5VcqLxXIkTr41smi1HTfo2qZBaNPU3bb3zJPlq6UEwOEJOQ9ovo9N5kQYaNzqe0ZClMIZD','','2014-04-03 00:53:00',1,'facebook','320537284708371',0,NULL,'PH'),(36,'GoodDayDCMS','2424508375-KygCMHWMAAQRWwMHPq6GoZF4wTneHYjkMOVUbLY','zJmq8Ubb9UM4KbsKED5lCwxNJUYvsSFTU9jmY9Y3bcfrQ','2014-04-03 01:03:07',1,'twitter','2424508375',0,NULL,'SG'),(37,'eugene_1010','31162608-s6PdfhJ0f0bzh08zEBdicZslOni2qgwiyHRSWK1H7','IxHFHTRS6nnNFSxIo9MEZ7gEZNNrSBwPBKw9FaBGNpZp4','2014-04-03 01:05:10',1,'twitter','31162608',0,NULL,'PH'),(38,'gizikucom','257925234-krTcoC6XB34Rx9ZeBY9tCLuiGJup5vKONiZViv1e','oJELpVb8XidoeQtySSXrobrsvXWIsZMjOyMBlVgNBMc5v','2014-04-03 05:28:05',1,'twitter','257925234',0,NULL,'ID'),(39,'[Frame]/Second','CAAFm2lqzuUgBABUJJX0cAJLvwy4NZBp2KgkdK7FMiboQ3ZCSZBi7obpRrb4xrBR2qJefHGTmYECkcodZAi0gfhJ2HFY2g8BN8YBtzB0m2ZCikgVmRUfFhNVlqZAa9ahxx0xeyNxzsaIBr5bCVjxCNLEb89tYA4oBnOHRF6HUoFKpTkGTDZCwZAPA7i1DoIdUGvsZD','','2014-05-06 11:39:44',1,'facebook','194527650657518',0,NULL,'All'),(40,'purnomo_eko','59060128-OuwpCi8qrHQShDwJ3hIeIgSSYHSPSVMs8QNqiQMnV','U8rDlNqiajksWnhPCGWrkXaGSA6pVHKgYfXL8d53m6V95','2014-08-08 04:35:47',1,'twitter','59060128',0,NULL,'All'),(41,'akasuki911','225188500-ZENT825TKVfOCSlX90xQklz1ZKlc7CGieNn4DT1R','PPPpsgWHY2MrauuvtKLzEe7YackKGX7byKnQS4J3q7ab7','2014-08-14 07:10:37',1,'twitter','225188500',0,NULL,'MY'),(44,'Bena Waketversa','{\"access_token\":\"ya29.MAE2NGRzbKzGZHeD3AUa8rDJ1Rl2JLSmTs11kc7H3vwingiUG68zdnOplK1E5UgExefTtFQPRtsRAQ\",\"expires_in\":3600,\"created\":1425876961,\"refresh_token\":\"1\\/w0GvD4dsfNO8tASe-fBZucWTl1GgGv7kyBVtNY4FQAs\"}','{\"g_plus_id\":{\"$t\":\"110428300560330378309\"},\"youtube_id\":\"UCwoa3NwIBac77QfIEiUDM7A\",\"youtube_username\":\"benawaketversa\",\"youtube_image\":\"http:\\/\\/yt3.ggpht.com\\/-EsDlP4U1oEA\\/AAAAAAAAAAI\\/AAAAAAAAAAA\\/1HPcFr5b1uo\\/s88-c-k-no\\/photo.jpg\"}','2015-03-09 04:56:01',1,'youtube','UUwoa3NwIBac77QfIEiUDM7A',0,392187,NULL),(45,'Teo Eu Gene','{\"access_token\":\"ya29.MAE93Uw8gohFMfd5QotF3GlxqqVUlJkfVinGJ3kge7HnGeTUMlKS5PEdgHal3OPeXgA_hPyLtbGrlw\",\"expires_in\":3599,\"created\":1425874569,\"refresh_token\":\"1\\/04_eaWMQ5yk5EeELPlY75owRWboVrnZq80yC9dZ5TZ4\"}','{\"g_plus_id\":{\"$t\":\"104786648936649782185\"},\"youtube_id\":\"UCdqCHaAsBgTtPHHA1eijpTQ\",\"youtube_username\":\"eugene101079\",\"youtube_image\":\"http:\\/\\/yt3.ggpht.com\\/-TkuzI2quSZo\\/AAAAAAAAAAI\\/AAAAAAAAAAA\\/xRuMWS-aA2o\\/s88-c-k-no\\/photo.jpg\"}','2015-03-09 04:16:09',1,'youtube','UUdqCHaAsBgTtPHHA1eijpTQ',0,392226,NULL);
/*!40000 ALTER TABLE `channel` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-09 12:06:36
