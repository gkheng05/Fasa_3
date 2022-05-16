-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: webapp
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL AUTO_INCREMENT,
  `idPengguna` int(11) NOT NULL,
  `namaAdmin` varchar(200) NOT NULL,
  PRIMARY KEY (`idAdmin`),
  KEY `admin_ibfk_1` (`idPengguna`),
  CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`idPengguna`) REFERENCES `pengguna` (`idPengguna`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,1,'Admin');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `allpengguna`
--

DROP TABLE IF EXISTS `allpengguna`;
/*!50001 DROP VIEW IF EXISTS `allpengguna`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `allpengguna` (
  `id` tinyint NOT NULL,
  `nama` tinyint NOT NULL,
  `emel` tinyint NOT NULL,
  `kataLaluan` tinyint NOT NULL,
  `peranan` tinyint NOT NULL,
  `telefonPeserta` tinyint NOT NULL,
  `noicPeserta` tinyint NOT NULL,
  `alamatPeserta` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `allpeserta`
--

DROP TABLE IF EXISTS `allpeserta`;
/*!50001 DROP VIEW IF EXISTS `allpeserta`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `allpeserta` (
  `id` tinyint NOT NULL,
  `nama` tinyint NOT NULL,
  `a` tinyint NOT NULL,
  `b` tinyint NOT NULL,
  `c` tinyint NOT NULL,
  `jumlah` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `hakim`
--

DROP TABLE IF EXISTS `hakim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hakim` (
  `idHakim` int(11) NOT NULL AUTO_INCREMENT,
  `idPengguna` int(11) NOT NULL,
  `namaHakim` varchar(200) NOT NULL,
  PRIMARY KEY (`idHakim`),
  KEY `hakim_ibfk_1` (`idPengguna`),
  CONSTRAINT `hakim_ibfk_1` FOREIGN KEY (`idPengguna`) REFERENCES `pengguna` (`idPengguna`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hakim`
--

LOCK TABLES `hakim` WRITE;
/*!40000 ALTER TABLE `hakim` DISABLE KEYS */;
/*!40000 ALTER TABLE `hakim` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `markah`
--

DROP TABLE IF EXISTS `markah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `markah` (
  `idMarkah` int(11) NOT NULL AUTO_INCREMENT,
  `idPeserta` int(11) NOT NULL,
  `markahBhgA` int(11) NOT NULL DEFAULT 0,
  `markahBhgB` int(11) NOT NULL DEFAULT 0,
  `markahBhgC` int(11) NOT NULL DEFAULT 0,
  `jumlahMarkah` int(11) GENERATED ALWAYS AS (`markahBhgA` + `markahBhgB` + `markahBhgC`) VIRTUAL,
  PRIMARY KEY (`idMarkah`),
  KEY `markah_ibfk_1` (`idPeserta`),
  CONSTRAINT `markah_ibfk_1` FOREIGN KEY (`idPeserta`) REFERENCES `peserta` (`idPeserta`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `markah`
--

LOCK TABLES `markah` WRITE;
/*!40000 ALTER TABLE `markah` DISABLE KEYS */;
INSERT INTO `markah` VALUES (1,1,2,5,6,13),(2,2,0,0,0,0),(3,3,0,0,0,0),(4,4,0,0,0,0),(5,5,0,0,0,0),(6,6,20,30,50,100),(7,7,20,30,50,100),(8,8,4,3,3,10),(9,9,2,3,4,9),(10,10,12,23,45,80),(11,11,10,10,10,30),(12,12,10,30,20,60),(13,13,0,0,0,0);
/*!40000 ALTER TABLE `markah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengguna`
--

DROP TABLE IF EXISTS `pengguna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengguna` (
  `idPengguna` int(11) NOT NULL AUTO_INCREMENT,
  `emelPengguna` varchar(200) NOT NULL,
  `kataLaluanPengguna` varchar(64) NOT NULL,
  `perananPengguna` int(11) NOT NULL,
  PRIMARY KEY (`idPengguna`),
  UNIQUE KEY `emelPengguna` (`emelPengguna`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengguna`
--

LOCK TABLES `pengguna` WRITE;
/*!40000 ALTER TABLE `pengguna` DISABLE KEYS */;
INSERT INTO `pengguna` VALUES (1,'admin@testing.com','b822f1cd2dcfc685b47e83e3980289fd5d8e3ff3a82def24d7d1d68bb272eb32',6),(2,'dwadw@gmail.com','cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90',1),(3,'ae2aq@gmail.com','cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90',1),(4,'jaylen.leuschke@hotmail.com','cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90',1),(5,'jennie67@yahoo.com','cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90',1),(6,'otho.schultz@hotmail.com','cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90',1),(7,'paxton29@gmail.com','cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90',1),(8,'darlene.schmeler@gmail.com','cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90',1),(9,'alexandria88@yahoo.com','cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90',1),(10,'trycia.block7@yahoo.com','cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90',1),(11,'a@dw21.cokwad','cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90',1),(12,'e1e12@ggg.com','cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90',1),(13,'dwad21@fwa.com','cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90',1),(14,'a@WEEEEEEEE.com','cf80cd8aed482d5d1527d7dc72fceff84e6326592848447d2dc0b0e87dfc9a90',1);
/*!40000 ALTER TABLE `pengguna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peserta`
--

DROP TABLE IF EXISTS `peserta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peserta` (
  `idPeserta` int(11) NOT NULL AUTO_INCREMENT,
  `idPengguna` int(11) NOT NULL,
  `namaPeserta` varchar(200) NOT NULL,
  `telefonPeserta` varchar(12) NOT NULL,
  `noicPeserta` varchar(12) NOT NULL,
  `alamatPeserta` varchar(200) NOT NULL,
  PRIMARY KEY (`idPeserta`),
  KEY `peserta_ibfk_1` (`idPengguna`),
  CONSTRAINT `peserta_ibfk_1` FOREIGN KEY (`idPengguna`) REFERENCES `pengguna` (`idPengguna`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peserta`
--

LOCK TABLES `peserta` WRITE;
/*!40000 ALTER TABLE `peserta` DISABLE KEYS */;
INSERT INTO `peserta` VALUES (1,2,'b','aa','aa','aa'),(2,3,'c','a','a','a'),(3,4,'d','b','b','a'),(4,5,'e','aa','aa','aa'),(5,6,'f','a','a','a'),(6,7,'g','b','b','a'),(7,8,'h','aa','aa','aa'),(8,9,'i','a','a','a'),(9,10,'j','b','b','a'),(10,11,'dwadwa','1','1','d'),(11,12,'admin@testing.com','dwad','adw','dwa'),(12,13,'admin@testing.com','dwa','dwwa','dwa'),(13,14,'1','1','2','a');
/*!40000 ALTER TABLE `peserta` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `add markah` AFTER INSERT ON `peserta` FOR EACH ROW INSERT INTO markah (idPeserta) VALUES (NEW.idPeserta) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `allpengguna`
--

/*!50001 DROP TABLE IF EXISTS `allpengguna`*/;
/*!50001 DROP VIEW IF EXISTS `allpengguna`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `allpengguna` AS select `ap`.`id` AS `id`,`ap`.`nama` AS `nama`,`webapp`.`pengguna`.`emelPengguna` AS `emel`,`webapp`.`pengguna`.`kataLaluanPengguna` AS `kataLaluan`,`webapp`.`pengguna`.`perananPengguna` AS `peranan`,`ap`.`telefonPeserta` AS `telefonPeserta`,`ap`.`noicPeserta` AS `noicPeserta`,`ap`.`alamatPeserta` AS `alamatPeserta` from ((select `webapp`.`peserta`.`idPengguna` AS `id`,`webapp`.`peserta`.`namaPeserta` AS `nama`,`webapp`.`peserta`.`telefonPeserta` AS `telefonPeserta`,`webapp`.`peserta`.`noicPeserta` AS `noicPeserta`,`webapp`.`peserta`.`alamatPeserta` AS `alamatPeserta` from `webapp`.`peserta` union all select `webapp`.`hakim`.`idPengguna` AS `id`,`webapp`.`hakim`.`namaHakim` AS `nama`,NULL AS `NULL`,NULL AS `NULL`,NULL AS `NULL` from `webapp`.`hakim` union all select `webapp`.`admin`.`idPengguna` AS `id`,`webapp`.`admin`.`namaAdmin` AS `nama`,NULL AS `NULL`,NULL AS `NULL`,NULL AS `NULL` from `webapp`.`admin`) `ap` join `webapp`.`pengguna` on(`webapp`.`pengguna`.`idPengguna` = `ap`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `allpeserta`
--

/*!50001 DROP TABLE IF EXISTS `allpeserta`*/;
/*!50001 DROP VIEW IF EXISTS `allpeserta`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `allpeserta` AS select `peserta`.`idPeserta` AS `id`,`peserta`.`namaPeserta` AS `nama`,`markah`.`markahBhgA` AS `a`,`markah`.`markahBhgB` AS `b`,`markah`.`markahBhgC` AS `c`,`markah`.`jumlahMarkah` AS `jumlah` from (`peserta` join `markah` on(`peserta`.`idPeserta` = `markah`.`idPeserta`)) order by `markah`.`jumlahMarkah` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-16 23:49:34
