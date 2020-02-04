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
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `devices` (
  `DeviceId` int(11) NOT NULL AUTO_INCREMENT,
  `DeviceFName` varchar(255) NOT NULL,
  `DevicesName` varchar(255) NOT NULL,
  `DeviceDirection` varchar(255) DEFAULT NULL,
  `SerialNumber` varchar(255) NOT NULL,
  `ConnectionType` varchar(255) DEFAULT NULL,
  `IpAddress` varchar(255) DEFAULT NULL,
  `BaudRate` varchar(255) DEFAULT NULL,
  `CommKey` varchar(255) NOT NULL,
  `ComPort` varchar(255) DEFAULT NULL,
  `LastLogDownloadDate` datetime DEFAULT NULL,
  `C1` varchar(255) DEFAULT NULL,
  `C2` varchar(255) DEFAULT NULL,
  `C3` varchar(255) DEFAULT NULL,
  `C4` varchar(255) DEFAULT NULL,
  `C5` varchar(255) DEFAULT NULL,
  `C6` varchar(255) DEFAULT NULL,
  `C7` varchar(255) DEFAULT NULL,
  `TransactionStamp` varchar(50) DEFAULT NULL,
  `LastPing` datetime DEFAULT NULL,
  `DeviceType` varchar(255) DEFAULT NULL,
  `OpStamp` varchar(255) DEFAULT NULL,
  `DownLoadType` int(11) DEFAULT NULL,
  `TimeZone` varchar(50) DEFAULT NULL,
  `DeviceLocation` varchar(50) DEFAULT NULL,
  `TimeOut` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`DeviceId`,`SerialNumber`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
INSERT INTO `devices` VALUES (1,'HOSHITEC g','htg','in','A6FE183262317','Tcp/IP','10.247.29.96','','0','','2019-12-24 09:49:12',NULL,NULL,NULL,NULL,NULL,'C33AE38CEA4D13BD2D02E0E686183AE8','0','642160143','2019-12-24 16:14:09','Attendance','637418433',1,'330','Hoshitec-G','300'),(2,'Hoshitec B','htb','altinout','A6FE183160302','Tcp/IP','10.247.2.22','','0','','2019-12-24 15:13:38',NULL,NULL,NULL,NULL,NULL,'CF24E21CF930D753D0E1E608112BAC58','0','642179613','2019-12-24 16:13:52','Attendance','641663746',1,'330','Bangalore','300'),(14,'fadsfadsf','dfasfadsf','in','A6FE193262013','Tcp/IP','192.168.1.20','','0','','2019-12-24 17:42:06',NULL,NULL,NULL,NULL,NULL,'ED4BFB1824AA42B4FD556A47E7BE44E5','0','9999','2019-12-24 17:44:29','Attendance','9999',1,'330','fdsafadsf','300');
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-02 14:08:56
