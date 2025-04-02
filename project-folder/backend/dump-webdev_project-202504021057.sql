-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: webdev_project
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT 'moderator',
  `permissions` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `email` (`email`),
  CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (2,10,'test_67e4108e61ffd@example.com','admin',NULL),(3,12,'test_67e4119084ee9@example.com','admin',''),(4,13,'test_67e833edd24e4@example.com','admin',''),(5,14,'test_67e834e817c5a@example.com','admin',''),(6,15,'test_67e8354934a57@example.com','admin',''),(7,24,'test_67e83e5d9aa94@example.com','admin',''),(8,1,'test_67e84008f2b38@example.com','admin','all');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `release_date` datetime DEFAULT NULL,
  `description` text DEFAULT NULL,
  `specifications` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Web Development Book',52.45,0,NULL,NULL,NULL,'2025-03-26 15:07:24'),(2,'Test Product 67e40afb95f1b',13.68,0,NULL,NULL,NULL,'2025-03-26 15:11:07'),(3,'Test Product 67e40bdbbaa08',77.46,0,NULL,NULL,NULL,'2025-03-26 15:14:51'),(4,'Test Product 67e40c60c79ef',72.99,0,NULL,NULL,NULL,'2025-03-26 15:17:04'),(5,'Test Product 67e40ce681702',81.95,0,NULL,NULL,NULL,'2025-03-26 15:19:18'),(6,'Test Product 67e40ddcb4352',39.17,0,NULL,NULL,NULL,'2025-03-26 15:23:24'),(7,'Test Product 67e40e5b1e8a0',92.99,0,NULL,NULL,NULL,'2025-03-26 15:25:31'),(8,'Test Product 67e40ea62b9ec',14.68,0,NULL,NULL,NULL,'2025-03-26 15:26:46'),(9,'Test Product 67e40f7b5956d',50.58,0,NULL,NULL,NULL,'2025-03-26 15:30:19'),(10,'Test Product 67e4108e88979',31.08,0,NULL,NULL,NULL,'2025-03-26 15:34:54'),(11,'Test Product 67e41141b1ab9',84.05,0,NULL,NULL,NULL,'2025-03-26 15:37:53'),(12,'Test Product 67e41190a2b98',33.11,0,NULL,NULL,NULL,'2025-03-26 15:39:12'),(13,'Test Product 67e833ede5fb2',14.77,0,NULL,NULL,NULL,'2025-03-29 18:54:53'),(14,'Test Product 67e834e827530',54.17,0,NULL,NULL,NULL,'2025-03-29 18:59:04'),(15,'Test Product 67e83549481c2',29.55,0,NULL,NULL,NULL,'2025-03-29 19:00:41'),(16,'Test Product 67e835b1c61a6',19.10,0,NULL,NULL,NULL,'2025-03-29 19:02:25'),(17,'Test Product 67e835d808db5',31.40,0,NULL,NULL,NULL,'2025-03-29 19:03:04'),(18,'Test Product 67e838928893c',29.15,0,NULL,NULL,NULL,'2025-03-29 19:14:42'),(19,'Test Product 67e83a71b1bf0',66.44,0,NULL,NULL,NULL,'2025-03-29 19:22:41'),(20,'Test Product 67e83b16b36fd',54.61,0,NULL,NULL,NULL,'2025-03-29 19:25:26'),(21,'Test Product 67e83b834076c',37.07,0,NULL,NULL,NULL,'2025-03-29 19:27:15'),(22,'Test Product 67e83e5daa9f6',18.29,0,NULL,NULL,NULL,'2025-03-29 19:39:25'),(23,'Test Product 67e840090e845',47.45,100,NULL,NULL,NULL,'2025-03-29 19:46:33'),(24,'Test Product 67e8406db0158',88.92,100,NULL,NULL,NULL,'2025-03-29 19:48:13'),(25,'Test Product 67e84142259a4',86.62,100,NULL,NULL,NULL,'2025-03-29 19:51:46'),(26,'Test Product 67e841e802a92',80.60,0,NULL,NULL,NULL,'2025-03-29 19:54:32'),(27,'Test Product 67e84321711bc',79.54,0,NULL,NULL,NULL,'2025-03-29 19:59:45'),(28,'Test Product 67e843d470605',91.71,0,NULL,NULL,NULL,'2025-03-29 20:02:44'),(29,'Test Product 67e8446e1708b',68.50,0,NULL,NULL,NULL,'2025-03-29 20:05:18'),(30,'Test Product 67e84d01968b6',22.78,0,NULL,NULL,NULL,'2025-03-29 20:41:53'),(31,'Test Product 67e84f92bfa80',82.32,0,NULL,NULL,NULL,'2025-03-29 20:52:50'),(32,'Test Product 67e8500d38653',21.38,0,NULL,NULL,NULL,'2025-03-29 20:54:53'),(33,'Test Product 67e8500f6ead0',100.24,0,NULL,NULL,NULL,'2025-03-29 20:54:55'),(34,'Test Product 67e8500fb72f2',93.03,0,NULL,NULL,NULL,'2025-03-29 20:54:55'),(35,'Test Product 67e8501001fdc',34.91,0,NULL,NULL,NULL,'2025-03-29 20:54:56'),(36,'Test Product 67e85013cd4a1',63.84,0,NULL,NULL,NULL,'2025-03-29 20:54:59'),(37,'Test Product 67e8502011877',77.57,0,NULL,NULL,NULL,'2025-03-29 20:55:12');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `review_date` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `purchase_date` datetime DEFAULT current_timestamp(),
  `payment_method` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(20) DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (2,6,6,'2025-03-26 15:23:24','credit_card',39.17,'completed'),(3,7,7,'2025-03-26 15:25:31','credit_card',92.99,'completed'),(4,8,8,'2025-03-26 15:26:46','credit_card',14.68,'completed'),(5,9,9,'2025-03-26 15:30:19','credit_card',50.58,'completed'),(6,10,10,'2025-03-26 15:34:54','credit_card',31.08,'completed'),(7,11,11,'2025-03-26 15:37:53','credit_card',84.05,'completed'),(8,12,12,'2025-03-26 15:39:12','credit_card',33.11,'completed'),(9,13,13,'2025-03-29 18:54:53','credit_card',14.77,'completed'),(10,14,14,'2025-03-29 18:59:04','credit_card',54.17,'completed'),(11,15,15,'2025-03-29 19:00:41','credit_card',29.55,'completed'),(12,16,16,'2025-03-29 19:02:25','credit_card',19.10,'completed'),(13,17,17,'2025-03-29 19:03:04','credit_card',31.40,'completed'),(14,22,20,'2025-03-29 19:25:26','credit_card',54.61,'completed'),(15,23,21,'2025-03-29 19:27:15','credit_card',37.07,'completed'),(16,24,1,'2025-03-29 19:39:25','credit_card',29.99,'completed'),(17,1,1,'2025-03-29 19:46:33','credit_card',47.45,'completed'),(18,1,1,'2025-03-29 19:48:13','credit_card',88.92,'completed'),(19,1,1,'2025-03-29 19:51:46','credit_card',86.62,'completed'),(20,1,1,'2025-03-29 19:54:32','credit_card',52.45,'completed'),(21,1,1,'2025-03-29 19:59:45','credit_card',52.45,'completed'),(22,1,1,'2025-03-29 20:02:44','credit_card',52.45,'completed'),(23,1,1,'2025-03-29 20:05:18','credit_card',52.45,'completed'),(24,1,1,'2025-03-29 20:41:53','credit_card',52.45,'completed'),(25,1,1,'2025-03-29 20:52:50','credit_card',52.45,'completed'),(26,1,1,'2025-03-29 20:54:53','credit_card',52.45,'completed'),(27,1,1,'2025-03-29 20:54:55','credit_card',52.45,'completed'),(28,1,1,'2025-03-29 20:54:55','credit_card',52.45,'completed'),(29,1,1,'2025-03-29 20:54:56','credit_card',52.45,'completed'),(30,1,1,'2025-03-29 20:54:59','credit_card',52.45,'completed'),(31,1,1,'2025-03-29 20:55:12','credit_card',52.45,'completed');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `registration_date` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'johffndoesdf','updated_test_67e84008f2b38@example.com','$2y$10$mvqhVrjDdhpPgYhCCMEJIOq1i.1PkrdUToZI3k6Rzax5NNPoC1LYG','2025-03-26 15:07:24',NULL,1),(2,'testuser_67e40afb4f581','test_67e40afb4f584@example.com','$2y$10$/rRTqBCKieDQxe9O5rTTwOqyeIZ6c7i8YzexOSQWJ.iqkSoQjc6lS','2025-03-26 15:11:07',NULL,1),(3,'testuser_67e40bdb9b194','test_67e40bdb9b197@example.com','$2y$10$iM1l7mdyJmu.1QeuON8v/uqigzzG6CiPdxeRBW/uNqZDqrZFf72Rm','2025-03-26 15:14:51',NULL,1),(4,'testuser_67e40c6095660','test_67e40c6095662@example.com','$2y$10$bRv5FaAeRVL1nZ4zZnPC3OIqO3rqtKI1fFbGF4eIZk63y749aizse','2025-03-26 15:17:04',NULL,1),(5,'testuser_67e40ce6446bc','test_67e40ce6446c1@example.com','$2y$10$jJzrAPyt521nnbmOw/MZhuSr/37SBtrfXaf0D6kfO.5dEBLkXwRZW','2025-03-26 15:19:18',NULL,1),(6,'testuser_67e40ddc8fb29','test_67e40ddc8fb2b@example.com','$2y$10$H8rEy9LBdxaLncOtiyRQ9eHeXxr9A06JViRYd64536mlLU4jN0BTm','2025-03-26 15:23:24',NULL,1),(7,'testuser_67e40e5aed2b2','test_67e40e5aed2b5@example.com','$2y$10$U3kfqIQVgRBB54z73OOquucVWZIz7qPKs.NFDpCkeTHxKECdivRzq','2025-03-26 15:25:31',NULL,1),(8,'testuser_67e40ea606eb1','test_67e40ea606eb4@example.com','$2y$10$pzmgC.14H2iWX8IeyxrDv.NGxz3gPfAP33kodQ8lE5nkheE6cnfBa','2025-03-26 15:26:46',NULL,1),(9,'testuser_67e40f7b2b363','test_67e40f7b2b36c@example.com','$2y$10$V3fAk.tKZ16/twQCSIZWC.mat6qb53L55IEv.LQAYhgw7DHwE38tm','2025-03-26 15:30:19',NULL,1),(10,'testuser_67e4108e61ff6','test_67e4108e61ffd@example.com','$2y$10$63JFk6WnEOBLsb7w7NCGj.XOazZ3ZEIaCX9bJkMQ7ybELKFKeNIFC','2025-03-26 15:34:54',NULL,1),(11,'testuser_67e4114174715','test_67e411417471a@example.com','$2y$10$vBiFwh0hCR8N13DJHaBXcevSW/CiQ3Rm6typetaNLKMXJ4lL/nidy','2025-03-26 15:37:53',NULL,1),(12,'testuser_67e4119084ee5','test_67e4119084ee9@example.com','$2y$10$A/cebaLS.W1BQf4fF55dE.oSYVhW6AHr873Fg.uS1aW5NDWp3ragC','2025-03-26 15:39:12',NULL,1),(13,'testuser_67e833edd24e3','test_67e833edd24e4@example.com','$2y$10$rSZU93ujdXwPbJOtc2ddE.Kg6t/OIfToinEpota.m5ofDXrghJIxy','2025-03-29 18:54:53',NULL,1),(14,'testuser_67e834e817c58','test_67e834e817c5a@example.com','$2y$10$MJg0zqVcf/FvsX7sxUvgDuog.yjsLanNwaPH6j.bIi6UbBlR.JnTa','2025-03-29 18:59:04',NULL,1),(15,'testuser_67e8354934a56','test_67e8354934a57@example.com','$2y$10$AMB4XJDKQPAbB0zBv47UX.ZZlxR/lQmvKKKh43CDdY.J4bJs3GiMm','2025-03-29 19:00:41',NULL,1),(16,'testuser_67e835b1ae513','test_67e835b1ae515@example.com','$2y$10$sI7nu6zotNTcP18ZLAhTxuUGgT2L2oFOHGYLw7VhlSX.ABpFCmfQC','2025-03-29 19:02:25',NULL,1),(17,'testuser_67e835d7eb6cb','test_67e835d7eb6cd@example.com','$2y$10$LrLGctA4DeEVenR3qZgnoOcodno99FJ88Fbz4YKTD/8XC3cfWOR3y','2025-03-29 19:03:04',NULL,1),(18,'testuser_67e83723eb014','test_67e83723eb016@example.com','$2y$10$ZX7A6E6ApGM2f6R7DXnw7eTYM.3wbvcfVF1bpq0eMus5sOSXHf3S2','2025-03-29 19:08:36',NULL,1),(19,'testuser_67e837ee36677','test_67e837ee36679@example.com','$2y$10$L.1HKubtsUg/wqEXn/PV8O2Xc9ManPZRNqzxf9MfYCJxdegjUkCvy','2025-03-29 19:11:58',NULL,1),(20,'testuser_67e8389277abd','test_67e8389277abe@example.com','$2y$10$sLJ901ft9ig9X3u3hJDKru/hHHMIFUfjqaZOQHQDPHiPrOUZMPEZe','2025-03-29 19:14:42',NULL,1),(21,'testuser_67e83a71a19e7','test_67e83a71a19e9@example.com','$2y$10$3ARgdizuyhY930fUMEN2BuupiBd0TnSg6./5sKdpTWjXj58rdHTcu','2025-03-29 19:22:41',NULL,1),(22,'testuser_67e83b16a1b8e','test_67e83b16a1b8f@example.com','$2y$10$t0nS.lwpxDYuUaBDMnRz4.NudSxt4Cr3uATtn.Klg3bqusndrZN.W','2025-03-29 19:25:26',NULL,1),(23,'testuser_67e83b83310b9','test_67e83b83310ba@example.com','$2y$10$z8v9VGQHSOAhgtAnba8Uxex/OtoUKPFgVsq8WuzGoSZmP5gI7n0ie','2025-03-29 19:27:15',NULL,1),(24,'testuser_67e83e5d9aa92','test_67e83e5d9aa94@example.com','$2y$10$zlkCfmJxZL4Uc2rhquhsL.DsBcuFpsbmsFPgWCa9HOYklO9sb8h3y','2025-03-29 19:39:25',NULL,1),(25,'testuser_67e84008f2b37','test_67e84008f2b38@example.com','$2y$10$MQYwYZ.0K985BDtg1i94ce3CIRSL2GQNEfj/eM//Av9D6KPpY9uia','2025-03-29 19:46:33',NULL,1),(26,'testuser_67e8406da0002','test_67e8406da0004@example.com','$2y$10$JKCCYxLsxjz5ChfvKoQRkepSQ77CBUqQKVeHU1IKghEyyHfIVAgYy','2025-03-29 19:48:13',NULL,1),(27,'testuser_67e8414215ce9','test_67e8414215cea@example.com','$2y$10$342ivVJBsdTWtJ/ISCs/qu7vBOSgog3LB6/px7f8qG5ntxOC3VzIG','2025-03-29 19:51:46',NULL,1),(28,'testuser_67e841e7e60f1','test_67e841e7e60f2@example.com','$2y$10$gdAn6.6r4hrKHJOZDi6qIuKn.1nVDV4ch1MM8mBCdirebaYBBCQzi','2025-03-29 19:54:31',NULL,1),(29,'testuser_67e843215f45c','test_67e843215f45e@example.com','$2y$10$Wi8wPQhBbI8kPBYEdvCo6O4fmfSitfQX8e1YG/BMkUCZRy/sBNEiO','2025-03-29 19:59:45',NULL,1),(30,'testuser_67e843d45fdf3','test_67e843d45fdf4@example.com','$2y$10$ZWImTI5.QPsmN/VFBuOyKuqg/TRyfbLbMQ/bmRBN9PTM7DpfanIlu','2025-03-29 20:02:44',NULL,1),(31,'testuser_67e8446e06c27','test_67e8446e06c29@example.com','$2y$10$yN3ajUpLMMR4qodpxk3ivuAbAH6EszblXjsmnaHXO8QwTqQjrHV7.','2025-03-29 20:05:18',NULL,1),(32,'testuser_67e84d01854ff','test_67e84d0185501@example.com','$2y$10$JOElyc7AwVppMjjeosGEIuNmNYLTtCqxrEp0VKk3k3kdh6biBt2n2','2025-03-29 20:41:53',NULL,1),(33,'testuser_67e84f92b0729','test_67e84f92b072b@example.com','$2y$10$lJz.czm9Lz5fp2QyejRC5.Bed2zln5.xsprlVL8yXQ7WoJoELjrUy','2025-03-29 20:52:50',NULL,1),(34,'testuser_67e8500d20913','test_67e8500d20915@example.com','$2y$10$ztKEHoaUXo8nR5UnXRWQl.2L/zInYYxUiyaCqCT0l7Lf9yURkRItG','2025-03-29 20:54:53',NULL,1),(35,'testuser_67e8500f5e65b','test_67e8500f5e65e@example.com','$2y$10$44rSn0IOqjjXQ50d/SCg6ecH9S1IuBmDvMBpDcbt984AOwzOUIN7W','2025-03-29 20:54:55',NULL,1),(36,'testuser_67e8500fa56af','test_67e8500fa56b2@example.com','$2y$10$WMDBP.l57K.CJhI6/eVyzeD3RKzc1Ouh6X0ZH0arnfQzQIk7PLJba','2025-03-29 20:54:55',NULL,1),(37,'testuser_67e8500fe4d5c','test_67e8500fe4d5e@example.com','$2y$10$99l6bPrJI4F/G6JgfGR9P.ELNsBA6WGtcgGtjbAc41CBPeqsdJhTG','2025-03-29 20:54:56',NULL,1),(38,'testuser_67e85013bcdf6','test_67e85013bcdf8@example.com','$2y$10$tk6xAi14GIPqNreGJW1lyOO146KiBZTYyDe2xDAJXSMBzoGXA7eUm','2025-03-29 20:54:59',NULL,1),(39,'testuser_67e8501ff26ed','test_67e8501ff26ef@example.com','$2y$10$QFUk5ZbtZqoP5qX4d9rLru0A2rmKvgyZ8qgAwsAdZWLqgZ1O00tKi','2025-03-29 20:55:12',NULL,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'webdev_project'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-02 10:57:57
