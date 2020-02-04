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
-- Table structure for table `DeviceGroup`
--

DROP TABLE IF EXISTS `DeviceGroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `DeviceGroup` (
  `DeviceGroupId` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `VerificationTypeId` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  PRIMARY KEY (`DeviceGroupId`),
  UNIQUE KEY `UK_DeviceGroup_Name` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DeviceGroup`
--

LOCK TABLES `DeviceGroup` WRITE;
/*!40000 ALTER TABLE `DeviceGroup` DISABLE KEYS */;
INSERT INTO `DeviceGroup` VALUES (1,'DeviceGroup 01','DeviceGroup 01',0,'1970-01-01 00:00:00'),(2,'DeviceGroup 02','DeviceGroup 02',0,'1970-01-01 00:00:00'),(3,'DeviceGroup 03','DeviceGroup 03',0,'1970-01-01 00:00:00'),(4,'DeviceGroup 04','DeviceGroup 04',0,'1970-01-01 00:00:00'),(5,'DeviceGroup 05','DeviceGroup 05',0,'1970-01-01 00:00:00'),(6,'DeviceGroup 06','DeviceGroup 06',0,'1970-01-01 00:00:00'),(7,'DeviceGroup 07','DeviceGroup 07',0,'1970-01-01 00:00:00'),(8,'DeviceGroup 08','DeviceGroup 08',0,'1970-01-01 00:00:00'),(9,'DeviceGroup 09','DeviceGroup 09',0,'1970-01-01 00:00:00'),(10,'DeviceGroup 10','DeviceGroup 10',0,'1970-01-01 00:00:00');
/*!40000 ALTER TABLE `DeviceGroup` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-02 14:08:43
