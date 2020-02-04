-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: 159.65.150.201    Database: epushserver
-- ------------------------------------------------------
-- Server version	5.7.27-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `DeviceLogs`
--

DROP TABLE IF EXISTS `DeviceLogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `DeviceLogs` (
  `DeviceLogId` int(11) NOT NULL AUTO_INCREMENT,
  `DownloadDate` datetime DEFAULT NULL,
  `DeviceId` int(11) NOT NULL,
  `UserId` varchar(50) NOT NULL,
  `LogDate` datetime NOT NULL,
  `Direction` varchar(255) DEFAULT NULL,
  `AttDirection` varchar(255) DEFAULT NULL,
  `C1` varchar(255) DEFAULT NULL,
  `C2` varchar(255) DEFAULT NULL,
  `C3` varchar(255) DEFAULT NULL,
  `C4` varchar(255) DEFAULT NULL,
  `C5` varchar(255) DEFAULT NULL,
  `C6` varchar(255) DEFAULT NULL,
  `C7` varchar(255) DEFAULT NULL,
  `WorkCode` varchar(255) DEFAULT NULL,
  KEY `DeviceLogId` (`DeviceLogId`)
) ENGINE=MyISAM AUTO_INCREMENT=42594 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DeviceLogs`
--

LOCK TABLES `DeviceLogs` WRITE;
/*!40000 ALTER TABLE `DeviceLogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `DeviceLogs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-02 14:08:51
