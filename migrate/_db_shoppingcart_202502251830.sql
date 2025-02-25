CREATE TABLE `carousel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `carousel` (`title`, `description`, `image`, `status`) VALUES
('Welcome to Shopping Cart', 'Discover amazing products at great prices', 'slide-1.jpg', 1),
('Special Offers', 'Get up to 50% off on selected items', 'slide-2.jpg', 1),
('New Arrivals', 'Check out our latest products', 'slide-3.jpg', 1);