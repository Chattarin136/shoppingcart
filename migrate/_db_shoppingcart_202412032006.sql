-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 04, 2024 at 01:57 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS shoppingcart;
USE shoppingcart;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `order_date` datetime NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `grand_total` decimal(8,2) NOT NULL DEFAULT '0.00',
  `address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_date`, `fullname`, `email`, `tel`, `grand_total`, `address`) VALUES
(1, '2024-12-03 14:07:06', 'supaporn jundee', 'admin@local.com', '0823400985', '1193.00', '192 ต.ในเมือง อ.เมือง จ.นครราชสีมา 10310'),
(2, '2024-12-03 14:07:33', 'ญาณารณพ นวลระแหง', 'yanaranop.naulrahaeng@outlook.com', '0925396670', '834.00', '63/2238 ซ.104 หมู่บ้าน เคหะธานี4 ถ.ราษฎร์พัฒนา แขวงราษฎร์พัฒนา เขตสะพานสูง กรุงเทพมหานคร 10240\r\nแขวงราษฎร์พัฒนา'),
(3, '2024-12-03 15:08:45', 'supaporn jundee', 'admin@local.com', '0823400985', '30.00', '192 ต.ในเมือง อ.เมือง จ.นครราชสีมา 10310'),
(4, '2024-12-03 15:12:35', 'ญาณารณพ นวลระแหง', 'yanaranop.naulrahaeng@outlook.com', '0925396670', '1244.00', '63/2238 ซ.104 หมู่บ้าน เคหะธานี4 กรุงเทพมหานคร 10240 แขวงราษฎร์พัฒนา'),
(5, '2024-12-03 16:04:29', 'supaporn jundee', 'admin@local.com', '0823400985', '651.00', '192 ต.ในเมือง อ.เมือง จ.นครราชสีมา 10310'),
(6, '2024-12-03 16:05:20', 'supaporn jundee', 'admin@local.com', '0823400985', '38.00', '192 ต.ในเมือง อ.เมือง จ.นครราชสีมา 10310'),
(7, '2024-12-03 16:12:18', 'supaporn jundee', 'admin@local.com', '0823400985', '1216.00', '192 ต.ในเมือง อ.เมือง จ.นครราชสีมา 10310');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `quantity` int NOT NULL DEFAULT '0',
  `total` decimal(8,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_id`, `product_id`, `product_name`, `price`, `quantity`, `total`) VALUES
('1', 1, 'แฮมเบอร์เก้อ', '189.00', 2, '378.00'),
('1', 2, 'พิซซ่าซีฟู๊ด', '199.00', 4, '796.00'),
('1', 4, 'เครื่องดื่มโค๊ก', '19.00', 1, '19.00'),
('2', 5, 'เฟรนฟราย', '99.00', 2, '198.00'),
('2', 3, 'แซนวิซ', '30.00', 1, '30.00'),
('2', 1, 'แฮมเบอร์เก้อ', '189.00', 1, '189.00'),
('2', 2, 'พิซซ่าซีฟู๊ด', '199.00', 2, '398.00'),
('2', 4, 'เครื่องดื่มโค๊ก', '19.00', 1, '19.00'),
('3', 9, 'hotdog', '15.00', 2, '30.00'),
('4', 1, 'แฮมเบอร์เก้อ', '189.00', 1, '189.00'),
('4', 2, 'พิซซ่าซีฟู๊ด', '199.00', 5, '995.00'),
('4', 3, 'แซนวิซ', '30.00', 2, '60.00'),
('5', 1, 'แฮมเบอร์เก้อ', '189.00', 1, '189.00'),
('5', 2, 'พิซซ่าซีฟู๊ด', '199.00', 2, '398.00'),
('5', 3, 'แซนวิซ', '30.00', 1, '30.00'),
('5', 4, 'เครื่องดื่มโค๊ก', '19.00', 1, '19.00'),
('5', 9, 'hotdog', '15.00', 1, '15.00'),
('6', 4, 'เครื่องดื่มโค๊ก', '19.00', 2, '38.00'),
('7', 2, 'พิซซ่าซีฟู๊ด', '199.00', 4, '796.00'),
('7', 3, 'แซนวิซ', '30.00', 2, '60.00'),
('7', 4, 'เครื่องดื่มโค๊ก', '19.00', 3, '57.00'),
('7', 1, 'แฮมเบอร์เก้อ', '189.00', 1, '189.00'),
('7', 5, 'เฟรนฟราย', '99.00', 1, '99.00'),
('7', 9, 'hotdog', '15.00', 1, '15.00');

-- --------------------------------------------------------

--
-- Table structure for table `permission_users`
--

CREATE TABLE `permission_users` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `role` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permission_users`
--

INSERT INTO `permission_users` (`id`, `user_id`, `role`) VALUES
(1, 1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `profile_image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `detail` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `profile_image`, `detail`) VALUES
(1, 'แฮมเบอร์เก้อ', '189.00', 'food-1.png', 'อร่อย เต็มคำ รสชาติจัดจ้าน'),
(2, 'พิซซ่าซีฟู๊ด', '199.00', 'food-2.png', 'อิ่มอร่อย ที่สุดของโปรดปราน'),
(3, 'แซนวิซ', '30.00', 'food-4.png', 'ไม่แพงแต่อิ่ม'),
(4, 'เครื่องดื่มโค๊ก', '19.00', 'food-5.png', 'อร่อย ซ่า โดนใจ'),
(5, 'เฟรนฟราย', '99.00', 'food-6.png', 'มันทอดกรอบ ติดใจวัยรุ่น'),
(9, 'hotdog', '15.00', 'hotdog.jpg', 'อร่อย เต็มคำ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `username`, `password`, `name`, `surname`, `tel`, `email`, `address`, `status`) VALUES
(1, 'admin', '$2y$10$i5/1/8WlrFzsJeto7Ip1UeTSSiGuccPhYIZJ7rvc.tQSe4dALzrI6', 'supaporn', 'jundee', '0823400985', 'admin@local.com', '192 ต.ในเมือง อ.เมือง จ.นครราชสีมา 10310', 1),
(2, 'customer', '$2y$10$u2Jeu.6E14O9mtfzde/2jeiS.AuqCdEEihQn1cAUYyd/rWfMOK5dW', 'mike', 'berry', '0823400984', 'admin2@local.com', '192 ต.ในเมือง อ.เมือง จ.นครราชสีมา 10310', 1),
(3, 'mike', '$2y$10$6fjheBRMWiCKgFq.oe7D4Oqmi1he.Ky2mLiFDC7r70RMzr2UbuKVu', 'ญาณารณพ', 'นวลระแหง', '0823400983', 'admin3@local.com', '192 ต.ในเมือง อ.เมือง จ.นครราชสีมา 10310', 1),
(4, 'mikeberry1', '$2y$10$0Hi8PizeBlDAjoXQAAhV5enmTA5GYnsGHo45v.UH4pWfHRdQGz0CC', 'ญาณารณพ', 'นวลระแหง', '0925396670', 'yanaranop.naulrahaeng@outlook.com', '63/2238 ซ.104 หมู่บ้าน เคหะธานี4 ถ.ราษฎร์พัฒนา แขวงราษฎร์พัฒนา เขตสะพานสูง กรุงเทพมหานคร 10240\r\nแขวงราษฎร์พัฒนา', 1),
(5, 'root', '$2y$10$MOlj37CwuP100.n.iUoyr.UqxBBudBxZv2ymExZsWYbyPe.YfRSU2', 'คงเกียรติ', 'โชตวาณิช', '0895396312', 'yanaranop2540mike@gmail.com', '62/521 ซ.10', 1),
(6, 'myuser', '$2y$10$NiWuq3AV/MaX615jw1ePeONt4haAGwuZ4fWXScP78xr/Kl5aiVWe6', 'myuser', 'myuser', '0925396670', 'myuser@gmail.com', '63/2238 ซ.104', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_users`
--
ALTER TABLE `permission_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;