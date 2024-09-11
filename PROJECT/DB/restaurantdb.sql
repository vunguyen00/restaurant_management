-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2024 at 06:54 PM
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
-- Database: `dacs`
--
CREATE DATABASE IF NOT EXISTS `dacs` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dacs`;

-- --------------------------------------------------------

--
-- Table structure for table `tblbill`
--

CREATE TABLE `tblbill` (
  `user` varchar(50) NOT NULL,
  `seat` varchar(4) NOT NULL,
  `movie_name` text NOT NULL,
  `total` int(11) NOT NULL,
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblbill`
--

INSERT INTO `tblbill` (`user`, `seat`, `movie_name`, `total`, `code`) VALUES
('vũ', 'E5', 'QUỶ ÁM', 150, '66b5f9b4ba1f1');

-- --------------------------------------------------------

--
-- Table structure for table `tblmovie`
--

CREATE TABLE `tblmovie` (
  `movie_id` int(50) NOT NULL,
  `movie_name` varchar(50) NOT NULL,
  `image_movie` text NOT NULL,
  `describe_movie` text NOT NULL,
  `date` date NOT NULL,
  `number_tickets_sold` varchar(50) NOT NULL,
  `price` varchar(50) NOT NULL,
  `status_movie` varchar(10) NOT NULL,
  `screen_id` int(11) NOT NULL,
  `thoiLuong` int(10) NOT NULL,
  `daoDien` text NOT NULL,
  `doanhThu` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tblmovie`
--

INSERT INTO `tblmovie` (`movie_id`, `movie_name`, `image_movie`, `describe_movie`, `date`, `number_tickets_sold`, `price`, `status_movie`, `screen_id`, `thoiLuong`, `daoDien`, `doanhThu`) VALUES
(1, 'QUỶ ÁM', 'https://cinestar.com.vn/pictures/Cinestar/10-2023/quy-am-tin-do.jpg', 'Phần tiếp theo của bộ phim năm 1973 kể về một cô bé 12 tuổi bị ám bởi một thực thể ma quỷ bí ẩn, buộc mẹ cô phải tìm đến sự giúp đỡ của hai linh mục để cứu cô.', '2024-07-15', '', '45000', 'playing', 1, 75, 'Leslie Odom Jr., Ellen Burstyn, Lidya Jewett, Olivia Marcum, Ann Dowd', 664150),
(2, 'ĐẤT RỪNG PHƯƠNG NAM (K)', 'https://cinestar.com.vn/pictures/Cinestar/10-2023/poster-dat-rung-phuong-nam.jpg', 'Sau bao ngày chờ đợi, dự án điện ảnh gợi ký ức tuổi thơ của nhiều thế hệ người Việt chính thức tung hình ảnh đầu tiên đầy cảm xúc. First look poster khắc họa hình ảnh đối lập: bé An đang ôm chặt mẹ giữa một khung cảnh chạy giặc loạn lạc. Cùng chờ đợi và theo dõi thêm hành trình bé An đi tìm cha khắp nam kỳ lục tỉnh cùng các người bạn đồng hành nhé!', '2024-07-16', '', '45000', 'playing', 2, 80, 'Nguyễn Quang Dũng', 0),
(3, 'KRAVEN THỢ SĂN THỦ LĨNH', 'https://cinestar.com.vn/pictures/Cinestar/10-2023/kraven.jpg', 'Gã nhập cư Nga Sergei Kravinoff đang thực hiện nhiệm vụ chứng minh rằng anh ta là thợ săn vĩ đại nhất thế giới.', '2024-07-16', '', '45000', 'playing', 3, 80, 'J.C. Chandor', 1040000),
(4, 'MỸ NHÂN ĐẠO CHÍCH', 'https://cinestar.com.vn/pictures/Cinestar/11-2023/my-nhan-dao-chich.jpg', 'Cặp mẹ con “đạo chích” Ji Hye - Joo Yeong từng thực hiện vô số phi vụ thành công, nhưng mà là… công cốc. Để khép lại sự nghiệp không mấy vẻ vang này, Ji Hye lên kế hoạch trộm số vàng với giá trị lên đến 60 tỷ Won bằng cách lợi dụng trái tim mong manh mới biết yêu của anh chàng tài phiệt Wan Gyu. Nhưng phi vụ đặc biệt này không hề suôn sẻ khi cũng có những kẻ khác đang nhòm ngó số vàng kếch xù này.', '2024-07-16', '', '45000', 'playing', 4, 80, 'Lee Seung-Joon', 0),
(5, 'MỸ NHÂN ĐẠO CHÍCH 2', 'https://cinestar.com.vn/pictures/Cinestar/11-2023/my-nhan-dao-chich.jpg', 'Cặp mẹ con “đạo chích” Ji Hye - Joo Yeong từng thực hiện vô số phi vụ thành công, nhưng mà là… công cốc. Để khép lại sự nghiệp không mấy vẻ vang này, Ji Hye lên kế hoạch trộm số vàng với giá trị lên đến 60 tỷ Won bằng cách lợi dụng trái tim mong manh mới biết yêu của anh chàng tài phiệt Wan Gyu. Nhưng phi vụ đặc biệt này không hề suôn sẻ khi cũng có những kẻ khác đang nhòm ngó số vàng kếch xù này.', '2024-07-16', '', '45000', 'comming', 4, 80, 'Lee Seung-Joon', 0),
(6, 'QUỶ ÁM 2', 'https://cinestar.com.vn/pictures/Cinestar/10-2023/quy-am-tin-do.jpg', 'Phần tiếp theo của bộ phim năm 1973 kể về một cô bé 12 tuổi bị ám bởi một thực thể ma quỷ bí ẩn, buộc mẹ cô phải tìm đến sự giúp đỡ của hai linh mục để cứu cô.', '2024-07-14', '', '45000', 'comming', 1, 75, 'Leslie Odom Jr., Ellen Burstyn, Lidya Jewett, Olivia Marcum, Ann Dowd', 0),
(7, 'ĐẤT RỪNG PHƯƠNG NAM 2 (K)', 'https://cinestar.com.vn/pictures/Cinestar/10-2023/poster-dat-rung-phuong-nam.jpg', 'Sau bao ngày chờ đợi, dự án điện ảnh gợi ký ức tuổi thơ của nhiều thế hệ người Việt chính thức tung hình ảnh đầu tiên đầy cảm xúc. First look poster khắc họa hình ảnh đối lập: bé An đang ôm chặt mẹ giữa một khung cảnh chạy giặc loạn lạc. Cùng chờ đợi và theo dõi thêm hành trình bé An đi tìm cha khắp nam kỳ lục tỉnh cùng các người bạn đồng hành nhé!', '2024-07-16', '', '45000', 'comming', 2, 80, 'Nguyễn Quang Dũng', 0),
(8, 'KRAVEN THỢ SĂN THỦ LĨNH 2', 'https://cinestar.com.vn/pictures/Cinestar/10-2023/kraven.jpg', 'Gã nhập cư Nga Sergei Kravinoff đang thực hiện nhiệm vụ chứng minh rằng anh ta là thợ săn vĩ đại nhất thế giới.', '2024-07-16', '', '45000', 'comming', 3, 80, 'J.C. Chandor', 0),
(9, 'HÀNH TINH CÁT PHẦN 2', 'https://cinestar.com.vn/pictures/Cinestar/11-2023/dune-poster.jpg', 'Dune: Hành tinh cát - Phần hai là bộ phim sử thi khoa học viễn tưởng của Mỹ ra mắt năm 2023 do Denis Villeneuve đạo diễn vởi kịch bản do Villeneuve, Jon Spaihts và Eric Roth cùng chấp bút.', '2024-07-15', '', '45000', 'playing', 5, 80, 'Denis Villeneuve', 45000),
(10, 'HÀNH TINH CÁT PHẦN 3', 'https://cinestar.com.vn/pictures/Cinestar/11-2023/dune-poster.jpg', 'Dune: Hành tinh cát - Phần hai là bộ phim sử thi khoa học viễn tưởng của Mỹ ra mắt năm 2023 do Denis Villeneuve đạo diễn vởi kịch bản do Villeneuve, Jon Spaihts và Eric Roth cùng chấp bút.', '2024-07-15', '', '45000', 'comming', 5, 80, 'Denis Villeneuve', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblscreen`
--

CREATE TABLE `tblscreen` (
  `screen_id` int(11) NOT NULL,
  `movie_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblseat`
--

CREATE TABLE `tblseat` (
  `seat_id` int(11) NOT NULL,
  `seat_name` varchar(5) NOT NULL,
  `screen_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tblseat`
--

INSERT INTO `tblseat` (`seat_id`, `seat_name`, `screen_id`, `status`) VALUES
(1, 'A1', 2, 'available'),
(2, 'A2', 2, 'available'),
(3, 'A3', 2, 'unavailable'),
(4, 'A4', 3, 'unavailable'),
(5, 'A5', 3, 'unavailable'),
(6, 'B1', 3, 'unavailable'),
(7, 'B2', 4, 'unavailable'),
(8, 'B3', 4, 'unavailable'),
(9, 'B4', 4, 'available'),
(10, 'C1', 5, 'available'),
(11, 'C2', 5, 'available'),
(12, 'C3', 5, 'unavailable'),
(13, 'C4', 6, 'available'),
(14, 'D1', 6, 'available'),
(15, 'D2', 6, 'available'),
(16, 'D3', 7, 'available'),
(17, 'D4', 7, 'available'),
(18, 'E1', 7, 'available'),
(19, 'E2', 7, 'available'),
(20, 'E3', 7, 'available'),
(41, 'A1', 1, 'unavailable'),
(42, 'A2', 1, 'unavailable'),
(43, 'A3', 1, 'unavailable'),
(44, 'A4', 1, 'unavailable'),
(45, 'A5', 1, 'unavailable'),
(46, 'B1', 1, 'unavailable'),
(47, 'B2', 1, 'unavailable'),
(48, 'B3', 1, 'unavailable'),
(49, 'B4', 1, 'unavailable'),
(50, 'B5', 1, 'available'),
(51, 'C1', 1, 'available'),
(52, 'C2', 1, 'available'),
(53, 'C3', 1, 'unavailable'),
(54, 'C4', 1, 'available'),
(55, 'C5', 1, 'available'),
(56, 'D1', 1, 'available'),
(57, 'D2', 1, 'available'),
(58, 'D3', 1, 'available'),
(59, 'D4', 1, 'unavailable'),
(60, 'D5', 1, 'available'),
(61, 'E1', 1, 'available'),
(62, 'E2', 1, 'available'),
(63, 'E3', 1, 'unavailable'),
(64, 'E4', 1, 'available'),
(65, 'E5', 1, 'unavailable');

-- --------------------------------------------------------

--
-- Table structure for table `tblshowtime`
--

CREATE TABLE `tblshowtime` (
  `showtime_id` int(11) NOT NULL,
  `thoiGian` time NOT NULL,
  `date` date NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tblshowtime`
--

INSERT INTO `tblshowtime` (`showtime_id`, `thoiGian`, `date`, `movie_id`) VALUES
(1, '12:00:00', '2024-07-05', 1),
(2, '22:52:00', '2024-07-10', 1),
(3, '14:00:00', '2024-07-05', 1),
(4, '15:00:00', '2024-07-05', 1),
(5, '04:00:00', '2024-07-15', 2),
(6, '07:00:00', '2024-07-15', 2),
(7, '08:00:00', '2024-07-15', 3),
(8, '17:00:00', '2024-07-15', 3),
(9, '09:00:00', '2024-07-15', 4),
(10, '20:10:00', '2024-07-22', 9);

-- --------------------------------------------------------

--
-- Table structure for table `tblticket`
--

CREATE TABLE `tblticket` (
  `id` int(11) NOT NULL,
  `movie` varchar(255) NOT NULL,
  `DATE` date NOT NULL,
  `TIME` time NOT NULL,
  `seat` varchar(255) NOT NULL,
  `food` varchar(255) DEFAULT NULL,
  `total_price` int(11) NOT NULL,
  `userName` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblticket`
--

INSERT INTO `tblticket` (`id`, `movie`, `DATE`, `TIME`, `seat`, `food`, `total_price`, `userName`) VALUES
(1, 'QUỶ ÁM', '2024-07-10', '22:52:00', 'E3', '[]', 45, ''),
(2, 'QUỶ ÁM', '2024-07-05', '12:00:00', 'D4', '{\"COMBO SOLO\":0,\"COMBO COUPLE\":1,\"COMBO PARTY\":0}', 150, ''),
(3, 'QUỶ ÁM', '2024-07-05', '12:00:00', 'B4', '{\"COMBO SOLO\":1,\"COMBO COUPLE\":0,\"COMBO PARTY\":0}', 129, ''),
(5, 'QUỶ ÁM', '2024-07-05', '12:00:00', 'A1', '{\"COMBO SOLO\":0,\"COMBO COUPLE\":0,\"COMBO PARTY\":0}', 45000, 'vũ'),
(6, 'QUỶ ÁM', '2024-07-05', '14:00:00', 'A2', '{\"COMBO SOLO\":0,\"COMBO COUPLE\":0,\"COMBO PARTY\":0}', 45000, 'vũ'),
(7, 'QUỶ ÁM', '2024-07-10', '22:52:00', 'B2', '{\"COMBO SOLO\":0,\"COMBO COUPLE\":0,\"COMBO PARTY\":0}', 45000, 'vũ'),
(8, 'QUỶ ÁM', '2024-07-10', '22:52:00', 'B1', '{\"COMBO SOLO\":0,\"COMBO COUPLE\":1,\"COMBO PARTY\":0}', 195000, 'baso'),
(9, 'QUỶ ÁM', '2024-07-10', '22:52:00', 'A5', '{\"COMBO SOLO\":0,\"COMBO COUPLE\":1,\"COMBO PARTY\":0}', 195000, 'baso'),
(10, 'QUỶ ÁM', '2024-07-15', '09:00:00', 'B3', '{\"COMBO SOLO\":0,\"COMBO COUPLE\":0,\"COMBO PARTY\":0}', 45000, 'vũ'),
(11, 'QUỶ ÁM', '2024-07-15', '17:00:00', 'B1', '{\"COMBO SOLO\":0,\"COMBO COUPLE\":0,\"COMBO PARTY\":1}', 244000, 'vũ'),
(12, 'QUỶ ÁM', '2024-07-15', '09:00:00', 'B2', '{\"COMBO SOLO\":0,\"COMBO COUPLE\":0,\"COMBO PARTY\":0}', 45000, 'vũ'),
(13, 'QUỶ ÁM', '2024-07-15', '17:00:00', 'A4', '{\"COMBO SOLO\":0,\"COMBO COUPLE\":0,\"COMBO PARTY\":0}', 45000, 'vũ'),
(14, '9', '2024-07-22', '20:10:00', 'C3', '{\"COMBO SOLO\":0,\"COMBO COUPLE\":0,\"COMBO PARTY\":0}', 45000, 'vũ'),
(15, '3', '2024-07-15', '17:00:00', 'A5', '{\"COMBO SOLO\":0,\"COMBO COUPLE\":0,\"COMBO PARTY\":5}', 1040000, 'vũ'),
(16, '1', '2024-07-05', '12:00:00', 'A3', '{\"COMBO SOLO\":0,\"COMBO COUPLE\":0,\"COMBO PARTY\":0}', 45000, 'vũ'),
(17, '1', '2024-07-05', '12:00:00', 'E5', '{\"COMBO SOLO\":0,\"COMBO COUPLE\":1,\"COMBO PARTY\":0}', 150, 'vũ');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `user_id` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `token` text NOT NULL,
  `leveluser` varchar(50) NOT NULL,
  `userName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`user_id`, `email`, `password`, `token`, `leveluser`, `userName`) VALUES
(17, 'concoko35@gmail.com', '$2y$10$KUp0dFIB24KIpH4GiZiDE.NnnmMxGYOSRDj2Od0e4.LPuC/g2pDuG', 'Toikoco_12345', '0', 'I trust U'),
(18, 'nguyenvu00304@gmail.com', '$2y$10$yK2tUvsibOdhg4aB8uZij.O/ISAQwpjuDfcOk1qh0WyEl73l01q/i', '25042003Vu_', '1', 'vũ'),
(19, 'pimpompimpom4@gmail.com', '$2y$10$8BPFBw89r1dmd2WYtKGEiuA.QNYtW6SDyk3zh4alXltHMIz/UBZrS', '123456P_', '0', 'baso');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblmovie`
--
ALTER TABLE `tblmovie`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `tblscreen`
--
ALTER TABLE `tblscreen`
  ADD PRIMARY KEY (`screen_id`);

--
-- Indexes for table `tblseat`
--
ALTER TABLE `tblseat`
  ADD PRIMARY KEY (`seat_id`);

--
-- Indexes for table `tblshowtime`
--
ALTER TABLE `tblshowtime`
  ADD PRIMARY KEY (`showtime_id`);

--
-- Indexes for table `tblticket`
--
ALTER TABLE `tblticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblscreen`
--
ALTER TABLE `tblscreen`
  MODIFY `screen_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblseat`
--
ALTER TABLE `tblseat`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tblshowtime`
--
ALTER TABLE `tblshowtime`
  MODIFY `showtime_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblticket`
--
ALTER TABLE `tblticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Database: `demo_project`
--
CREATE DATABASE IF NOT EXISTS `demo_project` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `demo_project`;

-- --------------------------------------------------------

--
-- Table structure for table `cousre`
--

CREATE TABLE `cousre` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `courseName` varchar(255) NOT NULL,
  `courseDescription` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6, '2014_10_12_000000_create_users_table', 1),
(7, '2014_10_12_100000_create_password_resets_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2024_09_08_071012_create_new_table_name', 1),
(11, '2024_09_08_074711_demo', 1),
(12, '2024_09_08_075802_course', 1);

-- --------------------------------------------------------

--
-- Table structure for table `new_table_name`
--

CREATE TABLE `new_table_name` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cousre`
--
ALTER TABLE `cousre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_table_name`
--
ALTER TABLE `new_table_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cousre`
--
ALTER TABLE `cousre`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `new_table_name`
--
ALTER TABLE `new_table_name`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `message`
--
CREATE DATABASE IF NOT EXISTS `message` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `message`;
--
-- Database: `messaging_app`
--
CREATE DATABASE IF NOT EXISTS `messaging_app` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `messaging_app`;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `timestamp`) VALUES
(1, 1, 3, 'ádasd', '2024-08-29 17:32:47'),
(2, 3, 1, 'aa', '2024-08-29 17:33:29'),
(3, 1, 3, 'dd', '2024-08-29 17:33:35'),
(4, 3, 1, 'aa', '2024-08-29 17:34:45'),
(5, 1, 3, 'add', '2024-08-29 17:38:39'),
(6, 3, 1, 'đ', '2024-08-29 17:38:54'),
(7, 3, 1, 'ád', '2024-08-29 17:41:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'vu', '$2y$10$HBfL/FZE0PwDlIbJyxuvzOguFW1RZl.SWCkW63iuoQt91hCAGeOqq'),
(3, 'vu2', '$2y$10$vgSUs0fe/mtUyChpHtuHVeAoKcbtAgQqurgaax23/5TVQR.dxqn/S');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"restaurantdb\",\"table\":\"restaurant_table\"},{\"db\":\"restaurantdb\",\"table\":\"menu\"},{\"db\":\"restaurantdb\",\"table\":\"dish_ingredients\"},{\"db\":\"restaurantdb\",\"table\":\"ingredient\"},{\"db\":\"restaurantdb\",\"table\":\"booking\"},{\"db\":\"daln\",\"table\":\"menu\"},{\"db\":\"project_1\",\"table\":\"courses\"},{\"db\":\"project_1\",\"table\":\"course\"},{\"db\":\"demo_project\",\"table\":\"users\"},{\"db\":\"messaging_app\",\"table\":\"messages\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2024-09-11 16:07:16', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `project_1`
--
CREATE DATABASE IF NOT EXISTS `project_1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `project_1`;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instructor` varchar(255) NOT NULL,
  `courseHead` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_09_09_001921_create-course', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `restaurantdb`
--
CREATE DATABASE IF NOT EXISTS `restaurantdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `restaurantdb`;

-- --------------------------------------------------------

--
-- Table structure for table `booking_history`
--

CREATE TABLE `booking_history` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `booking_code` varchar(50) DEFAULT NULL,
  `booking_time` datetime DEFAULT NULL,
  `booking_day` date DEFAULT NULL
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
-- Table structure for table `ingredient`
--

CREATE TABLE `ingredient` (
  `ingredient_id` int(11) NOT NULL,
  `ingredient_name` varchar(100) NOT NULL,
  `ingredient_number` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, 'sodfhohi', 'k ngon', 100000);

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
  `table_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_table`
--

INSERT INTO `restaurant_table` (`table_id`, `table_number`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`ingredient_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`dish_id`);

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
-- AUTO_INCREMENT for table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `ingredient_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `dish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurant_table`
--
ALTER TABLE `restaurant_table`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_history`
--
ALTER TABLE `booking_history`
  ADD CONSTRAINT `booking_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `order_history`
--
ALTER TABLE `order_history`
  ADD CONSTRAINT `order_history_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `restaurant_table` (`table_id`),
  ADD CONSTRAINT `order_history_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `menu` (`dish_id`);
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
