-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for shoppingcart
CREATE DATABASE IF NOT EXISTS `shoppingcart` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `shoppingcart`;

-- Dumping structure for table shoppingcart.carousel
CREATE TABLE IF NOT EXISTS `carousel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table shoppingcart.carousel: ~2 rows (approximately)
INSERT INTO `carousel` (`id`, `title`, `description`, `image`, `status`, `created_at`) VALUES
	(1, 'Welcome to Shopping Cart', 'Discover amazing products at great prices', 'slide-1.jpg', 1, '2025-02-25 11:30:44'),
	(3, 'ส่วดลดสุดพิเศษ', 'ส่วนลด 80 บาท เพียงกรอก Promocode: NEWYEAR', 'slide-3.jpg', 1, '2025-02-25 11:30:44');

-- Dumping structure for table shoppingcart.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `display_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table shoppingcart.categories: ~7 rows (approximately)
INSERT INTO `categories` (`id`, `name`, `display_name`, `created_at`) VALUES
	(1, 'all', 'All Foods', '2025-02-18 14:25:35'),
	(2, 'thai', 'Thai Food', '2025-02-18 14:25:35'),
	(3, 'japanese', 'Japanese Food', '2025-02-18 14:25:35'),
	(4, 'fastfood', 'Fast Food', '2025-02-18 14:25:35'),
	(5, 'dessert', 'Dessert', '2025-02-18 14:25:35'),
	(6, 'beverage', 'Beverage', '2025-02-18 14:25:35'),
	(7, 'other', 'Other', '2025-02-18 14:25:35');

-- Dumping structure for table shoppingcart.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_date` datetime NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `grand_total` decimal(8,2) NOT NULL DEFAULT '0.00',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table shoppingcart.order_details
CREATE TABLE IF NOT EXISTS `order_details` (
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `quantity` int NOT NULL DEFAULT '0',
  `total` decimal(8,2) NOT NULL DEFAULT '0.00',
  KEY `FK_order_details_products` (`product_id`),
  KEY `FK_order_details_orders` (`order_id`),
  CONSTRAINT `FK_order_details_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `FK_order_details_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table shoppingcart.permission_users
CREATE TABLE IF NOT EXISTS `permission_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `FK_permission_users_users` (`user_id`),
  CONSTRAINT `FK_permission_users_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table shoppingcart.permission_users: ~5 rows (approximately)
INSERT INTO `permission_users` (`id`, `user_id`, `role`) VALUES
	(1, 1, 'admin');

-- Dumping structure for table shoppingcart.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `profile_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'other',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table shoppingcart.products: ~11 rows (approximately)
INSERT INTO `products` (`id`, `product_name`, `price`, `profile_image`, `detail`, `category`) VALUES
	(1, 'แฮมเบอร์เก้อ', 189.00, 'food-1.png', 'อร่อย เต็มคำ รสชาติจัดจ้าน', 'fastfood'),
	(3, 'แซนวิซ', 30.00, 'food-4.png', 'ไม่แพงแต่อิ่ม', 'fastfood'),
	(4, 'เครื่องดื่มโค๊ก', 19.00, 'food-5.png', 'อร่อย ซ่า โดนใจ', 'beverage'),
	(5, 'เฟรนฟราย', 99.00, 'food-6.png', 'มันทอดกรอบ ติดใจวัยรุ่น', 'fastfood'),
	(9, 'hotdog', 15.00, 'hotdog.jpg', 'อร่อย เต็มคำ', 'other'),
	(10, 'ชูชิ', 90.00, 'Image.jpg', 'สดๆ', ' japanese'),
	(11, 'ต้มยํากุ้ง', 50.00, 'maxresdefault.jpg', 'เผ็น อร่อย', 'thai'),
	(12, 'ขนมฟักทอง', 20.00, 'lltf-hero.jpg', 'หวาน มัน อร่อย', ' beverage'),
	(13, 'ข้าวแกงกระหรี่หมูกรอบ', 80.00, 'OIP.jpg', 'อร่อย', ' japanese'),
	(14, 'บัวลอย', 20.00, '7aa5acd80f0e3a2de1dbe06d8da3f620.jpg', 'หวาน มัน ลอย', 'dessert'),
	(15, 'น้ำดื่ม', 15.00, 'namthip1.5l_3.jpg', 'น้ำดื่ม', ' beverage');

-- Dumping structure for table shoppingcart.promocodes
CREATE TABLE IF NOT EXISTS `promocodes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `promotion_text` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `status` enum('active','inactive','expired') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table shoppingcart.promocodes: ~3 rows (approximately)
INSERT INTO `promocodes` (`id`, `code`, `promotion_text`, `discount_value`, `status`, `created_at`) VALUES
	(1, 'PRO100', 'ส่วนลด 100 บาท', 100.00, 'active', '2022-02-25 11:30:00'),
	(2, 'PRO80', 'ส่วนลด 80 บาท', 80.00, 'active', '2022-02-25 11:30:00'),
	(3, 'PRO20', 'ส่วนลด 20 บาท', 20.00, 'active', '2022-02-25 11:30:00');

-- Dumping structure for table shoppingcart.users
CREATE TABLE IF NOT EXISTS `users` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `reset_token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL,
  `points` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table shoppingcart.users: ~5 rows (approximately)
INSERT INTO `users` (`Id`, `username`, `password`, `name`, `surname`, `tel`, `email`, `address`, `status`, `reset_token`, `reset_expiry`, `points`) VALUES
	(1, 'admin', '$2y$10$FBeDS1bIBRStH5tvDEEaeuypOgtRzxCv.ucGZtGqmgJBcjwR9pEH.', 'admin', 'admin', '0854790731', 'chattarin136@gmail.co', '23/1112 ต.ในเมือง อ.เมือง จ.นครราชสีมา 10310', 1, NULL, NULL, 4);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
