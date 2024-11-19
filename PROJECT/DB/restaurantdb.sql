-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2024 at 04:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurantdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_history`
--

CREATE TABLE `booking_history` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `booking_code` varchar(50) DEFAULT NULL,
  `booking_time` datetime DEFAULT NULL,
  `booking_day` date DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `special_request` text DEFAULT NULL,
  `table_number` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_history`
--

INSERT INTO `booking_history` (`booking_id`, `user_id`, `booking_code`, `booking_time`, `booking_day`, `table_id`, `special_request`, `table_number`) VALUES
(1, 2, '89c35374-94d4-11ef-8c4a-088fc30b9eea', '2024-10-28 10:31:00', '2024-10-28', NULL, NULL, ''),
(2, 2, '8309455e-94d6-11ef-8c4a-088fc30b9eea', '2024-10-28 10:45:00', '2024-10-28', NULL, NULL, ''),
(3, 2, '316f7e7b-94d7-11ef-8c4a-088fc30b9eea', '2024-10-28 11:49:00', '2024-10-28', NULL, NULL, ''),
(4, 2, '72e1ada4-94d7-11ef-8c4a-088fc30b9eea', '2024-10-28 10:52:00', '2024-10-28', NULL, NULL, ''),
(5, 2, '5456be6c-94d8-11ef-8c4a-088fc30b9eea', '2024-10-28 10:59:00', '2024-10-28', 0, NULL, ''),
(6, 2, 'ceb01c46-94d9-11ef-8c4a-088fc30b9eea', '2024-10-28 11:08:00', '2024-10-28', 35, NULL, '7'),
(8, 3, 'ee6162ad-9538-11ef-9a4e-088fc30b9eea', '2024-10-28 23:28:00', '2024-10-28', 30, NULL, '4'),
(9, 3, '17127a44-954a-11ef-9a4e-088fc30b9eea', '2024-10-29 14:31:00', '2024-10-29', 30, NULL, '4'),
(11, 3, '66f314e8-9750-11ef-a9fc-088fc30b9eea', '2024-11-01 13:21:00', '2024-11-01', 31, NULL, '5'),
(12, 3, 'da9e0dfd-9750-11ef-a9fc-088fc30b9eea', '2024-10-31 15:24:00', '2024-10-31', 30, NULL, '4'),
(13, 3, 'fc18710a-9750-11ef-a9fc-088fc30b9eea', '2024-11-01 16:25:00', '2024-11-01', 30, NULL, '4'),
(14, 3, '642e3d95-9751-11ef-a9fc-088fc30b9eea', '2024-11-01 16:25:00', '2024-11-01', 30, NULL, '4'),
(15, 3, '76855e4d-9751-11ef-a9fc-088fc30b9eea', '2024-11-02 17:29:00', '2024-11-02', 28, NULL, '2'),
(16, 3, 'bcf260f2-9751-11ef-a9fc-088fc30b9eea', '2024-11-01 13:31:00', '2024-11-01', 30, NULL, '4'),
(17, 3, '0d1f2700-9f9c-11ef-9894-04bf1bff196c', '2024-11-11 11:43:00', '2024-11-11', 30, '', '4');

-- --------------------------------------------------------

--
-- Table structure for table `dish_ingredients`
--

CREATE TABLE `dish_ingredients` (
  `dish_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `ingredient_id` int(11) NOT NULL,
  `ingredient_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`ingredient_id`, `ingredient_name`, `quantity`, `is_primary`) VALUES
(10, 'phượng hoàng', 7, 0),
(11, 'trứng gà', 97, 0);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `dish_id` int(11) NOT NULL,
  `dish_name` varchar(100) NOT NULL,
  `dish_describe` text DEFAULT NULL,
  `price` int(10) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`dish_id`, `dish_name`, `dish_describe`, `price`, `image_path`) VALUES
(28, 'sườn xào chua ngọt', 'sườn,aa', 222, '../storage/1731293869_th.jfif'),
(29, 'gà chiên ', 'gà, sốt chua ngọt, sốt cay, sốt phô mai', 23, '../storage/1731297134_2-cach-lam-ga-sot-chua-ngot-tai-nha-cuc-de-nguoi-lon-va-tre-em-deu-thich-ga-sot-chua-ngot-eva-006-1688630094-797-width700height574.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `payment_time` datetime DEFAULT NULL,
  `customer_name` varchar(35) NOT NULL,
  `customer_phone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `order_date`, `table_id`, `payment_time`, `customer_name`, `customer_phone`) VALUES
(36, 2, 1212.00, '2024-10-22 13:10:05', 28, '2024-10-22 13:10:05', 'vu', 774303485),
(37, 2, 9596.00, '2024-10-22 13:28:04', 28, '2024-10-22 13:28:04', 'vu', 774303485),
(38, 2, 3536.00, '2024-10-22 13:42:03', 28, '2024-10-22 13:42:03', 'vu', 774303485),
(39, 2, 1212.00, '2024-10-22 13:47:53', 28, '2024-10-22 13:47:53', 'vu', 774303485),
(40, 2, 2324.00, '2024-10-22 13:49:51', 28, '2024-10-22 13:49:51', 'vu', 774303485),
(41, 2, 1212.00, '2024-10-22 13:52:06', 28, '2024-10-22 13:52:06', 'vu', 774303485),
(42, 2, 1212.00, '2024-10-22 13:53:26', 28, '2024-10-22 13:53:26', 'vu', 774303485),
(43, 2, 2324.00, '2024-10-22 13:54:34', 28, '2024-10-22 13:54:34', 'vu', 774303485),
(44, 2, 1212.00, '2024-10-22 13:55:35', 28, '2024-10-22 13:55:35', 'vu', 774303485),
(45, 2, 2324.00, '2024-10-22 13:56:01', 28, '2024-10-22 13:56:01', 'vu', 774303485),
(46, 2, 1212.00, '2024-10-22 14:04:29', 28, '2024-10-22 14:04:29', 'vu', 774303485),
(47, 2, 2324.00, '2024-10-22 14:06:23', 28, '2024-10-22 14:06:23', 'vu', 774303485),
(48, 2, 49104.00, '2024-10-26 11:25:07', 30, '2024-10-26 11:25:07', 'sè', 0),
(49, 2, 1212.00, '2024-10-26 12:05:15', 28, '2024-10-26 12:05:15', 'sè', 0),
(50, 2, 1212.00, '2024-10-27 08:42:36', 28, '2024-10-27 08:42:36', 'sè', 0),
(51, 2, 8284.00, '2024-10-27 08:42:56', 30, '2024-10-27 08:42:56', 'sè', 0),
(52, 2, 2424.00, '2024-10-27 08:43:13', 31, '2024-10-27 08:43:13', 'sè', 0),
(54, 2, 2324.00, '2024-10-27 10:07:42', 30, '2024-10-27 10:07:42', 'sè', 0),
(55, NULL, 1212.00, '2024-10-28 08:36:34', 30, '2024-10-28 08:36:34', 'sè', 0),
(57, 2, 3536.00, '2024-10-28 09:51:24', 28, '2024-10-28 09:51:24', 'sè', 0),
(58, 3, 2324.00, '2024-10-28 21:13:56', 31, '2024-10-28 21:13:56', 'sd', 0),
(59, 3, 2324.00, '2024-10-28 21:18:12', 28, '2024-10-28 21:18:12', 'trth', 0),
(60, 3, 2324.00, '2024-10-28 23:37:18', 30, '2024-10-28 23:37:18', 'sadf', 14),
(61, 3, 2324.00, '2024-10-28 23:37:32', 28, '2024-10-28 23:37:32', '43', 234),
(62, 3, 2324.00, '2024-10-29 01:06:35', NULL, NULL, '', 0),
(63, 2, 2324.00, '2024-10-29 01:41:47', 28, '2024-10-29 01:41:47', '43', 234),
(64, 2, 2324.00, '2024-10-29 10:43:59', 28, '2024-10-29 10:43:59', '43', 234),
(65, 2, 2324.00, '2024-10-29 10:52:32', 30, '2024-10-29 10:52:32', '43', 234),
(66, 2, 222.00, '2024-11-10 17:49:47', 31, '2024-11-10 17:49:47', '3', 3),
(67, 4, 3636.00, '2024-11-11 02:36:29', 28, '2024-11-11 02:36:29', '123', 0),
(68, 4, 1212.00, '2024-11-11 02:38:54', 28, '2024-11-11 02:38:54', 'sdcac', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `dish_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `dish_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `dish_name`, `quantity`, `price`, `dish_id`) VALUES
(56, 36, 'trứng rán', 1, 1212.00, NULL),
(57, 37, 'trứng rán', 6, 1212.00, NULL),
(58, 37, 'phượng hoàng gián', 1, 2324.00, NULL),
(59, 38, 'trứng rán', 1, 1212.00, NULL),
(60, 38, 'phượng hoàng gián', 1, 2324.00, NULL),
(61, 39, 'trứng rán', 1, 1212.00, NULL),
(62, 40, 'phượng hoàng gián', 1, 2324.00, NULL),
(63, 41, 'trứng rán', 1, 1212.00, NULL),
(64, 42, 'trứng rán', 1, 1212.00, NULL),
(65, 43, 'phượng hoàng gián', 1, 2324.00, NULL),
(66, 44, 'trứng rán', 1, 1212.00, NULL),
(67, 45, 'phượng hoàng gián', 1, 2324.00, NULL),
(68, 46, 'trứng rán', 1, 1212.00, NULL),
(69, 47, 'phượng hoàng gián', 1, 2324.00, NULL),
(70, 48, 'trứng rán', 6, 1212.00, NULL),
(71, 48, 'phượng hoàng gián', 18, 2324.00, NULL),
(72, 49, 'trứng rán', 1, 1212.00, NULL),
(73, 50, 'trứng rán', 1, 1212.00, NULL),
(74, 51, 'trứng rán', 3, 1212.00, NULL),
(75, 51, 'phượng hoàng gián', 2, 2324.00, NULL),
(76, 52, 'trứng rán', 2, 1212.00, NULL),
(77, 54, 'phượng hoàng gián', 1, 2324.00, NULL),
(78, 55, 'trứng rán', 1, 1212.00, NULL),
(79, 57, 'trứng rán', 1, 1212.00, NULL),
(80, 57, 'phượng hoàng gián', 1, 2324.00, NULL),
(81, 58, 'phượng hoàng gián', 1, 2324.00, NULL),
(82, 59, 'phượng hoàng gián', 1, 2324.00, NULL),
(83, 60, 'phượng hoàng gián', 1, 2324.00, NULL),
(84, 61, 'phượng hoàng gián', 1, 2324.00, NULL),
(85, 62, 'phượng hoàng gián', 1, 2324.00, NULL),
(86, 63, 'phượng hoàng gián', 1, 2324.00, NULL),
(87, 64, 'phượng hoàng gián', 1, 2324.00, NULL),
(88, 65, 'phượng hoàng gián', 1, 2324.00, NULL),
(89, 66, 'sườn xào chua ngọt', 1, 222.00, NULL),
(90, 67, 'trứng rán', 3, 1212.00, NULL),
(91, 68, 'trứng rán', 1, 1212.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_table`
--

CREATE TABLE `restaurant_table` (
  `table_id` int(11) NOT NULL,
  `table_number` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'empty',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_table`
--

INSERT INTO `restaurant_table` (`table_id`, `table_number`, `status`, `user_id`) VALUES
(28, 2, 'empty', NULL),
(30, 4, 'booked', 3),
(31, 5, 'empty', NULL),
(32, 6, 'empty', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `table_orders`
--

CREATE TABLE `table_orders` (
  `table_id` int(11) DEFAULT NULL,
  `dish_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_orders`
--

INSERT INTO `table_orders` (`table_id`, `dish_id`, `quantity`) VALUES
(25, 9, 1),
(25, 10, 1),
(25, 14, 1),
(3, 9, 3),
(3, 17, 1),
(27, 26, 3),
(27, 27, 1),
(29, 26, 3),
(29, 27, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `phone_number` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` text NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `phone_number`, `email`, `password`, `role`) VALUES
(2, 'vu01', 774303475, 'nguyenvu00304@gmail.com', '$2y$10$wbLfwustkWn9l9ptvZhih.Zw1lRbBAxWtQe9UmYxjh3jCUFvC7Mve', 1),
(3, 'vu02', 2147483647, 'pimpompimpom4@gmail.com', '$2y$10$buj6FdOyU050oMJ/2.D4iuJms.WPjV0BrH5FxjovAfZ2GZXasweyW', 0),
(4, 'vu03', 2147483647, 'aoiuhfds@gmail.com', '$2y$10$WUpUXjQ5TlG/XJSq5VUYr.N/LU9QVVC4cmB/8wscfPJcre2CovanC', 0),
(5, 'vugiau', 123456789, 'hoa@gmail.com', '$2y$10$yQWqMzTQ4pVBC31Nafhu0e0sNd0vI5Vdz0xeKTLkIP7XSiuXDkDX6', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_history`
--
ALTER TABLE `booking_history`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dish_ingredients`
--
ALTER TABLE `dish_ingredients`
  ADD PRIMARY KEY (`dish_id`,`ingredient_id`),
  ADD KEY `ingredient_id` (`ingredient_id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ingredient_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`dish_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `restaurant_table`
--
ALTER TABLE `restaurant_table`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_history`
--
ALTER TABLE `booking_history`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `ingredient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `dish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `restaurant_table`
--
ALTER TABLE `restaurant_table`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_history`
--
ALTER TABLE `booking_history`
  ADD CONSTRAINT `booking_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `dish_ingredients`
--
ALTER TABLE `dish_ingredients`
  ADD CONSTRAINT `dish_ingredients_ibfk_1` FOREIGN KEY (`dish_id`) REFERENCES `menu` (`dish_id`),
  ADD CONSTRAINT `dish_ingredients_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`ingredient_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
