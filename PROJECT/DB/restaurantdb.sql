-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2024 at 04:19 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

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
  `people` int(11) DEFAULT NULL,
  `special_request` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `dish_id` int(11) NOT NULL,
  `dish_name` varchar(100) NOT NULL,
  `dish_sold_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dish_ingredients`
--

CREATE TABLE `dish_ingredients` (
  `dish_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `quantity_required` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dish_ingredients`
--

INSERT INTO `dish_ingredients` (`dish_id`, `ingredient_id`, `quantity_required`) VALUES
(26, 11, NULL),
(27, 10, NULL);

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
(10, 'phượng hoàng', 5, 0),
(11, 'trứng gà', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `dish_id` int(11) NOT NULL,
  `dish_name` varchar(100) NOT NULL,
  `dish_describe` text DEFAULT NULL,
  `price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`dish_id`, `dish_name`, `dish_describe`, `price`) VALUES
(26, 'trứng rán', 'hành', 1212),
(27, 'phượng hoàng gián', 'ngon', 2324);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `invoice_code` varchar(255) NOT NULL,
  `order_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `order_date`, `invoice_code`, `order_code`) VALUES
(1, NULL, 620.00, '2024-09-24 01:57:39', '', NULL),
(2, NULL, 300.00, '2024-09-24 01:58:43', '', NULL),
(3, NULL, 340.00, '2024-09-24 02:02:17', '', NULL),
(4, 3, 960.00, '2024-09-28 12:03:50', '', NULL),
(5, 3, 20.00, '2024-09-28 12:08:12', '', NULL),
(6, 4, 500.00, '2024-09-28 12:08:39', '', NULL),
(7, 3, 200.00, '2024-09-28 12:09:03', '', NULL),
(8, 3, 800.00, '2024-09-28 12:16:57', '', NULL),
(9, 3, 500.00, '2024-09-30 23:15:55', '', NULL),
(10, 3, 300.00, '2024-09-30 23:22:07', 'INV66FAD02F853EF', NULL),
(11, 3, 400.00, '2024-09-30 23:24:00', 'INV66FAD0A0A85E1', NULL),
(14, 3, 2540.00, '2024-09-30 23:51:25', '', NULL),
(15, 3, 120.00, '2024-10-03 11:25:35', '', NULL),
(22, 5, 3.00, '2024-10-13 00:19:52', '', NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_table`
--

CREATE TABLE `restaurant_table` (
  `table_id` int(11) NOT NULL,
  `table_number` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'empty'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_table`
--

INSERT INTO `restaurant_table` (`table_id`, `table_number`, `status`) VALUES
(27, 1, 'empty'),
(28, 2, 'empty'),
(29, 3, 'empty');

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
(3, 17, 1);

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
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`dish_id`);

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
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `dish_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `ingredient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `dish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `restaurant_table`
--
ALTER TABLE `restaurant_table`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_history`
--
ALTER TABLE `booking_history`
  ADD CONSTRAINT `booking_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `dishes`
--
ALTER TABLE `dishes`
  ADD CONSTRAINT `fk_dish_menu` FOREIGN KEY (`dish_id`) REFERENCES `menu` (`dish_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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