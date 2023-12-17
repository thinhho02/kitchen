-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2023 at 10:01 AM
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
-- Database: `kitchen_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Canh'),
(2, 'Món chiên'),
(3, 'Món xào'),
(4, 'Tráng miệng');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `dish_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` int(10) NOT NULL,
  `description` text NOT NULL,
  `is_approved` tinyint(1) NOT NULL,
  `remove` tinyint(1) NOT NULL,
  `created_time` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_time` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`dish_id`, `category_id`, `name`, `image`, `price`, `description`, `is_approved`, `remove`, `created_time`, `updated_time`) VALUES
(3, 1, 'Canh cà chua trứng', 'canhcachuatrung.png', 20000, 'Canh cà chua nấu chung với trứng gà, đậm đà đến từng muỗng!', 1, 0, '2023-11-05 10:03:21', '2023-12-02 00:17:16'),
(4, 2, 'Tôm chiên xù', 'tomchienxu.png', 15000, 'Tôm chiên giòn rụm, ngon đến từng miếng', 1, 0, '2023-11-05 10:03:21', '2023-12-02 00:17:22'),
(5, 3, 'Sườn xào chua ngọt', 'suonxaochuangot.png', 30000, 'Sường xào hai vị chua ngọt, thơm ngón nứt mũi', 1, 0, '2023-11-05 10:03:21', '2023-12-02 00:17:26'),
(6, 4, 'Rau câu dừa', 'raucaudua.png', 0, 'Rau câu dừa truyền thống, được phủ thêm lớp cốt dừa béo ngậy', 1, 0, '2023-11-05 10:03:21', '2023-11-30 20:12:29'),
(7, 1, 'Canh rau ngót thịt bằm', 'raungot.jpg', 0, 'Canh rau ngót nấu kèm thịt bằm,thơm ngon đủ chất!', 1, 0, '2023-11-05 10:08:12', '2023-11-30 20:11:52'),
(8, 2, 'Cá thu chiên sốt cà', 'cathu.jpg ', 30000, 'Cá thu tươi ngon, chiên cùng sốt cà chua rất bắt cơm', 1, 0, '2023-11-05 10:08:12', '2023-12-16 17:48:23'),
(9, 3, 'Lòng xào dưa', 'longxao.jpg', 14000, 'Món ăn quen thuộc, thích hợp với các buổi cơm trưa', 1, 0, '2023-11-05 10:08:12', '2023-12-16 16:23:44'),
(10, 4, 'Panna Cotta', 'panna.jpg', 0, 'Panna cotta được làm bằng sữa tươi chất lượng, thêm lớp kem sốt dâu là món tráng miệng tuyệt vời', 0, 0, '2023-11-05 10:08:12', '2023-12-16 18:45:36');

-- --------------------------------------------------------

--
-- Table structure for table `dish_detail`
--

CREATE TABLE `dish_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `dish_id` int(10) UNSIGNED NOT NULL,
  `resource_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dish_detail`
--

INSERT INTO `dish_detail` (`id`, `dish_id`, `resource_id`, `quantity`) VALUES
(1, 3, 1, 2),
(2, 3, 2, 3),
(3, 7, 3, 3),
(4, 7, 4, 3),
(5, 5, 5, 1),
(6, 5, 1, 3),
(7, 9, 6, 2),
(8, 9, 7, 2),
(9, 8, 1, 2),
(10, 8, 8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` varchar(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_number` varchar(12) NOT NULL,
  `birthdate` date NOT NULL,
  `debt` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `roles` varchar(255) NOT NULL,
  `created_time` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_time` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `first_name`, `last_name`, `avatar`, `number`, `email`, `password`, `id_number`, `birthdate`, `debt`, `status`, `roles`, `created_time`, `updated_time`) VALUES
('NV471102', 'Hồ Công', 'Thịnh', 'hocongthinh.jpg', '0326429044', 'thinhhocm02@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$RzN2Q3FtVWZKZ0dvVE1SaQ$OLEupo7lL4r3d/Mbop8nf4GSjOAGV9s1cOJuD47nDUo', '232323232323', '2002-01-02', 2080000, 0, 'employee', '2023-11-25 18:14:52', '2023-12-17 03:06:01'),
('NV541026', 'Trần Đại', 'Phúc', 'phuc.png', '0909831147', 'trandaiphuc2711@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$OG1DQ0VZaFA3NXhmZ3pWZA$7cADXGUAGxlgeXKV8oqAblhriaoByZxBHWXf+0EBzHg', '123123333232', '2002-11-27', 550000, 0, 'employee', '2023-10-25 13:26:01', '2023-12-16 21:54:00'),
('NV561787', 'thinh', 'ho', 'adrian-rodriguez-glitch-frame.jpg', '1231233213', 'taquocthong.nct.2020@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$OG1DQ0VZaFA3NXhmZ3pWZA$7cADXGUAGxlgeXKV8oqAblhriaoByZxBHWXf+0EBzHg', '123232323232', '2002-02-02', 0, 0, 'chef', '2023-11-15 15:35:06', '2023-12-17 01:22:24'),
('NV582705', 'Trần Mạnh', 'Quân', 'wp6743882.jpg', '0968033196', 'quan91023@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$WGQ2V0JkN2paU01yZGVMSg$EzJTQrS591rOZhQBumEHuHSNrGmkhrAk2hiqtGwJMUY', '2414123213', '2002-08-28', 0, 0, 'deliver', '2023-12-12 21:23:31', '2023-12-12 21:23:31'),
('NV866060', 'Kim', 'Xuân', 'xuan.png', '2302923812', 'xuanxuannguyen1810@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$Zmc1T2I4aUJBL25PZVJlcg$TxzybJv2o7OoM6ea3ilQ3WRV4jdTSbnKAsh3Ih+bPZA', '232049728991', '2002-02-02', 0, 0, 'manager', '2023-12-16 18:28:41', '2023-12-16 18:29:11');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(10) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `price` int(10) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `status`, `price`, `date`) VALUES
(1, 'food', 20000, '2023-12-17'),
(2, 'food', 30000, '2023-12-13'),
(3, 'food', 10000, '2023-12-13'),
(4, 'menu', 50000, '2023-12-14'),
(5, 'menu', 40000, '2023-12-13'),
(6, 'food', 20000, '2023-12-17'),
(7, 'menu', 40000, '2023-12-18');

-- --------------------------------------------------------

--
-- Table structure for table `menu_list`
--

CREATE TABLE `menu_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `dish_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_list`
--

INSERT INTO `menu_list` (`id`, `menu_id`, `dish_id`) VALUES
(1, 1, 3),
(2, 2, 5),
(3, 3, 7),
(4, 4, 3),
(5, 4, 5),
(6, 5, 7),
(7, 5, 5),
(8, 6, 9),
(9, 7, 7),
(10, 7, 8);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `trading_code` varchar(10) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `total` int(10) NOT NULL,
  `created_time` date NOT NULL,
  `updated_time` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `employee_id`, `trading_code`, `payment_method`, `status`, `total`, `created_time`, `updated_time`) VALUES
(27, 'NV471102', '', '', 0, 2080000, '2023-12-09', '2023-12-16 22:52:02'),
(33, 'NV541026', '', '', 0, 550000, '2023-12-11', '2023-12-16 21:39:21'),
(34, 'NV471102', '434159', 'vnpay', 1, 50000, '2023-11-01', '2023-12-16 19:25:44'),
(35, 'NV541026', '202312', 'vnpay', 1, 2000000, '2022-12-12', '2023-12-16 19:26:39'),
(36, 'NV541026', '232123', 'vnpay', 1, 1000000, '2021-12-01', '2023-12-14 00:37:02'),
(37, 'NV471102', '123233', 'vnpay', 1, 40000, '2022-04-01', '2023-12-16 19:26:43'),
(38, 'NV471102', '123214', 'vnpay', 1, 50000, '2022-11-01', '2023-12-16 19:26:47'),
(39, 'NV471102', '123314', 'vnpay', 1, 60000, '2022-10-01', '2023-12-14 21:39:52'),
(40, 'NV471102', '1233314', 'vnpay', 1, 70000, '2022-09-01', '2023-12-14 21:39:52'),
(41, 'NV471102', '1232334', 'vnpay', 1, 210000, '2022-08-01', '2023-12-14 21:39:52'),
(42, 'NV471102', '1232314', 'vnpay', 1, 30000, '2022-07-01', '2023-12-14 21:39:52'),
(43, 'NV471102', '1223314', 'vnpay', 1, 50000, '2022-06-01', '2023-12-14 21:39:52'),
(44, 'NV471102', '1323314', 'vnpay', 1, 190000, '2022-05-01', '2023-12-14 21:39:52');

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `receipt_id` varchar(10) NOT NULL,
  `payment_id` int(10) UNSIGNED NOT NULL,
  `price` int(10) NOT NULL,
  `note` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_time` date NOT NULL,
  `updated_time` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`receipt_id`, `payment_id`, `price`, `note`, `status`, `created_time`, `updated_time`) VALUES
('HD114915', 27, 80000, '', 'shipped', '2023-12-11', '2023-12-12 20:38:38'),
('HD115718', 27, 200000, 'gg', 'shipped', '2023-12-17', '2023-12-16 21:53:36'),
('HD141120', 27, 160000, '754', 'confirmed', '2023-12-12', '2023-12-12 01:28:24'),
('HD152020', 27, 40000, '', 'shipped', '2023-12-11', '2023-12-12 20:38:40'),
('HD172334', 27, 40000, '', 'confirmed', '2023-12-12', '2023-12-12 01:28:24'),
('HD214266', 27, 150000, '', 'confirmed', '2023-12-14', '2023-12-14 15:12:30'),
('HD324413', 27, 20000, '', 'confirmed', '2023-12-12', '2023-12-12 01:28:24'),
('HD342654', 27, 100000, '', 'confirmed', '2023-12-09', '2023-12-09 00:00:04'),
('HD345310', 27, 20000, '', 'confirmed', '2023-12-17', '2023-12-17 03:05:45'),
('HD451813', 27, 80000, '', 'shipped', '2023-12-11', '2023-12-12 20:38:41'),
('HD538199', 33, 80000, 'phuc', 'shipped', '2023-12-11', '2023-12-12 20:38:42'),
('HD625708', 27, 40000, '', 'shipped', '2023-12-11', '2023-12-12 20:38:43'),
('HD628923', 27, 40000, '', 'shipped', '2023-12-13', '2023-12-12 20:32:57'),
('HD636697', 33, 80000, 'ádjad', 'confirming', '2023-12-18', '2023-12-16 21:52:32'),
('HD638330', 27, 80000, '', 'shipped', '2023-12-11', '2023-12-12 20:38:44'),
('HD691333', 33, 200000, 'mm', 'confirmed', '2023-12-12', '2023-12-12 01:28:24'),
('HD837042', 27, 190000, '', 'shipped', '2023-12-13', '2023-12-12 20:30:58'),
('HD849482', 27, 120000, 'dfg', 'shipped', '2023-12-11', '2023-12-12 20:38:45'),
('HD849784', 27, 260000, '12', 'confirmed', '2023-12-12', '2023-12-12 01:28:24'),
('HD867657', 27, 40000, '', 'shipped', '2023-12-11', '2023-12-12 20:38:46'),
('HD887261', 27, 20000, 'sdf', 'confirmed', '2023-12-10', '2023-12-10 00:00:09'),
('HD892062', 27, 70000, 'thinh', 'confirmed', '2023-12-09', '2023-12-09 00:00:04'),
('HD927273', 33, 190000, '', 'shipped', '2023-12-11', '2023-12-12 20:38:47'),
('HD970682', 27, 270000, '9-lpio', 'confirmed', '2023-12-09', '2023-12-09 00:00:04');

-- --------------------------------------------------------

--
-- Table structure for table `receipt_detail`
--

CREATE TABLE `receipt_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `receipt_id` varchar(10) NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `created_time` time NOT NULL DEFAULT current_timestamp(),
  `updated_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `receipt_detail`
--

INSERT INTO `receipt_detail` (`id`, `receipt_id`, `menu_id`, `quantity`, `price`, `created_time`, `updated_time`) VALUES
(153, 'HD342654', 4, 1, 50000, '01:08:26', '2023-12-07 18:08:26'),
(154, 'HD342654', 1, 2, 40000, '01:08:26', '2023-12-07 18:08:26'),
(155, 'HD342654', 3, 1, 10000, '01:08:26', '2023-12-07 18:08:26'),
(156, 'HD892062', 4, 1, 50000, '17:21:45', '2023-12-08 10:21:45'),
(157, 'HD892062', 1, 1, 20000, '17:21:45', '2023-12-08 10:21:45'),
(158, 'HD970682', 4, 5, 250000, '23:41:54', '2023-12-08 16:41:54'),
(159, 'HD970682', 1, 1, 20000, '23:41:54', '2023-12-08 16:41:54'),
(163, 'HD887261', 1, 1, 20000, '15:27:54', '2023-12-09 08:27:54'),
(173, 'HD538199', 5, 2, 80000, '03:26:37', '2023-12-09 20:26:37'),
(175, 'HD867657', 5, 1, 40000, '03:37:06', '2023-12-09 20:37:06'),
(179, 'HD927273', 5, 4, 160000, '03:48:06', '2023-12-09 20:48:06'),
(180, 'HD691333', 1, 10, 200000, '03:49:14', '2023-12-09 20:49:14'),
(181, 'HD927273', 3, 3, 30000, '03:48:06', '2023-12-09 20:48:06'),
(184, 'HD152020', 5, 1, 40000, '18:08:54', '2023-12-10 11:08:54'),
(185, 'HD114915', 5, 2, 80000, '18:10:36', '2023-12-10 11:10:36'),
(186, 'HD451813', 5, 2, 80000, '20:16:36', '2023-12-10 13:16:36'),
(187, 'HD849482', 5, 3, 120000, '21:02:04', '2023-12-10 14:02:04'),
(188, 'HD625708', 5, 1, 40000, '21:04:27', '2023-12-10 14:04:27'),
(190, 'HD638330', 5, 2, 80000, '22:47:26', '2023-12-10 15:47:26'),
(194, 'HD849784', 1, 13, 260000, '12:49:29', '2023-12-11 05:49:29'),
(195, 'HD324413', 1, 1, 20000, '19:06:30', '2023-12-11 12:06:30'),
(201, 'HD141120', 5, 3, 120000, '19:54:19', '2023-12-11 12:54:19'),
(202, 'HD141120', 1, 2, 40000, '19:54:19', '2023-12-11 12:54:19'),
(203, 'HD172334', 5, 1, 40000, '19:59:06', '2023-12-11 12:59:06'),
(206, 'HD837042', 3, 1, 10000, '15:13:22', '2023-12-12 08:13:22'),
(207, 'HD837042', 2, 2, 60000, '15:13:22', '2023-12-12 08:13:22'),
(208, 'HD837042', 5, 3, 120000, '15:13:22', '2023-12-12 08:13:22'),
(210, 'HD628923', 5, 1, 40000, '20:24:36', '2023-12-12 13:24:36'),
(212, 'HD214266', 4, 3, 150000, '14:48:37', '2023-12-13 07:48:37'),
(214, 'HD115718', 6, 10, 200000, '19:22:03', '2023-12-16 12:22:03'),
(215, 'HD636697', 7, 2, 80000, '21:39:21', '2023-12-16 14:39:21'),
(216, 'HD345310', 1, 1, 20000, '22:52:02', '2023-12-16 15:52:02');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `name`, `unit`, `price`) VALUES
(1, 'cà chua', 'trái', 1000),
(2, 'trứng', 'trái', 3000),
(3, 'rau ngót', 'gram', 6000),
(4, 'thịt bằm', 'gram', 10000),
(5, 'sườn non', 'gram', 10000),
(6, 'dưa leo', 'trái', 2000),
(7, 'lòng heo', 'gram', 5000),
(8, 'cá thu', 'gram', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` varchar(10) NOT NULL,
  `dish_id` int(10) UNSIGNED NOT NULL,
  `review` int(1) NOT NULL,
  `comment` text NOT NULL,
  `created_time` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_time` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `employee_id`, `dish_id`, `review`, `comment`, `created_time`, `updated_time`) VALUES
(1, 'NV471102', 3, 5, 'đây là món ăn tuyệt vời', '2023-12-01 18:16:44', '2023-12-01 18:16:44'),
(2, 'NV541026', 3, 2, 'cũng tạm', '2023-12-01 18:45:02', '2023-12-01 19:39:34'),
(3, 'NV561787', 3, 5, 'lsajfdlkfjdflkdsjdslkjsdlkf', '2023-12-02 19:50:17', '2023-12-02 19:50:17'),
(4, 'NV471102', 3, 4, 'sadf', '2023-12-07 19:24:37', '2023-12-07 19:24:37'),
(5, 'NV471102', 3, 5, 'món ăn ngon', '2023-12-07 19:40:32', '2023-12-07 19:40:32'),
(6, 'NV471102', 3, 5, 'ádsadds', '2023-12-07 19:42:15', '2023-12-07 19:42:15'),
(7, 'NV471102', 3, 1, 'sdsdsd', '2023-12-07 19:44:57', '2023-12-07 19:44:57'),
(8, 'NV471102', 7, 5, 'ngon', '2023-12-07 19:45:14', '2023-12-07 19:45:14'),
(9, 'NV541026', 7, 5, 'ngon đấy', '2023-12-07 19:47:44', '2023-12-07 19:47:44'),
(10, 'NV541026', 7, 1, 'như cc', '2023-12-07 19:50:57', '2023-12-07 19:50:57'),
(11, 'NV471102', 3, 5, 'ngon', '2023-12-09 23:19:52', '2023-12-09 23:19:52'),
(12, 'NV541026', 3, 1, 'dỡ ẹt', '2023-12-11 00:28:32', '2023-12-11 00:28:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`dish_id`),
  ADD KEY `fk_dish_cate` (`category_id`);

--
-- Indexes for table `dish_detail`
--
ALTER TABLE `dish_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dish_list` (`dish_id`),
  ADD KEY `fk_resource_list` (`resource_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `menu_list`
--
ALTER TABLE `menu_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu_dish` (`dish_id`),
  ADD KEY `fk_menu_detail` (`menu_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employee_payment` (`employee_id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`receipt_id`),
  ADD KEY `payment_receipts` (`payment_id`);

--
-- Indexes for table `receipt_detail`
--
ALTER TABLE `receipt_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_receipt_detail` (`receipt_id`),
  ADD KEY `fk_menu_receipts` (`menu_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_review_employee` (`employee_id`),
  ADD KEY `fk_review_dish` (`dish_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `dish_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dish_detail`
--
ALTER TABLE `dish_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `menu_list`
--
ALTER TABLE `menu_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `receipt_detail`
--
ALTER TABLE `receipt_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dishes`
--
ALTER TABLE `dishes`
  ADD CONSTRAINT `fk_dish_cate` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dish_detail`
--
ALTER TABLE `dish_detail`
  ADD CONSTRAINT `fk_dish_list` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`dish_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_resource_list` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_list`
--
ALTER TABLE `menu_list`
  ADD CONSTRAINT `fk_menu_detail` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_menu_dish` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`dish_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_employee_payment` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `receipts`
--
ALTER TABLE `receipts`
  ADD CONSTRAINT `payment_receipts` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `receipt_detail`
--
ALTER TABLE `receipt_detail`
  ADD CONSTRAINT `fk_menu_receipts` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_receipt_detail` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`receipt_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `fk_review_dish` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`dish_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_review_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
