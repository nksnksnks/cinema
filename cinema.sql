CREATE DATABASE  IF NOT EXISTS `cinema_ease` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cinema_ease`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: cinema_ease
-- ------------------------------------------------------
-- Server version	8.0.35

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
-- Table structure for table `ci_account`
--

DROP TABLE IF EXISTS `ci_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_account` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cinema_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ci_account_username_unique` (`username`),
  UNIQUE KEY `ci_account_email_unique` (`email`),
  KEY `ci_account_role_id_foreign` (`role_id`),
  CONSTRAINT `ci_account_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `ci_role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_account`
--

LOCK TABLES `ci_account` WRITE;
/*!40000 ALTER TABLE `ci_account` DISABLE KEYS */;
INSERT INTO `ci_account` VALUES (4,2,'user1','user1@gmail.com','1','$2y$10$qnWHjb/LAylviN058e8upeETmStRDQIxEcjtIUpQbj7.1q0B/psyS','xxx111xxx',1,'2024-11-06 13:52:59','2024-11-27 14:40:09',NULL),(5,1,'admin','002@gmail.com','1','$2y$10$v19EJG9bxIVVEW7.eRxmG.vUzP/GfmFCVNsw/.pns3ARPR4RLUcNC','null',1,'2024-11-27 14:38:11','2024-12-16 05:37:45',NULL),(7,3,'user5','user5@gmail.com','1','$2y$10$EMkrE3Crlsh0g8qfpY4w7Oj.X/z3/IZxJHK.5wdaj0BXqSf.mI/vu','xxxx',1,'2024-12-08 18:00:08','2024-12-29 03:41:47',NULL),(8,4,'user4','user4@gmail.com','1','$2y$10$cNs/Jk7N7iCBaRmMl.ixquUAV3pYhevUEzh4NosyVrRK8eYZGL2Uy','xxxx',1,'2024-12-11 09:40:37','2024-12-25 08:11:50',NULL),(9,4,'user6','nhatbg06042002@gmail.com','1','$2y$10$Uaxq/QJ4BpbKm2GH5PBjgOxNChTK6p471yl8aSsgl8nStiSCSuzse','xxxx',1,'2024-12-13 10:41:06','2025-01-02 02:19:32',NULL),(10,4,'user7','emailTest@gmail.com','1','$2y$10$RolZ4YDZIBL1GN5eybXJ1eh0KJ20A4N1L15VD4VBrEfLnU3WnGHnq',NULL,1,'2024-12-13 11:09:15','2024-12-13 11:09:15',NULL),(11,4,'user8','nhat123@gmail.com','1','$2y$10$U/w36yQoylYGevcmKfWB3OCmbBa7s259sXCoF/x.9ffmSt./GcQQW',NULL,1,'2024-12-13 12:02:13','2024-12-13 12:02:13',NULL),(12,4,'user9','user9@gmail.com',NULL,'$2y$10$mIxjnC.3uYB72y7lJpHlqOX.8fT4wNCkH6zsTH9QsdcHbFbbRdQay',NULL,1,'2024-12-16 05:35:28','2024-12-16 05:35:28',NULL);
/*!40000 ALTER TABLE `ci_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_bill`
--

DROP TABLE IF EXISTS `ci_bill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_bill` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ticket_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Unique ticket code for each bill',
  `account_id` bigint unsigned NOT NULL,
  `cinema_id` bigint unsigned NOT NULL,
  `movie_show_time_id` bigint unsigned NOT NULL,
  `staff_check` int NOT NULL,
  `total` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ci_bill_ticket_code_unique` (`ticket_code`),
  KEY `ci_bill_cinema_id_foreign` (`cinema_id`),
  KEY `ci_bill_account_id_foreign` (`account_id`),
  CONSTRAINT `ci_bill_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `ci_account` (`id`),
  CONSTRAINT `ci_bill_cinema_id_foreign` FOREIGN KEY (`cinema_id`) REFERENCES `ci_cinema` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_bill`
--

LOCK TABLES `ci_bill` WRITE;
/*!40000 ALTER TABLE `ci_bill` DISABLE KEYS */;
INSERT INTO `ci_bill` VALUES (19,'961611735357411',9,1,60,7,'535000',NULL,'1','2024-12-20 03:43:31','2024-12-29 09:43:08',NULL),(20,'947871735357570',9,1,61,7,'535000',NULL,'1','2024-12-20 03:46:10','2024-12-29 03:46:49',NULL),(21,'348081735357607',9,1,63,7,'535000',NULL,'1','2024-12-20 03:46:47','2024-12-29 09:50:41',NULL),(22,'820611735357640',9,1,64,7,'535000',NULL,'1','2024-12-21 03:47:20','2024-12-29 09:52:52',NULL),(23,'968671735357668',9,1,65,9,'535000',NULL,'1','2024-12-22 03:47:48','2024-12-29 02:24:14',NULL),(24,'778781735358530',9,1,66,0,'535000',NULL,'0','2024-12-22 04:02:10','2024-12-28 04:02:10',NULL),(25,'591601735358586',9,1,67,0,'535000',NULL,'0','2024-12-23 04:03:06','2024-12-28 04:03:06',NULL),(26,'411821735358626',9,1,68,0,'535000',NULL,'0','2024-12-24 04:03:46','2024-12-28 04:03:46',NULL),(28,'224881735360321',9,1,60,0,'535000',NULL,'0','2024-12-20 04:32:01','2024-12-28 04:32:01',NULL),(29,'174801735473834',7,1,72,7,'310000',NULL,'1','2024-12-29 12:03:54','2024-12-29 12:03:54',NULL),(30,'975491735482242',8,1,72,0,'430000',NULL,'0','2024-12-29 14:24:02','2024-12-29 14:24:02',NULL),(31,'962641735482409',7,1,72,7,'310000',NULL,'1','2024-12-29 14:26:49','2024-12-29 14:26:49',NULL),(32,'117621735842368',9,1,72,0,'230000','2','0','2025-01-02 18:26:08','2025-01-02 18:26:08',NULL);
/*!40000 ALTER TABLE `ci_bill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_cinema`
--

DROP TABLE IF EXISTS `ci_cinema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_cinema` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_cinema`
--

LOCK TABLES `ci_cinema` WRITE;
/*!40000 ALTER TABLE `ci_cinema` DISABLE KEYS */;
INSERT INTO `ci_cinema` VALUES (1,'CinemaEase Hà Đông',NULL,'Số 10 - Trần Phú - Hà Đông - Hà Nội',20.9831660,105.7909850,'2024-10-20 14:11:39','2024-10-20 14:11:39',NULL),(2,'CinemaEase Bắc Từ Liêm',NULL,'Tòa nhà 21B5, 234 Phạm Văn Đồng, Bắc Từ Liêm, Cổ Nhuế, Từ Liêm, Hà Nội',21.0481570,105.7817570,'2024-12-14 13:42:20','2024-12-14 13:42:20',NULL);
/*!40000 ALTER TABLE `ci_cinema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_country`
--

DROP TABLE IF EXISTS `ci_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_country` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_country`
--

LOCK TABLES `ci_country` WRITE;
/*!40000 ALTER TABLE `ci_country` DISABLE KEYS */;
INSERT INTO `ci_country` VALUES (1,'Việt Nam','Đất nước yêu hòa bình','2024-11-06 13:54:23','2024-11-06 13:54:23',NULL),(7,'Hoa Kỳ','Quốc gia Bắc Mỹ, có nền kinh tế hàng đầu thế giới.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(8,'Anh','Quốc gia châu Âu với lịch sử lâu đời và văn hóa đa dạng.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(9,'Pháp','Quốc gia nổi tiếng với văn hóa, nghệ thuật và ẩm thực.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(10,'Nhật Bản','Quốc gia châu Á với công nghệ tiên tiến và truyền thống độc đáo.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(11,'Hàn Quốc','Quốc gia nổi tiếng với âm nhạc K-pop và công nghệ phát triển.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(12,'Trung Quốc','Quốc gia đông dân nhất thế giới với lịch sử hơn 5000 năm.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(13,'Đức','Quốc gia châu Âu với nền kinh tế mạnh và công nghiệp phát triển.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(14,'Ấn Độ','Quốc gia Nam Á với nền văn hóa và tôn giáo đa dạng.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(15,'Canada','Quốc gia Bắc Mỹ với thiên nhiên hùng vĩ và hệ thống giáo dục tốt.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(16,'Úc','Quốc gia châu Đại Dương với động vật độc đáo và phong cảnh đẹp.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL);
/*!40000 ALTER TABLE `ci_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_evaluate`
--

DROP TABLE IF EXISTS `ci_evaluate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_evaluate` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned NOT NULL,
  `movie_id` bigint unsigned NOT NULL,
  `vote_star` int NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_evaluate`
--

LOCK TABLES `ci_evaluate` WRITE;
/*!40000 ALTER TABLE `ci_evaluate` DISABLE KEYS */;
INSERT INTO `ci_evaluate` VALUES (5,9,25,5,'Phim rất hay','2024-12-24 06:05:55','2024-12-24 06:05:55',NULL);
/*!40000 ALTER TABLE `ci_evaluate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_food_bill_join`
--

DROP TABLE IF EXISTS `ci_food_bill_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_food_bill_join` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bill_id` bigint unsigned NOT NULL,
  `food_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `total` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_food_bill_join`
--

LOCK TABLES `ci_food_bill_join` WRITE;
/*!40000 ALTER TABLE `ci_food_bill_join` DISABLE KEYS */;
INSERT INTO `ci_food_bill_join` VALUES (1,19,1,4,480000,'2024-12-28 03:43:31','2024-12-28 03:43:31'),(2,20,1,4,480000,'2024-12-28 03:46:10','2024-12-28 03:46:10'),(3,21,1,4,480000,'2024-12-28 03:46:47','2024-12-28 03:46:47'),(4,22,1,4,480000,'2024-12-28 03:47:20','2024-12-28 03:47:20'),(5,23,1,4,480000,'2024-12-28 03:47:48','2024-12-28 03:47:48'),(6,24,1,4,480000,'2024-12-28 04:02:10','2024-12-28 04:02:10'),(7,25,1,4,480000,'2024-12-28 04:03:06','2024-12-28 04:03:06'),(8,26,1,4,480000,'2024-12-28 04:03:46','2024-12-28 04:03:46'),(9,27,1,4,480000,'2024-12-28 04:21:30','2024-12-28 04:21:30'),(10,28,1,4,480000,'2024-12-28 04:32:01','2024-12-28 04:32:01'),(11,29,3,2,240000,'2024-12-29 12:03:54','2024-12-29 12:03:54'),(12,30,2,2,240000,'2024-12-29 14:24:02','2024-12-29 14:24:02'),(13,30,3,1,120000,'2024-12-29 14:24:02','2024-12-29 14:24:02'),(14,31,2,1,120000,'2024-12-29 14:26:49','2024-12-29 14:26:49'),(15,31,3,1,120000,'2024-12-29 14:26:49','2024-12-29 14:26:49'),(16,32,1,1,120000,'2025-01-02 18:26:08','2025-01-02 18:26:08'),(17,32,2,1,120000,'2025-01-02 18:26:08','2025-01-02 18:26:08');
/*!40000 ALTER TABLE `ci_food_bill_join` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_foods`
--

DROP TABLE IF EXISTS `ci_foods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_foods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_foods`
--

LOCK TABLES `ci_foods` WRITE;
/*!40000 ALTER TABLE `ci_foods` DISABLE KEYS */;
INSERT INTO `ci_foods` VALUES (1,'Combo 1','Harmony Plus: 1 Hộp bắp Harmony mix 2 vị + 1 nước ngọt cỡ lớn + 1 chai nước suối: 120.000đ',120000,'https://res.cloudinary.com/dxlcnw5bz/image/upload/v1734248195/food/ubrbfgydb040a10ynqza.jpg',1,'2024-12-15 07:36:36','2024-12-15 07:36:36',NULL),(2,'Combo 2','Harmony Plus: 1 Hộp bắp Harmony mix 2 vị + 1 nước ngọt cỡ lớn + 1 chai nước suối: 120.000đ',120000,'https://res.cloudinary.com/dxlcnw5bz/image/upload/v1734248223/food/uey21ta2eiqvnap73oqr.jpg',1,'2024-12-15 07:37:03','2024-12-15 07:37:58',NULL),(3,'Combo 3','Harmony Plus: 1 Hộp bắp Harmony mix 2 vị + 1 nước ngọt cỡ lớn + 1 chai nước suối: 120.000đ',120000,'https://res.cloudinary.com/dxlcnw5bz/image/upload/v1734248263/food/kz3qx4ybyinu25n070q2.jpg',1,'2024-12-15 07:37:43','2024-12-15 07:37:43',NULL),(4,'Combo 4','Harmony Plus: 1 Hộp bắp Harmony mix 2 vị + 1 nước ngọt cỡ lớn + 1 chai nước suối: 120.000đ',120000,'https://res.cloudinary.com/dxlcnw5bz/image/upload/v1734248326/food/qwpxk2iuzjzhsjvj8wjc.jpg',1,'2024-12-15 07:38:47','2024-12-15 07:38:47',NULL),(5,'Combo 5','Harmony Plus: 1 Hộp bắp Harmony mix 2 vị + 1 nước ngọt cỡ lớn + 1 chai nước suối: 120.000đ',120000,'https://res.cloudinary.com/dxlcnw5bz/image/upload/v1734248352/food/t88hjphkkxa2zdyvnrqy.jpg',1,'2024-12-15 07:39:12','2024-12-15 07:39:12',NULL);
/*!40000 ALTER TABLE `ci_foods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_genre`
--

DROP TABLE IF EXISTS `ci_genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_genre` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_genre`
--

LOCK TABLES `ci_genre` WRITE;
/*!40000 ALTER TABLE `ci_genre` DISABLE KEYS */;
INSERT INTO `ci_genre` VALUES (1,'Hành động','Phim có những cảnh quay mạnh mẽ','2024-11-06 13:54:38','2024-11-06 13:54:38',NULL),(12,'Kinh dị','Phim với nội dung đáng sợ, tạo cảm giác hồi hộp và lo lắng.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(13,'Hài','Thể loại mang lại tiếng cười và sự giải trí nhẹ nhàng.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(14,'Tình cảm','Phim xoay quanh các mối quan hệ tình yêu, gia đình và cảm xúc.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(15,'Hoạt hình','Phim với hình ảnh động, thường dành cho trẻ em và gia đình.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(16,'Phiêu lưu','Thể loại với nội dung khám phá, mạo hiểm và đầy kịch tính.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(17,'Tâm lý','Phim tập trung vào cảm xúc, tâm lý và phát triển nhân vật.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(18,'Gia đình','Phim mang tính giáo dục và giải trí cho các thành viên trong gia đình.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(19,'Thần thoại','Phim dựa trên các câu chuyện thần thoại và truyền thuyết.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(20,'Khoa học viễn tưởng','Thể loại với nội dung về công nghệ, không gian và tương lai.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(21,'Hồi hộp','Phim tạo cảm giác căng thẳng, bí ẩn và đầy bất ngờ.','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL);
/*!40000 ALTER TABLE `ci_genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_movie`
--

DROP TABLE IF EXISTS `ci_movie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_movie` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `genre_id` bigint unsigned NOT NULL,
  `country_id` bigint unsigned NOT NULL,
  `rated_id` bigint unsigned NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trailer_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `performer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `director` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vote_total` bigint unsigned NOT NULL DEFAULT '0',
  `voting` decimal(2,1) DEFAULT '0.0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_movie_genre_id_foreign` (`genre_id`),
  KEY `ci_movie_country_id_foreign` (`country_id`),
  KEY `ci_movie_rated_id_foreign` (`rated_id`),
  CONSTRAINT `ci_movie_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `ci_country` (`id`),
  CONSTRAINT `ci_movie_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `ci_genre` (`id`),
  CONSTRAINT `ci_movie_rated_id_foreign` FOREIGN KEY (`rated_id`) REFERENCES `ci_rated` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_movie`
--

LOCK TABLES `ci_movie` WRITE;
/*!40000 ALTER TABLE `ci_movie` DISABLE KEYS */;
INSERT INTO `ci_movie` VALUES (5,'LINH MIÊU',NULL,1,1,1,'','','https://youtu.be/4oxoPMxBO6s','120','2024-11-22','performer','Lưu Thành Luân','Linh Miêu: Quỷ Nhập Tràng lấy cảm hứng từ truyền thuyết dân gian...',0,NULL,'2024-12-08 10:37:44','2024-12-24 14:42:53',1,'2024-12-24 14:42:53'),(11,'NGÀY XƯA CÓ MỘT CHUYỆN TÌNH',NULL,1,1,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/_/s/_size_chu_n_nxcmct_main-poster_dctr_1_.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/_/s/_size_chu_n_nxcmct_main-poster_dctr_1_.jpg','https://youtu.be/qaeHlk0OXec','120','2024-10-28','performer','Trịnh Đình Lê Minh','Ngày Xưa Có Một Chuyện Tình xoay quanh câu chuyện tình bạn, tình yêu giữa hai chàng trai và một cô gái từ thuở ấu thơ cho đến khi trưởng thành, phải đối mặt với những thử thách của số phận. Trải dài trong 4 giai đoạn từ năm 1987 - 2000, ba người bạn cùng ',0,NULL,'2024-12-08 10:37:44','2024-12-08 10:37:44',1,NULL),(16,'CU LI KHÔNG BAO GIỜ KHÓC',NULL,1,1,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/c/l/clnc-digitalposter-vnmarket-2048_1_.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/c/l/clnc-digitalposter-vnmarket-2048_1_.jpg','https://youtu.be/kMjlJkmt5nk','120','2024-11-15','performer','Phạm Ngọc Lân','Sau đám tang người chồng cũ ở nước ngoài, bà Nguyện quay lại Hà Nội với một bình tro và một con cu li nhỏ - loài linh trưởng đặc hữu của bán đảo Đông Dương. Về tới nơi, bà phát hiện ra cô cháu gái mang bầu đang vội vã chuẩn bị đám cưới. Lo sợ cô đi theo v',0,NULL,'2024-12-08 10:37:44','2024-12-08 10:37:44',1,NULL),(18,'KẺ ĐÓNG THẾ',NULL,1,7,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/k/e/kedongthe_payoff_poster_kc15.11.2024.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/k/e/kedongthe_payoff_poster_kc15.11.2024.jpg','https://youtu.be/O62t0TMdG4I','120','2024-11-15','performer','Lương Quán Nghiêu - Lương Quán Thuấn','Một đạo diễn đóng thế hết thời đang vật lộn để tìm lối đi trong ngành công nghiệp điện ảnh nhiều biến động. Ông đánh cược tất cả để tạo nên màn tái xuất cuối cùng, đồng thời cố gắng hàn gắn mối quan hệ với cô con gái xa cách của mình.',0,NULL,'2024-12-08 10:37:44','2024-12-28 04:11:00',1,'2024-12-28 04:11:00'),(20,'LINH MIÊU',NULL,1,1,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/3/5/350x495-linhmieu.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/3/5/350x495-linhmieu.jpg','https://youtu.be/4oxoPMxBO6s','120','2024-11-22','performer','Lưu Thành Luân','Linh Miêu: Quỷ Nhập Tràng lấy cảm hứng từ truyền thuyết dân gian...',0,NULL,'2024-12-10 14:31:16','2024-12-24 14:52:03',1,'2024-12-24 14:52:03'),(21,'LINH MIÊU',NULL,1,1,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/3/5/350x495-linhmieu.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/3/5/350x495-linhmieu.jpg','https://youtu.be/4oxoPMxBO6s','120','2024-11-22','performer','Lưu Thành Luân','Linh Miêu: Quỷ Nhập Tràng lấy cảm hứng từ truyền thuyết dân gian...',0,0.0,'2024-12-10 14:35:59','2024-12-10 14:35:59',1,NULL),(23,'CƯỜI XUYÊN BIÊN GIỚI',NULL,1,7,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/a/m/amazon-main-poster-printing.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/a/m/amazon-main-poster-printing.jpg','https://youtu.be/4ALt4VT7grw','120','2024-11-15','performer','KIM Chang-ju','Cười Xuyên Biên Giới kể về hành trình của Jin-bong...',0,0.0,'2024-12-10 14:40:11','2024-12-10 14:40:11',1,NULL),(24,'VÕ SĨ GIÁC ĐẤU II',NULL,1,7,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/7/0/700x1000-gladiator.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/7/0/700x1000-gladiator.jpg','https://youtu.be/R4AFSgUGEEs','120','2024-11-15','performer','Ridley Scott','Sau khi đánh mất quê hương vào tay hoàng đế bạo chúa...',0,0.0,'2024-12-10 14:40:11','2024-12-10 14:40:11',1,NULL),(25,'MẬT MÃ ĐỎ',NULL,1,7,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/3/5/350x495-red-one_1.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/3/5/350x495-red-one_1.jpg','https://youtu.be/2T_mKyH17mY','120','2024-11-08','performer','Jake Kasdan','Sau khi Ông già Noel (mật danh=> Red One) bị bắt cóc, Trưởng An ninh Bắc Cực (Dwayne Johnson) phải hợp tác với thợ săn tiền thưởng khét tiếng nhất thế giới (Chris Evans) trong một nhiệm vụ kịch tính xuyên lục địa để giải cứu Giáng Sinh.',1,0.0,'2024-12-10 14:40:11','2024-12-24 06:05:55',1,NULL),(26,'ĐÔI BẠN HỌC YÊU',NULL,1,11,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/l/i/litbc-main-poster-printing.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/l/i/litbc-main-poster-printing.jpg','https://youtu.be/EIARKqcXILM','120','2024-11-08','performer','E.Oni','Bộ phim xoay quanh đôi bạn ngỗ nghịch Jae-hee và Heung-soo cùng những khoảnh khắc “dở khóc dở cười” khi cùng chung sống trong một ngôi nhà. Jae-hee là một cô gái “cờ xanh” với tâm hồn tự do, sống hết mình với tình yêu. Ngược lại, Heung-soo lại là một “cờ ',0,0.0,'2024-12-10 14:40:11','2024-12-10 14:40:11',1,NULL),(27,'NGÀY XƯA CÓ MỘT CHUYỆN TÌNH',NULL,1,1,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/_/s/_size_chu_n_nxcmct_main-poster_dctr_1_.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/_/s/_size_chu_n_nxcmct_main-poster_dctr_1_.jpg','https://youtu.be/qaeHlk0OXec','120','2024-10-28','performer','Trịnh Đình Lê Minh','Ngày Xưa Có Một Chuyện Tình xoay quanh câu chuyện tình bạn, tình yêu giữa hai chàng trai và một cô gái từ thuở ấu thơ cho đến khi trưởng thành, phải đối mặt với những thử thách của số phận. Trải dài trong 4 giai đoạn từ năm 1987 - 2000, ba người bạn cùng ',0,0.0,'2024-12-10 14:40:11','2024-12-10 14:40:11',1,NULL),(28,'VENOM: KÈO CUỐI',NULL,1,13,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/r/s/rsz_vnm3_intl_online_1080x1350_tsr_01.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/r/s/rsz_vnm3_intl_online_1080x1350_tsr_01.jpg','https://youtu.be/id1rfr_KZWg','120','2024-10-25','performer','Kelly Marcel','Đây là phần phim cuối cùng và hoành tráng nhất về cặp đôi Venom và Eddie Brock (Tom Hardy). Sau khi dịch chuyển từ Vũ trụ Marvel trong ‘Spider-man=> No way home’ (2021) trở về thực tại, Eddie Brock giờ đây cùng Venom sẽ phải đối mặt với ác thần Knull hùng',0,0.0,'2024-12-10 14:40:11','2024-12-10 14:40:11',1,NULL),(29,'THẦN DƯỢC',NULL,1,12,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/o/f/official_poster_the_substance.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/o/f/official_poster_the_substance.jpg','https://youtu.be/zBIDSp17AOo','120','2025-01-22','performer','Coralie Fargeat','Elizabeth Sparkle, minh tinh sở hữu vẻ đẹp hút hồn cùng với tài năng được mến mộ nồng nhiệt. Khi đã trải qua thời kỳ đỉnh cao, nhan sắc dần tàn phai, cô tìm đến những kẻ buôn lậu để mua một loại thuốc bí hiểm nhằm \"thay da đổi vận\", tạo ra một phiên bản t',0,0.0,'2024-12-10 14:40:11','2024-12-10 14:40:11',1,NULL),(30,'NGÀY TA ĐÃ YÊU',NULL,1,11,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/p/o/poster_ngay_ta_da_yeu_6.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/p/o/poster_ngay_ta_da_yeu_6.jpg','https://youtu.be/lbLk9PzHWfg','120','2024-11-15','performer','John Crowley','Định mệnh đã đưa một nữ đầu bếp đầy triển vọng và một người đàn ông vừa trải qua hôn nhân đổ vỡ đến với nhau trong tình cảnh đặc biệt. Bộ phim là cuộc tình mười năm sâu đậm của cặp đôi này, từ lúc họ rơi vào lưới tình, xây dựng tổ ấm, cho đến khi một biến',0,0.0,'2024-12-10 14:40:11','2024-12-10 14:40:11',1,NULL),(31,'OZI: PHI VỤ RỪNG XANH',NULL,1,8,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/o/z/ozi_poster_single_470x700.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/o/z/ozi_poster_single_470x700.jpg','https://youtu.be/tyHPFFnDuZY','120','2025-11-15','performer','Tim Harper','Câu chuyện xoay quanh Ozi, một cô đười ươi mồ côi có tầm ảnh hưởng, sử dụng những kỹ năng học được để bảo vệ khu rừng và ngôi nhà của mình khỏi sự tàn phá của nạn phá rừng. Đây là một bộ phim đầy hy vọng, truyền cảm hứng cho thế hệ trẻ mạnh dạn cất tiếng ',0,0.0,'2024-12-10 14:40:11','2024-12-10 14:40:11',1,NULL),(32,'CU LI KHÔNG BAO GIỜ KHÓC',NULL,1,8,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/c/l/clnc-digitalposter-vnmarket-2048_1_.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/c/l/clnc-digitalposter-vnmarket-2048_1_.jpg','https://youtu.be/kMjlJkmt5nk','120','2025-11-15','performer','Phạm Ngọc Lân','Sau đám tang người chồng cũ ở nước ngoài, bà Nguyện quay lại Hà Nội với một bình tro và một con cu li nhỏ - loài linh trưởng đặc hữu của bán đảo Đông Dương. Về tới nơi, bà phát hiện ra cô cháu gái mang bầu đang vội vã chuẩn bị đám cưới. Lo sợ cô đi theo v',0,0.0,'2024-12-10 14:40:11','2024-12-10 14:40:11',1,NULL),(33,'HỒN MA THEO ĐUỔI',NULL,1,9,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/h/o/hon_ma_theo_duoi_-_payoff_poster_-_kc_15.11.2024.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/h/o/hon_ma_theo_duoi_-_payoff_poster_-_kc_15.11.2024.jpg','https://youtu.be/B8aGGueNtiE','120','2025-11-15','performer','Banjong Pisanthanakun, Parkpoom Wongpoom','Nhiếp ảnh gia Tun và bạn gái Jane trong một lần lái xe trên đường đã vô tình gây tai nạn cho một cô gái trẻ rồi bỏ chạy mà không hề quan tâm đến sự sống chết của cô gái đó. Sau vụ tai nạn, Jane mỗi ngày sống trong lo âu, hối hận, còn những tấm ảnh được Tu',0,0.0,'2024-12-10 14:40:11','2024-12-10 14:40:11',1,NULL),(34,'KẺ ĐÓNG THẾ',NULL,1,7,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/k/e/kedongthe_payoff_poster_kc15.11.2024.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/k/e/kedongthe_payoff_poster_kc15.11.2024.jpg','https://youtu.be/O62t0TMdG4I','120','2025-11-15','performer','Lương Quán Nghiêu - Lương Quán Thuấn','Một đạo diễn đóng thế hết thời đang vật lộn để tìm lối đi trong ngành công nghiệp điện ảnh nhiều biến động. Ông đánh cược tất cả để tạo nên màn tái xuất cuối cùng, đồng thời cố gắng hàn gắn mối quan hệ với cô con gái xa cách của mình.',0,0.0,'2024-12-10 14:40:11','2024-12-28 04:17:19',1,NULL),(35,'ĐỪNG BUÔNG TAY',NULL,1,12,1,'https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/3/5/350x495-never-let-go.jpg','https://iguov8nhvyobj.vcdn.cloud/media/catalog/product/cache/1/image/c5f0a1eff4c394a251036189ccddaacd/3/5/350x495-never-let-go.jpg','https://youtu.be/ZlsGSkMIPaU','120','2025-11-15','performer','Alexandre Aja','Một ngôi nhà chứa đầy bùa chú là nơi an toàn cuối cùng để tránh xa lũ quỷ trong thế giới hậu tận thế đáng sợ. Một người mẹ và 2 đứa con nhỏ phải kết nối với ngôi nhà bằng sợi dây thừng linh thiêng để sinh tồn nơi rừng rậm, nơi hai thực thể ác độc Kẻ Xấu v',0,0.0,'2024-12-10 14:40:11','2024-12-10 14:40:11',1,NULL);
/*!40000 ALTER TABLE `ci_movie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_movie_genre`
--

DROP TABLE IF EXISTS `ci_movie_genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_movie_genre` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `movie_id` bigint unsigned NOT NULL,
  `genre_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_movie_genre_movie_id_foreign` (`movie_id`),
  KEY `ci_movie_genre_genre_id_foreign` (`genre_id`),
  CONSTRAINT `ci_movie_genre_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `ci_genre` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ci_movie_genre_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `ci_movie` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_movie_genre`
--

LOCK TABLES `ci_movie_genre` WRITE;
/*!40000 ALTER TABLE `ci_movie_genre` DISABLE KEYS */;
INSERT INTO `ci_movie_genre` VALUES (32,18,1,'2024-12-08 10:37:44','2024-12-28 04:11:00','2024-12-28 04:11:00'),(37,21,12,'2024-12-10 14:35:59','2024-12-10 14:35:59',NULL),(38,23,13,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(39,23,14,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(40,24,16,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(41,24,19,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(42,25,19,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(43,25,20,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(44,25,21,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(45,26,14,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(46,26,13,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(47,27,14,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(48,28,1,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(49,28,16,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(50,28,21,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(51,29,20,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(52,30,14,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(53,30,13,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(54,31,15,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(55,32,13,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(56,33,12,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(57,34,1,'2024-12-10 14:40:11','2024-12-28 04:30:14',NULL),(58,34,17,'2024-12-10 14:40:11','2024-12-28 04:30:14',NULL),(59,35,14,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL),(60,35,15,'2024-12-10 14:40:11','2024-12-10 14:40:11',NULL);
/*!40000 ALTER TABLE `ci_movie_genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_movie_show_time`
--

DROP TABLE IF EXISTS `ci_movie_show_time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_movie_show_time` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `movie_id` bigint unsigned NOT NULL,
  `room_id` bigint unsigned NOT NULL,
  `start_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_movie_show_time_movie_id_foreign` (`movie_id`),
  KEY `ci_movie_show_time_room_id_foreign` (`room_id`),
  CONSTRAINT `ci_movie_show_time_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `ci_movie` (`id`),
  CONSTRAINT `ci_movie_show_time_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `ci_room` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_movie_show_time`
--

LOCK TABLES `ci_movie_show_time` WRITE;
/*!40000 ALTER TABLE `ci_movie_show_time` DISABLE KEYS */;
INSERT INTO `ci_movie_show_time` VALUES (46,18,5,'08:00','10:00','2024-11-28','2024-12-10 14:49:53','2024-12-28 04:11:00','2024-12-28 04:11:00'),(48,30,5,'11:00','13:00','2024-12-01','2024-12-10 14:51:11','2024-12-10 14:51:11',NULL),(49,20,5,'15:30','17:30','2024-11-29','2024-12-10 14:51:11','2024-12-24 14:52:03','2024-12-24 14:52:03'),(50,21,5,'18:00','20:00','2024-11-30','2024-12-10 14:51:11','2024-12-10 14:51:11',NULL),(52,34,6,'08:00','10:00','2024-11-28','2024-12-10 14:51:38','2024-12-28 04:30:14',NULL),(53,23,6,'11:00','13:00','2024-11-29','2024-12-10 14:51:38','2024-12-10 14:51:38',NULL),(54,24,6,'15:30','17:30','2024-11-30','2024-12-10 14:51:38','2024-12-10 14:51:38',NULL),(55,25,6,'18:00','20:00','2024-12-01','2024-12-10 14:51:38','2024-12-10 14:51:38',NULL),(56,34,6,'08:00','10:00','2024-12-02','2024-12-10 14:51:38','2024-12-28 04:30:14',NULL),(57,23,6,'11:00','13:00','2024-12-03','2024-12-10 14:51:38','2024-12-10 14:51:38',NULL),(58,24,6,'15:30','17:30','2024-12-04','2024-12-10 14:51:38','2024-12-10 14:51:38',NULL),(59,25,6,'18:00','20:00','2024-12-05','2024-12-10 14:51:38','2024-12-10 14:51:38',NULL),(60,34,6,'08:00','10:00','2024-12-06','2024-12-10 14:51:38','2024-12-28 04:30:14',NULL),(61,23,6,'11:00','13:00','2024-12-07','2024-12-10 14:51:38','2024-12-10 14:51:38',NULL),(62,24,6,'15:30','17:30','2024-12-08','2024-12-10 14:51:38','2024-12-10 14:51:38',NULL),(63,25,6,'18:00','20:00','2024-12-09','2024-12-10 14:51:38','2024-12-10 14:51:38',NULL),(64,34,6,'08:00','10:00','2024-12-10','2024-12-10 14:51:38','2024-12-28 04:30:14',NULL),(65,23,6,'11:00','13:00','2024-12-11','2024-12-10 14:51:38','2024-12-10 14:51:38',NULL),(66,24,6,'15:30','17:30','2024-12-12','2024-12-10 14:51:38','2024-12-10 14:51:38',NULL),(67,25,6,'18:00','20:00','2024-12-13','2024-12-10 14:51:38','2024-12-10 14:51:38',NULL),(68,34,6,'08:00','10:00','2024-12-14','2024-12-10 14:51:38','2024-12-28 04:30:14',NULL),(69,23,6,'11:00','13:00','2024-12-15','2024-12-10 14:51:38','2024-12-10 14:51:38',NULL),(70,24,6,'15:30','17:30','2024-12-16','2024-12-10 14:51:38','2024-12-10 14:51:38',NULL),(71,25,6,'18:00','20:00','2024-12-17','2024-12-10 14:51:38','2024-12-10 14:51:38',NULL),(72,30,5,'08:00','10:00','2024-12-22','2024-12-25 07:59:09','2024-12-25 08:00:32',NULL),(73,30,5,'08:00','22:00','2024-12-23','2024-12-25 08:27:22','2024-12-25 08:27:22',NULL),(74,30,5,'08:00','22:00','2024-12-24','2024-12-25 08:27:53','2024-12-25 08:27:53',NULL);
/*!40000 ALTER TABLE `ci_movie_show_time` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_profile`
--

DROP TABLE IF EXISTS `ci_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_profile` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_profile_account_id_foreign` (`account_id`),
  CONSTRAINT `ci_profile_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `ci_account` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_profile`
--

LOCK TABLES `ci_profile` WRITE;
/*!40000 ALTER TABLE `ci_profile` DISABLE KEYS */;
INSERT INTO `ci_profile` VALUES (1,4,'Nguyen Van A',NULL,'0123456789',NULL,'2024-11-06 13:52:59','2024-11-06 13:52:59',NULL),(2,5,'Nguyen Van A','18','0123456799','https://res.cloudinary.com/dxlcnw5bz/image/upload/v1734326416/avatar/k6laxvnkh1kmfveu4ym5.jpg','2024-12-08 07:25:14','2024-12-16 05:20:19',NULL),(3,7,'Nguyen Van A','20','0123556789','https://res.cloudinary.com/dxlcnw5bz/image/upload/v1734327551/avatar/myvevgcilaceobpjx2uf.jpg','2024-12-08 18:00:08','2024-12-16 05:39:12',NULL),(4,8,'Nguyen Van B','19','0123456786','https://res.cloudinary.com/dxlcnw5bz/image/upload/v1735739205/avatar/dsjsyjz8icybivhrk8n8.png','2024-12-11 09:40:37','2025-01-01 13:46:48',NULL),(5,9,'Nguyen Van A',NULL,'0123456782',NULL,'2024-12-13 10:41:06','2024-12-13 10:41:06',NULL),(6,10,'Nguyen van B',NULL,'0353495146',NULL,'2024-12-13 11:09:15','2024-12-13 11:09:15',NULL),(7,11,'Nguen Van C',NULL,'0353495144',NULL,'2024-12-13 12:02:13','2024-12-13 12:02:13',NULL),(8,12,'Nguyen Van A',NULL,'0123456780',NULL,'2024-12-16 05:35:28','2024-12-16 05:35:28',NULL);
/*!40000 ALTER TABLE `ci_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_promotion_user`
--

DROP TABLE IF EXISTS `ci_promotion_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_promotion_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `promotion_id` bigint unsigned NOT NULL,
  `account_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_promotion_user_promotion_id_foreign` (`promotion_id`),
  KEY `ci_promotion_user_account_id_foreign` (`account_id`),
  CONSTRAINT `ci_promotion_user_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `ci_account` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ci_promotion_user_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `ci_promotions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_promotion_user`
--

LOCK TABLES `ci_promotion_user` WRITE;
/*!40000 ALTER TABLE `ci_promotion_user` DISABLE KEYS */;
INSERT INTO `ci_promotion_user` VALUES (1,1,9,'2024-12-16 06:53:50','2024-12-16 06:53:50',NULL),(2,1,7,'2024-12-26 17:42:21','2024-12-26 17:42:21',NULL),(3,2,9,'2025-01-02 18:26:08','2025-01-02 18:26:08',NULL);
/*!40000 ALTER TABLE `ci_promotion_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_promotions`
--

DROP TABLE IF EXISTS `ci_promotions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_promotions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `promo_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `discount` int NOT NULL DEFAULT '0',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_promotions`
--

LOCK TABLES `ci_promotions` WRITE;
/*!40000 ALTER TABLE `ci_promotions` DISABLE KEYS */;
INSERT INTO `ci_promotions` VALUES (1,'Đêm giáng sinh - giảm 60K giá vé',NULL,'Giảm 60k/vé – Dành cho tất cả khách hàng đến rạp xem phim',60000,'2024-12-14','2025-01-31',9998,'2024-12-15 07:46:21','2024-12-26 17:42:21',1,NULL),(2,'Giảm giá mừng sinh nhật - giảm 80k giá vé',NULL,'Giảm 80k/vé – Dành cho tất cả khách hàng đến rạp xem phim',80000,'2024-12-14','2025-01-16',999,'2024-12-15 07:47:54','2025-01-02 18:26:08',1,NULL),(3,'Giảm giá bất ngờ - giảm 60k cho mỗi hóa đơn thanh toán',NULL,'Giảm 60k/vé – Dành cho tất cả khách hàng đến rạp xem phim',60000,'2024-12-14','2025-01-16',10000,'2024-12-15 09:40:07','2024-12-15 09:40:07',1,NULL),(4,'Black Friday - Giảm giá 50K cho mỗi hóa đơn',NULL,'Giảm 50k/vé – Dành cho tất cả khách hàng đến rạp xem phim',50000,'2024-12-14','2025-01-16',10000,'2024-12-15 09:41:39','2024-12-15 09:41:39',1,NULL);
/*!40000 ALTER TABLE `ci_promotions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_rated`
--

DROP TABLE IF EXISTS `ci_rated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_rated` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_rated`
--

LOCK TABLES `ci_rated` WRITE;
/*!40000 ALTER TABLE `ci_rated` DISABLE KEYS */;
INSERT INTO `ci_rated` VALUES (1,'18+','T18 - Phim được phổ biến đến người xem từ đủ 18 tuổi trở lên (18+)','2024-11-06 13:55:00','2024-11-06 13:55:00',NULL),(2,'13+','Giới hạn độ tuổi 13 trở lên','2024-12-08 10:27:32','2024-12-08 10:27:32',NULL);
/*!40000 ALTER TABLE `ci_rated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_role`
--

DROP TABLE IF EXISTS `ci_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_role` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_role`
--

LOCK TABLES `ci_role` WRITE;
/*!40000 ALTER TABLE `ci_role` DISABLE KEYS */;
INSERT INTO `ci_role` VALUES (1,'admin','admin',NULL,NULL),(2,'manager','manager',NULL,NULL),(3,'staff','staff',NULL,NULL),(4,'user','user',NULL,NULL);
/*!40000 ALTER TABLE `ci_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_room`
--

DROP TABLE IF EXISTS `ci_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_room` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cinema_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seat_map` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_room_cinema_id_foreign` (`cinema_id`),
  CONSTRAINT `ci_room_cinema_id_foreign` FOREIGN KEY (`cinema_id`) REFERENCES `ci_cinema` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_room`
--

LOCK TABLES `ci_room` WRITE;
/*!40000 ALTER TABLE `ci_room` DISABLE KEYS */;
INSERT INTO `ci_room` VALUES (3,1,'Cinema 1','[[0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1]]','2024-12-08 10:37:44','2024-12-08 10:37:44',NULL),(4,1,'Cinema 2','[[0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1]]','2024-12-08 10:37:45','2024-12-08 10:37:45',NULL),(5,1,'Cinema 3','[[0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1]]','2024-12-10 14:47:18','2024-12-10 14:47:18',NULL),(6,1,'Cinema 4','[[0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1]]','2024-12-10 14:47:18','2024-12-10 14:47:18',NULL),(7,2,'Cinema 1','[[0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1]]','2024-12-28 06:17:23','2024-12-28 06:17:23',NULL),(8,2,'Cinema 2','[[0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1],[1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1]]','2024-12-28 06:17:24','2024-12-28 06:17:24',NULL);
/*!40000 ALTER TABLE `ci_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_seat`
--

DROP TABLE IF EXISTS `ci_seat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_seat` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `room_id` bigint unsigned NOT NULL,
  `seat_type_id` bigint unsigned NOT NULL,
  `seat_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_seat_room_id_foreign` (`room_id`),
  KEY `ci_seat_seat_type_id_foreign` (`seat_type_id`),
  CONSTRAINT `ci_seat_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `ci_room` (`id`),
  CONSTRAINT `ci_seat_seat_type_id_foreign` FOREIGN KEY (`seat_type_id`) REFERENCES `ci_seat_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=730 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_seat`
--

LOCK TABLES `ci_seat` WRITE;
/*!40000 ALTER TABLE `ci_seat` DISABLE KEYS */;
INSERT INTO `ci_seat` VALUES (10,3,2,'A1','2024-12-08 10:37:44','2024-12-08 10:37:44'),(11,3,2,'A2','2024-12-08 10:37:44','2024-12-08 10:37:44'),(12,3,2,'A3','2024-12-08 10:37:44','2024-12-08 10:37:44'),(13,3,2,'A4','2024-12-08 10:37:44','2024-12-08 10:37:44'),(14,3,2,'A5','2024-12-08 10:37:44','2024-12-08 10:37:44'),(15,3,2,'A6','2024-12-08 10:37:44','2024-12-08 10:37:44'),(16,3,2,'B1','2024-12-08 10:37:44','2024-12-08 10:37:44'),(17,3,2,'B2','2024-12-08 10:37:44','2024-12-08 10:37:44'),(18,3,2,'B3','2024-12-08 10:37:44','2024-12-08 10:37:44'),(19,3,2,'B4','2024-12-08 10:37:44','2024-12-08 10:37:44'),(20,3,2,'B6','2024-12-08 10:37:44','2024-12-08 10:37:44'),(21,3,2,'B7','2024-12-08 10:37:44','2024-12-08 10:37:44'),(22,3,2,'B8','2024-12-08 10:37:44','2024-12-08 10:37:44'),(23,3,2,'B9','2024-12-08 10:37:44','2024-12-08 10:37:44'),(24,3,2,'B11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(25,3,2,'B12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(26,3,2,'B13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(27,3,2,'B14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(28,3,2,'C1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(29,3,2,'C2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(30,3,2,'C3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(31,3,2,'C4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(32,3,2,'C6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(33,3,2,'C7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(34,3,2,'C8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(35,3,2,'C9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(36,3,2,'C11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(37,3,2,'C12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(38,3,2,'C13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(39,3,2,'C14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(40,3,1,'D1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(41,3,1,'D2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(42,3,1,'D3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(43,3,2,'D4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(44,3,2,'D6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(45,3,2,'D7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(46,3,2,'D8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(47,3,2,'D9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(48,3,2,'D11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(49,3,2,'D12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(50,3,1,'D13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(51,3,1,'D14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(52,3,1,'E1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(53,3,1,'E2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(54,3,1,'E3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(55,3,2,'E4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(56,3,2,'E6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(57,3,2,'E7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(58,3,2,'E8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(59,3,2,'E9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(60,3,2,'E11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(61,3,2,'E12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(62,3,1,'E13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(63,3,1,'E14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(64,3,1,'E15','2024-12-08 10:37:45','2024-12-08 10:37:45'),(65,3,1,'F1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(66,3,1,'F2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(67,3,1,'F3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(68,3,2,'F4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(69,3,2,'F6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(70,3,2,'F7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(71,3,2,'F8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(72,3,2,'F9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(73,3,2,'F11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(74,3,2,'F12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(75,3,1,'F13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(76,3,1,'F14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(77,3,1,'F15','2024-12-08 10:37:45','2024-12-08 10:37:45'),(78,3,1,'G1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(79,3,1,'G2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(80,3,1,'G3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(81,3,2,'G4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(82,3,2,'G6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(83,3,2,'G7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(84,3,2,'G8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(85,3,2,'G9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(86,3,2,'G11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(87,3,2,'G12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(88,3,1,'G13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(89,3,1,'G14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(90,3,1,'G15','2024-12-08 10:37:45','2024-12-08 10:37:45'),(91,3,1,'H1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(92,3,1,'H2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(93,3,1,'H3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(94,3,2,'H4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(95,3,2,'H6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(96,3,2,'H7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(97,3,2,'H8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(98,3,2,'H9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(99,3,2,'H11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(100,3,2,'H12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(101,3,1,'H13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(102,3,1,'H14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(103,3,1,'H15','2024-12-08 10:37:45','2024-12-08 10:37:45'),(104,3,1,'I1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(105,3,1,'I2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(106,3,1,'I3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(107,3,2,'I4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(108,3,2,'I6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(109,3,2,'I7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(110,3,2,'I8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(111,3,2,'I9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(112,3,2,'I11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(113,3,2,'I12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(114,3,1,'I13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(115,3,1,'I14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(116,3,1,'I15','2024-12-08 10:37:45','2024-12-08 10:37:45'),(117,3,2,'J1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(118,3,2,'J2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(119,3,2,'J3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(120,3,2,'J4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(121,3,2,'J6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(122,3,2,'J7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(123,3,2,'J8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(124,3,2,'J9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(125,3,2,'J11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(126,3,2,'J12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(127,3,2,'J13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(128,3,2,'J14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(129,3,2,'J15','2024-12-08 10:37:45','2024-12-08 10:37:45'),(130,4,2,'A2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(131,4,2,'A3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(132,4,2,'A7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(133,4,2,'A8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(134,4,2,'A12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(135,4,2,'A13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(136,4,2,'B1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(137,4,2,'B2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(138,4,2,'B3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(139,4,2,'B4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(140,4,2,'B6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(141,4,2,'B7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(142,4,2,'B8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(143,4,2,'B9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(144,4,2,'B11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(145,4,2,'B12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(146,4,2,'B13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(147,4,2,'B14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(148,4,2,'C1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(149,4,2,'C2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(150,4,2,'C3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(151,4,2,'C4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(152,4,2,'C6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(153,4,2,'C7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(154,4,2,'C8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(155,4,2,'C9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(156,4,2,'C11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(157,4,2,'C12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(158,4,2,'C13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(159,4,2,'C14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(160,4,1,'D1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(161,4,1,'D2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(162,4,1,'D3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(163,4,2,'D4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(164,4,2,'D6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(165,4,2,'D7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(166,4,2,'D8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(167,4,2,'D9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(168,4,2,'D11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(169,4,2,'D12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(170,4,1,'D13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(171,4,1,'D14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(172,4,1,'E1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(173,4,1,'E2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(174,4,1,'E3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(175,4,2,'E4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(176,4,2,'E6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(177,4,2,'E7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(178,4,2,'E8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(179,4,2,'E9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(180,4,2,'E11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(181,4,2,'E12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(182,4,1,'E13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(183,4,1,'E14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(184,4,1,'E15','2024-12-08 10:37:45','2024-12-08 10:37:45'),(185,4,1,'F1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(186,4,1,'F2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(187,4,1,'F3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(188,4,2,'F4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(189,4,2,'F6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(190,4,2,'F7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(191,4,2,'F8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(192,4,2,'F9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(193,4,2,'F11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(194,4,2,'F12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(195,4,1,'F13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(196,4,1,'F14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(197,4,1,'F15','2024-12-08 10:37:45','2024-12-08 10:37:45'),(198,4,1,'G1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(199,4,1,'G2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(200,4,1,'G3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(201,4,2,'G4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(202,4,2,'G6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(203,4,2,'G7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(204,4,2,'G8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(205,4,2,'G9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(206,4,2,'G11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(207,4,2,'G12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(208,4,1,'G13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(209,4,1,'G14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(210,4,1,'G15','2024-12-08 10:37:45','2024-12-08 10:37:45'),(211,4,1,'H1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(212,4,1,'H2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(213,4,1,'H3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(214,4,2,'H4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(215,4,2,'H6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(216,4,2,'H7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(217,4,2,'H8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(218,4,2,'H9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(219,4,2,'H11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(220,4,2,'H12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(221,4,1,'H13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(222,4,1,'H14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(223,4,1,'H15','2024-12-08 10:37:45','2024-12-08 10:37:45'),(224,4,1,'I1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(225,4,1,'I2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(226,4,1,'I3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(227,4,2,'I4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(228,4,2,'I6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(229,4,2,'I7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(230,4,2,'I8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(231,4,2,'I9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(232,4,2,'I11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(233,4,2,'I12','2024-12-08 10:37:45','2024-12-08 10:37:45'),(234,4,1,'I13','2024-12-08 10:37:45','2024-12-08 10:37:45'),(235,4,1,'I14','2024-12-08 10:37:45','2024-12-08 10:37:45'),(236,4,1,'I15','2024-12-08 10:37:45','2024-12-08 10:37:45'),(237,4,2,'J1','2024-12-08 10:37:45','2024-12-08 10:37:45'),(238,4,2,'J2','2024-12-08 10:37:45','2024-12-08 10:37:45'),(239,4,2,'J3','2024-12-08 10:37:45','2024-12-08 10:37:45'),(240,4,2,'J4','2024-12-08 10:37:45','2024-12-08 10:37:45'),(241,4,2,'J6','2024-12-08 10:37:45','2024-12-08 10:37:45'),(242,4,2,'J7','2024-12-08 10:37:45','2024-12-08 10:37:45'),(243,4,2,'J8','2024-12-08 10:37:45','2024-12-08 10:37:45'),(244,4,2,'J9','2024-12-08 10:37:45','2024-12-08 10:37:45'),(245,4,2,'J11','2024-12-08 10:37:45','2024-12-08 10:37:45'),(246,4,2,'J12','2024-12-08 10:37:46','2024-12-08 10:37:46'),(247,4,2,'J13','2024-12-08 10:37:46','2024-12-08 10:37:46'),(248,4,2,'J14','2024-12-08 10:37:46','2024-12-08 10:37:46'),(249,4,2,'J15','2024-12-08 10:37:46','2024-12-08 10:37:46'),(250,5,2,'A2','2024-12-10 14:47:18','2024-12-10 14:47:18'),(251,5,2,'A3','2024-12-10 14:47:18','2024-12-10 14:47:18'),(252,5,2,'A4','2024-12-10 14:47:18','2024-12-10 14:47:18'),(253,5,2,'A5','2024-12-10 14:47:18','2024-12-10 14:47:18'),(254,5,2,'A6','2024-12-10 14:47:18','2024-12-10 14:47:18'),(255,5,2,'A7','2024-12-10 14:47:18','2024-12-10 14:47:18'),(256,5,2,'B2','2024-12-10 14:47:18','2024-12-10 14:47:18'),(257,5,2,'B3','2024-12-10 14:47:18','2024-12-10 14:47:18'),(258,5,2,'B4','2024-12-10 14:47:18','2024-12-10 14:47:18'),(259,5,2,'B5','2024-12-10 14:47:18','2024-12-10 14:47:18'),(260,5,2,'B6','2024-12-10 14:47:18','2024-12-10 14:47:18'),(261,5,2,'B7','2024-12-10 14:47:18','2024-12-10 14:47:18'),(262,5,2,'B8','2024-12-10 14:47:18','2024-12-10 14:47:18'),(263,5,2,'B9','2024-12-10 14:47:18','2024-12-10 14:47:18'),(264,5,2,'B10','2024-12-10 14:47:18','2024-12-10 14:47:18'),(265,5,2,'B11','2024-12-10 14:47:18','2024-12-10 14:47:18'),(266,5,2,'B12','2024-12-10 14:47:18','2024-12-10 14:47:18'),(267,5,2,'B13','2024-12-10 14:47:18','2024-12-10 14:47:18'),(268,5,2,'C2','2024-12-10 14:47:18','2024-12-10 14:47:18'),(269,5,2,'C3','2024-12-10 14:47:18','2024-12-10 14:47:18'),(270,5,2,'C4','2024-12-10 14:47:18','2024-12-10 14:47:18'),(271,5,2,'C5','2024-12-10 14:47:18','2024-12-10 14:47:18'),(272,5,2,'C6','2024-12-10 14:47:18','2024-12-10 14:47:18'),(273,5,2,'C7','2024-12-10 14:47:18','2024-12-10 14:47:18'),(274,5,2,'C8','2024-12-10 14:47:18','2024-12-10 14:47:18'),(275,5,2,'C9','2024-12-10 14:47:18','2024-12-10 14:47:18'),(276,5,2,'C10','2024-12-10 14:47:18','2024-12-10 14:47:18'),(277,5,2,'C11','2024-12-10 14:47:18','2024-12-10 14:47:18'),(278,5,2,'C12','2024-12-10 14:47:18','2024-12-10 14:47:18'),(279,5,2,'C13','2024-12-10 14:47:18','2024-12-10 14:47:18'),(280,5,1,'D1','2024-12-10 14:47:18','2024-12-10 14:47:18'),(281,5,1,'D2','2024-12-10 14:47:18','2024-12-10 14:47:18'),(282,5,1,'D3','2024-12-10 14:47:18','2024-12-10 14:47:18'),(283,5,2,'D4','2024-12-10 14:47:18','2024-12-10 14:47:18'),(284,5,2,'D6','2024-12-10 14:47:18','2024-12-10 14:47:18'),(285,5,2,'D7','2024-12-10 14:47:18','2024-12-10 14:47:18'),(286,5,2,'D8','2024-12-10 14:47:18','2024-12-10 14:47:18'),(287,5,2,'D9','2024-12-10 14:47:18','2024-12-10 14:47:18'),(288,5,2,'D11','2024-12-10 14:47:18','2024-12-10 14:47:18'),(289,5,2,'D12','2024-12-10 14:47:18','2024-12-10 14:47:18'),(290,5,1,'D13','2024-12-10 14:47:18','2024-12-10 14:47:18'),(291,5,1,'D14','2024-12-10 14:47:18','2024-12-10 14:47:18'),(292,5,1,'E1','2024-12-10 14:47:18','2024-12-10 14:47:18'),(293,5,1,'E2','2024-12-10 14:47:18','2024-12-10 14:47:18'),(294,5,1,'E3','2024-12-10 14:47:18','2024-12-10 14:47:18'),(295,5,2,'E4','2024-12-10 14:47:18','2024-12-10 14:47:18'),(296,5,2,'E6','2024-12-10 14:47:18','2024-12-10 14:47:18'),(297,5,2,'E7','2024-12-10 14:47:18','2024-12-10 14:47:18'),(298,5,2,'E8','2024-12-10 14:47:18','2024-12-10 14:47:18'),(299,5,2,'E9','2024-12-10 14:47:18','2024-12-10 14:47:18'),(300,5,2,'E11','2024-12-10 14:47:18','2024-12-10 14:47:18'),(301,5,2,'E12','2024-12-10 14:47:18','2024-12-10 14:47:18'),(302,5,1,'E13','2024-12-10 14:47:18','2024-12-10 14:47:18'),(303,5,1,'E14','2024-12-10 14:47:18','2024-12-10 14:47:18'),(304,5,1,'E15','2024-12-10 14:47:18','2024-12-10 14:47:18'),(305,5,1,'F1','2024-12-10 14:47:18','2024-12-10 14:47:18'),(306,5,1,'F2','2024-12-10 14:47:18','2024-12-10 14:47:18'),(307,5,1,'F3','2024-12-10 14:47:18','2024-12-10 14:47:18'),(308,5,2,'F4','2024-12-10 14:47:18','2024-12-10 14:47:18'),(309,5,2,'F6','2024-12-10 14:47:18','2024-12-10 14:47:18'),(310,5,2,'F7','2024-12-10 14:47:18','2024-12-10 14:47:18'),(311,5,2,'F8','2024-12-10 14:47:18','2024-12-10 14:47:18'),(312,5,2,'F9','2024-12-10 14:47:18','2024-12-10 14:47:18'),(313,5,2,'F11','2024-12-10 14:47:18','2024-12-10 14:47:18'),(314,5,2,'F12','2024-12-10 14:47:18','2024-12-10 14:47:18'),(315,5,1,'F13','2024-12-10 14:47:18','2024-12-10 14:47:18'),(316,5,1,'F14','2024-12-10 14:47:18','2024-12-10 14:47:18'),(317,5,1,'F15','2024-12-10 14:47:18','2024-12-10 14:47:18'),(318,5,1,'G1','2024-12-10 14:47:18','2024-12-10 14:47:18'),(319,5,1,'G2','2024-12-10 14:47:18','2024-12-10 14:47:18'),(320,5,1,'G3','2024-12-10 14:47:18','2024-12-10 14:47:18'),(321,5,2,'G4','2024-12-10 14:47:18','2024-12-10 14:47:18'),(322,5,2,'G6','2024-12-10 14:47:18','2024-12-10 14:47:18'),(323,5,2,'G7','2024-12-10 14:47:18','2024-12-10 14:47:18'),(324,5,2,'G8','2024-12-10 14:47:18','2024-12-10 14:47:18'),(325,5,2,'G9','2024-12-10 14:47:18','2024-12-10 14:47:18'),(326,5,2,'G11','2024-12-10 14:47:18','2024-12-10 14:47:18'),(327,5,2,'G12','2024-12-10 14:47:18','2024-12-10 14:47:18'),(328,5,1,'G13','2024-12-10 14:47:18','2024-12-10 14:47:18'),(329,5,1,'G14','2024-12-10 14:47:18','2024-12-10 14:47:18'),(330,5,1,'G15','2024-12-10 14:47:18','2024-12-10 14:47:18'),(331,5,1,'H1','2024-12-10 14:47:18','2024-12-10 14:47:18'),(332,5,1,'H2','2024-12-10 14:47:18','2024-12-10 14:47:18'),(333,5,1,'H3','2024-12-10 14:47:18','2024-12-10 14:47:18'),(334,5,2,'H4','2024-12-10 14:47:18','2024-12-10 14:47:18'),(335,5,2,'H6','2024-12-10 14:47:18','2024-12-10 14:47:18'),(336,5,2,'H7','2024-12-10 14:47:18','2024-12-10 14:47:18'),(337,5,2,'H8','2024-12-10 14:47:18','2024-12-10 14:47:18'),(338,5,2,'H9','2024-12-10 14:47:18','2024-12-10 14:47:18'),(339,5,2,'H11','2024-12-10 14:47:18','2024-12-10 14:47:18'),(340,5,2,'H12','2024-12-10 14:47:18','2024-12-10 14:47:18'),(341,5,1,'H13','2024-12-10 14:47:18','2024-12-10 14:47:18'),(342,5,1,'H14','2024-12-10 14:47:18','2024-12-10 14:47:18'),(343,5,1,'H15','2024-12-10 14:47:18','2024-12-10 14:47:18'),(344,5,1,'I1','2024-12-10 14:47:18','2024-12-10 14:47:18'),(345,5,1,'I2','2024-12-10 14:47:18','2024-12-10 14:47:18'),(346,5,1,'I3','2024-12-10 14:47:18','2024-12-10 14:47:18'),(347,5,2,'I4','2024-12-10 14:47:18','2024-12-10 14:47:18'),(348,5,2,'I6','2024-12-10 14:47:18','2024-12-10 14:47:18'),(349,5,2,'I7','2024-12-10 14:47:18','2024-12-10 14:47:18'),(350,5,2,'I8','2024-12-10 14:47:18','2024-12-10 14:47:18'),(351,5,2,'I9','2024-12-10 14:47:18','2024-12-10 14:47:18'),(352,5,2,'I11','2024-12-10 14:47:18','2024-12-10 14:47:18'),(353,5,2,'I12','2024-12-10 14:47:18','2024-12-10 14:47:18'),(354,5,1,'I13','2024-12-10 14:47:18','2024-12-10 14:47:18'),(355,5,1,'I14','2024-12-10 14:47:18','2024-12-10 14:47:18'),(356,5,1,'I15','2024-12-10 14:47:18','2024-12-10 14:47:18'),(357,5,2,'J2','2024-12-10 14:47:18','2024-12-10 14:47:18'),(358,5,2,'J3','2024-12-10 14:47:18','2024-12-10 14:47:18'),(359,5,2,'J4','2024-12-10 14:47:18','2024-12-10 14:47:18'),(360,5,2,'J5','2024-12-10 14:47:18','2024-12-10 14:47:18'),(361,5,2,'J6','2024-12-10 14:47:18','2024-12-10 14:47:18'),(362,5,2,'J7','2024-12-10 14:47:18','2024-12-10 14:47:18'),(363,5,2,'J8','2024-12-10 14:47:18','2024-12-10 14:47:18'),(364,5,2,'J9','2024-12-10 14:47:18','2024-12-10 14:47:18'),(365,5,2,'J10','2024-12-10 14:47:18','2024-12-10 14:47:18'),(366,5,2,'J11','2024-12-10 14:47:18','2024-12-10 14:47:18'),(367,5,2,'J12','2024-12-10 14:47:18','2024-12-10 14:47:18'),(368,5,2,'J13','2024-12-10 14:47:18','2024-12-10 14:47:18'),(369,5,2,'J14','2024-12-10 14:47:18','2024-12-10 14:47:18'),(370,6,2,'A2','2024-12-10 14:47:18','2024-12-10 14:47:18'),(371,6,2,'A3','2024-12-10 14:47:18','2024-12-10 14:47:18'),(372,6,2,'A4','2024-12-10 14:47:18','2024-12-10 14:47:18'),(373,6,2,'A5','2024-12-10 14:47:18','2024-12-10 14:47:18'),(374,6,2,'A6','2024-12-10 14:47:18','2024-12-10 14:47:18'),(375,6,2,'A7','2024-12-10 14:47:18','2024-12-10 14:47:18'),(376,6,2,'B2','2024-12-10 14:47:18','2024-12-10 14:47:18'),(377,6,2,'B3','2024-12-10 14:47:18','2024-12-10 14:47:18'),(378,6,2,'B4','2024-12-10 14:47:18','2024-12-10 14:47:18'),(379,6,2,'B5','2024-12-10 14:47:18','2024-12-10 14:47:18'),(380,6,2,'B6','2024-12-10 14:47:18','2024-12-10 14:47:18'),(381,6,2,'B7','2024-12-10 14:47:18','2024-12-10 14:47:18'),(382,6,2,'B8','2024-12-10 14:47:18','2024-12-10 14:47:18'),(383,6,2,'B9','2024-12-10 14:47:18','2024-12-10 14:47:18'),(384,6,2,'B10','2024-12-10 14:47:18','2024-12-10 14:47:18'),(385,6,2,'B11','2024-12-10 14:47:18','2024-12-10 14:47:18'),(386,6,2,'B12','2024-12-10 14:47:18','2024-12-10 14:47:18'),(387,6,2,'B13','2024-12-10 14:47:18','2024-12-10 14:47:18'),(388,6,2,'C2','2024-12-10 14:47:18','2024-12-10 14:47:18'),(389,6,2,'C3','2024-12-10 14:47:18','2024-12-10 14:47:18'),(390,6,2,'C4','2024-12-10 14:47:18','2024-12-10 14:47:18'),(391,6,2,'C5','2024-12-10 14:47:18','2024-12-10 14:47:18'),(392,6,2,'C6','2024-12-10 14:47:18','2024-12-10 14:47:18'),(393,6,2,'C7','2024-12-10 14:47:18','2024-12-10 14:47:18'),(394,6,2,'C8','2024-12-10 14:47:18','2024-12-10 14:47:18'),(395,6,2,'C9','2024-12-10 14:47:18','2024-12-10 14:47:18'),(396,6,2,'C10','2024-12-10 14:47:18','2024-12-10 14:47:18'),(397,6,2,'C11','2024-12-10 14:47:18','2024-12-10 14:47:18'),(398,6,2,'C12','2024-12-10 14:47:18','2024-12-10 14:47:18'),(399,6,2,'C13','2024-12-10 14:47:18','2024-12-10 14:47:18'),(400,6,1,'D2','2024-12-10 14:47:18','2024-12-10 14:47:18'),(401,6,1,'D3','2024-12-10 14:47:18','2024-12-10 14:47:18'),(402,6,1,'D4','2024-12-10 14:47:18','2024-12-10 14:47:18'),(403,6,2,'D4','2024-12-10 14:47:18','2024-12-10 14:47:18'),(404,6,2,'D6','2024-12-10 14:47:18','2024-12-10 14:47:18'),(405,6,2,'D7','2024-12-10 14:47:18','2024-12-10 14:47:18'),(406,6,2,'D8','2024-12-10 14:47:18','2024-12-10 14:47:18'),(407,6,2,'D9','2024-12-10 14:47:18','2024-12-10 14:47:18'),(408,6,2,'D11','2024-12-10 14:47:18','2024-12-10 14:47:18'),(409,6,2,'D12','2024-12-10 14:47:18','2024-12-10 14:47:18'),(410,6,1,'D12','2024-12-10 14:47:18','2024-12-10 14:47:18'),(411,6,1,'D13','2024-12-10 14:47:18','2024-12-10 14:47:18'),(412,6,1,'E2','2024-12-10 14:47:18','2024-12-10 14:47:18'),(413,6,1,'E3','2024-12-10 14:47:19','2024-12-10 14:47:19'),(414,6,1,'E4','2024-12-10 14:47:19','2024-12-10 14:47:19'),(415,6,2,'E4','2024-12-10 14:47:19','2024-12-10 14:47:19'),(416,6,2,'E6','2024-12-10 14:47:19','2024-12-10 14:47:19'),(417,6,2,'E7','2024-12-10 14:47:19','2024-12-10 14:47:19'),(418,6,2,'E8','2024-12-10 14:47:19','2024-12-10 14:47:19'),(419,6,2,'E9','2024-12-10 14:47:19','2024-12-10 14:47:19'),(420,6,2,'E11','2024-12-10 14:47:19','2024-12-10 14:47:19'),(421,6,2,'E12','2024-12-10 14:47:19','2024-12-10 14:47:19'),(422,6,1,'E12','2024-12-10 14:47:19','2024-12-10 14:47:19'),(423,6,1,'E13','2024-12-10 14:47:19','2024-12-10 14:47:19'),(424,6,1,'E14','2024-12-10 14:47:19','2024-12-10 14:47:19'),(425,6,1,'F2','2024-12-10 14:47:19','2024-12-10 14:47:19'),(426,6,1,'F3','2024-12-10 14:47:19','2024-12-10 14:47:19'),(427,6,1,'F4','2024-12-10 14:47:19','2024-12-10 14:47:19'),(428,6,2,'F4','2024-12-10 14:47:19','2024-12-10 14:47:19'),(429,6,2,'F6','2024-12-10 14:47:19','2024-12-10 14:47:19'),(430,6,2,'F7','2024-12-10 14:47:19','2024-12-10 14:47:19'),(431,6,2,'F8','2024-12-10 14:47:19','2024-12-10 14:47:19'),(432,6,2,'F9','2024-12-10 14:47:19','2024-12-10 14:47:19'),(433,6,2,'F11','2024-12-10 14:47:19','2024-12-10 14:47:19'),(434,6,2,'F12','2024-12-10 14:47:19','2024-12-10 14:47:19'),(435,6,1,'F12','2024-12-10 14:47:19','2024-12-10 14:47:19'),(436,6,1,'F13','2024-12-10 14:47:19','2024-12-10 14:47:19'),(437,6,1,'F14','2024-12-10 14:47:19','2024-12-10 14:47:19'),(438,6,1,'G2','2024-12-10 14:47:19','2024-12-10 14:47:19'),(439,6,1,'G3','2024-12-10 14:47:19','2024-12-10 14:47:19'),(440,6,1,'G4','2024-12-10 14:47:19','2024-12-10 14:47:19'),(441,6,2,'G4','2024-12-10 14:47:19','2024-12-10 14:47:19'),(442,6,2,'G6','2024-12-10 14:47:19','2024-12-10 14:47:19'),(443,6,2,'G7','2024-12-10 14:47:19','2024-12-10 14:47:19'),(444,6,2,'G8','2024-12-10 14:47:19','2024-12-10 14:47:19'),(445,6,2,'G9','2024-12-10 14:47:19','2024-12-10 14:47:19'),(446,6,2,'G11','2024-12-10 14:47:19','2024-12-10 14:47:19'),(447,6,2,'G12','2024-12-10 14:47:19','2024-12-10 14:47:19'),(448,6,1,'G12','2024-12-10 14:47:19','2024-12-10 14:47:19'),(449,6,1,'G13','2024-12-10 14:47:19','2024-12-10 14:47:19'),(450,6,1,'G14','2024-12-10 14:47:19','2024-12-10 14:47:19'),(451,6,1,'H2','2024-12-10 14:47:19','2024-12-10 14:47:19'),(452,6,1,'H3','2024-12-10 14:47:19','2024-12-10 14:47:19'),(453,6,1,'H4','2024-12-10 14:47:19','2024-12-10 14:47:19'),(454,6,2,'H4','2024-12-10 14:47:19','2024-12-10 14:47:19'),(455,6,2,'H6','2024-12-10 14:47:19','2024-12-10 14:47:19'),(456,6,2,'H7','2024-12-10 14:47:19','2024-12-10 14:47:19'),(457,6,2,'H8','2024-12-10 14:47:19','2024-12-10 14:47:19'),(458,6,2,'H9','2024-12-10 14:47:19','2024-12-10 14:47:19'),(459,6,2,'H11','2024-12-10 14:47:19','2024-12-10 14:47:19'),(460,6,2,'H12','2024-12-10 14:47:19','2024-12-10 14:47:19'),(461,6,1,'H12','2024-12-10 14:47:19','2024-12-10 14:47:19'),(462,6,1,'H13','2024-12-10 14:47:19','2024-12-10 14:47:19'),(463,6,1,'H14','2024-12-10 14:47:19','2024-12-10 14:47:19'),(464,6,1,'I2','2024-12-10 14:47:19','2024-12-10 14:47:19'),(465,6,1,'I3','2024-12-10 14:47:19','2024-12-10 14:47:19'),(466,6,1,'I4','2024-12-10 14:47:19','2024-12-10 14:47:19'),(467,6,2,'I4','2024-12-10 14:47:19','2024-12-10 14:47:19'),(468,6,2,'I6','2024-12-10 14:47:19','2024-12-10 14:47:19'),(469,6,2,'I7','2024-12-10 14:47:19','2024-12-10 14:47:19'),(470,6,2,'I8','2024-12-10 14:47:19','2024-12-10 14:47:19'),(471,6,2,'I9','2024-12-10 14:47:19','2024-12-10 14:47:19'),(472,6,2,'I11','2024-12-10 14:47:19','2024-12-10 14:47:19'),(473,6,2,'I12','2024-12-10 14:47:19','2024-12-10 14:47:19'),(474,6,1,'I12','2024-12-10 14:47:19','2024-12-10 14:47:19'),(475,6,1,'I13','2024-12-10 14:47:19','2024-12-10 14:47:19'),(476,6,1,'I14','2024-12-10 14:47:19','2024-12-10 14:47:19'),(477,6,2,'J2','2024-12-10 14:47:19','2024-12-10 14:47:19'),(478,6,2,'J3','2024-12-10 14:47:19','2024-12-10 14:47:19'),(479,6,2,'J4','2024-12-10 14:47:19','2024-12-10 14:47:19'),(480,6,2,'J5','2024-12-10 14:47:19','2024-12-10 14:47:19'),(481,6,2,'J6','2024-12-10 14:47:19','2024-12-10 14:47:19'),(482,6,2,'J7','2024-12-10 14:47:19','2024-12-10 14:47:19'),(483,6,2,'J8','2024-12-10 14:47:19','2024-12-10 14:47:19'),(484,6,2,'J9','2024-12-10 14:47:19','2024-12-10 14:47:19'),(485,6,2,'J10','2024-12-10 14:47:19','2024-12-10 14:47:19'),(486,6,2,'J11','2024-12-10 14:47:19','2024-12-10 14:47:19'),(487,6,2,'J12','2024-12-10 14:47:19','2024-12-10 14:47:19'),(488,6,2,'J13','2024-12-10 14:47:19','2024-12-10 14:47:19'),(489,6,2,'J14','2024-12-10 14:47:19','2024-12-10 14:47:19'),(490,7,2,'A2','2024-12-28 06:17:23','2024-12-28 06:17:23'),(491,7,2,'A3','2024-12-28 06:17:23','2024-12-28 06:17:23'),(492,7,2,'A4','2024-12-28 06:17:23','2024-12-28 06:17:23'),(493,7,2,'A5','2024-12-28 06:17:23','2024-12-28 06:17:23'),(494,7,2,'A6','2024-12-28 06:17:23','2024-12-28 06:17:23'),(495,7,2,'A7','2024-12-28 06:17:23','2024-12-28 06:17:23'),(496,7,2,'B2','2024-12-28 06:17:23','2024-12-28 06:17:23'),(497,7,2,'B3','2024-12-28 06:17:23','2024-12-28 06:17:23'),(498,7,2,'B4','2024-12-28 06:17:23','2024-12-28 06:17:23'),(499,7,2,'B5','2024-12-28 06:17:23','2024-12-28 06:17:23'),(500,7,2,'B6','2024-12-28 06:17:23','2024-12-28 06:17:23'),(501,7,2,'B7','2024-12-28 06:17:23','2024-12-28 06:17:23'),(502,7,2,'B8','2024-12-28 06:17:23','2024-12-28 06:17:23'),(503,7,2,'B9','2024-12-28 06:17:23','2024-12-28 06:17:23'),(504,7,2,'B10','2024-12-28 06:17:23','2024-12-28 06:17:23'),(505,7,2,'B11','2024-12-28 06:17:23','2024-12-28 06:17:23'),(506,7,2,'B12','2024-12-28 06:17:23','2024-12-28 06:17:23'),(507,7,2,'B13','2024-12-28 06:17:23','2024-12-28 06:17:23'),(508,7,2,'C2','2024-12-28 06:17:23','2024-12-28 06:17:23'),(509,7,2,'C3','2024-12-28 06:17:23','2024-12-28 06:17:23'),(510,7,2,'C4','2024-12-28 06:17:23','2024-12-28 06:17:23'),(511,7,2,'C5','2024-12-28 06:17:23','2024-12-28 06:17:23'),(512,7,2,'C6','2024-12-28 06:17:23','2024-12-28 06:17:23'),(513,7,2,'C7','2024-12-28 06:17:23','2024-12-28 06:17:23'),(514,7,2,'C8','2024-12-28 06:17:23','2024-12-28 06:17:23'),(515,7,2,'C9','2024-12-28 06:17:23','2024-12-28 06:17:23'),(516,7,2,'C10','2024-12-28 06:17:23','2024-12-28 06:17:23'),(517,7,2,'C11','2024-12-28 06:17:23','2024-12-28 06:17:23'),(518,7,2,'C12','2024-12-28 06:17:23','2024-12-28 06:17:23'),(519,7,2,'C13','2024-12-28 06:17:23','2024-12-28 06:17:23'),(520,7,1,'D1','2024-12-28 06:17:23','2024-12-28 06:17:23'),(521,7,1,'D2','2024-12-28 06:17:23','2024-12-28 06:17:23'),(522,7,1,'D3','2024-12-28 06:17:23','2024-12-28 06:17:23'),(523,7,2,'D4','2024-12-28 06:17:23','2024-12-28 06:17:23'),(524,7,2,'D6','2024-12-28 06:17:23','2024-12-28 06:17:23'),(525,7,2,'D7','2024-12-28 06:17:23','2024-12-28 06:17:23'),(526,7,2,'D8','2024-12-28 06:17:23','2024-12-28 06:17:23'),(527,7,2,'D9','2024-12-28 06:17:23','2024-12-28 06:17:23'),(528,7,2,'D11','2024-12-28 06:17:23','2024-12-28 06:17:23'),(529,7,2,'D12','2024-12-28 06:17:23','2024-12-28 06:17:23'),(530,7,1,'D13','2024-12-28 06:17:23','2024-12-28 06:17:23'),(531,7,1,'D14','2024-12-28 06:17:23','2024-12-28 06:17:23'),(532,7,1,'E1','2024-12-28 06:17:23','2024-12-28 06:17:23'),(533,7,1,'E2','2024-12-28 06:17:23','2024-12-28 06:17:23'),(534,7,1,'E3','2024-12-28 06:17:23','2024-12-28 06:17:23'),(535,7,2,'E4','2024-12-28 06:17:23','2024-12-28 06:17:23'),(536,7,2,'E6','2024-12-28 06:17:23','2024-12-28 06:17:23'),(537,7,2,'E7','2024-12-28 06:17:23','2024-12-28 06:17:23'),(538,7,2,'E8','2024-12-28 06:17:23','2024-12-28 06:17:23'),(539,7,2,'E9','2024-12-28 06:17:23','2024-12-28 06:17:23'),(540,7,2,'E11','2024-12-28 06:17:23','2024-12-28 06:17:23'),(541,7,2,'E12','2024-12-28 06:17:23','2024-12-28 06:17:23'),(542,7,1,'E13','2024-12-28 06:17:23','2024-12-28 06:17:23'),(543,7,1,'E14','2024-12-28 06:17:23','2024-12-28 06:17:23'),(544,7,1,'E15','2024-12-28 06:17:23','2024-12-28 06:17:23'),(545,7,1,'F1','2024-12-28 06:17:23','2024-12-28 06:17:23'),(546,7,1,'F2','2024-12-28 06:17:23','2024-12-28 06:17:23'),(547,7,1,'F3','2024-12-28 06:17:23','2024-12-28 06:17:23'),(548,7,2,'F4','2024-12-28 06:17:23','2024-12-28 06:17:23'),(549,7,2,'F6','2024-12-28 06:17:23','2024-12-28 06:17:23'),(550,7,2,'F7','2024-12-28 06:17:23','2024-12-28 06:17:23'),(551,7,2,'F8','2024-12-28 06:17:23','2024-12-28 06:17:23'),(552,7,2,'F9','2024-12-28 06:17:23','2024-12-28 06:17:23'),(553,7,2,'F11','2024-12-28 06:17:23','2024-12-28 06:17:23'),(554,7,2,'F12','2024-12-28 06:17:23','2024-12-28 06:17:23'),(555,7,1,'F13','2024-12-28 06:17:23','2024-12-28 06:17:23'),(556,7,1,'F14','2024-12-28 06:17:24','2024-12-28 06:17:24'),(557,7,1,'F15','2024-12-28 06:17:24','2024-12-28 06:17:24'),(558,7,1,'G1','2024-12-28 06:17:24','2024-12-28 06:17:24'),(559,7,1,'G2','2024-12-28 06:17:24','2024-12-28 06:17:24'),(560,7,1,'G3','2024-12-28 06:17:24','2024-12-28 06:17:24'),(561,7,2,'G4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(562,7,2,'G6','2024-12-28 06:17:24','2024-12-28 06:17:24'),(563,7,2,'G7','2024-12-28 06:17:24','2024-12-28 06:17:24'),(564,7,2,'G8','2024-12-28 06:17:24','2024-12-28 06:17:24'),(565,7,2,'G9','2024-12-28 06:17:24','2024-12-28 06:17:24'),(566,7,2,'G11','2024-12-28 06:17:24','2024-12-28 06:17:24'),(567,7,2,'G12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(568,7,1,'G13','2024-12-28 06:17:24','2024-12-28 06:17:24'),(569,7,1,'G14','2024-12-28 06:17:24','2024-12-28 06:17:24'),(570,7,1,'G15','2024-12-28 06:17:24','2024-12-28 06:17:24'),(571,7,1,'H1','2024-12-28 06:17:24','2024-12-28 06:17:24'),(572,7,1,'H2','2024-12-28 06:17:24','2024-12-28 06:17:24'),(573,7,1,'H3','2024-12-28 06:17:24','2024-12-28 06:17:24'),(574,7,2,'H4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(575,7,2,'H6','2024-12-28 06:17:24','2024-12-28 06:17:24'),(576,7,2,'H7','2024-12-28 06:17:24','2024-12-28 06:17:24'),(577,7,2,'H8','2024-12-28 06:17:24','2024-12-28 06:17:24'),(578,7,2,'H9','2024-12-28 06:17:24','2024-12-28 06:17:24'),(579,7,2,'H11','2024-12-28 06:17:24','2024-12-28 06:17:24'),(580,7,2,'H12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(581,7,1,'H13','2024-12-28 06:17:24','2024-12-28 06:17:24'),(582,7,1,'H14','2024-12-28 06:17:24','2024-12-28 06:17:24'),(583,7,1,'H15','2024-12-28 06:17:24','2024-12-28 06:17:24'),(584,7,1,'I1','2024-12-28 06:17:24','2024-12-28 06:17:24'),(585,7,1,'I2','2024-12-28 06:17:24','2024-12-28 06:17:24'),(586,7,1,'I3','2024-12-28 06:17:24','2024-12-28 06:17:24'),(587,7,2,'I4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(588,7,2,'I6','2024-12-28 06:17:24','2024-12-28 06:17:24'),(589,7,2,'I7','2024-12-28 06:17:24','2024-12-28 06:17:24'),(590,7,2,'I8','2024-12-28 06:17:24','2024-12-28 06:17:24'),(591,7,2,'I9','2024-12-28 06:17:24','2024-12-28 06:17:24'),(592,7,2,'I11','2024-12-28 06:17:24','2024-12-28 06:17:24'),(593,7,2,'I12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(594,7,1,'I13','2024-12-28 06:17:24','2024-12-28 06:17:24'),(595,7,1,'I14','2024-12-28 06:17:24','2024-12-28 06:17:24'),(596,7,1,'I15','2024-12-28 06:17:24','2024-12-28 06:17:24'),(597,7,2,'J2','2024-12-28 06:17:24','2024-12-28 06:17:24'),(598,7,2,'J3','2024-12-28 06:17:24','2024-12-28 06:17:24'),(599,7,2,'J4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(600,7,2,'J5','2024-12-28 06:17:24','2024-12-28 06:17:24'),(601,7,2,'J6','2024-12-28 06:17:24','2024-12-28 06:17:24'),(602,7,2,'J7','2024-12-28 06:17:24','2024-12-28 06:17:24'),(603,7,2,'J8','2024-12-28 06:17:24','2024-12-28 06:17:24'),(604,7,2,'J9','2024-12-28 06:17:24','2024-12-28 06:17:24'),(605,7,2,'J10','2024-12-28 06:17:24','2024-12-28 06:17:24'),(606,7,2,'J11','2024-12-28 06:17:24','2024-12-28 06:17:24'),(607,7,2,'J12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(608,7,2,'J13','2024-12-28 06:17:24','2024-12-28 06:17:24'),(609,7,2,'J14','2024-12-28 06:17:24','2024-12-28 06:17:24'),(610,8,2,'A2','2024-12-28 06:17:24','2024-12-28 06:17:24'),(611,8,2,'A3','2024-12-28 06:17:24','2024-12-28 06:17:24'),(612,8,2,'A4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(613,8,2,'A5','2024-12-28 06:17:24','2024-12-28 06:17:24'),(614,8,2,'A6','2024-12-28 06:17:24','2024-12-28 06:17:24'),(615,8,2,'A7','2024-12-28 06:17:24','2024-12-28 06:17:24'),(616,8,2,'B2','2024-12-28 06:17:24','2024-12-28 06:17:24'),(617,8,2,'B3','2024-12-28 06:17:24','2024-12-28 06:17:24'),(618,8,2,'B4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(619,8,2,'B5','2024-12-28 06:17:24','2024-12-28 06:17:24'),(620,8,2,'B6','2024-12-28 06:17:24','2024-12-28 06:17:24'),(621,8,2,'B7','2024-12-28 06:17:24','2024-12-28 06:17:24'),(622,8,2,'B8','2024-12-28 06:17:24','2024-12-28 06:17:24'),(623,8,2,'B9','2024-12-28 06:17:24','2024-12-28 06:17:24'),(624,8,2,'B10','2024-12-28 06:17:24','2024-12-28 06:17:24'),(625,8,2,'B11','2024-12-28 06:17:24','2024-12-28 06:17:24'),(626,8,2,'B12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(627,8,2,'B13','2024-12-28 06:17:24','2024-12-28 06:17:24'),(628,8,2,'C2','2024-12-28 06:17:24','2024-12-28 06:17:24'),(629,8,2,'C3','2024-12-28 06:17:24','2024-12-28 06:17:24'),(630,8,2,'C4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(631,8,2,'C5','2024-12-28 06:17:24','2024-12-28 06:17:24'),(632,8,2,'C6','2024-12-28 06:17:24','2024-12-28 06:17:24'),(633,8,2,'C7','2024-12-28 06:17:24','2024-12-28 06:17:24'),(634,8,2,'C8','2024-12-28 06:17:24','2024-12-28 06:17:24'),(635,8,2,'C9','2024-12-28 06:17:24','2024-12-28 06:17:24'),(636,8,2,'C10','2024-12-28 06:17:24','2024-12-28 06:17:24'),(637,8,2,'C11','2024-12-28 06:17:24','2024-12-28 06:17:24'),(638,8,2,'C12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(639,8,2,'C13','2024-12-28 06:17:24','2024-12-28 06:17:24'),(640,8,1,'D2','2024-12-28 06:17:24','2024-12-28 06:17:24'),(641,8,1,'D3','2024-12-28 06:17:24','2024-12-28 06:17:24'),(642,8,1,'D4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(643,8,2,'D4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(644,8,2,'D6','2024-12-28 06:17:24','2024-12-28 06:17:24'),(645,8,2,'D7','2024-12-28 06:17:24','2024-12-28 06:17:24'),(646,8,2,'D8','2024-12-28 06:17:24','2024-12-28 06:17:24'),(647,8,2,'D9','2024-12-28 06:17:24','2024-12-28 06:17:24'),(648,8,2,'D11','2024-12-28 06:17:24','2024-12-28 06:17:24'),(649,8,2,'D12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(650,8,1,'D12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(651,8,1,'D13','2024-12-28 06:17:24','2024-12-28 06:17:24'),(652,8,1,'E2','2024-12-28 06:17:24','2024-12-28 06:17:24'),(653,8,1,'E3','2024-12-28 06:17:24','2024-12-28 06:17:24'),(654,8,1,'E4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(655,8,2,'E4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(656,8,2,'E6','2024-12-28 06:17:24','2024-12-28 06:17:24'),(657,8,2,'E7','2024-12-28 06:17:24','2024-12-28 06:17:24'),(658,8,2,'E8','2024-12-28 06:17:24','2024-12-28 06:17:24'),(659,8,2,'E9','2024-12-28 06:17:24','2024-12-28 06:17:24'),(660,8,2,'E11','2024-12-28 06:17:24','2024-12-28 06:17:24'),(661,8,2,'E12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(662,8,1,'E12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(663,8,1,'E13','2024-12-28 06:17:24','2024-12-28 06:17:24'),(664,8,1,'E14','2024-12-28 06:17:24','2024-12-28 06:17:24'),(665,8,1,'F2','2024-12-28 06:17:24','2024-12-28 06:17:24'),(666,8,1,'F3','2024-12-28 06:17:24','2024-12-28 06:17:24'),(667,8,1,'F4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(668,8,2,'F4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(669,8,2,'F6','2024-12-28 06:17:24','2024-12-28 06:17:24'),(670,8,2,'F7','2024-12-28 06:17:24','2024-12-28 06:17:24'),(671,8,2,'F8','2024-12-28 06:17:24','2024-12-28 06:17:24'),(672,8,2,'F9','2024-12-28 06:17:24','2024-12-28 06:17:24'),(673,8,2,'F11','2024-12-28 06:17:24','2024-12-28 06:17:24'),(674,8,2,'F12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(675,8,1,'F12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(676,8,1,'F13','2024-12-28 06:17:24','2024-12-28 06:17:24'),(677,8,1,'F14','2024-12-28 06:17:24','2024-12-28 06:17:24'),(678,8,1,'G2','2024-12-28 06:17:24','2024-12-28 06:17:24'),(679,8,1,'G3','2024-12-28 06:17:24','2024-12-28 06:17:24'),(680,8,1,'G4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(681,8,2,'G4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(682,8,2,'G6','2024-12-28 06:17:24','2024-12-28 06:17:24'),(683,8,2,'G7','2024-12-28 06:17:24','2024-12-28 06:17:24'),(684,8,2,'G8','2024-12-28 06:17:24','2024-12-28 06:17:24'),(685,8,2,'G9','2024-12-28 06:17:24','2024-12-28 06:17:24'),(686,8,2,'G11','2024-12-28 06:17:24','2024-12-28 06:17:24'),(687,8,2,'G12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(688,8,1,'G12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(689,8,1,'G13','2024-12-28 06:17:24','2024-12-28 06:17:24'),(690,8,1,'G14','2024-12-28 06:17:24','2024-12-28 06:17:24'),(691,8,1,'H2','2024-12-28 06:17:24','2024-12-28 06:17:24'),(692,8,1,'H3','2024-12-28 06:17:24','2024-12-28 06:17:24'),(693,8,1,'H4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(694,8,2,'H4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(695,8,2,'H6','2024-12-28 06:17:24','2024-12-28 06:17:24'),(696,8,2,'H7','2024-12-28 06:17:24','2024-12-28 06:17:24'),(697,8,2,'H8','2024-12-28 06:17:24','2024-12-28 06:17:24'),(698,8,2,'H9','2024-12-28 06:17:24','2024-12-28 06:17:24'),(699,8,2,'H11','2024-12-28 06:17:24','2024-12-28 06:17:24'),(700,8,2,'H12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(701,8,1,'H12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(702,8,1,'H13','2024-12-28 06:17:24','2024-12-28 06:17:24'),(703,8,1,'H14','2024-12-28 06:17:24','2024-12-28 06:17:24'),(704,8,1,'I2','2024-12-28 06:17:24','2024-12-28 06:17:24'),(705,8,1,'I3','2024-12-28 06:17:24','2024-12-28 06:17:24'),(706,8,1,'I4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(707,8,2,'I4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(708,8,2,'I6','2024-12-28 06:17:24','2024-12-28 06:17:24'),(709,8,2,'I7','2024-12-28 06:17:24','2024-12-28 06:17:24'),(710,8,2,'I8','2024-12-28 06:17:24','2024-12-28 06:17:24'),(711,8,2,'I9','2024-12-28 06:17:24','2024-12-28 06:17:24'),(712,8,2,'I11','2024-12-28 06:17:24','2024-12-28 06:17:24'),(713,8,2,'I12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(714,8,1,'I12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(715,8,1,'I13','2024-12-28 06:17:24','2024-12-28 06:17:24'),(716,8,1,'I14','2024-12-28 06:17:24','2024-12-28 06:17:24'),(717,8,2,'J2','2024-12-28 06:17:24','2024-12-28 06:17:24'),(718,8,2,'J3','2024-12-28 06:17:24','2024-12-28 06:17:24'),(719,8,2,'J4','2024-12-28 06:17:24','2024-12-28 06:17:24'),(720,8,2,'J5','2024-12-28 06:17:24','2024-12-28 06:17:24'),(721,8,2,'J6','2024-12-28 06:17:24','2024-12-28 06:17:24'),(722,8,2,'J7','2024-12-28 06:17:24','2024-12-28 06:17:24'),(723,8,2,'J8','2024-12-28 06:17:24','2024-12-28 06:17:24'),(724,8,2,'J9','2024-12-28 06:17:24','2024-12-28 06:17:24'),(725,8,2,'J10','2024-12-28 06:17:24','2024-12-28 06:17:24'),(726,8,2,'J11','2024-12-28 06:17:24','2024-12-28 06:17:24'),(727,8,2,'J12','2024-12-28 06:17:24','2024-12-28 06:17:24'),(728,8,2,'J13','2024-12-28 06:17:24','2024-12-28 06:17:24'),(729,8,2,'J14','2024-12-28 06:17:24','2024-12-28 06:17:24');
/*!40000 ALTER TABLE `ci_seat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_seat_type`
--

DROP TABLE IF EXISTS `ci_seat_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_seat_type` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `extra_fee` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_seat_type`
--

LOCK TABLES `ci_seat_type` WRITE;
/*!40000 ALTER TABLE `ci_seat_type` DISABLE KEYS */;
INSERT INTO `ci_seat_type` VALUES (1,'Ghế vip','Ghế vip','2024-11-06 13:59:46','2024-11-06 13:59:46',0,NULL),(2,'Ghế thường','Ghế thường','2024-11-06 14:00:19','2024-11-06 14:00:19',0,NULL),(3,'Ghế đôi','Ghế đôi','2024-11-06 14:00:33','2024-11-06 14:00:33',0,NULL);
/*!40000 ALTER TABLE `ci_seat_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_special_days`
--

DROP TABLE IF EXISTS `ci_special_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_special_days` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `day_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special_day` date NOT NULL,
  `extra_fee` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_special_days`
--

LOCK TABLES `ci_special_days` WRITE;
/*!40000 ALTER TABLE `ci_special_days` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_special_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_ticket`
--

DROP TABLE IF EXISTS `ci_ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_ticket` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seat_id` bigint unsigned NOT NULL,
  `bill_id` bigint unsigned NOT NULL,
  `movie_showtime_id` bigint unsigned NOT NULL,
  `price` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_ticket_bill_id_foreign` (`bill_id`),
  KEY `ci_ticket_seat_id_foreign` (`seat_id`),
  CONSTRAINT `ci_ticket_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `ci_bill` (`id`),
  CONSTRAINT `ci_ticket_seat_id_foreign` FOREIGN KEY (`seat_id`) REFERENCES `ci_seat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_ticket`
--

LOCK TABLES `ci_ticket` WRITE;
/*!40000 ALTER TABLE `ci_ticket` DISABLE KEYS */;
INSERT INTO `ci_ticket` VALUES (1,370,19,60,55000,'2024-12-20 03:43:31','2024-12-28 03:43:31',NULL),(2,370,20,61,55000,'2024-12-20 03:46:10','2024-12-28 03:46:10',NULL),(3,370,21,63,55000,'2024-12-20 03:46:47','2024-12-28 03:46:47',NULL),(4,370,22,64,55000,'2024-12-21 03:47:20','2024-12-28 03:47:20',NULL),(5,370,23,65,55000,'2024-12-22 03:47:48','2024-12-28 03:47:48',NULL),(6,370,24,66,55000,'2024-12-22 04:02:10','2024-12-28 04:02:10',NULL),(7,370,25,67,55000,'2024-12-23 04:03:06','2024-12-28 04:03:06',NULL),(8,370,26,68,55000,'2024-12-24 04:03:46','2024-12-28 04:03:46',NULL),(9,371,28,60,70000,'2024-12-20 04:32:01','2024-12-28 04:32:01',NULL),(10,276,29,72,70000,'2024-12-29 12:03:54','2024-12-29 12:03:54',NULL),(11,295,30,72,70000,'2024-12-29 14:24:02','2024-12-29 14:24:02',NULL),(12,275,31,72,70000,'2024-12-29 14:26:49','2024-12-29 14:26:49',NULL),(13,271,32,72,70000,'2025-01-02 18:26:08','2025-01-02 18:26:08',NULL);
/*!40000 ALTER TABLE `ci_ticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_time_slots`
--

DROP TABLE IF EXISTS `ci_time_slots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_time_slots` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slot_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `extra_fee` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_time_slots`
--

LOCK TABLES `ci_time_slots` WRITE;
/*!40000 ALTER TABLE `ci_time_slots` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_time_slots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_weekly_ticket_prices`
--

DROP TABLE IF EXISTS `ci_weekly_ticket_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ci_weekly_ticket_prices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra_fee` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start_time` time NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_weekly_ticket_prices`
--

LOCK TABLES `ci_weekly_ticket_prices` WRITE;
/*!40000 ALTER TABLE `ci_weekly_ticket_prices` DISABLE KEYS */;
INSERT INTO `ci_weekly_ticket_prices` VALUES (1,'Weekdays','Weekdays',55000,'2024-11-17 07:12:34','2024-11-17 07:12:34','00:00:00',NULL),(2,'Weekdays','Weekdays',70000,'2024-11-17 07:12:34','2024-11-17 07:12:34','12:00:00',NULL),(3,'Weekdays','Weekdays',80000,'2024-11-17 07:12:34','2024-11-17 07:12:34','17:00:00',NULL),(4,'Weekdays','Weekdays',65000,'2024-11-17 07:12:34','2024-11-17 07:12:34','23:00:00',NULL),(5,'Weekend','Weekend',70000,'2024-11-17 07:12:34','2024-11-17 07:12:34','00:00:00',NULL),(6,'Weekend','Weekend',80000,'2024-11-17 07:12:34','2024-11-17 07:12:34','12:00:00',NULL),(7,'Weekend','Weekend',90000,'2024-11-17 07:12:34','2024-11-17 07:12:34','17:00:00',NULL),(8,'Weekend','Weekend',75000,'2024-11-17 07:12:34','2024-11-17 07:12:34','23:00:00',NULL);
/*!40000 ALTER TABLE `ci_weekly_ticket_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2013_05_22_015303_create_ci_role_table',1),(2,'2014_10_12_000000_create_ci_account_table',1),(3,'2019_12_14_000001_create_personal_access_tokens_table',1),(4,'2024_09_30_170250_create_ci_profile_table',1),(5,'2024_09_30_170317_create_ci_bill_table',1),(6,'2024_09_30_170359_create_ci_genre_table',1),(7,'2024_09_30_170414_create_ci_rated_table',1),(8,'2024_09_30_170429_create_ci_country_table',1),(9,'2024_09_30_170438_create_ci_movie_table',1),(10,'2024_09_30_170508_create_ci_seat_type_table',1),(11,'2024_09_30_170602_create_ci_cinema_table',1),(12,'2024_09_30_170610_create_ci_room_table',1),(13,'2024_09_30_170628_create_ci_movie_show_time_table',1),(14,'2024_09_30_170652_create_ci_seat_table',1),(15,'2024_09_30_170730_create_ci_ticket_table',1),(16,'2024_09_30_170859_create_ci_comment_table',1),(17,'2024_10_02_030141_add_foreign_key',1),(18,'2024_10_09_112252_create_ci_movie_genre_table',1),(19,'2024_10_11_112204_add_slug_to_ci_movie_table',1),(20,'2024_10_20_144212_update_column_seat_map_in_ci_room',2),(21,'2024_11_01_181618_create_ci_time_slots_table',2),(22,'2024_11_01_181724_create_ci_special_days_table',2),(23,'2024_11_01_182016_add_extra_fee_to_ci_seat_types_table',2),(24,'2024_11_01_182147_create_ci_promotions_table',2),(25,'2024_11_04_002921_create_ci_weekly_ticket_prices_table',2),(26,'2024_11_10_114812_update_foreign_key_on_ci_bill_table',3),(27,'2024_11_10_134151_add_column_start_time_to_ci_weekly_ticket_prices',3),(28,'2024_11_22_135448_add_status_to_ci_movie_table',4),(29,'2024_11_23_100241_create_password_resets_table',4),(30,'2024_11_26_083455_change_day_type_to_string_in_ci_special_days_table',4),(31,'2024_11_26_144943_add_chi_nhanh_to_ci_account_table',4),(32,'2024_11_26_145541_rename_chi_nhanh_to_cinema_id_in_ci_account_table',4),(33,'2024_11_26_211540_update_start_end_time_columns_in_ci_movie_show_time_table',4),(34,'2024_12_03_094912_update_ci_promotions_table',5),(35,'2024_12_03_095004_create_ci_promotion_user_table',5),(36,'2024_12_03_103006_add_status_to_ci_promotions_table',5),(37,'2024_12_03_114630_create_ci_evaluate_movie',5),(38,'2024_12_03_115343_add_column_vote_to_ci_movie',5),(39,'2024_12_04_133129_create_ci_foods_table',5),(40,'2024_12_04_140938_add_status_to_ci_foods_table',5),(41,'2024_12_07_101835_add_ticket_code_to_ci_bill_table',5),(42,'2024_12_09_103721_add_deleted_at_to_multiple_tables',6),(43,'2024_12_13_142100_add_staff_check_to_ci_bill_table',7),(44,'2024_12_13_145151_add_movie_show_time_id_to_ci_bill_table',7),(45,'2024_12_13_223211_add_column_extra_id_to_ci_bill_table',8),(46,'2024_12_13_223856_create_ci_food_bill_join_table',8),(47,'2024_12_14_223650_add_latitude_longitude_to_ci_cinema',8),(48,'2024_12_16_102221_add_avatar_to_ci_cinema_and_ci_promotions',9),(49,'2025_01_03_095757_update_default_values_in_ci_movie_table',10);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES (6,'nhatbg06042002@gmail.com','$2y$10$jFd6vIzk0BkjjsGUzIlbg.pz4otvL2Rj9KoUiFell25XMtp5bT85i','2024-12-14 09:55:21','2024-12-14 09:55:21');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\Account',4,'xxx111xxx','820ab1030e6c539c15cd5185e07374a498e0dd7bf3a094a311392748b9cb9ea7','[\"*\"]','2024-11-06 14:31:17',NULL,'2024-11-06 13:53:15','2024-11-06 14:31:17'),(2,'App\\Models\\Account',6,'null','3c1e2de8b241139285536404053306fa62d9a1a57f24c83e51bbd38d8315b270','[\"*\"]',NULL,NULL,'2024-12-08 07:25:33','2024-12-08 07:25:33'),(142,'App\\Models\\Account',7,'xxxx','b32a81deee93b505ddae37148c720274b73a20dc5b55d91ce5f3a37c0f177df5','[\"*\"]','2024-12-30 02:51:35',NULL,'2024-12-30 02:47:44','2024-12-30 02:51:35'),(143,'App\\Models\\Account',8,'xxxx','b380eca4b33e8ce67fdc80e2471645a389461e840d43777cc6a864ce2c2e46e3','[\"*\"]','2025-01-02 01:47:07',NULL,'2025-01-01 11:32:22','2025-01-02 01:47:07'),(145,'App\\Models\\Account',9,'xxxx','b2e0f8107b395f40dbfcc0c51447a2f5d3ea487127cdb687bd496693c2b8216a','[\"*\"]','2025-01-03 15:50:10',NULL,'2025-01-02 02:19:32','2025-01-03 15:50:10');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-03 23:03:17
