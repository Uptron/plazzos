-- MySQL dump 10.13  Distrib 5.7.32, for Linux (x86_64)
--
-- Host: localhost    Database: plazzos
-- ------------------------------------------------------
-- Server version	5.7.32-0ubuntu0.18.04.1

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
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `merchant`
--

DROP TABLE IF EXISTS `merchant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `merchant` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `merchantName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phoneNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `accountStatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_74AB25E1A76ED395` (`user_id`),
  CONSTRAINT `FK_74AB25E1A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `merchant`
--

LOCK TABLES `merchant` WRITE;
/*!40000 ALTER TABLE `merchant` DISABLE KEYS */;
/*!40000 ALTER TABLE `merchant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `productName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `productDesc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `createdAt` datetime NOT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updatedAt` datetime NOT NULL,
  `updatedBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `merchantID_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04AD291A17D` (`merchantID_id`),
  CONSTRAINT `FK_D34A04AD291A17D` FOREIGN KEY (`merchantID_id`) REFERENCES `merchant` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateAdded` datetime DEFAULT NULL,
  `lastUpdated` datetime DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_426EF392A76ED395` (`user_id`),
  CONSTRAINT `FK_426EF392A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES ('8fdd69af-41f3-11eb-90c8-5cc5d4145a3c',NULL,'Ian','Wagga','Wagga','ian@mwananchi.com',NULL,'2020-12-19 14:13:11','2020-12-19 14:13:11','Active'),('de9da3ad-41fa-11eb-90c8-5cc5d4145a3c','de9c039b-41fa-11eb-90c8-5cc5d4145a3c','Julius','Gitonga','Test','test@mwananchi.com','Human Resource','2020-12-19 15:05:29','2020-12-19 15:05:29','Active'),('e857d592-41fc-11eb-90c8-5cc5d4145a3c','e85642ca-41fc-11eb-90c8-5cc5d4145a3c','qwe','qwe','qwe@mwananchi.com','qwe@mwananchi.com','Human Resource','2020-12-19 15:20:05','2020-12-19 15:20:05','Active');
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middlename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `accountCreatedAt` datetime DEFAULT NULL,
  `accountUpdateAt` datetime DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8D93D649FE54D947` (`group_id`),
  CONSTRAINT `FK_8D93D649FE54D947` FOREIGN KEY (`group_id`) REFERENCES `user_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('2356336c-41c5-11eb-90c8-5cc5d4145a3c',NULL,'Test Valuer',NULL,NULL,'qwertyasd','$2y$10$LxSCoV3kaCfzkWxD4nKu5O0e87.UqpYQN3PAJyULA3C5ThEqN59d.','2020-12-19 08:40:52',NULL,'Active','9e56c78a-41a5-11eb-976b-5cc5d4145a3c'),('2a5bb2e0-8cb1-11ea-b953-5cc5d4145a3c','j@j.com',NULL,NULL,NULL,'hilda','$2y$10$Nbzyl3G/jeeE6iUUnpWzEuslxBMjxkiW65Yh6nQvQ9Bg55eeHhGfi','2020-05-02 22:11:53',NULL,'Active',NULL),('350e99cb-8eaa-11ea-bc5e-5cc5d4145a3c','test@jilipe.com',NULL,NULL,NULL,'jilipe','$2y$10$Vs/CwFqPrUp0uhyfGyeBvOnQAA13a4F7Ccq99SUtDsXb5T4x4SDB.','2020-05-05 10:27:07',NULL,'Active',NULL),('49c369d8-41f3-11eb-90c8-5cc5d4145a3c','ian@mwananchi.com','Ian','Wagga','Wagga','ian','$2y$10$JNV.L0mFdv/3UHu2hkIJiOVGCHrYqd0IHrk7H7Q6I/ayjDnY/ztna','2020-12-19 14:11:13',NULL,'Active',NULL),('73c83bf5-8d7b-11ea-b953-5cc5d4145a3c','f@f.com',NULL,NULL,NULL,'f','$2y$10$dLOrS0Ci5cfuDEDv5FHJr.8EkAvxah8cJK3bMx701gH7trev/esiy','2020-05-03 22:19:55',NULL,'Active',NULL),('767ad24d-41ce-11eb-90c8-5cc5d4145a3c','test3@valuer.com','Test Valuer',NULL,NULL,'qwertyasd','$2y$10$H.CqT5hxK70CbE82xRwtNuI3qDoK1LAXgdr96wPM..k7g2kwZk9Pa','2020-12-19 09:47:37',NULL,'Active','9e56c78a-41a5-11eb-976b-5cc5d4145a3c'),('8fdae83e-41f3-11eb-90c8-5cc5d4145a3c','ian@mwananchi.com','Ian','Wagga','Wagga','ian','$2y$10$.qQkD5acLA/66l.g5KjDbuw24/drxcOUGdaR4kQOD0VBxRl2BSvdK','2020-12-19 14:13:11',NULL,'Active',NULL),('90df1801-8cb7-11ea-b953-5cc5d4145a3c','',NULL,NULL,NULL,'','$2y$10$ioQg1wSgfmH7y.kGbUkjA.w4l6ZknmgvD9oogkpGVM9Wr6foJTxh6','2020-05-02 22:57:42',NULL,'Active',NULL),('930143cb-419b-11eb-976b-5cc5d4145a3c','uptronafrica@gmail.com','Julius','Gitonga','Koeman','uptron','$2y$10$h3tRRlgq5lyLHS7e.UCElOLUu9Nk2fw1kT5drOzdjcVSqHFtalBUC','2020-12-19 03:43:20',NULL,'Active',NULL),('962a55c9-8cb7-11ea-b953-5cc5d4145a3c','',NULL,NULL,NULL,'','$2y$10$CkrhELx8.50u9U01y.NtYOnuD9TqodGzJOC9sQbtr.p3Xf2tt7aD6','2020-05-02 22:57:51',NULL,'Active',NULL),('99ffc3e3-8cae-11ea-b953-5cc5d4145a3c','j@j.com',NULL,NULL,NULL,'hilda','$2y$10$j89SVEhJaCkPqr6UO/22n.7PTfnT9xE870PW43DS1Qd7p8YWZsW/.',NULL,NULL,'Active',NULL),('c1d033b2-41ce-11eb-90c8-5cc5d4145a3c','sasa@sasa.com','sasa',NULL,NULL,'poiuyt','$2y$10$9lUG4n2W4KKm5Iuochn02.SpdE50yagLwBfET/JIpc..4wyH/dt16','2020-12-19 09:49:43',NULL,'Active','9e56c78a-41a5-11eb-976b-5cc5d4145a3c'),('de9c039b-41fa-11eb-90c8-5cc5d4145a3c','test@mwananchi.com','Julius','Gitonga','Test','test','$2y$10$a27govDpZ17ovSRfwCFc2ORN/bVtR0ybJRxHIRkbM6OziVN.GmPpq','2020-12-19 15:05:29',NULL,'Active',NULL),('e85642ca-41fc-11eb-90c8-5cc5d4145a3c','qwe@mwananchi.com','qwe','qwe','qwe@mwananchi.com','qwe','$2y$10$G9DQK33E5JCtcxn29LAu/OUItj8F9oFvZRc5I/rKMw4/i8IW9ECrW','2020-12-19 15:20:05',NULL,'Active','c02e5456-41f1-11eb-90c8-5cc5d4145a3c');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_group` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group`
--

LOCK TABLES `user_group` WRITE;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
INSERT INTO `user_group` VALUES ('9e56c78a-41a5-11eb-976b-5cc5d4145a3c','Valuer','Active'),('c02e5456-41f1-11eb-90c8-5cc5d4145a3c','Staff','Active'),('d6458923-419a-11eb-976b-5cc5d4145a3c','Admin','Active');
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valuation_reports`
--

DROP TABLE IF EXISTS `valuation_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valuation_reports` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valuer_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valuation_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `insuranceCo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `policyNo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expiryDate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `yom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `engineNo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chassisNo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `odometerReading` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `regDate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `engineRating` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `serialNo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `antiTheft` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `windscreenValue` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `audiosystemValue` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alarmsystemValue` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `examinersOpinion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forcedsaleValue` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bodywork` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mechanical` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `steeringandsuspension` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `brakingsystem` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `electricalsystem` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wheels` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addedequipment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modificationsnoted` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `specialremarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `generalcondition` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `engineattachment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logbookattachment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reportattachment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateDone` datetime NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7FC928882211BFE6` (`valuation_id`),
  KEY `IDX_7FC9288867EC383F` (`valuer_id`),
  CONSTRAINT `FK_7FC928882211BFE6` FOREIGN KEY (`valuation_id`) REFERENCES `valuations` (`id`),
  CONSTRAINT `FK_7FC9288867EC383F` FOREIGN KEY (`valuer_id`) REFERENCES `valuer` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valuation_reports`
--

LOCK TABLES `valuation_reports` WRITE;
/*!40000 ALTER TABLE `valuation_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `valuation_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valuations`
--

DROP TABLE IF EXISTS `valuations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valuations` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `requester_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateRequested` datetime NOT NULL,
  `approvedBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valuationStatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valuerID_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clientName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clientPhone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vehicleReg` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vehicleMake` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vehicleModel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  `logBook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vehicleType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_92FC8AFD5A238DAE` (`valuerID_id`),
  KEY `IDX_92FC8AFDED442CF4` (`requester_id`),
  CONSTRAINT `FK_92FC8AFD5A238DAE` FOREIGN KEY (`valuerID_id`) REFERENCES `valuer` (`id`),
  CONSTRAINT `FK_92FC8AFDED442CF4` FOREIGN KEY (`requester_id`) REFERENCES `staff` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valuations`
--

LOCK TABLES `valuations` WRITE;
/*!40000 ALTER TABLE `valuations` DISABLE KEYS */;
INSERT INTO `valuations` VALUES ('38033f6b-42b6-11eb-90c8-5cc5d4145a3c','e857d592-41fc-11eb-90c8-5cc5d4145a3c','2020-12-20 13:26:35',NULL,'Pending','c1d0e45b-41ce-11eb-90c8-5cc5d4145a3c','Julius Gitonga','0729643482','KCB 456Y','Toyota','Premio','2020-12-20 13:26:35','0f7cf38cdc260a2f.png','                              Needed in the next 24hrs',''),('6f31c14e-42a9-11eb-90c8-5cc5d4145a3c','8fdd69af-41f3-11eb-90c8-5cc5d4145a3c','2020-12-20 11:55:04',NULL,'Pending','767bb28f-41ce-11eb-90c8-5cc5d4145a3c','Kariuki Makau','07246536374','kbf j64u','Toyota','d','2020-12-20 11:55:04','c8525746bdb0c269.png','                                f',''),('cd3d5139-4282-11eb-90c8-5cc5d4145a3c','e857d592-41fc-11eb-90c8-5cc5d4145a3c','2020-12-20 07:18:32',NULL,'Pending','9b04314e-41ae-11eb-976b-5cc5d4145a3c','Test','test','test','test','test','2020-12-20 07:18:32','0fac839584a67211.png','                                test','');
/*!40000 ALTER TABLE `valuations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valuer`
--

DROP TABLE IF EXISTS `valuer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valuer` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valuerName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phoneNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `accountStatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4DA07C70A76ED395` (`user_id`),
  CONSTRAINT `FK_4DA07C70A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valuer`
--

LOCK TABLES `valuer` WRITE;
/*!40000 ALTER TABLE `valuer` DISABLE KEYS */;
INSERT INTO `valuer` VALUES ('767bb28f-41ce-11eb-90c8-5cc5d4145a3c','767ad24d-41ce-11eb-90c8-5cc5d4145a3c','Test Valuer','072839933','test3@valuer.com','jdkjfksf','2020-12-19 09:47:37','Active'),('9b04314e-41ae-11eb-976b-5cc5d4145a3c',NULL,'Test Valuer','20e2','test@valuer.com','dc','2020-12-19 05:59:34','Active'),('c1d0e45b-41ce-11eb-90c8-5cc5d4145a3c','c1d033b2-41ce-11eb-90c8-5cc5d4145a3c','sasa','0734765432','sasa@sasa.com','rerer','2020-12-19 09:49:43','Active');
/*!40000 ALTER TABLE `valuer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `worker_groups`
--

DROP TABLE IF EXISTS `worker_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `worker_groups` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `merchant_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `groupName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `createdAt` datetime NOT NULL,
  `createdBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updatedAt` datetime NOT NULL,
  `updatedBy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_71CF88196796D554` (`merchant_id`),
  CONSTRAINT `FK_71CF88196796D554` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `worker_groups`
--

LOCK TABLES `worker_groups` WRITE;
/*!40000 ALTER TABLE `worker_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `worker_groups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-21  4:07:20
