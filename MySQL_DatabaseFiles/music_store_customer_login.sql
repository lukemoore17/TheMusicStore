CREATE DATABASE  IF NOT EXISTS `music_store` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `music_store`;
-- MySQL dump 10.16  Distrib 10.1.28-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: music_store
-- ------------------------------------------------------
-- Server version	8.0.3-rc-log

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
-- Table structure for table `customer_login`
--

DROP TABLE IF EXISTS `customer_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_login` (
  `CustomerID` int(11) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `Email` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`CustomerID`),
  UNIQUE KEY `Username_UNIQUE` (`Username`),
  UNIQUE KEY `Email_UNIQUE` (`Email`),
  CONSTRAINT `CustomerID` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`customerid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_login`
--

LOCK TABLES `customer_login` WRITE;
/*!40000 ALTER TABLE `customer_login` DISABLE KEYS */;
INSERT INTO `customer_login` VALUES (1,'luke','123','lmoore006@my.wilmu.edu'),(7,'john.doe','123','john.doe@example.com');
/*!40000 ALTER TABLE `customer_login` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-07 15:29:32
