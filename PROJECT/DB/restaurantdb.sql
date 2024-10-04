-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2024 at 10:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
  `quantity` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `ingredient_id` int(11) NOT NULL,
  `ingredient_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`ingredient_id`, `ingredient_name`, `quantity`) VALUES
(2, 'thịt ba chỉ ', 10),
(3, 'gà ', 100);

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
(1, 'chicken Wing', 'gà ngon ', 20000),
(2, 'gà đen', 'k ngon', 100000),
(4, 'gà chiên ', 'gà chiên giòn', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `table_id`, `dish_id`, `quantity`) VALUES
(5, 1, 1, 1),
(6, 5, 1, 1),
(7, 5, 2, 1),
(8, 8, 1, 1),
(10, 2, 1, 1),
(11, 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_history`
--

CREATE TABLE `order_history` (
  `order_id` int(11) NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `dish_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
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
(1, 1, 'occupied'),
(2, 2, 'occupied'),
(3, 3, 'occupied'),
(4, 4, 'occupied'),
(5, 5, 'occupied'),
(6, 6, 'occupied'),
(7, 7, 'occupied'),
(8, 8, 'occupied'),
(9, 9, 'occupied'),
(10, 10, 'occupied'),
(11, 11, 'occupied'),
(12, 12, 'occupied'),
(13, 13, 'occupied'),
(14, 14, 'occupied'),
(18, 77, 'occupied'),
(19, 22, 'occupied');

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
(4, 'vu03', 2147483647, 'aoiuhfds@gmail.com', '$2y$10$WUpUXjQ5TlG/XJSq5VUYr.N/LU9QVVC4cmB/8wscfPJcre2CovanC', 0);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `table_id` (`table_id`),
  ADD KEY `dish_id` (`dish_id`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `table_id` (`table_id`),
  ADD KEY `dish_id` (`dish_id`);

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
  MODIFY `ingredient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `dish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurant_table`
--
ALTER TABLE `restaurant_table`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `dish_ingredients_ibfk_1` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`dish_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dish_ingredients_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`ingredient_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `restaurant_table` (`table_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `menu` (`dish_id`);

--
-- Constraints for table `order_history`
--
ALTER TABLE `order_history`
  ADD CONSTRAINT `order_history_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `restaurant_table` (`table_id`),
  ADD CONSTRAINT `order_history_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `menu` (`dish_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
