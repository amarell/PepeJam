-- MySQL dump 10.13  Distrib 8.0.23, for Win64 (x86_64)
--
-- Host: localhost    Database: pepejam
-- ------------------------------------------------------
-- Server version	8.0.23

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
-- Table structure for table `albums`
--

DROP TABLE IF EXISTS `albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `albums` (
  `album_id` int unsigned NOT NULL AUTO_INCREMENT,
  `album_name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `artist_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`album_id`),
  UNIQUE KEY `album_id_UNIQUE` (`album_id`),
  KEY `album_artist_idx` (`artist_id`),
  CONSTRAINT `album_artist` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albums`
--

LOCK TABLES `albums` WRITE;
/*!40000 ALTER TABLE `albums` DISABLE KEYS */;
INSERT INTO `albums` VALUES (1,'Curtains',1),(2,'Master of JSON',1),(3,'Hypnotic Clan',5);
/*!40000 ALTER TABLE `albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `artists`
--

DROP TABLE IF EXISTS `artists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `artists` (
  `artist_id` int unsigned NOT NULL AUTO_INCREMENT,
  `artist_name` varchar(256) COLLATE utf8_bin NOT NULL,
  `number_of_followers` int unsigned NOT NULL,
  PRIMARY KEY (`artist_id`),
  UNIQUE KEY `artist_id_UNIQUE` (`artist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artists`
--

LOCK TABLES `artists` WRITE;
/*!40000 ALTER TABLE `artists` DISABLE KEYS */;
INSERT INTO `artists` VALUES (1,'Amar10',218000),(2,'amarrel0',999),(3,'aMAR',90000),(4,'Muky',9000),(5,'Hytech',11),(6,'The Muriority',1000);
/*!40000 ALTER TABLE `artists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playlists`
--

DROP TABLE IF EXISTS `playlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `playlists` (
  `playlist_id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`playlist_id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlists`
--

LOCK TABLES `playlists` WRITE;
/*!40000 ALTER TABLE `playlists` DISABLE KEYS */;
INSERT INTO `playlists` VALUES (1,'playlist1',17),(2,'Dark of the light',17),(3,'Tottenham',39),(4,'Underworld',80);
/*!40000 ALTER TABLE `playlists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `song_album_logs`
--

DROP TABLE IF EXISTS `song_album_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `song_album_logs` (
  `song_album_log_id` int unsigned NOT NULL AUTO_INCREMENT,
  `song_id` int unsigned DEFAULT NULL,
  `album_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`song_album_log_id`),
  KEY `song_id_idx` (`song_id`),
  KEY `album_id_idx` (`album_id`),
  CONSTRAINT `fk_album_id` FOREIGN KEY (`album_id`) REFERENCES `albums` (`album_id`),
  CONSTRAINT `fk_song_id` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `song_album_logs`
--

LOCK TABLES `song_album_logs` WRITE;
/*!40000 ALTER TABLE `song_album_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `song_album_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `song_playlist_logs`
--

DROP TABLE IF EXISTS `song_playlist_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `song_playlist_logs` (
  `song_playlist_log_id` int unsigned NOT NULL AUTO_INCREMENT,
  `playlist_id` int unsigned NOT NULL,
  `song_id` int unsigned NOT NULL,
  PRIMARY KEY (`song_playlist_log_id`),
  KEY `playlist_id_idx` (`playlist_id`),
  KEY `song_id_idx` (`song_id`),
  CONSTRAINT `playlist_id` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`playlist_id`),
  CONSTRAINT `song_id` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `song_playlist_logs`
--

LOCK TABLES `song_playlist_logs` WRITE;
/*!40000 ALTER TABLE `song_playlist_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `song_playlist_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `songs`
--

DROP TABLE IF EXISTS `songs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `songs` (
  `song_id` int unsigned NOT NULL AUTO_INCREMENT,
  `song_name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `song_duration` double DEFAULT NULL,
  `number_of_plays` int unsigned NOT NULL,
  `artist_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`song_id`),
  UNIQUE KEY `song_id_UNIQUE` (`song_id`),
  KEY `song_artist_idx` (`artist_id`),
  CONSTRAINT `song_artist` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `songs`
--

LOCK TABLES `songs` WRITE;
/*!40000 ALTER TABLE `songs` DISABLE KEYS */;
INSERT INTO `songs` VALUES (1,'Song1',1,1230,1),(2,'Song1',32,12300,1),(3,'Tottenham',23,300,1),(4,'Dynamo',25,333,2),(5,'Chelsea',4,0,2),(6,'Similarity',4,0,2),(7,'Blinding Lights',4,1000,1);
/*!40000 ALTER TABLE `songs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) COLLATE utf8_bin NOT NULL,
  `password` varchar(256) COLLATE utf8_bin NOT NULL,
  `email` varchar(256) COLLATE utf8_bin NOT NULL,
  `status` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'PENDING',
  `token` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `role` varchar(45) COLLATE utf8_bin NOT NULL DEFAULT 'USER',
  `token_created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'amokney','666','mujagicamar@gmail.com','1','2','0000-00-00 00:00:00','USER',NULL),(16,'amarell','amarel123','amar.m@gmail.com','1','134','0000-00-00 00:00:00','USER',NULL),(17,'amr','202cb962ac59075b964b07152d234b70','amar.pepe@jam.com','ACTIVE','245','0000-00-00 00:00:00','USER',NULL),(18,'muky','muky1234','muky@gmail.com','1','12','0000-00-00 00:00:00','USER',NULL),(37,'dflksjljfd','password123','email','PENDING','mar','2021-03-19 11:47:14','USER',NULL),(38,'LMLzLg==','vrpQqflz+lSRmn7QhoJtSg==','if/DR20HQ4nGpw==','PENDING','xH9+LB5K4Tix9QipHVj4ejicRqQPGLK1','2021-03-19 15:07:43','USER',NULL),(39,'number','UdgYP1Uk5JdorAfgu6e9Kw==','QarjOPwranzSNg==','PENDING','ja+AvbgN0qB6Y6a+mp2H9yUFvDEDIn9t','2021-03-19 15:07:43','USER',NULL),(40,'4mWQJA==','hhvqTW98pPo/XYZ84mRrKA==','raoIbnmy/wwmOw==','PENDING','/zZkx0BdSh/gemu3m5pr5uXGFs+9mWrn','2021-03-19 15:07:43','USER',NULL),(41,'W4CbaQ==','xGNYeG7wYX4tDyBaLyA5Qw==','vW9NMmLt+mNPcA==','PENDING','76s2e26o9PF0vEffAWUOcWGDHyK4/2+T','2021-03-19 15:07:43','USER',NULL),(42,'YkhoeA==','c5NaWBlAobBMLmv8fApwzA==','KCF3zkcjAXNigw==','PENDING','LfAy8i/ND4ygI7vnOIv0dkT21lBDYp+M','2021-03-19 15:07:43','USER',NULL),(43,'QfI69w==','GyE7xHPqKwYApxAc+F2Iuw==','JdakhnIu4RWAKA==','PENDING','P4zxW82ipXwL6wBsDnTwEpZoMXZVvMQZ','2021-03-19 15:07:43','USER',NULL),(44,'uvWadw==','EZlNUlzAR1fDXnyCQtJXLQ==','JPXcEOUPbLfB9A==','PENDING','KbxcJWglmbrgBmVWE2YrgzindHuMipxS','2021-03-19 15:07:43','USER',NULL),(45,'5YyeqA==','1w8qhK/i2DfbpfqgEeH3QA==','v/lWvXbm9onEVw==','PENDING','p2swgBIYn5QYG1y6FuALCGFfBBQcKqoF','2021-03-19 15:07:43','USER',NULL),(46,'OERGuA==','y/bEsaYW580C1BWhhpTtMw==','veore0pZPnB7rw==','PENDING','wCGQUAhE0gvOeNmSe0y5YUelXrN92JRh','2021-03-19 15:07:43','USER',NULL),(47,'A/1qEg==','NX6AE7vWV9dxLhvBzOCtqA==','r91uVYz0pJsZQA==','PENDING','2yvEqxDHBpnbqB5d0k96VzgX75vVTXIX','2021-03-19 15:07:43','USER',NULL),(51,'AmarIRL','bla bla','random@random.net','ACTIVE','henlo','2021-03-19 17:07:43','USER',NULL),(52,'a121','fjdslččč','random@89.net','PENDING','jk','2021-03-20 13:19:34','USER',NULL),(54,'11111','fjdslččč','gulag@89.net','PENDING','ONESTEPFROMGIVINGUP','2021-03-20 14:19:54','USER',NULL),(55,'438932','amarel1234567878','wordlwar219@89.net','PENDING','ONESTEPFdffROMGIVINGUP','2021-03-20 14:29:25','USER',NULL),(56,'839018577','213890kfldsj329','235jklfg000@89.net','PENDING','aadfhjbbbb333','2021-03-20 14:34:59','USER',NULL),(59,'henloer','henlodfso','235jklfg000@8hnbro9.net','PENDING','9e0loiFbJneoPK9nJhEumQ==','2021-03-20 16:59:42','USER',NULL),(61,'henloer1234','henlodfso','googoogaga@8hnbro9.net','PENDING','+toWY/yvcB4T4iLhRYwB8g==','2021-03-20 17:13:38','USER',NULL),(62,'amr12','henlodfso','googoogagaubbubu@345.net','ACTIVE','7fd30c0f76792c5177c7135c308bd075','2021-03-20 17:22:31','USER',NULL),(63,'amr12354','henlodfsof','googoogagaubbubu@34ds5.net','ACTIVE','f2e53e36d4d4a89544a887646bf462b9','2021-03-20 17:24:28','USER',NULL),(66,'najdorf123344','213890kfldsj329','235jklfg000@8s9.net','PENDING','aadfhjbbbb33sgnn3','2021-03-21 12:39:49','USER',NULL),(80,'najdorf','202cb962ac59075b964b07152d234b70','amar.mujagic@stu.ibu.edu.ba','ACTIVE',NULL,'2021-03-27 17:59:06','ADMIN','2021-04-03 11:37:03'),(81,'DFBNN','213890kfldsj329','235jklfg000@8s9.neSSt','PENDING','SFDGHN13','2021-03-27 19:18:38','USER',NULL),(82,'user1','81dc9bdb52d04dc20036dbd8313ed055','myemail@gmail.com','ACTIVE',NULL,'2021-03-27 19:22:07','USER',NULL),(83,'Kingc2','202cb962ac59075b964b07152d234b70','blabla@gmail.com','ACTIVE','8ae11d1dba987275b387c27e5a2051c4','2021-04-07 15:51:23','USER','2021-04-07 16:12:59'),(84,'newuser','202cb962ac59075b964b07152d234b70','blabla@gmdsfail.com','ACTIVE',NULL,'2021-04-07 15:53:04','USER',NULL),(85,'ne4wguy','827ccb0eea8a706c4c34a16891f84e7b','blabla@fail.com','ACTIVE',NULL,'2021-04-07 16:00:32','USER','2021-04-07 16:28:22');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-07 20:47:14
