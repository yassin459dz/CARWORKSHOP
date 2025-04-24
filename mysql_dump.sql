-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: myfirstproject
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `brand` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (57,'BMW','s','2024-10-25 21:49:46','2024-10-25 21:49:46'),(59,'PORSHE',NULL,'2024-10-26 22:17:19','2024-10-26 22:17:19'),(60,'AMG',NULL,'2024-10-26 22:17:25','2024-10-26 22:17:25'),(61,'LAMBO',NULL,'2024-10-26 22:17:32','2024-10-26 22:17:32'),(62,'FORD',NULL,'2024-10-26 22:18:06','2024-10-26 22:18:06'),(63,'FIAT','Image','2024-10-27 19:55:28','2024-10-27 19:55:28'),(85,'LAND ROVER','LAND','2024-11-05 22:15:34','2024-11-05 22:15:34'),(86,'ASTON MARTIN','ASTON','2024-11-05 22:15:58','2024-11-05 22:15:58'),(87,'BMW','HGHF','2024-11-06 20:13:30','2024-11-06 20:13:30'),(91,'Non',NULL,NULL,NULL),(92,'Brand',NULL,NULL,NULL);
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cars` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` bigint(20) unsigned NOT NULL,
  `model` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cars_brand_id_foreign` (`brand_id`),
  CONSTRAINT `cars_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cars`
--

LOCK TABLES `cars` WRITE;
/*!40000 ALTER TABLE `cars` DISABLE KEYS */;
INSERT INTO `cars` VALUES (6,60,'A45S',NULL,'2024-11-08 14:35:08'),(8,59,'GT RS3','2024-10-26 22:28:23','2024-10-26 22:28:23'),(32,59,'s','2024-11-05 20:27:14','2024-11-05 20:27:14'),(33,59,'kghkj','2024-11-05 21:10:18','2024-11-05 21:10:18'),(34,62,'vvvvvvvv','2024-11-05 21:31:09','2024-11-05 21:31:09'),(36,86,'C8','2024-11-05 22:17:36','2024-11-05 22:17:36'),(37,87,'GFCHFG','2024-11-06 20:17:26','2024-11-06 20:17:26'),(40,60,'A45S8','2024-11-06 20:42:09','2024-11-06 20:42:09'),(41,86,'C85','2024-11-06 20:42:28','2024-11-06 20:42:28'),(42,91,'Car',NULL,NULL),(44,60,'S63','2024-11-09 12:49:54','2024-11-09 12:49:54'),(46,62,'F150',NULL,NULL);
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `phone2` varchar(10) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `sold` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=280 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (209,'YASSIN 4598','0553928164','0568574','address','kelb',0.00,'2024-10-24 23:32:20','2024-11-13 19:55:47'),(245,'Ms. Della Maggio','0771305054','0667589121','London','Frequent visitor',7991.19,'2024-10-25 20:56:02','2024-10-25 20:56:02'),(246,'Mrs. Dana Ullrich III','0778838767','0773644005','Dubai','Frequent visitor',9530.89,'2024-10-25 20:56:02','2024-10-25 20:56:02'),(247,'Morris Langworth V','0551214757','0776896583','New York','Frequent visitor',12509.30,'2024-10-25 20:56:02','2024-10-25 20:56:02'),(248,'Mr. Devin Klocko','0771202940','0558206064','London','Prefers quick service',12108.61,'2024-10-25 20:56:02','2024-10-25 20:56:02'),(249,'Rae Abbott','0778316088','0771863156','Cairo','Good client',4368.22,'2024-10-25 20:56:02','2024-10-25 20:56:02'),(250,'Quincy Purdy','0555450920','0558081052','Paris','Frequent visitor',15624.03,'2024-10-25 20:56:02','2024-10-25 20:56:02'),(251,'Jayda Hessel','0556957085','0773390802','Alger','Prefers quick service',671.81,'2024-10-25 20:56:02','2024-10-25 20:56:02'),(252,'Dr. Velva Collins','0668283568','0669608081','New York','Doesn\'t want to stay long time',7018.27,'2024-10-25 20:56:02','2024-10-25 20:56:02'),(253,'Prof. Cleo Deckow','0661886652',NULL,'New York','Prefers quick service',18636.54,'2024-10-25 20:56:02','2024-10-25 20:56:02'),(254,'Gage Kovacek','0777096428','0552908826','London','Prefers quick service',2172.47,'2024-10-25 20:56:02','2024-10-25 20:56:02'),(255,'khireddinefsf boualem','088856446','054944944',NULL,NULL,NULL,'2024-10-25 21:09:09','2024-10-25 21:09:09'),(256,'Client',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(257,'khireddinGHJ','0553928188',NULL,NULL,NULL,NULL,'2024-11-13 19:35:06','2024-11-13 19:35:06'),(258,'Yacinehh','066448877',NULL,NULL,NULL,NULL,'2024-11-13 19:54:25','2024-11-13 19:54:25'),(259,'jghjrjeje','0777888555',NULL,NULL,NULL,NULL,'2024-11-13 19:56:34','2024-11-13 19:56:34'),(260,'xcvvxcv','6536777777',NULL,NULL,NULL,NULL,'2024-11-13 19:57:44','2024-11-13 19:57:44'),(261,'YRYE','0987654321',NULL,NULL,NULL,NULL,'2024-11-13 20:00:03','2024-11-13 20:00:03'),(262,'aerze','0123456789',NULL,NULL,NULL,NULL,'2024-11-13 20:00:57','2024-11-13 20:00:57'),(266,'test','0111222333',NULL,NULL,NULL,NULL,'2024-11-15 19:58:58','2024-11-15 19:58:58'),(267,'khireddine boualll','0222333555',NULL,NULL,NULL,NULL,'2024-11-15 20:00:14','2024-11-15 20:00:14'),(268,'dsfdfssdf','0222555111',NULL,NULL,NULL,NULL,'2024-11-15 20:01:39','2024-11-15 20:01:39'),(269,'gdfgdfggdf','0111444777',NULL,NULL,NULL,NULL,'2024-11-15 20:03:56','2024-11-15 20:03:56'),(273,'YacineYT','9999999999',NULL,NULL,NULL,NULL,'2024-11-15 20:53:09','2024-11-15 20:53:09'),(274,'YacineXX','5477474444',NULL,NULL,NULL,NULL,'2024-11-15 20:53:36','2024-11-15 20:53:36'),(279,'KHIRO',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factures`
--

DROP TABLE IF EXISTS `factures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factures` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `car_id` bigint(20) unsigned NOT NULL,
  `matricule_id` bigint(20) unsigned NOT NULL,
  `km` int(10) unsigned NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `extra_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `order_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`order_items`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('PAID','NOT PAID') NOT NULL DEFAULT 'PAID',
  PRIMARY KEY (`id`),
  KEY `factures_client_id_foreign` (`client_id`),
  KEY `factures_car_id_foreign` (`car_id`),
  KEY `factures_matricule_id_foreign` (`matricule_id`),
  CONSTRAINT `factures_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `factures_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `factures_matricule_id_foreign` FOREIGN KEY (`matricule_id`) REFERENCES `matricules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factures`
--

LOCK TABLES `factures` WRITE;
/*!40000 ALTER TABLE `factures` DISABLE KEYS */;
INSERT INTO `factures` VALUES (7,209,8,2,12500,'Its A Porshe',26000.00,2000.00,500.00,'\"[{\\\"product_id\\\":3,\\\"name\\\":\\\"liqui moly Touring High Tech \\\\r\\\\n\\\",\\\"description\\\":\\\"20W-50\\\",\\\"quantity\\\":2,\\\"price\\\":9500,\\\"total\\\":19000},{\\\"product_id\\\":1,\\\"name\\\":\\\"Elf Evolution Full-Tech FE \\\",\\\"description\\\":\\\"5W-30\\\",\\\"quantity\\\":1,\\\"price\\\":5500,\\\"total\\\":5500}]\"','2025-01-26 22:44:56','2025-01-26 22:44:56','PAID'),(8,254,44,21,12157,'Remark',13500.00,2000.00,1000.00,'\"[{\\\"product_id\\\":6,\\\"name\\\":\\\"Castrol EDGE Titanium \\\",\\\"description\\\":\\\"5W-30\\\",\\\"quantity\\\":1,\\\"price\\\":12500,\\\"total\\\":12500}]\"','2025-01-26 22:45:27','2025-01-26 22:45:27','NOT PAID'),(12,256,42,2,0,NULL,11500.00,2000.00,0.00,'\"[{\\\"product_id\\\":null,\\\"name\\\":\\\"liqui moly Touring High Tech \\\\r\\\\n\\\",\\\"description\\\":\\\"20W-50\\\",\\\"quantity\\\":1,\\\"price\\\":9500,\\\"total\\\":9500}]\"','2025-01-27 19:36:01','2025-01-27 19:36:57','PAID'),(34,209,6,1,45645456,'remark',9500.00,0.00,0.00,'\"[{\\\"product_id\\\":3,\\\"name\\\":\\\"liqui moly Touring High Tech \\\\r\\\\n\\\",\\\"description\\\":\\\"20W-50\\\",\\\"quantity\\\":1,\\\"price\\\":9500,\\\"total\\\":9500}]\"','2025-02-01 15:58:46','2025-02-01 15:58:46','PAID'),(35,209,6,1,456764564,NULL,12500.00,0.00,0.00,'\"[{\\\"product_id\\\":6,\\\"name\\\":\\\"Castrol EDGE Titanium \\\",\\\"description\\\":\\\"5W-30\\\",\\\"quantity\\\":1,\\\"price\\\":12500,\\\"total\\\":12500}]\"','2025-02-01 15:59:37','2025-02-01 15:59:37','PAID');
/*!40000 ALTER TABLE `factures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matricules`
--

DROP TABLE IF EXISTS `matricules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matricules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `car_id` bigint(20) unsigned NOT NULL,
  `mat` varchar(255) NOT NULL,
  `km` int(10) unsigned NOT NULL DEFAULT 0,
  `color` varchar(255) DEFAULT NULL,
  `anne` int(11) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `matricules_car_id_foreign` (`car_id`),
  CONSTRAINT `matricules_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `matricules_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matricules`
--

LOCK TABLES `matricules` WRITE;
/*!40000 ALTER TABLE `matricules` DISABLE KEYS */;
INSERT INTO `matricules` VALUES (1,209,6,'51615 124 16',35000,'blue',2024,NULL,NULL,NULL),(2,256,42,'0000',0,NULL,NULL,NULL,NULL,NULL),(3,209,6,'415641556',0,NULL,NULL,NULL,'2024-12-21 19:50:43','2024-12-21 19:50:43'),(4,209,6,'45656464333',0,NULL,NULL,NULL,'2024-12-21 19:51:38','2024-12-21 19:51:38'),(5,209,6,'156154144',0,NULL,NULL,NULL,'2024-12-21 19:52:04','2024-12-21 19:52:04'),(6,209,8,'12356622266',0,NULL,NULL,NULL,'2024-12-21 20:14:04','2024-12-21 20:14:04'),(7,250,40,'01211561565',0,NULL,NULL,NULL,'2024-12-21 20:14:30','2024-12-21 20:14:30'),(8,209,6,'00',0,NULL,NULL,NULL,'2025-01-05 20:51:20','2025-01-05 20:51:20'),(9,250,6,'000000',0,NULL,NULL,NULL,'2025-01-08 20:22:06','2025-01-08 20:22:06'),(10,209,6,'55465',0,NULL,NULL,NULL,'2025-01-08 20:41:59','2025-01-08 20:41:59'),(11,209,6,'333',0,NULL,NULL,NULL,'2025-01-08 20:42:22','2025-01-08 20:42:22'),(12,209,8,'132133',0,NULL,NULL,NULL,'2025-01-11 21:52:49','2025-01-11 21:52:49'),(13,209,36,'33333',0,NULL,NULL,NULL,'2025-01-12 17:59:28','2025-01-12 17:59:28'),(14,258,36,'33333',0,NULL,NULL,NULL,'2025-01-12 18:02:45','2025-01-12 18:02:45'),(15,209,6,'444',0,NULL,NULL,NULL,'2025-01-12 18:03:12','2025-01-12 18:03:12'),(16,273,34,'888',0,NULL,NULL,NULL,'2025-01-12 18:05:48','2025-01-12 18:05:48'),(17,209,40,'333333',0,NULL,NULL,NULL,'2025-01-12 18:06:14','2025-01-12 18:06:14'),(18,251,6,'36',0,NULL,NULL,NULL,'2025-01-12 18:06:56','2025-01-12 18:06:56'),(19,261,44,'456566464',0,NULL,NULL,NULL,'2025-01-12 18:13:26','2025-01-12 18:13:26'),(20,250,32,'0000000',0,NULL,NULL,NULL,'2025-01-12 19:40:02','2025-01-12 19:40:02'),(21,254,44,'86489496',0,NULL,NULL,NULL,'2025-01-26 22:45:27','2025-01-26 22:45:27'),(22,256,42,'1234',0,NULL,NULL,NULL,NULL,NULL),(25,279,46,'753951',0,NULL,NULL,NULL,NULL,NULL),(48,252,8,'7777777',0,NULL,NULL,NULL,'2025-02-10 20:25:14','2025-02-10 20:25:14'),(49,249,36,'444444',0,NULL,NULL,NULL,'2025-02-10 20:25:50','2025-02-10 20:25:50'),(50,260,36,'yyyy',0,NULL,NULL,NULL,'2025-02-10 20:26:11','2025-02-10 20:26:11'),(51,260,40,'qqqq',0,NULL,NULL,NULL,'2025-02-10 20:26:33','2025-02-10 20:26:33'),(52,250,36,'ssss',0,NULL,NULL,NULL,'2025-02-10 20:28:15','2025-02-10 20:28:15'),(53,255,6,'7565',0,NULL,NULL,NULL,'2025-02-10 20:29:44','2025-02-10 20:29:44'),(54,209,36,'6666',0,NULL,NULL,NULL,'2025-02-10 20:30:52','2025-02-10 20:30:52'),(55,279,6,'hjkhkhj',0,NULL,NULL,NULL,'2025-02-10 20:32:38','2025-02-10 20:32:38'),(56,279,8,'852',0,NULL,NULL,NULL,'2025-02-10 20:49:07','2025-02-10 20:49:07'),(57,279,36,'999999',0,NULL,NULL,NULL,'2025-02-10 21:03:26','2025-02-10 21:03:26'),(58,247,32,'888888',0,NULL,NULL,NULL,'2025-02-10 22:07:30','2025-02-10 22:07:30'),(59,252,36,'664564',0,NULL,NULL,NULL,'2025-02-10 22:08:33','2025-02-10 22:08:33'),(60,279,33,'56445656',0,NULL,NULL,NULL,'2025-02-11 20:18:06','2025-02-11 20:18:06'),(61,262,8,'753952',0,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `matricules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_10_15_212435_create_clients_table',1),(5,'2024_10_15_212907_create_brands_table',1),(6,'2024_10_15_213340_cars',1),(7,'2024_10_19_183203_create_students_table',2),(9,'2024_11_08_172708_create_matricules_table',3),(16,'2024_11_08_200643_create_factures_table',4),(17,'2024_11_23_144520_create_products_table',4),(18,'2025_01_22_204413_add_status_to_factures_table',5),(19,'2025_02_01_164924_add_unique_index_to_matricules_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Elf Evolution Full-Tech FE ','5W-30',5500,NULL,NULL),(2,'MOTUL SCOOTER EXPRET ','4T 10W-40',1200,NULL,NULL),(3,'liqui moly Touring High Tech \r\n','20W-50',9500,NULL,NULL),(4,'filtre a air',NULL,1000,NULL,NULL),(5,'filtre a OIL','AUDI A3',2000,NULL,NULL),(6,'Castrol EDGE Titanium ','5W-30',12500,NULL,NULL),(7,'NAFTAL','UNIVERSEL',1800,NULL,NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('KtIhWQA0hRbstWyiBEhxYNysw74rtkeATfbx4qb6',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU1VOMFd2dHIyQVNIN3BxM3RiRUIwTXhab28xc3BySTdJZXBybmlWNiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNjoiaHR0cDovL215Zmlyc3Rwcm9qZWN0LnRlc3QvbWF0cmljdWxlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1739660472);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'YASSIN','yassinsina459@gmail.com',NULL,'$2y$12$pZTsrbHcAd1OiSqwnzRuZuqn12vloS1K.sMi2GI6fjHHFD4W/3tCu','zSZvlC4ML3HSE8Pv8q9WPaA1AQN8H6numQzAoFvRIZiu1ZCI0EcnGt1Cpm4q','2024-10-15 20:41:32','2024-10-15 20:41:32'),(2,'Test User','test@example.com','2024-10-25 20:46:41','$2y$12$xnsZwvql.pjEIWot9e8oiOAiu1ABYLZOv4zpi7yhXoj58ZfxZC4MO','etxYAU55uu','2024-10-25 20:46:42','2024-10-25 20:46:42');
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

-- Dump completed on 2025-02-16 22:39:35
