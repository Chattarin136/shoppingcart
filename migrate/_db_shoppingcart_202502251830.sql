CREATE TABLE `carousel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `promocodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `promotion_text` varchar(100) NOT NULL DEFAULT 'ส่วนลดพิเศษ',
  `discount_value` decimal(10,2) NOT NULL,
  `status` enum('active','inactive','expired') DEFAULT 'active',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=UTF8MB4_UNICODE_CI;

INSERT INTO `promocodes` (`id`, `code`, `promotion_text`, `discount_value`, `status`, `created_at`) VALUES
(1, 'PROMO100', 'ส่วนลด 100 บาท', 100.00, 'active', '2022-02-25 18:30:00'),
(2, 'PROMO200', 'ส่วนลด 200 บาท', 200.00, 'active', '2022-02-25 18:30:00'),
(3, 'PROMO500', 'ส่วนลด 500 บาท', 500.00, 'active', '2022-02-25 18:30:00'),