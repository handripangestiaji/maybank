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
-- Dumping data for table `content_products`
--

LOCK TABLES `content_products` WRITE;
/*!40000 ALTER TABLE `content_products` DISABLE KEYS */;
INSERT INTO `content_products` VALUES (1,'Maybank2u','Retail online banking system','2014-05-09 02:08:19',0,392266,'All',NULL),(2,'Buying','Reload prepaid cards, Top-up, Ticketing','2014-05-09 02:10:43',0,392266,'All',1),(3,'Payment','Bills, Loans, Insurance, ESI','2014-05-09 02:11:49',0,392266,'All',1),(4,'Transfers','Intrabank, Interbank IBG','2014-05-09 02:12:21',0,392266,'All',1),(5,'Login','First-time login, Forgot Username or Password, Password Locked, Challenge Questions, Access Denied','2014-05-09 02:12:53',0,392266,'All',1),(6,'Technical Reports','Transaction error, System down, Auto Logout, Invalid DNS','2014-05-09 02:13:18',0,392266,'All',1),(7,'TAC','Registration, Not Receive TAC, Change Telco','2014-05-09 02:14:13',0,392266,'All',1),(8,'Statements','Print Receipt, Account Statements, Email Statements','2014-05-09 02:14:46',0,392266,'All',1),(9,'Mobile Banking','Maybank2u Mobile apps','2014-05-09 02:17:07',0,392266,'All',1),(10,'Merchant Programme','Online Merchants sell products and collect payments online via Maybank2u','2014-05-09 02:21:51',0,392266,'All',1),(11,'Fees & Charges','Transaction fees, Maintenance fees','2014-05-09 02:23:17',0,392266,'All',1),(12,'Promotions & Contests','Online transfer, deposit, opening account promotions & contests','2014-05-09 02:27:10',0,392266,'All',1),(13,'Cards','Retail and Corporate cards','2014-05-09 02:30:06',0,392266,'All',NULL),(14,'Credit','All type of credit cards - Visa, MasterCard, AMEX','2014-05-09 02:31:52',0,392266,'All',13),(15,'Charge','All type of charge cards - AMEX','2014-05-09 02:32:53',0,392266,'All',13),(16,'Debit','All type of debit cards - Bankcard, Visa Debit, MasterCard Debit','2014-05-09 02:35:19',0,392266,'All',13),(17,'Prepaid','All type of prepaid cards','2014-05-09 02:36:35',0,392266,'All',13),(18,'Balance Transfer Programme','Transfer other banks credit card balances to Maybank','2014-05-09 02:43:40',0,392266,'All',13),(19,'Instalment Plan','Purchases to affordable monthly instalments','2014-05-09 02:45:14',0,392266,'All',13),(20,'MSOS','Secure Online Shopping, authentication process for safer online transactions','2014-05-09 02:48:24',0,392266,'All',13),(21,'Rewards','Debit, Credit Cards rewards points, Treats Points, Privileges','2014-05-09 02:50:37',0,392266,'All',13),(23,'Cards Reports','Lost or stolen card, ATM or Card activation overseas','2014-05-09 03:44:24',0,392266,'All',13),(25,'Merchant Programme','Payment facilities and services - POS, Auto PayBills, Instalment schemes','2014-05-09 03:59:51',0,392266,'All',13),(27,'Fees & Charges','Annual fees, Late charges, Interest rate','2014-05-09 04:00:44',0,392266,'All',13),(28,'Promotions & Contests','Special cards offer, discount, rebate or contests','2014-05-09 04:01:50',0,392266,'All',13),(29,'Loans','Personal and Corporate Loans','2014-05-09 04:04:43',0,392266,'All',NULL),(30,'Mortgage','All type of mortgage loan - MaxiHome, Trade Up, Loan scheme and Maxi plan','2014-05-09 04:09:36',0,392266,'All',29),(31,'Overdrafts','Overdrafts facility related','2014-05-09 04:14:08',0,392266,'All',29),(32,'Personal','All type of personal loans related','2014-05-09 04:19:05',0,392266,'All',29),(33,'Vehicle','All type of vehicle loan - Auto Financing, Hire Purchase','2014-05-09 04:24:11',0,392266,'All',29),(34,'Finance','Financing for Share Trading or Share Margin','2014-05-09 06:01:43',0,392266,'All',29),(35,'Promotions & Contests','Special loans rate, new application, refinancing promotions & contests','2014-05-09 06:10:34',0,392266,'All',29),(36,'Investments','Individual or non-individual investments','2014-05-09 06:12:24',0,392266,'All',NULL),(37,'Gold Investment','Buy or sell gold, gold rates','2014-05-09 06:25:14',0,392266,'All',36),(38,'Silver Investment','Buy or sell silver, silver rates','2014-05-09 06:28:33',0,392266,'All',36),(39,'Share Trading','All type of share trading - Margin or non-margin trading, Global trading','2014-05-09 06:32:15',0,392266,'All',36),(40,'Unit Trust','Investment plan, forex rates','2014-05-09 06:37:33',0,392266,'All',36),(41,'Online Stocks','View live quotes, market update, stock research and trade shares online','2014-05-09 06:45:13',0,392266,'All',36),(42,'Online Stocks Reports ','System down, Unable to view live quotes, Account activation issues','2014-05-09 06:57:51',0,392266,'All',36),(43,'Mobile Trading','Mobile stocks or trade apps','2014-05-09 07:01:41',0,392266,'All',36),(44,'Rates & Fees','Processing fees, Transaction fees, Maintenance fees, Investment Rates','2014-05-09 07:05:56',0,392266,'All',36),(45,'Promotions & Contests','Special rates, online stock game, trading with low rate promotions & contests','2014-05-09 07:08:00',0,392266,'All',36),(46,'Insurance','Personal or Corporate Insurance','2014-05-09 07:09:47',0,392266,'All',NULL),(47,'Personal Accident','All type of personal accident insurance - Premier PA, Privilege PA','2014-05-09 07:15:27',0,392266,'All',46),(48,'Motor','Motor insurance plan, renewal and policy','2014-05-09 07:15:43',0,392266,'All',46),(49,'Travel','All type of travel insurance - Air Travel Care, Domestic Travel Care','2014-05-09 07:17:15',0,392266,'All',46),(50,'Protection','All type of protection plan - Life insurance, Medical insurance, Critical illness plan, Premier with investment linked plan','2014-05-09 07:52:04',0,392266,'All',46),(51,'Education','All type of premier education savings plan for children','2014-05-09 07:57:14',0,392266,'All',46),(52,'Fees & Charges','Premier fees, Processing fees, Standing instruction fees','2014-05-09 07:59:19',0,392266,'All',46),(53,'Promotions & Contests','Additional protection plan, Special rates for premier with investment linked','2014-05-09 07:59:46',0,392266,'All',46),(54,'Deposits','Personal or Corporate accounts','2014-05-09 08:02:19',0,392266,'All',NULL),(55,'Savings','All type of Savings accounts - Basic savings, Golden savings, imteen savings','2014-05-09 08:02:35',0,392266,'All',54),(56,'Current','All type of Current accounts - Basic current, Personal or Business current accounts','2014-05-09 08:02:48',0,392266,'All',54),(57,'Foreign','All type of Foreign accounts - Foreign Currency account','2014-05-09 08:02:57',0,392266,'All',54),(58,'Fixed Deposits','General Fixed Deposits, eFixed, Special Investment account, Fixed Deposits Rates','2014-05-09 08:03:05',0,392266,'All',54),(59,'Rates & Fees','General Banking fees, Deposit Fees, Deposit Rates','2014-05-09 08:34:38',0,392266,'All',54),(60,'Promotions & Contests','Deposits and get rewarded, Special deposits rates, Deposits promotions & contests','2014-05-09 08:39:32',0,392266,'All',54),(61,'Service Quality','Customer\'s expectations, an assessment of service delivered','2014-05-09 08:49:32',0,392266,'All',NULL),(62,'Branch','Customer feedback of branches services','2014-05-09 09:59:56',0,392266,'All',61),(63,'Call Centre','Customer feedback of call centre services','2014-05-09 10:00:25',0,392266,'All',61),(64,'Money Exchange Booth','Customer feedback of Money Exchange Booth services','2014-05-09 10:01:06',0,392266,'All',61),(65,'Card Centre','Customer feedback of Card Centre services','2014-05-09 10:01:34',0,392266,'All',61),(66,'Auto Finance','Customer feedback of Auto Finance services','2014-05-09 10:02:17',0,392266,'All',61),(67,'Premier Centre','Customer feedback of Premier Centre services','2014-05-09 10:02:39',0,392266,'All',61),(68,'Online Banking','Customer feedback of Online Banking (Maybank2u, Maybank2E) services','2014-05-09 10:03:21',0,392266,'All',61),(69,'Mobile Banking','Customer feedback of Mobile Banking (Mobile apps) services','2014-05-09 10:04:42',0,392266,'All',61),(70,'Self Service Centre','Customer\'s expectations of Self Service Centre Services','2014-05-09 10:06:05',0,392266,'All',NULL),(71,'ATMs','Customer feedback of ATMs services','2014-05-09 10:15:33',0,392266,'All',70),(72,'Cash Deposit Machines','Customer feedback of Cash Deposit Machines services','2014-05-12 01:23:24',0,392266,'All',70),(73,'Cheque Deposit Machines','Customer feedback of Cheque Deposit Machines services','2014-05-12 01:23:42',0,392266,'All',70),(74,'Coins Deposit Machines','Customer feedback of Coins Deposit Machines services','2014-05-12 01:23:54',0,392266,'All',70),(75,'Passbook Update Machines','Customer feedback of Passbook Update Machines service','2014-05-12 01:24:05',0,392266,'All',70),(76,'Others / Products & Services','More products and services','2014-05-12 01:30:17',0,392266,'All',NULL),(77,'Money Express','Transfer money across the world of correspondent banks and beneficiary agents/banks','2014-05-12 01:30:34',0,392266,'All',76),(78,'MoneyGram','Person-to-person money transfer service','2014-05-12 01:30:46',0,392266,'All',76),(79,'Auto Debit','Standing Instruction, deducts money from savings/current account on fixed schedule','2014-05-12 01:30:58',0,392266,'All',76),(80,'Ticketing','AirAsia, MAS, GSC','2014-05-12 01:31:11',0,392266,'All',76),(81,'Brand, Corporate & HR','Regarding branding, corporate or HR matters. Including scholarship.','2014-05-12 03:20:20',0,392266,'All',76),(82,'Scams & Fraud','Cases of reported fraud or attempted fraud','2014-05-12 03:20:56',0,392266,'All',76);
/*!40000 ALTER TABLE `content_products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-09 12:15:54
