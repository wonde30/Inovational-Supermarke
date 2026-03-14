-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: smart_supermarket
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
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_foreign` (`user_id`),
  KEY `audit_logs_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `audit_logs_action_index` (`action`),
  CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
INSERT INTO `audit_logs` VALUES (1,1,'login','User',1,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-09 18:07:12','2026-03-09 18:07:12'),(2,7,'login','User',7,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-09 19:38:49','2026-03-09 19:38:49'),(3,1,'login','User',1,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-09 19:44:50','2026-03-09 19:44:50'),(4,7,'login','User',7,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-09 19:46:40','2026-03-09 19:46:40'),(5,1,'login','User',1,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-09 19:48:20','2026-03-09 19:48:20'),(6,7,'login','User',7,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-09 20:23:20','2026-03-09 20:23:20'),(7,1,'login','User',1,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-09 20:24:28','2026-03-09 20:24:28'),(8,7,'login','User',7,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-09 20:25:56','2026-03-09 20:25:56'),(9,7,'login','User',7,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-10 08:15:25','2026-03-10 08:15:25'),(10,7,'login','User',7,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-10 08:28:19','2026-03-10 08:28:19'),(12,1,'login','User',1,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-10 10:43:06','2026-03-10 10:43:06'),(13,1,'create_sale_from_order','Sale',4,NULL,'{\"order_id\":16,\"invoice_number\":\"INV-20260310-0001\"}','127.0.0.1','Sale created from Order #ORD-20260310-RKNRGR','2026-03-10 10:44:42','2026-03-10 10:44:42'),(14,1,'update_order_status','Order',16,'{\"status\":\"pending\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from pending to completed','2026-03-10 10:44:42','2026-03-10 10:44:42'),(15,1,'login','User',1,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-10 10:52:25','2026-03-10 10:52:25'),(16,1,'login','User',1,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-10 13:46:35','2026-03-10 13:46:35'),(17,7,'login','User',7,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-10 14:04:06','2026-03-10 14:04:06'),(18,7,'login','User',7,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-10 14:04:21','2026-03-10 14:04:21'),(19,7,'resolve_alert','StockAlert',2,NULL,NULL,'127.0.0.1','Resolved stock alert','2026-03-10 14:05:09','2026-03-10 14:05:09'),(20,7,'resolve_alert','StockAlert',3,NULL,NULL,'127.0.0.1','Resolved stock alert','2026-03-10 14:05:15','2026-03-10 14:05:15'),(21,7,'resolve_alert','StockAlert',4,NULL,NULL,'127.0.0.1','Resolved stock alert','2026-03-10 14:06:45','2026-03-10 14:06:45'),(22,7,'update_order_status','Order',15,'{\"status\":\"pending\"}','{\"status\":\"processing\"}','127.0.0.1','Order status changed from pending to processing','2026-03-10 14:07:59','2026-03-10 14:07:59'),(23,7,'create_sale_from_order','Sale',5,NULL,'{\"order_id\":15,\"invoice_number\":\"INV-20260310-0002\"}','127.0.0.1','Sale created from Order #ORD-20260310-LZ84CX','2026-03-10 14:08:06','2026-03-10 14:08:06'),(24,7,'update_order_status','Order',15,'{\"status\":\"processing\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from processing to completed','2026-03-10 14:08:06','2026-03-10 14:08:06'),(25,7,'create_sale_from_order','Sale',6,NULL,'{\"order_id\":12,\"invoice_number\":\"INV-20260310-0003\"}','127.0.0.1','Sale created from Order #ORD-20260309-XGNKEV','2026-03-10 14:08:16','2026-03-10 14:08:16'),(26,7,'update_order_status','Order',12,'{\"status\":\"pending\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from pending to completed','2026-03-10 14:08:16','2026-03-10 14:08:16'),(27,7,'create_sale_from_order','Sale',7,NULL,'{\"order_id\":8,\"invoice_number\":\"INV-20260310-0004\"}','127.0.0.1','Sale created from Order #ORD-20260309-XTK0YF','2026-03-10 14:08:36','2026-03-10 14:08:36'),(28,7,'update_order_status','Order',8,'{\"status\":\"pending\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from pending to completed','2026-03-10 14:08:36','2026-03-10 14:08:36'),(29,7,'login','User',7,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-10 14:10:04','2026-03-10 14:10:04'),(30,7,'login','User',7,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-10 15:07:19','2026-03-10 15:07:19'),(31,7,'create_sale_from_order','Sale',13,NULL,'{\"order_id\":22,\"invoice_number\":\"INV-20260310-0005\"}','127.0.0.1','Sale created from Order #ORD-20260310-7BCHUB','2026-03-10 15:11:51','2026-03-10 15:11:51'),(32,7,'update_order_status','Order',22,'{\"status\":\"pending\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from pending to completed','2026-03-10 15:11:51','2026-03-10 15:11:51'),(33,7,'create_sale_from_order','Sale',14,NULL,'{\"order_id\":21,\"invoice_number\":\"INV-20260310-0006\"}','127.0.0.1','Sale created from Order #ORD-20260310-LCAUOL','2026-03-10 15:11:57','2026-03-10 15:11:57'),(34,7,'update_order_status','Order',21,'{\"status\":\"pending\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from pending to completed','2026-03-10 15:11:57','2026-03-10 15:11:57'),(35,2,'login','User',2,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-10 15:13:57','2026-03-10 15:13:57'),(36,7,'login','User',7,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-10 15:56:53','2026-03-10 15:56:53'),(37,7,'login','User',7,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-10 17:09:37','2026-03-10 17:09:37'),(38,7,'create_sale_from_order','Sale',17,NULL,'{\"order_id\":33,\"invoice_number\":\"INV-20260310-0007\"}','127.0.0.1','Sale created from Order #ORD-20260310-KUJQSD','2026-03-10 17:45:41','2026-03-10 17:45:41'),(39,7,'update_order_status','Order',33,'{\"status\":\"pending\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from pending to completed','2026-03-10 17:45:41','2026-03-10 17:45:41'),(40,7,'login','User',7,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-10 17:48:55','2026-03-10 17:48:55'),(42,7,'create_sale_from_order','Sale',18,NULL,'{\"order_id\":44,\"invoice_number\":\"INV-20260311-0001\"}','127.0.0.1','Sale created from Order #ORD-20260311-TX7NRD','2026-03-11 03:31:15','2026-03-11 03:31:15'),(43,7,'update_order_status','Order',44,'{\"status\":\"pending\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from pending to completed','2026-03-11 03:31:15','2026-03-11 03:31:15'),(44,7,'create_sale_from_order','Sale',19,NULL,'{\"order_id\":45,\"invoice_number\":\"INV-20260311-0002\"}','127.0.0.1','Sale created from Order #ORD-20260311-YNNSKF','2026-03-11 03:31:44','2026-03-11 03:31:44'),(45,7,'update_order_status','Order',45,'{\"status\":\"pending\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from pending to completed','2026-03-11 03:31:44','2026-03-11 03:31:44'),(46,7,'create_sale_from_order','Sale',20,NULL,'{\"order_id\":32,\"invoice_number\":\"INV-20260311-0003\"}','127.0.0.1','Sale created from Order #ORD-20260310-9EEKRR','2026-03-11 03:31:58','2026-03-11 03:31:58'),(47,7,'update_order_status','Order',32,'{\"status\":\"pending\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from pending to completed','2026-03-11 03:31:58','2026-03-11 03:31:58'),(48,7,'create_sale_from_order','Sale',21,NULL,'{\"order_id\":46,\"invoice_number\":\"INV-20260311-0004\"}','127.0.0.1','Sale created from Order #ORD-20260311-CFU6QH','2026-03-11 03:32:16','2026-03-11 03:32:16'),(49,7,'update_order_status','Order',46,'{\"status\":\"pending\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from pending to completed','2026-03-11 03:32:16','2026-03-11 03:32:16'),(50,7,'create_sale_from_order','Sale',22,NULL,'{\"order_id\":47,\"invoice_number\":\"INV-20260311-0005\"}','127.0.0.1','Sale created from Order #ORD-20260311-0GQNS5','2026-03-11 03:36:44','2026-03-11 03:36:44'),(51,7,'update_order_status','Order',47,'{\"status\":\"pending\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from pending to completed','2026-03-11 03:36:44','2026-03-11 03:36:44'),(53,7,'create_sale_from_order','Sale',23,NULL,'{\"order_id\":50,\"invoice_number\":\"INV-20260311-0006\"}','127.0.0.1','Sale created from Order #ORD-20260311-AXKXOZ','2026-03-11 03:47:26','2026-03-11 03:47:26'),(54,7,'update_order_status','Order',50,'{\"status\":\"pending\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from pending to completed','2026-03-11 03:47:26','2026-03-11 03:47:26'),(58,7,'login','User',7,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-11 04:59:31','2026-03-11 04:59:31'),(60,12,'login','User',12,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-11 05:02:24','2026-03-11 05:02:24'),(61,7,'create_sale_from_order','Sale',24,NULL,'{\"order_id\":52,\"invoice_number\":\"INV-20260311-0007\"}','127.0.0.1','Sale created from Order #ORD-20260311-D5LE7H','2026-03-11 05:23:55','2026-03-11 05:23:55'),(62,7,'update_order_status','Order',52,'{\"status\":\"pending\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from pending to completed','2026-03-11 05:23:55','2026-03-11 05:23:55'),(63,7,'login','User',7,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-11 07:47:02','2026-03-11 07:47:02'),(64,2,'login','User',2,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-11 07:47:41','2026-03-11 07:47:41'),(65,7,'create_sale_from_order','Sale',25,NULL,'{\"order_id\":53,\"invoice_number\":\"INV-20260311-0008\"}','127.0.0.1','Sale created from Order #ORD-20260311-N4ZJUX','2026-03-11 07:49:20','2026-03-11 07:49:20'),(66,7,'update_order_status','Order',53,'{\"status\":\"pending\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from pending to completed','2026-03-11 07:49:20','2026-03-11 07:49:20'),(67,7,'create_sale_from_order','Sale',26,NULL,'{\"order_id\":54,\"invoice_number\":\"INV-20260311-0009\"}','127.0.0.1','Sale created from Order #ORD-20260311-IPCXP2','2026-03-11 07:54:45','2026-03-11 07:54:45'),(68,7,'update_order_status','Order',54,'{\"status\":\"pending\"}','{\"status\":\"completed\"}','127.0.0.1','Order status changed from pending to completed','2026-03-11 07:54:45','2026-03-11 07:54:45'),(69,12,'login','User',12,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-11 08:55:35','2026-03-11 08:55:35'),(70,12,'login','User',12,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-11 09:23:02','2026-03-11 09:23:02'),(71,12,'login','User',12,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-11 09:34:06','2026-03-11 09:34:06'),(72,12,'login','User',12,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-11 09:37:48','2026-03-11 09:37:48'),(73,12,'login','User',12,NULL,NULL,'127.0.0.1','User logged in successfully','2026-03-11 09:40:45','2026-03-11 09:40:45'),(74,1,'create_sale_from_order','Sale',31,NULL,'{\"order_id\":76,\"invoice_number\":\"INV-20260311-0010\"}','127.0.0.1','Sale created from Order #ORD-20260311-E9HOFO via Chapa payment','2026-03-11 09:47:00','2026-03-11 09:47:00'),(75,1,'create_sale_from_order','Sale',32,NULL,'{\"order_id\":75,\"invoice_number\":\"INV-20260311-0011\"}','127.0.0.1','Sale created from Order #ORD-20260311-PMCT0P via Chapa payment','2026-03-11 09:48:37','2026-03-11 09:48:37'),(76,12,'create_sale_from_order','Sale',33,NULL,'{\"order_id\":78,\"invoice_number\":\"INV-20260311-0012\"}','127.0.0.1','Sale created from Order #ORD-20260311-CT8AZC via Chapa payment','2026-03-11 09:50:46','2026-03-11 09:50:46');
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
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
INSERT INTO `cache` VALUES ('1fd8e4cfeb25c473c174cced2fcfdfb7','i:1;',1773233518),('1fd8e4cfeb25c473c174cced2fcfdfb7:timer','i:1773233518;',1773233518),('21c7ea48997eeecf541f9afb4a8bfc81','i:1;',1773216075),('21c7ea48997eeecf541f9afb4a8bfc81:timer','i:1773216075;',1773216075),('5c785c036466adea360111aa28563bfd556b5fba','i:1;',1773232904),('5c785c036466adea360111aa28563bfd556b5fba:timer','i:1773232904;',1773232904),('7c2150d7106073168321f39ec452420d','i:4;',1773212831),('7c2150d7106073168321f39ec452420d:timer','i:1773212831;',1773212831),('a75f3f172bfb296f2e10cbfc6dfc1883','i:4;',1773233457),('a75f3f172bfb296f2e10cbfc6dfc1883:timer','i:1773233457;',1773233457),('b37e2b0b86a8368405df02e0b66d0b39','i:1;',1773231784),('b37e2b0b86a8368405df02e0b66d0b39:timer','i:1773231784;',1773231784),('e9b6cc1432541b9ceebf113eee05eeba','i:2;',1773226684),('e9b6cc1432541b9ceebf113eee05eeba:timer','i:1773226684;',1773226684),('order_analytics:all','a:3:{s:7:\"pending\";i:35;s:10:\"processing\";i:0;s:9:\"completed\";i:14;}',1773218225);
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
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `scanned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cart_items_cart_id_product_id_unique` (`cart_id`,`product_id`),
  KEY `cart_items_product_id_index` (`product_id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `status` enum('active','abandoned','converted') NOT NULL DEFAULT 'active',
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_status_index` (`user_id`,`status`),
  KEY `carts_session_id_status_index` (`session_id`,`status`),
  KEY `carts_session_id_index` (`session_id`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `default_reorder_level` int(11) NOT NULL DEFAULT 10,
  `default_lead_time` int(11) NOT NULL DEFAULT 7,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Food & Beverages','Food items and drinks',10,7,'2026-03-09 18:00:55','2026-03-09 18:00:55'),(2,'Electronics','Electronic devices and accessories',10,7,'2026-03-09 18:00:55','2026-03-09 18:00:55'),(3,'Clothing','Clothes and fashion items',10,7,'2026-03-09 18:00:55','2026-03-09 18:00:55'),(4,'Household','Home and cleaning supplies',10,7,'2026-03-09 18:00:55','2026-03-09 18:00:55'),(5,'Stationery','Office and school supplies',10,7,'2026-03-09 18:00:55','2026-03-09 18:00:55'),(6,'Cosmetics','Beauty and personal care products',10,7,'2026-03-09 18:00:55','2026-03-09 18:00:55'),(7,'no catalogable','Another',10,7,'2026-03-09 20:29:54','2026-03-10 16:43:20');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `credit_limit` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Almaz Tadesse','almaz@email.com','+251911234567','Kombolcha, Zone 1',NULL,'2026-03-09 18:00:55','2026-03-09 18:00:55'),(2,'Bekele Girma','bekele@email.com','+251922345678','Kombolcha, Kebele 02',NULL,'2026-03-09 18:00:55','2026-03-09 18:00:55'),(3,'Chaltu Mohammed','chaltu@email.com','+251933456789','Dessie Road, Kombolcha',NULL,'2026-03-09 18:00:55','2026-03-09 18:00:55'),(4,'Daniel Assefa','daniel@email.com','+251944567890','Industrial Area, Kombolcha',NULL,'2026-03-09 18:00:55','2026-03-09 18:00:55'),(5,'Eyerusalem Hailu','eyerusalem@email.com','+251955678901','Main Street, Kombolcha',NULL,'2026-03-09 18:00:55','2026-03-09 18:00:55'),(6,'Fikadu Worku','fikadu@email.com','+251966789012','Market Area, Kombolcha',NULL,'2026-03-09 18:00:55','2026-03-09 18:00:55'),(7,'Genet Tesfaye','genet@email.com','+251977890123','Bus Station Area, Kombolcha',NULL,'2026-03-09 18:00:55','2026-03-09 18:00:55'),(8,'Wonde IT','admin@example.com','+251987654321','No address provided',NULL,'2026-03-09 18:07:29','2026-03-10 10:56:30'),(9,'wonde','teme23253@gmail.com','+251930000232','ADDIS ABABA',NULL,'2026-03-09 19:39:08','2026-03-10 17:06:49'),(10,'IT 3RD YEAR','lijself@gmail.com','+251987654346','No address provided',NULL,'2026-03-10 10:40:05','2026-03-11 09:50:33'),(11,'Tigist Haile','semredemssie83@gmail.com','+251953001117','Amhara\nPada',NULL,'2026-03-11 07:48:43','2026-03-11 07:53:41');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_summaries`
--

DROP TABLE IF EXISTS `daily_summaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `daily_summaries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `summary_date` date NOT NULL,
  `total_sales` decimal(14,2) NOT NULL DEFAULT 0.00,
  `transaction_count` int(11) NOT NULL DEFAULT 0,
  `total_cost` decimal(14,2) NOT NULL DEFAULT 0.00,
  `gross_profit` decimal(14,2) NOT NULL DEFAULT 0.00,
  `cash_sales` decimal(14,2) NOT NULL DEFAULT 0.00,
  `credit_sales` decimal(14,2) NOT NULL DEFAULT 0.00,
  `products_sold` int(11) NOT NULL DEFAULT 0,
  `top_products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`top_products`)),
  `cashier_performance` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`cashier_performance`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `daily_summaries_summary_date_unique` (`summary_date`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_summaries`
--

LOCK TABLES `daily_summaries` WRITE;
/*!40000 ALTER TABLE `daily_summaries` DISABLE KEYS */;
INSERT INTO `daily_summaries` VALUES (1,'2026-03-10',16600.25,16,10506.00,6094.25,14127.75,977.50,23,'[{\"name\":\"Bluetooth Speaker\",\"qty\":\"8\",\"revenue\":\"9600.00\"},{\"name\":\"Power Bank 10000mAh\",\"qty\":\"2\",\"revenue\":\"1700.00\"},{\"name\":\"Children Shoes\",\"qty\":\"2\",\"revenue\":\"1300.00\"},{\"name\":\"Plastic Chairs\",\"qty\":\"1\",\"revenue\":\"450.00\"},{\"name\":\"A4 Paper Ream\",\"qty\":\"1\",\"revenue\":\"380.00\"}]','[{\"name\":\"wonde\",\"transactions\":15,\"total\":16433.5},{\"name\":\"Wonde IT\",\"transactions\":1,\"total\":166.75}]','2026-03-10 06:18:43','2026-03-10 17:46:12'),(2,'2026-03-11',4042.25,7,2668.00,1374.25,4042.25,0.00,14,'[{\"name\":\"A4 Paper Ream\",\"qty\":\"5\",\"revenue\":\"1900.00\"},{\"name\":\"Bluetooth Speaker\",\"qty\":\"1\",\"revenue\":\"1200.00\"},{\"name\":\"Body Lotion 400ml\",\"qty\":\"1\",\"revenue\":\"180.00\"},{\"name\":\"Laundry Detergent 1kg\",\"qty\":\"1\",\"revenue\":\"145.00\"},{\"name\":\"Ball Pen Blue\",\"qty\":\"6\",\"revenue\":\"90.00\"}]','[{\"name\":\"wonde\",\"transactions\":7,\"total\":4042.25}]','2026-03-11 05:36:21','2026-03-11 05:36:21');
/*!40000 ALTER TABLE `daily_summaries` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'0001_01_01_000003_create_personal_access_tokens_table',1),(5,'2024_01_01_000001_create_categories_table',1),(6,'2024_01_01_000002_create_products_table',1),(7,'2024_01_01_000003_create_sales_table',1),(8,'2024_01_01_000004_create_sale_items_table',1),(9,'2024_01_01_000005_create_customers_table',1),(10,'2024_01_01_000006_create_suppliers_table',1),(11,'2024_01_01_000007_create_orders_table',1),(12,'2024_01_01_000008_create_order_items_table',1),(13,'2024_01_01_000009_add_advanced_features',1),(14,'2024_01_01_000010_add_notes_to_sales_table',1),(15,'2024_01_01_000011_add_sale_id_to_orders_table',1),(16,'2026_03_05_223826_add_qr_code_to_products_table',1),(17,'2026_03_05_223829_create_carts_table',1),(18,'2026_03_05_223836_create_payments_table',1),(19,'2026_03_06_000001_add_email_verification_to_users',1),(20,'2026_03_06_000002_add_is_active_to_users',1),(21,'2026_03_07_000001_add_chapa_fields_to_payments_table',1),(22,'2026_03_09_172718_add_payment_status_and_user_id_to_orders_table',1),(23,'2026_03_10_094750_add_language_to_users_table',2),(24,'2026_03_11_000001_make_user_id_nullable_in_sales_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,12,2,1200.00,2400.00,'2026-03-09 18:07:29','2026-03-09 18:07:29'),(2,2,24,1,15.00,15.00,'2026-03-09 18:07:50','2026-03-09 18:07:50'),(3,4,12,1,1200.00,1200.00,'2026-03-09 18:33:05','2026-03-09 18:33:05'),(4,5,12,1,1200.00,1200.00,'2026-03-09 18:40:48','2026-03-09 18:40:48'),(5,7,12,2,1200.00,2400.00,'2026-03-09 19:08:48','2026-03-09 19:08:48'),(6,8,12,2,1200.00,2400.00,'2026-03-09 19:13:21','2026-03-09 19:13:21'),(7,9,28,1,180.00,180.00,'2026-03-09 19:39:08','2026-03-09 19:39:08'),(8,10,28,1,180.00,180.00,'2026-03-09 19:43:56','2026-03-09 19:43:56'),(9,10,12,1,1200.00,1200.00,'2026-03-09 19:43:56','2026-03-09 19:43:56'),(10,11,19,1,85.00,85.00,'2026-03-09 19:46:54','2026-03-09 19:46:54'),(11,12,24,1,15.00,15.00,'2026-03-09 20:23:37','2026-03-09 20:23:37'),(12,13,12,1,1200.00,1200.00,'2026-03-10 02:51:30','2026-03-10 02:51:30'),(13,14,12,1,1200.00,1200.00,'2026-03-10 03:37:42','2026-03-10 03:37:42'),(14,15,12,1,1200.00,1200.00,'2026-03-10 04:51:18','2026-03-10 04:51:18'),(15,16,21,1,145.00,145.00,'2026-03-10 10:40:05','2026-03-10 10:40:05'),(16,17,24,1,15.00,15.00,'2026-03-10 10:56:30','2026-03-10 10:56:30'),(17,18,26,1,380.00,380.00,'2026-03-10 15:00:26','2026-03-10 15:00:26'),(18,18,24,1,15.00,15.00,'2026-03-10 15:00:26','2026-03-10 15:00:26'),(19,19,4,1,180.00,180.00,'2026-03-10 15:09:13','2026-03-10 15:09:13'),(20,20,4,1,180.00,180.00,'2026-03-10 15:10:06','2026-03-10 15:10:06'),(21,20,5,2,320.00,640.00,'2026-03-10 15:10:06','2026-03-10 15:10:06'),(22,21,21,1,145.00,145.00,'2026-03-10 15:10:47','2026-03-10 15:10:47'),(23,22,26,1,380.00,380.00,'2026-03-10 15:11:15','2026-03-10 15:11:15'),(24,23,24,1,15.00,15.00,'2026-03-10 15:57:26','2026-03-10 15:57:26'),(25,24,21,1,145.00,145.00,'2026-03-10 16:05:55','2026-03-10 16:05:55'),(26,24,26,1,380.00,380.00,'2026-03-10 16:05:55','2026-03-10 16:05:55'),(27,25,21,1,145.00,145.00,'2026-03-10 16:09:30','2026-03-10 16:09:30'),(28,25,26,1,380.00,380.00,'2026-03-10 16:09:30','2026-03-10 16:09:30'),(29,26,24,1,15.00,15.00,'2026-03-10 16:50:59','2026-03-10 16:50:59'),(30,27,24,1,15.00,15.00,'2026-03-10 16:53:32','2026-03-10 16:53:32'),(31,28,21,1,145.00,145.00,'2026-03-10 16:56:57','2026-03-10 16:56:57'),(32,28,26,1,380.00,380.00,'2026-03-10 16:56:57','2026-03-10 16:56:57'),(33,29,21,1,145.00,145.00,'2026-03-10 16:59:06','2026-03-10 16:59:06'),(34,29,26,1,380.00,380.00,'2026-03-10 16:59:06','2026-03-10 16:59:06'),(35,30,24,2,15.00,30.00,'2026-03-10 17:01:28','2026-03-10 17:01:28'),(36,31,21,1,145.00,145.00,'2026-03-10 17:06:49','2026-03-10 17:06:49'),(37,31,26,1,380.00,380.00,'2026-03-10 17:06:49','2026-03-10 17:06:49'),(38,32,21,1,145.00,145.00,'2026-03-10 17:09:18','2026-03-10 17:09:18'),(39,32,26,2,380.00,760.00,'2026-03-10 17:09:18','2026-03-10 17:09:18'),(40,33,28,1,180.00,180.00,'2026-03-10 17:45:07','2026-03-10 17:45:07'),(41,34,24,1,15.00,15.00,'2026-03-10 17:49:46','2026-03-10 17:49:46'),(42,35,28,1,180.00,180.00,'2026-03-11 02:40:10','2026-03-11 02:40:10'),(43,36,24,1,15.00,15.00,'2026-03-11 02:40:25','2026-03-11 02:40:25'),(44,37,24,1,15.00,15.00,'2026-03-11 02:54:52','2026-03-11 02:54:52'),(45,38,24,1,15.00,15.00,'2026-03-11 02:58:55','2026-03-11 02:58:55'),(46,39,26,1,380.00,380.00,'2026-03-11 03:03:24','2026-03-11 03:03:24'),(47,40,24,2,15.00,30.00,'2026-03-11 03:05:43','2026-03-11 03:05:43'),(48,41,24,2,15.00,30.00,'2026-03-11 03:09:33','2026-03-11 03:09:33'),(49,41,28,1,180.00,180.00,'2026-03-11 03:09:33','2026-03-11 03:09:33'),(50,42,24,2,15.00,30.00,'2026-03-11 03:12:03','2026-03-11 03:12:03'),(51,42,28,1,180.00,180.00,'2026-03-11 03:12:03','2026-03-11 03:12:03'),(52,43,24,1,15.00,15.00,'2026-03-11 03:15:27','2026-03-11 03:15:27'),(53,44,28,1,180.00,180.00,'2026-03-11 03:23:42','2026-03-11 03:23:42'),(54,45,26,1,380.00,380.00,'2026-03-11 03:26:59','2026-03-11 03:26:59'),(55,46,24,1,15.00,15.00,'2026-03-11 03:30:37','2026-03-11 03:30:37'),(56,47,12,1,1200.00,1200.00,'2026-03-11 03:34:40','2026-03-11 03:34:40'),(57,48,26,1,380.00,380.00,'2026-03-11 03:39:55','2026-03-11 03:39:55'),(58,49,24,1,15.00,15.00,'2026-03-11 03:45:17','2026-03-11 03:45:17'),(59,50,24,1,15.00,15.00,'2026-03-11 03:46:34','2026-03-11 03:46:34'),(60,51,26,2,380.00,760.00,'2026-03-11 05:22:07','2026-03-11 05:22:07'),(61,51,24,4,15.00,60.00,'2026-03-11 05:22:07','2026-03-11 05:22:07'),(62,52,26,2,380.00,760.00,'2026-03-11 05:22:52','2026-03-11 05:22:52'),(63,52,24,4,15.00,60.00,'2026-03-11 05:22:52','2026-03-11 05:22:52'),(64,53,5,1,320.00,320.00,'2026-03-11 07:48:43','2026-03-11 07:48:43'),(65,53,4,1,180.00,180.00,'2026-03-11 07:48:43','2026-03-11 07:48:43'),(66,54,26,1,380.00,380.00,'2026-03-11 07:53:41','2026-03-11 07:53:41'),(67,55,26,1,380.00,380.00,'2026-03-11 07:56:04','2026-03-11 07:56:04'),(68,55,12,2,1200.00,2400.00,'2026-03-11 07:56:04','2026-03-11 07:56:04'),(69,56,4,1,180.00,180.00,'2026-03-11 07:57:19','2026-03-11 07:57:19'),(70,56,24,1,15.00,15.00,'2026-03-11 07:57:19','2026-03-11 07:57:19'),(71,57,4,1,180.00,180.00,'2026-03-11 08:05:20','2026-03-11 08:05:20'),(72,57,24,1,15.00,15.00,'2026-03-11 08:05:20','2026-03-11 08:05:20'),(73,58,12,1,1200.00,1200.00,'2026-03-11 08:05:39','2026-03-11 08:05:39'),(74,59,12,2,1200.00,2400.00,'2026-03-11 08:30:07','2026-03-11 08:30:07'),(75,60,12,2,1200.00,2400.00,'2026-03-11 08:34:40','2026-03-11 08:34:40'),(76,60,28,1,180.00,180.00,'2026-03-11 08:34:40','2026-03-11 08:34:40'),(77,61,12,2,1200.00,2400.00,'2026-03-11 08:36:46','2026-03-11 08:36:46'),(78,61,28,1,180.00,180.00,'2026-03-11 08:36:46','2026-03-11 08:36:46'),(79,62,12,1,1200.00,1200.00,'2026-03-11 08:57:23','2026-03-11 08:57:23'),(80,63,12,1,1200.00,1200.00,'2026-03-11 08:58:06','2026-03-11 08:58:06'),(81,64,12,1,1200.00,1200.00,'2026-03-11 09:01:01','2026-03-11 09:01:01'),(82,64,4,1,180.00,180.00,'2026-03-11 09:01:01','2026-03-11 09:01:01'),(83,65,28,1,180.00,180.00,'2026-03-11 09:12:02','2026-03-11 09:12:02'),(84,66,26,1,380.00,380.00,'2026-03-11 09:23:25','2026-03-11 09:23:25'),(85,67,26,1,380.00,380.00,'2026-03-11 09:23:49','2026-03-11 09:23:49'),(86,68,26,1,380.00,380.00,'2026-03-11 09:23:57','2026-03-11 09:23:57'),(87,69,26,1,380.00,380.00,'2026-03-11 09:24:36','2026-03-11 09:24:36'),(88,70,26,1,380.00,380.00,'2026-03-11 09:28:10','2026-03-11 09:28:10'),(89,71,26,1,380.00,380.00,'2026-03-11 09:28:43','2026-03-11 09:28:43'),(90,72,26,1,380.00,380.00,'2026-03-11 09:29:37','2026-03-11 09:29:37'),(91,73,19,1,85.00,85.00,'2026-03-11 09:31:48','2026-03-11 09:31:48'),(92,74,24,2,15.00,30.00,'2026-03-11 09:34:32','2026-03-11 09:34:32'),(93,75,24,2,15.00,30.00,'2026-03-11 09:38:14','2026-03-11 09:38:14'),(94,76,24,2,15.00,30.00,'2026-03-11 09:41:30','2026-03-11 09:41:30'),(95,77,24,1,15.00,15.00,'2026-03-11 09:50:10','2026-03-11 09:50:10'),(96,78,28,1,180.00,180.00,'2026-03-11 09:50:33','2026-03-11 09:50:33');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `order_number` varchar(255) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `sale_id` bigint(20) unsigned DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  KEY `orders_sale_id_foreign` (`sale_id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,8,NULL,'ORD-20260309-IQXZSP',2400.00,360.00,0.00,2760.00,'pending','pending',NULL,NULL,'2026-03-09 18:07:29','2026-03-09 18:07:29'),(2,8,NULL,'ORD-20260309-DM18Z2',15.00,2.25,0.00,17.25,'pending','pending',NULL,NULL,'2026-03-09 18:07:50','2026-03-09 18:07:50'),(4,8,NULL,'ORD-20260309-LGVTJO',1200.00,180.00,0.00,1380.00,'pending','pending',NULL,NULL,'2026-03-09 18:33:05','2026-03-09 18:33:05'),(5,8,NULL,'ORD-20260309-LCIWIR',1200.00,180.00,0.00,1380.00,'pending','pending',NULL,'No address provided','2026-03-09 18:40:48','2026-03-09 18:40:48'),(7,8,NULL,'ORD-20260309-9REUXE',2400.00,360.00,0.00,2760.00,'pending','pending',NULL,'No address provided','2026-03-09 19:08:48','2026-03-09 19:08:48'),(8,8,NULL,'ORD-20260309-XTK0YF',2400.00,360.00,0.00,2760.00,'completed','pending',7,'No address provided','2026-03-09 19:13:21','2026-03-10 14:08:36'),(9,9,NULL,'ORD-20260309-FXNJR2',180.00,27.00,0.00,207.00,'pending','pending',NULL,'No address provided','2026-03-09 19:39:08','2026-03-09 19:39:08'),(10,9,NULL,'ORD-20260309-PPQUOO',1380.00,207.00,0.00,1587.00,'pending','pending',NULL,'No address provided','2026-03-09 19:43:56','2026-03-09 19:43:56'),(11,9,NULL,'ORD-20260309-6HGWPO',85.00,12.75,0.00,97.75,'pending','pending',NULL,'admin@example.com','2026-03-09 19:46:54','2026-03-09 19:46:54'),(12,9,NULL,'ORD-20260309-XGNKEV',15.00,2.25,0.00,17.25,'completed','pending',6,'No address provided','2026-03-09 20:23:37','2026-03-10 14:08:16'),(13,9,NULL,'ORD-20260310-99ZBK3',1200.00,180.00,0.00,1380.00,'pending','pending',NULL,'No address provided','2026-03-10 02:51:30','2026-03-10 02:51:30'),(14,9,NULL,'ORD-20260310-N7MLJT',1200.00,180.00,0.00,1380.00,'pending','pending',NULL,'No address provided','2026-03-10 03:37:42','2026-03-10 03:37:42'),(15,9,NULL,'ORD-20260310-LZ84CX',1200.00,180.00,0.00,1380.00,'completed','pending',5,'No address provided','2026-03-10 04:51:18','2026-03-10 14:08:06'),(16,10,NULL,'ORD-20260310-RKNRGR',145.00,21.75,0.00,166.75,'completed','pending',4,'No address provided','2026-03-10 10:40:05','2026-03-10 10:44:42'),(17,8,NULL,'ORD-20260310-GGJTBO',15.00,2.25,0.00,17.25,'pending','pending',NULL,'No address provided','2026-03-10 10:56:30','2026-03-10 10:56:30'),(18,9,NULL,'ORD-20260310-BA3JYS',395.00,59.25,0.00,454.25,'pending','pending',NULL,'Amhara\nPada','2026-03-10 15:00:26','2026-03-10 15:00:26'),(19,9,NULL,'ORD-20260310-MW4PYL',180.00,27.00,0.00,207.00,'pending','pending',NULL,'ADDIS ABABA','2026-03-10 15:09:13','2026-03-10 15:09:13'),(20,9,NULL,'ORD-20260310-FKVPGM',820.00,123.00,0.00,943.00,'pending','pending',NULL,'ADDIS ABABA','2026-03-10 15:10:06','2026-03-10 15:10:06'),(21,9,NULL,'ORD-20260310-LCAUOL',145.00,21.75,0.00,166.75,'completed','pending',14,'ADDIS ABABA','2026-03-10 15:10:47','2026-03-10 15:11:57'),(22,9,NULL,'ORD-20260310-7BCHUB',380.00,57.00,0.00,437.00,'completed','pending',13,'Amhara\nPada','2026-03-10 15:11:15','2026-03-10 15:11:51'),(23,9,NULL,'ORD-20260310-SLCE44',15.00,2.25,0.00,17.25,'pending','pending',NULL,'No address provided','2026-03-10 15:57:26','2026-03-10 15:57:26'),(24,9,NULL,'ORD-20260310-HTGOT4',525.00,78.75,0.00,603.75,'pending','pending',NULL,'ADDIS ABABA','2026-03-10 16:05:55','2026-03-10 16:05:55'),(25,9,NULL,'ORD-20260310-FRI8WK',525.00,78.75,0.00,603.75,'pending','pending',NULL,'ADDIS ABABA','2026-03-10 16:09:30','2026-03-10 16:09:30'),(26,9,NULL,'ORD-20260310-1196MO',15.00,2.25,0.00,17.25,'pending','pending',NULL,'No address provided','2026-03-10 16:50:59','2026-03-10 16:50:59'),(27,9,NULL,'ORD-20260310-AIRINN',15.00,2.25,0.00,17.25,'pending','pending',NULL,'No address provided','2026-03-10 16:53:32','2026-03-10 16:53:32'),(28,9,NULL,'ORD-20260310-USRKOH',525.00,78.75,0.00,603.75,'pending','pending',NULL,'No address provided','2026-03-10 16:56:57','2026-03-10 16:56:57'),(29,9,NULL,'ORD-20260310-NQ3PNI',525.00,78.75,0.00,603.75,'pending','pending',NULL,'No address provided','2026-03-10 16:59:06','2026-03-10 16:59:06'),(30,9,NULL,'ORD-20260310-Q7IOPD',30.00,4.50,0.00,34.50,'cancelled','pending',NULL,NULL,'2026-03-10 17:01:28','2026-03-10 17:02:36'),(31,9,NULL,'ORD-20260310-2ITASJ',525.00,78.75,0.00,603.75,'pending','pending',NULL,'ADDIS ABABA','2026-03-10 17:06:49','2026-03-10 17:06:49'),(32,9,NULL,'ORD-20260310-9EEKRR',905.00,135.75,0.00,1040.75,'completed','pending',20,'ADDIS ABABA','2026-03-10 17:09:18','2026-03-11 03:31:58'),(33,9,NULL,'ORD-20260310-KUJQSD',180.00,27.00,0.00,207.00,'completed','pending',17,'ADDIS ABABA','2026-03-10 17:45:07','2026-03-10 17:45:41'),(34,9,NULL,'ORD-20260310-B60AD4',15.00,2.25,0.00,17.25,'pending','pending',NULL,NULL,'2026-03-10 17:49:46','2026-03-10 17:49:46'),(35,9,NULL,'ORD-20260311-HCLDN1',180.00,27.00,0.00,207.00,'pending','pending',NULL,'ADDIS ABABA','2026-03-11 02:40:10','2026-03-11 02:40:10'),(36,9,NULL,'ORD-20260311-MCCO1P',15.00,2.25,0.00,17.25,'pending','pending',NULL,'ADDIS ABABA','2026-03-11 02:40:25','2026-03-11 02:40:25'),(37,9,NULL,'ORD-20260311-0NQSYO',15.00,2.25,0.00,17.25,'pending','pending',NULL,'ADDIS ABABA','2026-03-11 02:54:52','2026-03-11 02:54:52'),(38,9,NULL,'ORD-20260311-D3VFYZ',15.00,2.25,0.00,17.25,'pending','pending',NULL,'ADDIS ABABA','2026-03-11 02:58:55','2026-03-11 02:58:55'),(39,9,NULL,'ORD-20260311-Z1I0SW',380.00,57.00,0.00,437.00,'pending','pending',NULL,NULL,'2026-03-11 03:03:24','2026-03-11 03:03:24'),(40,9,NULL,'ORD-20260311-N3XJFH',30.00,4.50,0.00,34.50,'pending','pending',NULL,'ADDIS ABABA','2026-03-11 03:05:43','2026-03-11 03:05:43'),(41,9,NULL,'ORD-20260311-ZI0DPW',210.00,31.50,0.00,241.50,'pending','pending',NULL,'ADDIS ABABA','2026-03-11 03:09:33','2026-03-11 03:09:33'),(42,9,NULL,'ORD-20260311-8TTH95',210.00,31.50,0.00,241.50,'pending','pending',NULL,'ADDIS ABABA','2026-03-11 03:12:03','2026-03-11 03:12:03'),(43,9,NULL,'ORD-20260311-FM87VT',15.00,2.25,0.00,17.25,'pending','pending',NULL,'omman','2026-03-11 03:15:27','2026-03-11 03:15:27'),(44,9,NULL,'ORD-20260311-TX7NRD',180.00,27.00,0.00,207.00,'completed','pending',18,NULL,'2026-03-11 03:23:42','2026-03-11 03:31:15'),(45,10,NULL,'ORD-20260311-YNNSKF',380.00,57.00,0.00,437.00,'completed','pending',19,NULL,'2026-03-11 03:26:59','2026-03-11 03:31:44'),(46,10,NULL,'ORD-20260311-CFU6QH',15.00,2.25,0.00,17.25,'completed','pending',21,NULL,'2026-03-11 03:30:37','2026-03-11 03:32:16'),(47,10,NULL,'ORD-20260311-0GQNS5',1200.00,180.00,0.00,1380.00,'completed','pending',22,'No address provided','2026-03-11 03:34:40','2026-03-11 03:36:44'),(48,10,NULL,'ORD-20260311-HNXEXO',380.00,57.00,0.00,437.00,'pending','pending',NULL,NULL,'2026-03-11 03:39:55','2026-03-11 03:39:55'),(49,10,NULL,'ORD-20260311-EKNVJ6',15.00,2.25,0.00,17.25,'pending','pending',NULL,NULL,'2026-03-11 03:45:17','2026-03-11 03:45:17'),(50,10,NULL,'ORD-20260311-AXKXOZ',15.00,2.25,0.00,17.25,'completed','pending',23,'hvgvhg','2026-03-11 03:46:34','2026-03-11 03:47:26'),(51,10,NULL,'ORD-20260311-8WHFXW',820.00,123.00,0.00,943.00,'pending','pending',NULL,NULL,'2026-03-11 05:22:07','2026-03-11 05:22:07'),(52,10,NULL,'ORD-20260311-D5LE7H',820.00,123.00,0.00,943.00,'completed','pending',24,NULL,'2026-03-11 05:22:52','2026-03-11 05:23:55'),(53,11,NULL,'ORD-20260311-N4ZJUX',500.00,75.00,0.00,575.00,'completed','pending',25,'Amhara\nPada','2026-03-11 07:48:43','2026-03-11 07:49:20'),(54,11,NULL,'ORD-20260311-IPCXP2',380.00,57.00,0.00,437.00,'completed','pending',26,'Amhara\nPada','2026-03-11 07:53:41','2026-03-11 07:54:45'),(55,11,NULL,'ORD-20260311-THHDTM',2780.00,417.00,0.00,3197.00,'pending','pending',NULL,'Amhara\nPada','2026-03-11 07:56:04','2026-03-11 07:56:04'),(56,9,NULL,'ORD-20260311-EI3PPB',195.00,29.25,0.00,224.25,'pending','pending',NULL,'ADDIS ABABA','2026-03-11 07:57:19','2026-03-11 07:57:19'),(57,9,NULL,'ORD-20260311-5YMB0G',195.00,29.25,0.00,224.25,'pending','pending',NULL,'ADDIS ABABA','2026-03-11 08:05:20','2026-03-11 08:05:20'),(58,9,NULL,'ORD-20260311-MTYMJL',1200.00,180.00,0.00,1380.00,'pending','pending',NULL,'ADDIS ABABA','2026-03-11 08:05:39','2026-03-11 08:05:39'),(59,9,NULL,'ORD-20260311-5AXQY3',2400.00,360.00,0.00,2760.00,'pending','pending',NULL,'ADDIS ABABA','2026-03-11 08:30:07','2026-03-11 08:30:07'),(60,9,NULL,'ORD-20260311-RKXJGP',2580.00,387.00,0.00,2967.00,'pending','pending',NULL,'ADDIS ABABA','2026-03-11 08:34:40','2026-03-11 08:34:40'),(61,9,NULL,'ORD-20260311-OLXCOU',2580.00,387.00,0.00,2967.00,'pending','pending',NULL,'ADDIS ABABA','2026-03-11 08:36:45','2026-03-11 08:36:45'),(62,10,NULL,'ORD-20260311-ZRLCEO',1200.00,180.00,0.00,1380.00,'processing','pending',NULL,'No address provided','2026-03-11 08:57:23','2026-03-11 08:57:23'),(63,10,NULL,'ORD-20260311-RSJOKU',1200.00,180.00,0.00,1380.00,'processing','pending',NULL,'No address provided','2026-03-11 08:58:06','2026-03-11 08:58:06'),(64,10,NULL,'ORD-20260311-SJ8ZMP',1380.00,207.00,0.00,1587.00,'processing','pending',NULL,'No address provided','2026-03-11 09:01:01','2026-03-11 09:01:01'),(65,9,NULL,'ORD-20260311-DZARBA',180.00,27.00,0.00,207.00,'processing','pending',NULL,'ADDIS ABABA','2026-03-11 09:12:02','2026-03-11 09:12:02'),(66,10,NULL,'ORD-20260311-T6UNQ9',380.00,57.00,0.00,437.00,'pending','pending',NULL,NULL,'2026-03-11 09:23:25','2026-03-11 09:23:25'),(67,10,NULL,'ORD-20260311-UUYFRQ',380.00,57.00,0.00,437.00,'processing','pending',NULL,'No address provided','2026-03-11 09:23:49','2026-03-11 09:23:49'),(68,10,NULL,'ORD-20260311-9NQV91',380.00,57.00,0.00,437.00,'processing','pending',NULL,'No address provided','2026-03-11 09:23:57','2026-03-11 09:23:57'),(69,10,NULL,'ORD-20260311-LEL4ON',380.00,57.00,0.00,437.00,'processing','pending',NULL,'No address provided','2026-03-11 09:24:36','2026-03-11 09:24:36'),(70,10,NULL,'ORD-20260311-LNJZD6',380.00,57.00,0.00,437.00,'pending','pending',NULL,NULL,'2026-03-11 09:28:10','2026-03-11 09:28:10'),(71,10,NULL,'ORD-20260311-XJN2LP',380.00,57.00,0.00,437.00,'processing','pending',NULL,'No address provided','2026-03-11 09:28:43','2026-03-11 09:28:43'),(72,10,NULL,'ORD-20260311-ZE6AQO',380.00,57.00,0.00,437.00,'processing','pending',NULL,'No address provided','2026-03-11 09:29:37','2026-03-11 09:29:37'),(73,10,NULL,'ORD-20260311-UEYMBS',85.00,12.75,0.00,97.75,'processing','pending',NULL,'No address provided','2026-03-11 09:31:48','2026-03-11 09:31:48'),(74,10,NULL,'ORD-20260311-PMXNGS',30.00,4.50,0.00,34.50,'processing','pending',NULL,'No address provided','2026-03-11 09:34:32','2026-03-11 09:34:32'),(75,10,NULL,'ORD-20260311-PMCT0P',30.00,4.50,0.00,34.50,'completed','paid',32,'No address provided','2026-03-11 09:38:14','2026-03-11 09:48:37'),(76,10,NULL,'ORD-20260311-E9HOFO',30.00,4.50,0.00,34.50,'completed','paid',31,'No address provided','2026-03-11 09:41:30','2026-03-11 09:47:00'),(77,10,NULL,'ORD-20260311-HKVBKF',15.00,2.25,0.00,17.25,'pending','pending',NULL,NULL,'2026-03-11 09:50:10','2026-03-11 09:50:10'),(78,10,NULL,'ORD-20260311-CT8AZC',180.00,27.00,0.00,207.00,'completed','paid',33,'No address provided','2026-03-11 09:50:33','2026-03-11 09:50:46');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
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
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `gateway` varchar(255) NOT NULL DEFAULT 'chapa',
  `payment_method` enum('cash','card','mobile_money','wallet','bank_transfer') NOT NULL DEFAULT 'cash',
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'ETB',
  `status` enum('pending','processing','completed','failed','refunded','expired') NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) DEFAULT NULL,
  `checkout_url` text DEFAULT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `gateway_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gateway_response`)),
  `webhook_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`webhook_data`)),
  `failure_reason` text DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_transaction_id_unique` (`transaction_id`),
  KEY `payments_order_id_status_index` (`order_id`,`status`),
  KEY `payments_transaction_id_index` (`transaction_id`),
  KEY `payments_user_id_status_index` (`user_id`,`status`),
  KEY `payments_created_at_index` (`created_at`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,9,7,'chapa','cash',207.00,'ETB','pending','ORD-20260309-FXNJR2','https://checkout.chapa.co/checkout/payment/rNEyo6SKxcwdoR0xZ8bVK90KTrmwaco9RqoAj0DI0wwZm',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-09 20:09:11','2026-03-09 19:39:11','2026-03-09 19:39:11'),(2,10,7,'chapa','cash',1587.00,'ETB','pending','ORD-20260309-PPQUOO','https://checkout.chapa.co/checkout/payment/118jWNPfpr6ZXjJSupOQ3PxJimyJGlIoBhOyDfKZhf9aR',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-09 20:14:00','2026-03-09 19:44:00','2026-03-09 19:44:00'),(3,11,7,'chapa','cash',97.75,'ETB','pending','ORD-20260309-6HGWPO','https://checkout.chapa.co/checkout/payment/mpZRKZcGUTiepBZoRXLjBfWBf4tmm7N4FTk75EhOa2D1C',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-09 20:16:56','2026-03-09 19:46:56','2026-03-09 19:46:56'),(4,12,7,'chapa','cash',17.25,'ETB','pending','ORD-20260309-XGNKEV','https://checkout.chapa.co/checkout/payment/DCp38WVhzusFWEZR7b51MX2akNeLxVrktTJMNmsMaMzdE',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-09 20:53:39','2026-03-09 20:23:39','2026-03-09 20:23:39'),(5,13,7,'chapa','cash',1380.00,'ETB','pending','ORD-20260310-99ZBK3','https://checkout.chapa.co/checkout/payment/xn0gplh2XzJjDkqBy24p3JEnH05Uj3aSl6pcukkRPWCr5',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-10 03:21:31','2026-03-10 02:51:31','2026-03-10 02:51:31'),(6,14,7,'chapa','cash',1380.00,'ETB','pending','ORD-20260310-N7MLJT','https://checkout.chapa.co/checkout/payment/hdh0ItDTM3tJFBOc3yXfF3jdsV0iQYoNLbp11p8P26vct',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-10 04:07:45','2026-03-10 03:37:45','2026-03-10 03:37:45'),(7,15,7,'chapa','cash',1380.00,'ETB','pending','ORD-20260310-LZ84CX','https://checkout.chapa.co/checkout/payment/I95thzT8Lyx3im0m5ogwRwegtCrD8j1UcqJstvWpw0H57',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-10 05:21:20','2026-03-10 04:51:20','2026-03-10 04:51:20'),(9,19,7,'chapa','cash',207.00,'ETB','pending','ORD-20260310-MW4PYL','https://checkout.chapa.co/checkout/payment/mhGppnDuJ9RFoxcLNJuDDsLasTa2aYJv5RFMtRN7isuuP',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-10 15:39:15','2026-03-10 15:09:15','2026-03-10 15:09:15'),(10,20,7,'chapa','cash',943.00,'ETB','pending','ORD-20260310-FKVPGM','https://checkout.chapa.co/checkout/payment/DeZGpytR8HAmMg7oxq1Fpjy6tz6uHDd5oOP4QKKGYk1tY',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-10 15:40:07','2026-03-10 15:10:07','2026-03-10 15:10:07'),(11,21,7,'chapa','cash',166.75,'ETB','pending','ORD-20260310-LCAUOL','https://checkout.chapa.co/checkout/payment/zVnbxPEnqU73HnWvwf9lyeBYM9NhuG0FZo4IPoPT1Tl7m',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-10 15:40:49','2026-03-10 15:10:49','2026-03-10 15:10:49'),(12,23,7,'chapa','cash',17.25,'ETB','pending','ORD-20260310-SLCE44','https://checkout.chapa.co/checkout/payment/VZ6eaITcgW3k676UV9Ha1U12MNbTlaiweQxds9TTliGrV',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-10 16:27:28','2026-03-10 15:57:28','2026-03-10 15:57:28'),(13,24,7,'chapa','cash',603.75,'ETB','pending','ORD-20260310-HTGOT4','https://checkout.chapa.co/checkout/payment/dCbTlbSWOoePXMCYxK9MCTK770ax5pCswWTysStWdk9CS',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-10 16:35:58','2026-03-10 16:05:58','2026-03-10 16:05:58'),(14,25,7,'chapa','cash',603.75,'ETB','pending','ORD-20260310-FRI8WK','https://checkout.chapa.co/checkout/payment/tuUA8RSs4sZr1fMdqMvugcgcgqD6CdOCblvf37CsO67nn',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-10 16:39:33','2026-03-10 16:09:33','2026-03-10 16:09:33'),(15,26,7,'chapa','cash',17.25,'ETB','pending','ORD-20260310-1196MO','https://checkout.chapa.co/checkout/payment/TOQpXcUjg0nbdRVbPaiJZXxfYC9O5sTngT4W1EgMeuZPk',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-10 17:21:01','2026-03-10 16:51:01','2026-03-10 16:51:01'),(16,27,7,'chapa','cash',17.25,'ETB','pending','ORD-20260310-AIRINN','https://checkout.chapa.co/checkout/payment/kCSkxg714C4GZscn6suTstotUaD2DWX1zxA4ilP3o7Oz0',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-10 17:23:33','2026-03-10 16:53:33','2026-03-10 16:53:33'),(17,28,7,'chapa','cash',603.75,'ETB','pending','ORD-20260310-USRKOH','https://checkout.chapa.co/checkout/payment/GfctqY7M62YOeOy9CIYiiF3shbfosUs6RCVAlOg3NY4NE',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-10 17:26:58','2026-03-10 16:56:58','2026-03-10 16:56:58'),(18,29,7,'chapa','cash',603.75,'ETB','pending','ORD-20260310-NQ3PNI','https://checkout.chapa.co/checkout/payment/azDTXBF6UyQD0iL7G0vw66hE3CbRiVaJRpZIzjBElXXUt',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-10 17:29:07','2026-03-10 16:59:07','2026-03-10 16:59:07'),(19,36,7,'chapa','cash',17.25,'ETB','pending','ORD-20260311-MCCO1P','https://checkout.chapa.co/checkout/payment/yzbOMiQKMeu2PTDXqZRRsJb5R9rlH3S8rMw1VYezaYTps',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 03:10:27','2026-03-11 02:40:27','2026-03-11 02:40:27'),(20,37,7,'chapa','cash',17.25,'ETB','pending','ORD-20260311-0NQSYO','https://checkout.chapa.co/checkout/payment/DyZNm4UgRBI2ICzLi2eccFivQDl1qsS3HRJNkZjNnFIH1',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 03:24:53','2026-03-11 02:54:53','2026-03-11 02:54:53'),(21,38,7,'chapa','cash',17.25,'ETB','pending','ORD-20260311-D3VFYZ','https://checkout.chapa.co/checkout/payment/abEyT4uc4w7CTd2uhWwmPhBOl9GuPEGRK6mXVU1AQQ10t',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 03:28:57','2026-03-11 02:58:57','2026-03-11 02:58:57'),(22,40,7,'chapa','cash',34.50,'ETB','pending','ORD-20260311-N3XJFH','https://checkout.chapa.co/checkout/payment/zu06fJucPXzbPpoSUOoANJ03JC9yXa2HR7RCaMLtPyK0X',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 03:35:44','2026-03-11 03:05:44','2026-03-11 03:05:44'),(23,41,7,'chapa','cash',241.50,'ETB','pending','ORD-20260311-ZI0DPW','https://checkout.chapa.co/checkout/payment/fMxUpBHotnIPfa5MSkg3T1ghTnqbiaAh49cp8zQwq6vJf',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 03:39:35','2026-03-11 03:09:35','2026-03-11 03:09:35'),(24,42,7,'chapa','cash',241.50,'ETB','pending','ORD-20260311-8TTH95','https://checkout.chapa.co/checkout/payment/ACfqY6QhtaAAzo6MfaZ6yEL1X0s7uAIjaXC3kLIYtaQ9m',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 03:42:04','2026-03-11 03:12:04','2026-03-11 03:12:04'),(26,48,7,'chapa','cash',437.00,'ETB','pending','ORD-20260311-HNXEXO','https://checkout.chapa.co/checkout/payment/Ytpe04Pv97Ybzexwthuy7wAl0MlieZsHNkjfBesHZQvEH',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 04:12:51','2026-03-11 03:42:51','2026-03-11 03:42:51'),(27,51,12,'chapa','cash',943.00,'ETB','pending','ORD-20260311-8WHFXW','https://checkout.chapa.co/checkout/payment/R22mDP4g2CtVz61RiQFwhAfenpKVcerN6XOv61E0pauOL',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 05:52:08','2026-03-11 05:22:08','2026-03-11 05:22:08'),(28,54,2,'chapa','cash',437.00,'ETB','pending','ORD-20260311-IPCXP2','https://checkout.chapa.co/checkout/payment/KBuc83FSPsbdAAAHehCj38TeWCJ6w64xGsg2HeQlBoo5n',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 08:23:45','2026-03-11 07:53:45','2026-03-11 07:53:45'),(29,55,2,'chapa','cash',3197.00,'ETB','pending','ORD-20260311-THHDTM','https://checkout.chapa.co/checkout/payment/2RnhlAdnD9QcwkBdDeKIOPNUkdD0hQ5CDZQi2t4eUrtjn',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 08:26:08','2026-03-11 07:56:08','2026-03-11 07:56:08'),(30,56,7,'chapa','cash',224.25,'ETB','pending','ORD-20260311-EI3PPB','https://checkout.chapa.co/checkout/payment/mx8NhboaaXeJRsaUiQ3mmFOxoctHf6OInLAQfxVa07wIw',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 08:27:29','2026-03-11 07:57:29','2026-03-11 07:57:29'),(31,58,7,'chapa','cash',1380.00,'ETB','pending','ORD-20260311-MTYMJL','https://checkout.chapa.co/checkout/payment/ozKqcG5vkf46NZUUrkcX3UwKNY556P4QXoyOP5GvnG7ZX',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 08:35:42','2026-03-11 08:05:42','2026-03-11 08:05:42'),(32,59,7,'chapa','cash',2760.00,'ETB','pending','ORD-20260311-5AXQY3','https://checkout.chapa.co/checkout/payment/A5NfuzRuBhkSGZ2GCLTmN3d1MVp3eY00zyFBZOXDYqMFr',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 09:00:11','2026-03-11 08:30:11','2026-03-11 08:30:11'),(33,60,7,'chapa','cash',2967.00,'ETB','pending','ORD-20260311-RKXJGP','https://checkout.chapa.co/checkout/payment/XOz8Y5JQk7G3ISrEXXjc5jnh0wI3rIvzYVnrLDUFvJfv6',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 09:04:44','2026-03-11 08:34:44','2026-03-11 08:34:44'),(34,62,12,'chapa','cash',1380.00,'ETB','pending','ORD-20260311-ZRLCEO','https://checkout.chapa.co/checkout/payment/FoQdHV4Zxl51dlh0KZN6voblJVDvCM4iG1zGHIg3LRTRs',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 09:27:26','2026-03-11 08:57:26','2026-03-11 08:57:26'),(35,63,12,'chapa','cash',1380.00,'ETB','pending','ORD-20260311-RSJOKU','https://checkout.chapa.co/checkout/payment/pqDjyrsLhDfiTg676KeJnYYaDGkbEiGLZqIu6HbEVqPK8',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 09:28:10','2026-03-11 08:58:10','2026-03-11 08:58:10'),(36,64,12,'chapa','cash',1587.00,'ETB','pending','ORD-20260311-SJ8ZMP','https://checkout.chapa.co/checkout/payment/XbboG8LckNZK5ROGsSuCliM0pUIpk6kv8TTlSB30qVXZi',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 09:31:08','2026-03-11 09:01:08','2026-03-11 09:01:08'),(37,65,7,'chapa','cash',207.00,'ETB','pending','ORD-20260311-DZARBA','https://checkout.chapa.co/checkout/payment/czDIRkVFLG1wJZ2ljHSrM0nfumPzKND1dqyoOicusnlYV',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 09:42:11','2026-03-11 09:12:11','2026-03-11 09:12:11'),(38,67,12,'chapa','cash',437.00,'ETB','pending','ORD-20260311-UUYFRQ','https://checkout.chapa.co/checkout/payment/WQboSjdLKTuyknoUKx4ohviWVgk540liLr5kEVcu4RjwR',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 09:53:51','2026-03-11 09:23:51','2026-03-11 09:23:51'),(39,68,12,'chapa','cash',437.00,'ETB','pending','ORD-20260311-9NQV91','https://checkout.chapa.co/checkout/payment/f0jYHqKNhlSRVSHZ7M3PWMUlMjhSC1bnqHOs9jhmjS3ot',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 09:53:59','2026-03-11 09:23:59','2026-03-11 09:23:59'),(40,69,12,'chapa','cash',437.00,'ETB','pending','ORD-20260311-LEL4ON','https://checkout.chapa.co/checkout/payment/o4Ft6rs3rwmbqOj5CbQaRClPy0MRn2CdY69gYK09hlJVM',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 09:54:38','2026-03-11 09:24:38','2026-03-11 09:24:38'),(41,71,12,'chapa','cash',437.00,'ETB','pending','ORD-20260311-XJN2LP','https://checkout.chapa.co/checkout/payment/PwHwR5SORbmwpck6e1nCk97ndgtXML3QUSMd1td77i7se',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 09:58:45','2026-03-11 09:28:45','2026-03-11 09:28:45'),(42,72,12,'chapa','cash',437.00,'ETB','pending','ORD-20260311-ZE6AQO','https://checkout.chapa.co/checkout/payment/9h2MSLiISOH0xEAv3f4q6P0ItjvUHytu6Qh0h3Vh2Cr87',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 09:59:39','2026-03-11 09:29:39','2026-03-11 09:29:39'),(43,73,12,'chapa','cash',97.75,'ETB','pending','ORD-20260311-UEYMBS','https://checkout.chapa.co/checkout/payment/ANI2MNtkzhPDkkpC3O8dE6VZzM3Ffc8l1FLkGKUSFflkg',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 10:01:49','2026-03-11 09:31:49','2026-03-11 09:31:49'),(44,74,12,'chapa','cash',34.50,'ETB','pending','ORD-20260311-PMXNGS','https://checkout.chapa.co/checkout/payment/MzywEDdBAlmGs4XWqGy4ySMFVcBS62OKE3q81RhvvOsU8',NULL,NULL,NULL,NULL,NULL,NULL,'2026-03-11 10:04:34','2026-03-11 09:34:34','2026-03-11 09:34:34'),(45,75,12,'chapa','cash',34.50,'ETB','completed','ORD-20260311-PMCT0P','https://checkout.chapa.co/checkout/payment/gc4yX878eS8t7EBWcsynmS6K60gO4i3VtzfFrklUrksKP',NULL,NULL,NULL,NULL,NULL,'2026-03-11 09:48:37','2026-03-11 10:08:16','2026-03-11 09:38:16','2026-03-11 09:48:37'),(46,76,12,'chapa','cash',34.50,'ETB','completed','ORD-20260311-E9HOFO','https://checkout.chapa.co/checkout/payment/HqaBqehpQRR6JI2Q52ssicIrbCvMJMzGKz3k6kRIQ3HwK',NULL,NULL,NULL,NULL,NULL,'2026-03-11 09:43:46','2026-03-11 10:11:32','2026-03-11 09:41:32','2026-03-11 09:43:46'),(47,78,12,'chapa','cash',207.00,'ETB','completed','ORD-20260311-CT8AZC','https://checkout.chapa.co/checkout/payment/u3533LJBucE2weDVhdffhdvynpVGDcO5ZY1TD5h1usAKk',NULL,NULL,NULL,NULL,NULL,'2026-03-11 09:50:46','2026-03-11 10:20:36','2026-03-11 09:50:36','2026-03-11 09:50:46');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (2,'App\\Models\\User',7,'auth-token','7ea1f69390607a4e56b57ba7a45a95b9c4277a57f22dcbf51bac41ec819e006a','[\"*\"]','2026-03-09 19:44:37','2026-03-10 19:38:49','2026-03-09 19:38:49','2026-03-09 19:44:37'),(4,'App\\Models\\User',7,'auth-token','819f4a87e7e2f105066b9fadf68db3fb84a99b21bbd0d11af5513aa57aaa38d2','[\"*\"]','2026-03-09 19:48:02','2026-03-10 19:46:40','2026-03-09 19:46:40','2026-03-09 19:48:02'),(6,'App\\Models\\User',7,'auth-token','99b357c8767cdb66eebf1b6f332c08d5ab8fd8fad72218203b0ea462b98a084d','[\"*\"]','2026-03-09 20:24:05','2026-03-10 20:23:20','2026-03-09 20:23:20','2026-03-09 20:24:05'),(9,'App\\Models\\User',7,'auth-token','d8793dd42021aac6ad6ba25f8fb2401417b970ec4ebf95f4ce2f88d0f16d55d1','[\"*\"]','2026-03-10 08:26:36','2026-03-11 08:15:25','2026-03-10 08:15:25','2026-03-10 08:26:36'),(10,'App\\Models\\User',7,'auth-token','4ff449b28fca005aa723e4c9b192f5c980ae0df05cfd97d1f798abac5b95e131','[\"*\"]','2026-03-11 03:25:46','2026-03-11 08:28:19','2026-03-10 08:28:19','2026-03-11 03:25:46'),(12,'App\\Models\\User',1,'auth-token','568c7872f8db97e08f580ed19da44cc56762af47af7a61110a9a663783284da5','[\"*\"]','2026-03-11 03:57:16','2026-03-11 10:43:06','2026-03-10 10:43:06','2026-03-11 03:57:16'),(13,'App\\Models\\User',1,'auth-token','2bcfa0db8c6e410682acfe0b75b10dff20515d7e00870349845246c94e4008c4','[\"*\"]','2026-03-10 11:09:37','2026-03-11 10:52:25','2026-03-10 10:52:25','2026-03-10 11:09:37'),(15,'App\\Models\\User',7,'auth-token','22cabbab0e387c15057b5d0d54a1aed123e71d7a069c89765e2f802f8ef5b1f2','[\"*\"]','2026-03-10 15:27:59','2026-03-11 14:04:06','2026-03-10 14:04:06','2026-03-10 15:27:59'),(16,'App\\Models\\User',7,'auth-token','2ba87d05562b83e0f30f0e6b01cbda095335e24f618f0a20d6452f57a4a60fb3','[\"*\"]','2026-03-10 14:16:54','2026-03-11 14:04:21','2026-03-10 14:04:21','2026-03-10 14:16:54'),(17,'App\\Models\\User',7,'auth-token','7b49afdad476dfcdc07b7074d8894e9a83d68aa07ab768bf13a426eb57fd7845','[\"*\"]','2026-03-10 14:16:55','2026-03-11 14:10:04','2026-03-10 14:10:04','2026-03-10 14:16:55'),(18,'App\\Models\\User',7,'auth-token','875793189712b84cdffd83d32560fbeb746d881eedd92cbf9c9176cd7ab7ec72','[\"*\"]','2026-03-10 17:46:48','2026-03-11 15:07:19','2026-03-10 15:07:19','2026-03-10 17:46:48'),(20,'App\\Models\\User',7,'auth-token','3909565abc6bd0b48f94076f7664f3fcfc3fe10189fce0156ac1edc74d887e67','[\"*\"]','2026-03-10 17:04:24','2026-03-11 15:56:53','2026-03-10 15:56:53','2026-03-10 17:04:24'),(21,'App\\Models\\User',7,'auth-token','2e30e7974b454a37f2fd09936094c04f6e6c72f6866071184d28555ef66b5f41','[\"*\"]','2026-03-11 04:19:48','2026-03-11 17:09:37','2026-03-10 17:09:37','2026-03-11 04:19:48'),(25,'App\\Models\\User',8,'auth-token','af49e2ee519b3ff4205654c3aa6e831425dfac84e54e7e350e1a498d5233e9ec','[\"*\"]','2026-03-11 04:06:55','2026-03-12 04:03:53','2026-03-11 04:03:53','2026-03-11 04:06:55'),(28,'App\\Models\\User',7,'auth-token','690e4a452b1aeb2359aa99bb24d769e79b6febaa3a70b83bfdec542409e2d9de','[\"*\"]','2026-03-11 09:22:04','2026-03-12 04:59:31','2026-03-11 04:59:31','2026-03-11 09:22:04'),(29,'App\\Models\\User',10,'auth-token','b62850102a398728b1ecd2e554450cb96e3bbbe6eb2d6cdb6a398058d517adbf','[\"*\"]','2026-03-11 05:00:15','2026-03-12 05:00:14','2026-03-11 05:00:14','2026-03-11 05:00:15'),(31,'App\\Models\\User',7,'auth-token','c419752d32e1192302768145eb2c116bc84e44b596690588684f4bb8d3a3e10a','[\"*\"]','2026-03-11 07:58:26','2026-03-12 07:47:02','2026-03-11 07:47:02','2026-03-11 07:58:26'),(32,'App\\Models\\User',2,'auth-token','e84685b9d3e1601309770d459f0631bf343a635c134c6a3246abbd525a0708e5','[\"*\"]','2026-03-11 07:57:08','2026-03-12 07:47:41','2026-03-11 07:47:41','2026-03-11 07:57:08'),(33,'App\\Models\\User',12,'auth-token','44408ffd1f10f7dab4db15e51eace5aa32017508fc3d7fcf4671806a98cba3dd','[\"*\"]','2026-03-11 09:01:22','2026-03-12 08:55:35','2026-03-11 08:55:35','2026-03-11 09:01:22'),(34,'App\\Models\\User',12,'auth-token','69295d0da9dbf0d25f7e9f6bd020c41d54063a46620318eb1748477d38f5da73','[\"*\"]','2026-03-11 09:33:40','2026-03-12 09:23:02','2026-03-11 09:23:02','2026-03-11 09:33:40'),(35,'App\\Models\\User',12,'auth-token','8339a1d5c22d81f74de2abdb0ae5c1444e1b6a453f05866b3a51398b0e096bba','[\"*\"]','2026-03-11 09:37:17','2026-03-12 09:34:06','2026-03-11 09:34:06','2026-03-11 09:37:17'),(36,'App\\Models\\User',12,'auth-token','8bedcbed15c9c33b870564fd3903125c1731f01f5cd0f60c0502f3440ce4d40b','[\"*\"]','2026-03-11 09:40:21','2026-03-12 09:37:48','2026-03-11 09:37:48','2026-03-11 09:40:21'),(37,'App\\Models\\User',12,'auth-token','62ff542c7b362e6aee36f99125fe9a365337a60548df0868c123f15f05f7981b','[\"*\"]','2026-03-11 09:50:58','2026-03-12 09:40:45','2026-03-11 09:40:45','2026-03-11 09:50:58');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `scan_count` int(11) NOT NULL DEFAULT 0,
  `last_scanned_at` timestamp NULL DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `reorder_level` int(11) NOT NULL DEFAULT 10,
  `image` varchar(255) DEFAULT NULL,
  `batch_number` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `manufacture_date` date DEFAULT NULL,
  `movement_type` enum('fast','medium','slow') NOT NULL DEFAULT 'medium',
  `lead_time_days` int(11) NOT NULL DEFAULT 7,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  UNIQUE KEY `products_qr_code_unique` (`qr_code`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Teff Flour 25kg','FOOD-001',NULL,NULL,0,NULL,'Ethiopian teff flour',2800.00,2400.00,30,10,'images/products/teff-flour.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(2,1,'Rice 5kg','FOOD-002',NULL,NULL,0,NULL,'Long grain white rice',450.00,350.00,50,15,'images/products/rice.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(3,1,'Sugar 1kg','FOOD-003',NULL,NULL,0,NULL,'White granulated sugar',85.00,65.00,100,30,'images/products/sugar.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(4,1,'Cooking Oil 1L','FOOD-004',NULL,NULL,0,NULL,'Vegetable cooking oil',180.00,140.00,54,20,'images/products/cooking-oil.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-11 09:01:01',NULL),(5,1,'Coffee Beans 500g','FOOD-005',NULL,NULL,0,NULL,'Ethiopian coffee beans',320.00,250.00,37,12,'images/products/coffee-beans.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-11 07:48:43',NULL),(6,1,'Pasta 500g','FOOD-006',NULL,NULL,0,NULL,'Italian pasta',65.00,45.00,80,25,'images/products/pasta.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(7,2,'Samsung Galaxy A14','ELEC-001',NULL,NULL,0,NULL,'Smartphone 128GB',12500.00,10000.00,15,5,'images/products/samsung-galaxy-a14.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(8,2,'Tecno Spark 10','ELEC-002',NULL,NULL,0,NULL,'Smartphone 64GB',8500.00,7000.00,20,6,'images/products/tecno-spark.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(9,2,'Phone Charger USB-C','ELEC-003',NULL,NULL,0,NULL,'Fast charging cable',250.00,150.00,50,15,'images/products/phone-charger.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(10,2,'Earphones','ELEC-004',NULL,NULL,0,NULL,'Wired earphones with mic',180.00,120.00,40,12,'images/products/earphones.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(11,2,'Power Bank 10000mAh','ELEC-005',NULL,NULL,0,NULL,'Portable charger',850.00,600.00,23,8,'images/products/power-bank.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-10 14:10:43',NULL),(12,2,'Bluetooth Speaker','ELEC-006',NULL,NULL,0,NULL,'Portable wireless speaker',1200.00,900.00,17,6,'images/products/bluetooth-speaker.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-11 09:01:01',NULL),(13,3,'Men T-Shirt','CLTH-001',NULL,NULL,0,NULL,'Cotton t-shirt size L',350.00,220.00,40,12,'images/products/men-tshirt.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(14,3,'Women Dress','CLTH-002',NULL,NULL,0,NULL,'Casual dress size M',850.00,550.00,30,10,'images/products/women-dress.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(15,3,'Children Shoes','CLTH-003',NULL,NULL,0,NULL,'School shoes black',650.00,420.00,0,8,'images/products/children-shoes.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-11 05:33:58',NULL),(16,3,'Men Jeans','CLTH-004',NULL,NULL,0,NULL,'Denim jeans blue',950.00,600.00,20,6,'images/products/men-jeans.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(17,3,'Socks Pack (3)','CLTH-005',NULL,NULL,0,NULL,'Cotton socks pack of 3',120.00,70.00,60,20,'images/products/socks.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(18,4,'Plastic Bucket 20L','HOME-001',NULL,NULL,0,NULL,'Heavy duty plastic bucket',180.00,120.00,30,10,'images/products/plastic-bucket.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(19,4,'Broom','HOME-002',NULL,NULL,0,NULL,'Traditional grass broom',85.00,50.00,9,8,'images/products/broom.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-11 09:31:48',NULL),(20,4,'Dish Soap 500ml','HOME-003',NULL,NULL,0,NULL,'Liquid dish washing soap',75.00,50.00,50,15,'images/products/dish-soap.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(21,4,'Laundry Detergent 1kg','HOME-004',NULL,NULL,0,NULL,'Powder detergent',145.00,100.00,32,12,'images/products/laundry-detergent.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-10 17:09:18',NULL),(22,4,'Plastic Chairs','HOME-005',NULL,NULL,0,NULL,'Stackable plastic chair',450.00,300.00,19,5,'images/products/plastic-chair.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-10 14:10:31',NULL),(23,5,'Exercise Book 100pg','STAT-001',NULL,NULL,0,NULL,'Ruled exercise book',25.00,15.00,200,50,'images/products/exercise-book.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(24,5,'Ball Pen Blue','STAT-002',NULL,NULL,0,NULL,'Blue ink ball pen',15.00,8.00,261,80,'images/products/pen.svg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-11 09:50:10',NULL),(25,5,'Pencil HB','STAT-003',NULL,NULL,0,NULL,'HB graphite pencil',10.00,5.00,250,60,'images/products/pencil.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(26,5,'A4 Paper Ream','STAT-004',NULL,NULL,0,NULL,'500 sheets white paper',380.00,300.00,0,8,'images/products/a4-paper.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-11 09:29:37',NULL),(27,5,'Ruler 30cm','STAT-005',NULL,NULL,0,NULL,'Plastic ruler',20.00,10.00,100,30,'images/products/ruler.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(28,6,'Body Lotion 400ml','COSM-001',NULL,NULL,0,NULL,'Moisturizing body lotion',180.00,120.00,23,10,'images/products/body-lotion.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-11 09:50:33',NULL),(29,6,'Shampoo 500ml','COSM-002',NULL,NULL,0,NULL,'Hair shampoo',150.00,95.00,40,12,'images/products/shampoo.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(30,6,'Soap Bar','COSM-003',NULL,NULL,0,NULL,'Bath soap 125g',35.00,22.00,100,30,'images/products/soap-bar.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(31,6,'Toothpaste 100ml','COSM-004',NULL,NULL,0,NULL,'Fluoride toothpaste',65.00,42.00,60,20,'images/products/toothpaste.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-09 18:00:55',NULL),(32,6,'Vaseline 250ml','COSM-005',NULL,NULL,0,NULL,'Petroleum jelly',120.00,80.00,43,15,'images/products/vaseline.jpg',NULL,NULL,NULL,'medium',7,1,'2026-03-09 18:00:55','2026-03-10 14:10:11',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale_items`
--

DROP TABLE IF EXISTS `sale_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sale_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_items_sale_id_foreign` (`sale_id`),
  KEY `sale_items_product_id_foreign` (`product_id`),
  CONSTRAINT `sale_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale_items`
--

LOCK TABLES `sale_items` WRITE;
/*!40000 ALTER TABLE `sale_items` DISABLE KEYS */;
INSERT INTO `sale_items` VALUES (1,1,12,1,1200.00,1200.00,'2026-03-09 20:32:47','2026-03-09 20:32:47'),(2,2,15,1,650.00,650.00,'2026-03-10 05:44:44','2026-03-10 05:44:44'),(3,3,12,5,1200.00,6000.00,'2026-03-10 05:45:08','2026-03-10 05:45:08'),(4,3,28,1,180.00,180.00,'2026-03-10 05:45:08','2026-03-10 05:45:08'),(5,3,15,1,650.00,650.00,'2026-03-10 05:45:08','2026-03-10 05:45:08'),(6,4,21,1,145.00,145.00,'2026-03-10 10:44:42','2026-03-10 10:44:42'),(7,5,12,1,1200.00,1200.00,'2026-03-10 14:08:06','2026-03-10 14:08:06'),(8,6,24,1,15.00,15.00,'2026-03-10 14:08:16','2026-03-10 14:08:16'),(9,7,12,2,1200.00,2400.00,'2026-03-10 14:08:36','2026-03-10 14:08:36'),(10,8,32,1,120.00,120.00,'2026-03-10 14:10:02','2026-03-10 14:10:02'),(11,9,32,1,120.00,120.00,'2026-03-10 14:10:11','2026-03-10 14:10:11'),(12,10,22,1,450.00,450.00,'2026-03-10 14:10:31','2026-03-10 14:10:31'),(13,11,11,1,850.00,850.00,'2026-03-10 14:10:37','2026-03-10 14:10:37'),(14,12,11,1,850.00,850.00,'2026-03-10 14:10:43','2026-03-10 14:10:43'),(15,13,26,1,380.00,380.00,'2026-03-10 15:11:51','2026-03-10 15:11:51'),(16,14,21,1,145.00,145.00,'2026-03-10 15:11:57','2026-03-10 15:11:57'),(17,15,24,1,15.00,15.00,'2026-03-10 15:17:05','2026-03-10 15:17:05'),(18,16,19,1,85.00,85.00,'2026-03-10 17:03:27','2026-03-10 17:03:27'),(19,17,28,1,180.00,180.00,'2026-03-10 17:45:41','2026-03-10 17:45:41'),(20,18,28,1,180.00,180.00,'2026-03-11 03:31:15','2026-03-11 03:31:15'),(21,19,26,1,380.00,380.00,'2026-03-11 03:31:44','2026-03-11 03:31:44'),(22,20,21,1,145.00,145.00,'2026-03-11 03:31:58','2026-03-11 03:31:58'),(23,20,26,2,380.00,760.00,'2026-03-11 03:31:58','2026-03-11 03:31:58'),(24,21,24,1,15.00,15.00,'2026-03-11 03:32:16','2026-03-11 03:32:16'),(25,22,12,1,1200.00,1200.00,'2026-03-11 03:36:44','2026-03-11 03:36:44'),(26,23,24,1,15.00,15.00,'2026-03-11 03:47:26','2026-03-11 03:47:26'),(27,24,26,2,380.00,760.00,'2026-03-11 05:23:55','2026-03-11 05:23:55'),(28,24,24,4,15.00,60.00,'2026-03-11 05:23:55','2026-03-11 05:23:55'),(29,25,5,1,320.00,320.00,'2026-03-11 07:49:20','2026-03-11 07:49:20'),(30,25,4,1,180.00,180.00,'2026-03-11 07:49:20','2026-03-11 07:49:20'),(31,26,26,1,380.00,380.00,'2026-03-11 07:54:45','2026-03-11 07:54:45'),(34,31,24,2,15.00,30.00,'2026-03-11 09:47:00','2026-03-11 09:47:00'),(35,32,24,2,15.00,30.00,'2026-03-11 09:48:37','2026-03-11 09:48:37'),(36,33,28,1,180.00,180.00,'2026-03-11 09:50:46','2026-03-11 09:50:46');
/*!40000 ALTER TABLE `sale_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL DEFAULT 'cash',
  `payment_status` varchar(255) NOT NULL DEFAULT 'completed',
  `status` enum('completed','pending','cancelled') NOT NULL DEFAULT 'completed',
  `notes` text DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sales_invoice_number_unique` (`invoice_number`),
  KEY `sales_user_id_foreign` (`user_id`),
  CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,7,'INV-20260309-QCJTMG',1200.00,180.00,0.00,1380.00,'cash','completed','completed',NULL,NULL,'2026-03-09 20:32:47','2026-03-09 20:32:47',NULL),(2,7,'INV-20260310-UWWMBM',650.00,97.50,0.00,747.50,'cash','completed','completed',NULL,NULL,'2026-03-10 05:44:44','2026-03-10 05:44:44',NULL),(3,7,'INV-20260310-4GMIKI',6830.00,1024.50,0.00,7854.50,'cash','completed','completed',NULL,NULL,'2026-03-10 05:45:08','2026-03-10 05:45:08',NULL),(4,1,'INV-20260310-0001',145.00,21.75,0.00,166.75,'cash','paid','completed','From Order #ORD-20260310-RKNRGR','IT 3RD YEAR','2026-03-10 10:44:42','2026-03-10 10:44:42',NULL),(5,7,'INV-20260310-0002',1200.00,180.00,0.00,1380.00,'cash','paid','completed','From Order #ORD-20260310-LZ84CX','wonde','2026-03-10 14:08:06','2026-03-10 14:08:06',NULL),(6,7,'INV-20260310-0003',15.00,2.25,0.00,17.25,'cash','paid','completed','From Order #ORD-20260309-XGNKEV','wonde','2026-03-10 14:08:16','2026-03-10 14:08:16',NULL),(7,7,'INV-20260310-0004',2400.00,360.00,0.00,2760.00,'cash','paid','completed','From Order #ORD-20260309-XTK0YF','Wonde IT','2026-03-10 14:08:36','2026-03-10 14:08:36',NULL),(8,7,'INV-20260310-UL6NGN',120.00,18.00,0.00,138.00,'cash','completed','completed',NULL,NULL,'2026-03-10 14:10:02','2026-03-10 14:10:02',NULL),(9,7,'INV-20260310-CCFGVC',120.00,18.00,0.00,138.00,'cash','completed','completed',NULL,NULL,'2026-03-10 14:10:11','2026-03-10 14:10:11',NULL),(10,7,'INV-20260310-NBBMNS',450.00,67.50,0.00,517.50,'mobile_banking','completed','completed',NULL,NULL,'2026-03-10 14:10:31','2026-03-10 14:10:31',NULL),(11,7,'INV-20260310-NJ1NTE',850.00,127.50,0.00,977.50,'bank_transfer','completed','completed',NULL,NULL,'2026-03-10 14:10:37','2026-03-10 14:10:37',NULL),(12,7,'INV-20260310-THQA2J',850.00,127.50,0.00,977.50,'credit','completed','completed',NULL,NULL,'2026-03-10 14:10:43','2026-03-10 14:10:43',NULL),(13,7,'INV-20260310-0005',380.00,57.00,0.00,437.00,'cash','paid','completed','From Order #ORD-20260310-7BCHUB','wonde','2026-03-10 15:11:51','2026-03-10 15:11:51',NULL),(14,7,'INV-20260310-0006',145.00,21.75,0.00,166.75,'cash','paid','completed','From Order #ORD-20260310-LCAUOL','wonde','2026-03-10 15:11:57','2026-03-10 15:11:57',NULL),(15,7,'INV-20260310-5CRC7N',15.00,2.25,0.00,17.25,'cash','completed','completed',NULL,NULL,'2026-03-10 15:17:05','2026-03-10 15:17:05',NULL),(16,7,'INV-20260310-NIRCCC',85.00,12.75,0.00,97.75,'cash','completed','completed',NULL,NULL,'2026-03-10 17:03:27','2026-03-10 17:03:27',NULL),(17,7,'INV-20260310-0007',180.00,27.00,0.00,207.00,'cash','paid','completed','From Order #ORD-20260310-KUJQSD','wonde','2026-03-10 17:45:41','2026-03-10 17:45:41',NULL),(18,7,'INV-20260311-0001',180.00,27.00,0.00,207.00,'cash','paid','completed','From Order #ORD-20260311-TX7NRD','wonde','2026-03-11 03:31:15','2026-03-11 03:31:15',NULL),(19,7,'INV-20260311-0002',380.00,57.00,0.00,437.00,'cash','paid','completed','From Order #ORD-20260311-YNNSKF','IT 3RD YEAR','2026-03-11 03:31:44','2026-03-11 03:31:44',NULL),(20,7,'INV-20260311-0003',905.00,135.75,0.00,1040.75,'cash','paid','completed','From Order #ORD-20260310-9EEKRR','wonde','2026-03-11 03:31:58','2026-03-11 03:31:58',NULL),(21,7,'INV-20260311-0004',15.00,2.25,0.00,17.25,'cash','paid','completed','From Order #ORD-20260311-CFU6QH','IT 3RD YEAR','2026-03-11 03:32:16','2026-03-11 03:32:16',NULL),(22,7,'INV-20260311-0005',1200.00,180.00,0.00,1380.00,'cash','paid','completed','From Order #ORD-20260311-0GQNS5','IT 3RD YEAR','2026-03-11 03:36:44','2026-03-11 03:36:44',NULL),(23,7,'INV-20260311-0006',15.00,2.25,0.00,17.25,'cash','paid','completed','From Order #ORD-20260311-AXKXOZ','IT 3RD YEAR','2026-03-11 03:47:26','2026-03-11 03:47:26',NULL),(24,7,'INV-20260311-0007',820.00,123.00,0.00,943.00,'cash','paid','completed','From Order #ORD-20260311-D5LE7H','IT 3RD YEAR','2026-03-11 05:23:55','2026-03-11 05:23:55',NULL),(25,7,'INV-20260311-0008',500.00,75.00,0.00,575.00,'cash','paid','completed','From Order #ORD-20260311-N4ZJUX','Tigist Haile','2026-03-11 07:49:20','2026-03-11 07:49:20',NULL),(26,7,'INV-20260311-0009',380.00,57.00,0.00,437.00,'cash','paid','completed','From Order #ORD-20260311-IPCXP2','Tigist Haile','2026-03-11 07:54:45','2026-03-11 07:54:45',NULL),(31,NULL,'INV-20260311-0010',30.00,4.50,0.00,34.50,'chapa','paid','completed','From Order #ORD-20260311-E9HOFO - Paid via chapa','IT 3RD YEAR','2026-03-11 09:47:00','2026-03-11 09:47:00',NULL),(32,NULL,'INV-20260311-0011',30.00,4.50,0.00,34.50,'chapa','paid','completed','From Order #ORD-20260311-PMCT0P - Paid via chapa','IT 3RD YEAR','2026-03-11 09:48:37','2026-03-11 09:48:37',NULL),(33,NULL,'INV-20260311-0012',180.00,27.00,0.00,207.00,'chapa','paid','completed','From Order #ORD-20260311-CT8AZC - Paid via chapa','IT 3RD YEAR','2026-03-11 09:50:46','2026-03-11 09:50:46',NULL);
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('28rEUoNO32fszxXcxeYbzQdOItYIfpBnPu9IzNjl',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRTRTMXcxamRnR054TlBobkI0SlN1RnhoRUlwMUhsNHlkYnpPUnFFVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTgzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL3YxL2F1dGgvdmVyaWZ5LWVtYWlsLzgvZGE0ZWIxYTQ2OGFjM2QwNmRkOTA0ZWVhMjcwZmE0YmE5ZjVkOTIwND9leHBpcmVzPTE3NzMxNTM0Nzkmc2lnbmF0dXJlPTUxOTE2YmUyNTYwZTdmMzk2NTE2NmYyODc2MzgwN2MxN2Y3ZWE0MTk5ZDU5YzNiNWNiYjc5MGE5YzEzMGMyZmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1773149906),('F7x5HKOqWjiMPNPDEu6r1CP2vqvnznP2Z45BfPag',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTUxORHJuQm5TT0Q0azE4SEdnSFVtMXB6d0E1Q2cyRjhSN3lxWTU3QSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTgzOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL2F1dGgvdmVyaWZ5LWVtYWlsLzcvMGM0MDE4MjBhOWYyNmVmOGNjYzYzYzgzN2RmZDIzOWJhMjQ1MzUyZj9leHBpcmVzPTE3NzMwOTk1MDUmc2lnbmF0dXJlPWFhY2NiMzc4OTBkY2NkYjRmMDNiNzg3NWE4YzY4YTA0YzRlZjU2NjlkODA1NmE0YjA3Njg5M2I4NTRiNzJmYTMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1773095924),('zhNGZtmHXUIO5nvN2PZNnlsGeLS2YSAWEnb1wqai',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoidFhZSjZkR0ZEa2RBcGdudzRHQ0FaT21zaVgwQkx4YkYxRUZPQ3lHMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL3YxL2F1dGgvdmVyaWZ5LWVtYWlsLzEyL2RhNGViMWE0NjhhYzNkMDZkZDkwNGVlYTI3MGZhNGJhOWY1ZDkyMDQ/ZXhwaXJlcz0xNzczMjE5Njg1JnNpZ25hdHVyZT0xYTkyOWRkNGY4ZDkwNjJlOWFlMTMzOTRlYWEyZTA5ODFhYWU0ZTkzNTk3ZThlNWY5OGRjNTEyMjAyZDNmZTg3Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1773216137);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_alerts`
--

DROP TABLE IF EXISTS `stock_alerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_alerts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `alert_type` enum('low_stock','out_of_stock','expiring_soon','expired') NOT NULL,
  `is_resolved` tinyint(1) NOT NULL DEFAULT 0,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `resolved_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_alerts_product_id_foreign` (`product_id`),
  KEY `stock_alerts_resolved_by_foreign` (`resolved_by`),
  CONSTRAINT `stock_alerts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_alerts_resolved_by_foreign` FOREIGN KEY (`resolved_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_alerts`
--

LOCK TABLES `stock_alerts` WRITE;
/*!40000 ALTER TABLE `stock_alerts` DISABLE KEYS */;
INSERT INTO `stock_alerts` VALUES (1,12,'low_stock',1,'2026-03-10 05:45:08',NULL,'2026-03-10 04:52:10','2026-03-10 05:45:08'),(2,12,'out_of_stock',1,'2026-03-10 14:05:09',7,'2026-03-10 05:45:08','2026-03-10 14:05:09'),(3,12,'out_of_stock',1,'2026-03-10 14:05:15',7,'2026-03-10 14:05:10','2026-03-10 14:05:15'),(4,12,'out_of_stock',1,'2026-03-10 14:06:45',7,'2026-03-10 14:05:15','2026-03-10 14:06:45'),(5,12,'out_of_stock',1,'2026-03-11 03:22:40',NULL,'2026-03-10 14:06:46','2026-03-11 03:22:40'),(6,19,'out_of_stock',1,'2026-03-11 05:04:14',NULL,'2026-03-11 04:17:36','2026-03-11 05:04:14'),(7,15,'out_of_stock',0,NULL,NULL,'2026-03-11 05:33:58','2026-03-11 05:33:58'),(8,26,'low_stock',1,'2026-03-11 09:34:09',NULL,'2026-03-11 07:53:51','2026-03-11 09:34:09'),(9,26,'out_of_stock',0,NULL,NULL,'2026-03-11 09:34:09','2026-03-11 09:34:09');
/*!40000 ALTER TABLE `stock_alerts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `suppliers_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Addis Electronics Import','addis.electronics@email.com','+251111234567','Merkato, Addis Ababa','Ato Tadesse','2026-03-09 18:00:55','2026-03-09 18:00:55'),(2,'Kombolcha Wholesale','kombolcha.wholesale@email.com','+251112345678','Industrial Zone, Kombolcha','W/ro Tigist','2026-03-09 18:00:55','2026-03-09 18:00:55'),(3,'Dessie Trading PLC','dessie.trading@email.com','+251113456789','Dessie Town','Ato Mulugeta','2026-03-09 18:00:55','2026-03-09 18:00:55'),(4,'Bahir Dar Textiles','bd.textiles@email.com','+251114567890','Bahir Dar','Ato Yohannes','2026-03-09 18:00:55','2026-03-09 18:00:55'),(5,'Hawassa Food Distributors','hawassa.food@email.com','+251115678901','Hawassa','W/ro Marta','2026-03-09 18:00:55','2026-03-09 18:00:55'),(6,'Mekelle Cosmetics','mekelle.cosmetics@email.com','+251116789012','Mekelle','Ato Gebru','2026-03-09 18:00:55','2026-03-09 18:00:55');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
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
  `phone` varchar(255) DEFAULT NULL,
  `sms_alerts` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager','cashier','storekeeper','customer') NOT NULL DEFAULT 'cashier',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Wonde IT','admin@example.com',NULL,0,'2026-03-09 18:00:52','$2y$12$tLJpwSLaL8pfUGF/L0bXeukkNS0wSkT6xqMVV6t3PIwM2FXffHGKq','admin',1,'or',NULL,'2026-03-09 18:00:53','2026-03-10 11:08:48'),(2,'Tigist Haile','semredemssie83@gmail.com',NULL,0,'2026-03-09 18:00:53','$2y$12$.urkFCf6wRpR.ZdYuKGok.IMwtNGbdXWaW67djRL2wXfn5AewEAoW','customer',1,'en',NULL,'2026-03-09 18:00:53','2026-03-10 15:17:11'),(3,'Dawit Tesfaye','cashier1@example.com',NULL,0,'2026-03-09 18:00:53','$2y$12$al.zQJf.yY4hqgSx7QAkGeHv3qy3STd71ZoDrscbdyjj6gZTTRiEK','cashier',1,'en',NULL,'2026-03-09 18:00:53','2026-03-09 18:00:53'),(4,'Meron Alemu','cashier2@example.com',NULL,0,'2026-03-09 18:00:54','$2y$12$ir9iw/8oCespcZj5iCuQSOp49UPp2OTsobKawd7xYq7f7IsaSfWt.','cashier',1,'en',NULL,'2026-03-09 18:00:54','2026-03-09 18:00:54'),(6,'Almaz Tadesse','customer@example.com',NULL,0,'2026-03-09 18:00:55','$2y$12$B6sfGpT/VqeGt3ryy7qERegUjCAYMEgztOeDbo7MzinNmecNcyene','customer',1,'en',NULL,'2026-03-09 18:00:55','2026-03-09 18:00:55'),(7,'wonde','teme23253@gmail.com',NULL,0,'2026-03-09 19:38:44','$2y$12$LfX0E5iq2hU9do.frcSuh.9SZ9dirIrkokl/P81iOnv4TZpMLrf66','admin',1,'en',NULL,'2026-03-09 19:14:39','2026-03-11 05:36:39'),(9,'Abebe Kebede Alemu','lijg34559@gmail.com',NULL,0,NULL,'$2y$12$SigZeNDpkL98e8fpQiNCMeWJK7Xpl.6TiVy/nz642phOZrJUvRmAG','customer',1,'en',NULL,'2026-03-10 13:55:43','2026-03-10 13:55:43'),(12,'cu','lijself@gmail.com',NULL,0,'2026-03-11 05:02:17','$2y$12$9f50rOyMKmJUL926lVnP8.A.Lc5ZlyXC6ValOpZNRgXi4h3llO6N.','storekeeper',1,'en',NULL,'2026-03-11 05:01:25','2026-03-11 08:55:21');
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

-- Dump completed on 2026-03-11 15:55:19
