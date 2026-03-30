-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 30, 2026 at 04:03 PM
-- Server version: 8.4.8
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `se_topup`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `bonus_codes`
--

CREATE TABLE `bonus_codes` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `code` varchar(100) NOT NULL,
  `status` enum('unused','used') DEFAULT 'unused',
  `used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `package_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bonus_codes`
--

INSERT INTO `bonus_codes` (`id`, `user_id`, `code`, `status`, `used_at`, `created_at`, `package_id`) VALUES
(1, 1, 'BONUS20-AAA111', 'unused', NULL, '2026-03-27 14:25:41', NULL),
(2, 1, 'BONUS50-BBB222', 'used', NULL, '2026-03-27 14:25:41', NULL),
(3, 2, 'BONUS20-CCC333', 'used', '2026-03-30 00:03:50', '2026-03-27 14:25:41', NULL),
(4, 5, 'BONUS2681', 'used', '2026-03-30 00:03:40', '2026-03-29 23:47:38', NULL),
(5, 5, 'BONUS3788', 'unused', NULL, '2026-03-30 00:06:02', NULL),
(6, 5, 'BONUS3958', 'unused', NULL, '2026-03-30 00:10:15', NULL),
(7, 5, 'BONUSFBC22F', 'used', '2026-03-30 00:12:16', '2026-03-30 00:11:07', NULL),
(8, 5, 'BONUSAC8ABD', 'used', '2026-03-30 00:39:53', '2026-03-30 00:15:07', NULL),
(9, 5, 'BONUS7B5A80', 'unused', NULL, '2026-03-30 00:32:03', NULL),
(10, 5, 'BONUSAE0E5B', 'unused', NULL, '2026-03-30 01:05:32', NULL),
(11, 5, 'BONUS49A015', 'used', '2026-03-30 05:02:16', '2026-03-30 04:51:58', 1),
(12, 5, 'BONUSC5E7A0', 'used', '2026-03-30 05:04:25', '2026-03-30 05:04:03', 3),
(15, 11, 'BONUS816AEA', 'used', '2026-03-30 15:19:42', '2026-03-30 15:19:37', 2),
(16, 11, 'BONUS953BE2', 'used', '2026-03-30 15:23:19', '2026-03-30 15:23:12', 4),
(17, 11, 'BONUS54AEA6', 'used', '2026-03-30 15:27:14', '2026-03-30 15:27:08', 3),
(18, 11, 'BONUSAE253A', 'used', '2026-03-30 15:32:29', '2026-03-30 15:32:24', 3),
(19, 11, 'BONUS4821AE', 'unused', NULL, '2026-03-30 15:32:25', 3),
(20, 11, 'BONUSD92E03', 'used', '2026-03-30 15:34:23', '2026-03-30 15:34:18', 3),
(21, 11, 'BONUSB2467F', 'unused', NULL, '2026-03-30 15:34:19', 3);

-- --------------------------------------------------------

--
-- Table structure for table `discount_codes`
--

CREATE TABLE `discount_codes` (
  `id` int NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `min_price` decimal(10,2) DEFAULT '0.00',
  `usage_limit` int DEFAULT '1',
  `used_count` int DEFAULT '0',
  `status` enum('ACTIVE','USED','EXPIRED','DISABLED') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `discount_codes`
--

INSERT INTO `discount_codes` (`id`, `code`, `discount_amount`, `min_price`, `usage_limit`, `used_count`, `status`, `created_at`) VALUES
(1, 'SE20', 20.00, 50.00, 100, 4, 'ACTIVE', '2026-03-27 08:53:39'),
(2, 'WELCOME50', 50.00, 200.00, 50, 0, 'ACTIVE', '2026-03-27 08:53:39'),
(3, 'PUNN10', 10.00, 0.00, 999, 0, 'ACTIVE', '2026-03-27 08:53:39'),
(4, 'FLASH100', 100.00, 500.00, 10, 0, 'ACTIVE', '2026-03-27 08:53:39'),
(5, 'NEWUSER30', 30.00, 100.00, 1, 0, 'ACTIVE', '2026-03-27 08:53:39'),
(6, 'SE7943', 20.00, 0.00, 1, 2, 'ACTIVE', '2026-03-27 15:26:01'),
(7, 'SE7687', 20.00, 0.00, 1, 1, 'ACTIVE', '2026-03-27 15:26:03'),
(8, 'SE8802', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-27 15:26:04'),
(9, 'SE4826', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-27 15:26:05'),
(10, 'SE2754', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-27 15:26:06'),
(11, 'SE8829', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-27 15:26:07'),
(12, 'SE1831', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-27 15:26:07'),
(13, 'SE1365', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-27 15:26:08'),
(14, 'SE1522', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-27 15:26:10'),
(15, 'SE5681', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-28 12:27:33'),
(16, 'SE3939', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-28 12:27:42'),
(17, 'SE6340', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-28 12:27:43'),
(18, 'SE4231', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-28 12:28:40'),
(19, 'SE6438', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-29 06:28:15'),
(20, 'SE6844', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-29 08:01:55'),
(21, 'SE1467', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-29 08:02:00'),
(22, 'SE4539', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-29 09:53:38'),
(23, 'SE1179', 20.00, 0.00, 1, 0, 'DISABLED', '2026-03-29 10:01:48'),
(24, 'SE8876', 20.00, 0.00, 1, 0, 'DISABLED', '2026-03-29 10:01:53'),
(25, 'SE3531', 20.00, 0.00, 1, 0, 'DISABLED', '2026-03-29 10:02:09'),
(26, 'SE3248', 20.00, 0.00, 1, 0, 'DISABLED', '2026-03-29 10:05:28'),
(27, 'SE1130', 20.00, 0.00, 1, 0, 'DISABLED', '2026-03-29 13:02:32'),
(28, 'SE1953', 20.00, 0.00, 1, 0, 'DISABLED', '2026-03-29 23:35:17');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('ON','OFF') DEFAULT 'ON',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `category` enum('mobile','pc','gift','sub') DEFAULT 'mobile'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `name`, `image`, `status`, `created_at`, `category`) VALUES
(1, 'ROV', 'uploads/rov.jpg', 'ON', '2026-03-13 03:55:14', 'mobile'),
(2, 'Free Fire', 'uploads/freefire.jpg', 'ON', '2026-03-13 03:55:14', 'mobile'),
(3, 'PUBG Mobile', 'uploads/pubg.jpg', 'ON', '2026-03-13 03:55:14', 'mobile'),
(4, 'Genshin Impact', 'uploads/genshin.jpg', 'ON', '2026-03-13 04:09:36', 'pc'),
(100, 'Valorant', 'uploads/valorant.jpg', 'ON', '2026-03-29 07:29:18', 'pc'),
(101, 'League of Legends', 'uploads/lol.jpg', 'ON', '2026-03-29 07:29:18', 'pc'),
(102, 'Honkai Star Rail', 'uploads/hsr.jpg', 'ON', '2026-03-29 07:29:18', 'mobile'),
(103, 'Call of Duty Mobile', 'uploads/codm.jpg', 'ON', '2026-03-29 07:29:18', 'mobile'),
(104, 'Netflix Subscription', 'uploads/netflix.jpg', 'ON', '2026-03-29 07:29:18', 'sub'),
(105, 'Spotify Premium', 'uploads/spotify.jpg', 'ON', '2026-03-29 07:29:18', 'sub'),
(106, 'Steam Wallet', 'uploads/steam.jpg', 'ON', '2026-03-29 07:29:18', 'gift'),
(107, 'PlayStation Gift Card', 'uploads/ps.jpg', 'ON', '2026-03-29 07:29:18', 'gift'),
(108, 'Arena Breakout', 'uploads/arena.jpg', 'ON', '2026-03-29 07:29:18', 'mobile'),
(109, 'EA Sports FC Mobile', 'uploads/fc.jpg', 'ON', '2026-03-29 07:29:18', 'mobile');

-- --------------------------------------------------------

--
-- Table structure for table `game_uids`
--

CREATE TABLE `game_uids` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `game_id` int NOT NULL,
  `uid` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `game_uids`
--

INSERT INTO `game_uids` (`id`, `user_id`, `game_id`, `uid`, `created_at`) VALUES
(1, 1, 1, '123456789', '2026-03-13 04:06:13'),
(2, 1, 1, '987654321', '2026-03-13 04:06:13'),
(3, 2, 2, '555666777', '2026-03-13 04:06:13'),
(8, 1, 4, 'kuyrai#sus', '2026-03-27 10:22:45'),
(9, 1, 4, 'PunnNAJA#fyck', '2026-03-27 10:22:59'),
(10, 1, 3, 'PunnzaPubg', '2026-03-27 10:40:59'),
(11, 3, 4, 'PunnNAJA#fyck', '2026-03-27 11:17:13'),
(12, 5, 109, 'PunnInwza007', '2026-03-29 08:00:56'),
(13, 5, 100, 'PunnNAJA#fyck', '2026-03-29 08:05:30'),
(14, 5, 100, 'PunnNAJA#fyck', '2026-03-29 08:06:13'),
(15, 5, 103, 'SudlorPunnPunn#007', '2026-03-29 10:12:56'),
(16, 5, 101, 'D0esnotex1st#fyck', '2026-03-29 10:15:00'),
(17, 5, 101, 'd0esnotex1st#fyck', '2026-03-29 10:15:05'),
(18, 5, 2, 'PunnNAJA#fyck', '2026-03-30 00:25:12'),
(19, 11, 100, 'PunnNAJA#fyck', '2026-03-30 15:05:52');

-- --------------------------------------------------------

--
-- Table structure for table `giftcard_stock`
--

CREATE TABLE `giftcard_stock` (
  `id` int NOT NULL,
  `reward_id` int NOT NULL,
  `code` varchar(100) NOT NULL,
  `status` enum('available','used') DEFAULT 'available',
  `used_by` int DEFAULT NULL,
  `used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `giftcard_stock`
--

INSERT INTO `giftcard_stock` (`id`, `reward_id`, `code`, `status`, `used_by`, `used_at`, `created_at`) VALUES
(7, 27, 'STEAM50-BBB222', 'available', NULL, NULL, '2026-03-30 06:15:16'),
(8, 28, 'STEAM100-CCC333', 'available', NULL, NULL, '2026-03-30 06:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `package_id` int DEFAULT NULL,
  `game_uid` varchar(100) NOT NULL,
  `status` enum('pending','success','cancel') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `price` decimal(10,2) NOT NULL,
  `game_name` varchar(255) DEFAULT NULL,
  `package_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `package_id`, `game_uid`, `status`, `created_at`, `price`, `game_name`, `package_name`) VALUES
(9, 1, 1, '123456789', 'success', '2026-03-11 04:30:00', 30.00, 'ROV', '60 UC'),
(10, 2, 2, '987654321', 'success', '2026-03-12 04:04:30', 149.00, 'ROV', '300 UC'),
(11, 3, 3, '555666777', 'cancel', '2026-03-13 04:04:30', 50.00, 'Free Fire', '100 Diamonds'),
(12, 1, 4, '888999000', 'success', '2026-03-13 04:04:30', 150.00, 'PUBG Mobile', '325 UC'),
(15, 4, 8, '800123456', 'success', '2026-03-13 04:11:24', 29.00, 'Genshin Impact', '60 Genesis Crystals'),
(16, 4, 9, '800123456', 'success', '2026-03-23 04:11:24', 149.00, 'Genshin Impact', '300 Genesis Crystals'),
(17, 4, 10, '800987654', 'success', '2026-03-25 04:11:24', 449.00, 'Genshin Impact', '980 Genesis Crystals'),
(18, 1, 9, 'PunnNAJA#fyck', 'success', '2026-03-27 10:32:19', 149.00, 'Genshin Impact', '300 Genesis Crystals'),
(19, 1, 9, 'kuyrai#sus', 'success', '2026-03-27 10:37:11', 149.00, 'Genshin Impact', '300 Genesis Crystals'),
(20, 1, 4, 'PunnzaPubg', 'success', '2026-03-27 10:41:11', 150.00, 'PUBG Mobile', '325 UC'),
(21, 1, 8, 'kuyrai#sus', 'success', '2026-03-27 10:46:02', 29.00, 'Genshin Impact', '60 Genesis Crystals'),
(22, 3, 9, 'PunnNAJA#fyck', 'success', '2026-03-27 11:17:20', 149.00, 'Genshin Impact', '300 Genesis Crystals'),
(71, 3, 8, 'PunnNAJA#fyck', 'success', '2026-03-27 11:45:14', 29.00, 'Genshin Impact', '60 Genesis Crystals'),
(72, 3, 9, 'PunnNAJA#fyck', 'success', '2026-03-27 11:55:11', 129.00, 'Genshin Impact', '300 Genesis Crystals'),
(73, 1, 1, '987654321', 'success', '2026-03-28 12:29:39', 10.00, 'ROV', '60 UC'),
(74, 5, 36, 'PunnInwza007', 'success', '2026-03-29 08:00:40', 150.00, 'EA Sports FC Mobile', '500 FC Points'),
(75, 5, 36, 'PunnInwza007', 'success', '2026-03-29 08:01:00', 150.00, 'EA Sports FC Mobile', '500 FC Points'),
(76, 5, 36, 'PunnInwza007', 'success', '2026-03-29 08:01:10', 150.00, 'EA Sports FC Mobile', '500 FC Points'),
(77, 5, 36, 'PunnInwza007', 'success', '2026-03-29 08:02:19', 130.00, 'EA Sports FC Mobile', '500 FC Points'),
(78, 5, 15, 'PunnNAJA#fyck', 'success', '2026-03-29 08:05:42', 600.00, 'Valorant', '2050 VP'),
(79, 5, 15, 'PunnNAJA#fyck', 'success', '2026-03-29 08:06:18', 600.00, 'Valorant', '2050 VP'),
(80, 5, 21, 'SudlorPunnPunn#007', 'success', '2026-03-29 10:13:04', 29.00, 'Call of Duty Mobile', '80 CP'),
(81, 5, 21, 'SudlorPunnPunn#007', 'success', '2026-03-29 10:13:13', 29.00, 'Call of Duty Mobile', '80 CP'),
(82, 5, 21, 'SudlorPunnPunn#007', 'success', '2026-03-29 10:13:28', 29.00, 'Call of Duty Mobile', '80 CP'),
(83, 5, 21, 'SudlorPunnPunn#007', 'success', '2026-03-29 10:13:36', 29.00, 'Call of Duty Mobile', '80 CP'),
(84, 5, 21, 'SudlorPunnPunn#007', 'success', '2026-03-29 10:13:43', 29.00, 'Call of Duty Mobile', '80 CP'),
(85, 5, 21, 'SudlorPunnPunn#007', 'success', '2026-03-29 10:13:53', 29.00, 'Call of Duty Mobile', '80 CP'),
(86, 5, 17, 'd0esnotex1st#fyck', 'success', '2026-03-29 10:15:11', 400.00, 'League of Legends', '1380 RP'),
(87, 5, 16, 'd0esnotex1st#fyck', 'success', '2026-03-29 10:15:21', 200.00, 'League of Legends', '650 RP'),
(88, 5, 16, 'd0esnotex1st#fyck', 'success', '2026-03-29 10:15:29', 200.00, 'League of Legends', '650 RP'),
(89, 5, 16, 'd0esnotex1st#fyck', 'success', '2026-03-29 10:15:54', 200.00, 'League of Legends', '650 RP'),
(90, 5, 16, 'd0esnotex1st#fyck', 'success', '2026-03-29 10:16:10', 200.00, 'League of Legends', '650 RP'),
(91, 5, 16, 'PunnNAJA#fyck', 'success', '2026-03-29 10:16:22', 200.00, 'League of Legends', '650 RP'),
(92, 5, 13, 'PunnNAJA#fyck', 'success', '2026-03-29 12:50:23', 150.00, 'Valorant', '475 VP'),
(93, 5, 3, '5', 'cancel', '2026-03-30 00:39:53', 0.00, 'Free Fire', '100 Diamonds'),
(94, 5, 3, '5', 'cancel', '2026-03-30 00:47:08', 50.00, 'Free Fire', '100 Diamonds'),
(95, 5, 3, '5', 'cancel', '2026-03-30 00:52:18', 30.00, 'Free Fire', '100 Diamonds'),
(96, 5, 3, '5', 'cancel', '2026-03-30 00:53:05', 30.00, 'Free Fire', '100 Diamonds'),
(97, 5, 3, '5', 'cancel', '2026-03-30 00:56:37', 50.00, 'Free Fire', '100 Diamonds'),
(98, 5, 3, '5', 'cancel', '2026-03-30 01:01:41', 50.00, 'Free Fire', '100 Diamonds'),
(99, 5, 3, 'PunnNAJA#fyck', 'success', '2026-03-30 01:05:40', 50.00, 'Free Fire', '100 Diamonds'),
(100, 5, 1, 'PunnNAJA#fyck', 'success', '2026-03-30 05:02:25', 0.00, 'ROV', '60 UC'),
(101, 5, 3, 'punnpunnlovefreefire', 'success', '2026-03-30 05:04:29', 0.00, 'Free Fire', '100 Diamonds'),
(102, 5, 3, 'PunnNAJA#fyck', 'success', '2026-03-30 05:33:44', 30.00, 'Free Fire', '100 Diamonds'),
(103, 5, 3, 'PunnNAJA#fyck', 'success', '2026-03-30 05:37:04', 30.00, 'Free Fire', '100 Diamonds'),
(104, 5, 3, 'PunnNAJA#fyck', 'success', '2026-03-30 05:37:36', 30.00, 'Free Fire', '100 Diamonds'),
(105, 5, 2, 'PunnNAJA#fyck', 'success', '2026-03-30 05:39:30', 129.00, 'ROV', '300 UC'),
(106, 5, 3, 'punnpunnlovefreefire', 'success', '2026-03-30 07:39:07', 50.00, 'Free Fire', '100 Diamonds'),
(107, 5, 2, 'PunnNAJA#fyck', 'cancel', '2026-03-30 07:49:20', 149.00, 'ROV', '300 UC'),
(108, 5, 39, 'PunnNAJA#fyck', 'success', '2026-03-30 08:40:15', 1500.00, NULL, NULL),
(109, 5, 40, 'PunnNAJA#fyck', 'success', '2026-03-30 08:51:17', 20.00, 'Buu', 'Buuotelli'),
(110, 5, 40, 'PunnNAJA#fyck', 'success', '2026-03-30 08:51:29', 20.00, 'Buu', 'Buuotelli'),
(111, 5, 2, 'PunnNAJA#fyck', 'pending', '2026-03-30 09:21:21', 0.00, 'ROV', '300 UC'),
(112, 11, 1, 'PunnNAJA#fyck', 'cancel', '2026-03-30 13:01:05', 30.00, 'ROV', '60 UC'),
(113, 11, 10, 'PunnNAJA#fyck', 'cancel', '2026-03-30 15:04:21', 449.00, 'Genshin Impact', '980 Genesis Crystals'),
(114, 11, 15, 'PunnNAJA#fyck', 'cancel', '2026-03-30 15:05:55', 600.00, 'Valorant', '2050 VP'),
(115, 11, 15, 'PunnNAJA#fyck', 'success', '2026-03-30 15:07:26', 600.00, 'Valorant', '2050 VP'),
(116, 11, 15, 'PunnNAJA#fyck', 'cancel', '2026-03-30 15:07:43', 600.00, 'Valorant', '2050 VP'),
(117, 11, 15, 'PunnNAJA#fyck', 'success', '2026-03-30 15:18:36', 600.00, 'Valorant', '2050 VP'),
(118, 11, 2, 'PunnNAJA#fyck', 'cancel', '2026-03-30 15:19:44', 0.00, 'ROV', '300 UC'),
(119, 11, 4, 'PunnNAJA#fyck', 'cancel', '2026-03-30 15:23:20', 0.00, 'PUBG Mobile', '325 UC'),
(120, 11, 3, 'PunnNAJA#fyck', 'success', '2026-03-30 15:27:15', 0.00, 'Free Fire', '100 Diamonds'),
(121, 11, 3, 'PunnNAJA#fyck', 'success', '2026-03-30 15:32:30', 0.00, 'Free Fire', '100 Diamonds'),
(122, 11, 3, 'kuyrai#sus', 'success', '2026-03-30 15:34:24', 0.00, 'Free Fire', '100 Diamonds');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int NOT NULL,
  `game_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('ON','OFF') DEFAULT 'ON',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `game_id`, `name`, `price`, `status`, `created_at`) VALUES
(1, 1, '60 UC', 30.00, 'ON', '2026-03-13 04:03:10'),
(2, 1, '300 UC', 149.00, 'ON', '2026-03-13 04:03:10'),
(3, 2, '100 Diamonds', 50.00, 'ON', '2026-03-13 04:03:10'),
(4, 3, '325 UC', 150.00, 'ON', '2026-03-13 04:03:10'),
(8, 4, '60 Genesis Crystals', 29.00, 'ON', '2026-03-13 04:09:55'),
(9, 4, '300 Genesis Crystals', 149.00, 'ON', '2026-03-13 04:09:55'),
(10, 4, '980 Genesis Crystals', 449.00, 'ON', '2026-03-13 04:09:55'),
(13, 100, '475 VP', 150.00, 'ON', '2026-03-29 07:29:26'),
(14, 100, '1000 VP', 300.00, 'ON', '2026-03-29 07:29:26'),
(15, 100, '2050 VP', 600.00, 'ON', '2026-03-29 07:29:26'),
(16, 101, '650 RP', 200.00, 'ON', '2026-03-29 07:29:26'),
(17, 101, '1380 RP', 400.00, 'ON', '2026-03-29 07:29:26'),
(18, 102, '60 Oneiric Shard', 29.00, 'ON', '2026-03-29 07:29:26'),
(19, 102, '300 Oneiric Shard', 149.00, 'ON', '2026-03-29 07:29:26'),
(20, 102, '980 Oneiric Shard', 449.00, 'ON', '2026-03-29 07:29:26'),
(21, 103, '80 CP', 29.00, 'ON', '2026-03-29 07:29:26'),
(22, 103, '420 CP', 149.00, 'ON', '2026-03-29 07:29:26'),
(23, 103, '880 CP', 299.00, 'ON', '2026-03-29 07:29:26'),
(24, 104, '1 Month', 199.00, 'ON', '2026-03-29 07:29:26'),
(25, 104, '3 Months', 499.00, 'ON', '2026-03-29 07:29:26'),
(26, 105, '1 Month Premium', 129.00, 'ON', '2026-03-29 07:29:26'),
(27, 105, '3 Months Premium', 349.00, 'ON', '2026-03-29 07:29:26'),
(28, 106, '50 บาท', 50.00, 'ON', '2026-03-29 07:29:26'),
(29, 106, '100 บาท', 100.00, 'ON', '2026-03-29 07:29:26'),
(30, 106, '300 บาท', 300.00, 'ON', '2026-03-29 07:29:26'),
(31, 107, '100 บาท', 100.00, 'ON', '2026-03-29 07:29:26'),
(32, 107, '500 บาท', 500.00, 'ON', '2026-03-29 07:29:26'),
(33, 108, '60 Bonds', 30.00, 'ON', '2026-03-29 07:29:26'),
(34, 108, '300 Bonds', 150.00, 'ON', '2026-03-29 07:29:26'),
(35, 109, '100 FC Points', 35.00, 'ON', '2026-03-29 07:29:26'),
(36, 109, '500 FC Points', 150.00, 'ON', '2026-03-29 07:29:26');

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` enum('balance','code','giftcard') NOT NULL,
  `point_cost` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `package_id` int DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `status` enum('ON','OFF') DEFAULT 'ON'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `name`, `type`, `point_cost`, `created_at`, `package_id`, `amount`, `status`) VALUES
(16, 'เงิน 10 บาท', 'balance', 10, '2026-03-30 06:14:58', NULL, 10, 'ON'),
(17, 'เงิน 20 บาท', 'balance', 180, '2026-03-30 06:14:58', NULL, 20, 'ON'),
(18, 'เงิน 50 บาท', 'balance', 450, '2026-03-30 06:14:58', NULL, 50, 'ON'),
(19, 'เงิน 100 บาท', 'balance', 900, '2026-03-30 06:14:58', NULL, 100, 'ON'),
(20, 'ROV 60 UC', 'code', 200, '2026-03-30 06:15:04', 1, NULL, 'ON'),
(21, 'ROV 300 UC', 'code', 400, '2026-03-30 06:15:04', 2, NULL, 'ON'),
(22, 'Free Fire 100 Diamonds', 'code', 250, '2026-03-30 06:15:04', 3, NULL, 'ON'),
(23, 'PUBG 325 UC', 'code', 300, '2026-03-30 06:15:04', 4, NULL, 'ON'),
(24, 'Genshin 60 Crystal', 'code', 150, '2026-03-30 06:15:04', 8, NULL, 'ON'),
(26, 'LOL 650 RP', 'code', 400, '2026-03-30 06:15:04', 16, NULL, 'ON'),
(27, 'Steam Wallet 50฿', 'giftcard', 450, '2026-03-30 06:15:11', NULL, NULL, 'ON'),
(28, 'Steam Wallet 100฿', 'giftcard', 900, '2026-03-30 06:15:11', NULL, NULL, 'ON'),
(29, 'Netflix 1 เดือน', 'giftcard', 1500, '2026-03-30 06:15:11', NULL, NULL, 'ON'),
(31, 'P U N N', 'balance', 1000, '2026-03-30 08:27:15', 32, NULL, 'OFF');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `type` enum('topup','purchase','refund') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `order_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `type`, `amount`, `order_id`, `created_at`) VALUES
(1, 1, 'purchase', -30.00, 9, '2026-03-13 10:06:47'),
(2, 2, 'purchase', -149.00, 10, '2026-03-13 10:06:47'),
(3, 1, 'purchase', -150.00, 12, '2026-03-13 10:06:47'),
(4, 4, 'purchase', -149.00, 16, '2026-03-13 10:06:47'),
(5, 4, 'purchase', -449.00, 17, '2026-03-13 10:06:47'),
(6, 1, 'topup', 500.00, NULL, '2026-03-13 12:36:37'),
(7, 2, 'topup', 300.00, NULL, '2026-03-13 12:36:37'),
(8, 3, 'topup', 1000.00, NULL, '2026-03-13 12:36:37'),
(9, 4, 'topup', 500.00, NULL, '2026-03-13 12:36:37'),
(10, 3, 'refund', 50.00, 11, '2026-03-13 12:37:26'),
(11, 1, 'purchase', -149.00, 18, '2026-03-27 10:33:12'),
(12, 1, 'purchase', -149.00, 19, '2026-03-27 10:37:13'),
(13, 1, 'purchase', -150.00, 20, '2026-03-27 10:41:13'),
(14, 1, 'purchase', -29.00, 21, '2026-03-27 10:46:03'),
(63, 3, 'purchase', -29.00, 71, '2026-03-27 11:45:14'),
(64, 3, 'purchase', -129.00, 72, '2026-03-27 11:55:11'),
(65, 1, 'purchase', -10.00, 73, '2026-03-28 12:29:39'),
(66, 5, 'purchase', -150.00, 74, '2026-03-29 08:00:40'),
(67, 5, 'purchase', -150.00, 75, '2026-03-29 08:01:00'),
(68, 5, 'purchase', -150.00, 76, '2026-03-29 08:01:10'),
(69, 5, 'purchase', -130.00, 77, '2026-03-29 08:02:19'),
(70, 5, 'purchase', -600.00, 78, '2026-03-29 08:05:42'),
(71, 5, 'purchase', -600.00, 79, '2026-03-29 08:06:18'),
(72, 5, 'purchase', -29.00, 80, '2026-03-29 10:13:04'),
(73, 5, 'purchase', -29.00, 81, '2026-03-29 10:13:13'),
(74, 5, 'purchase', -29.00, 82, '2026-03-29 10:13:28'),
(75, 5, 'purchase', -29.00, 83, '2026-03-29 10:13:36'),
(76, 5, 'purchase', -29.00, 84, '2026-03-29 10:13:43'),
(77, 5, 'purchase', -29.00, 85, '2026-03-29 10:13:53'),
(78, 5, 'purchase', -400.00, 86, '2026-03-29 10:15:11'),
(79, 5, 'purchase', -200.00, 87, '2026-03-29 10:15:21'),
(80, 5, 'purchase', -200.00, 88, '2026-03-29 10:15:29'),
(81, 5, 'purchase', -200.00, 89, '2026-03-29 10:15:54'),
(82, 5, 'purchase', -200.00, 90, '2026-03-29 10:16:10'),
(83, 5, 'purchase', -200.00, 91, '2026-03-29 10:16:22'),
(84, 5, 'purchase', -150.00, 92, '2026-03-29 12:50:23'),
(85, 5, 'purchase', 0.00, 93, '2026-03-30 00:39:53'),
(86, 5, 'purchase', -50.00, 94, '2026-03-30 00:47:08'),
(87, 5, 'purchase', -30.00, 95, '2026-03-30 00:52:18'),
(88, 5, 'purchase', -30.00, 96, '2026-03-30 00:53:05'),
(89, 5, 'purchase', -50.00, 97, '2026-03-30 00:56:37'),
(90, 5, 'purchase', -50.00, 98, '2026-03-30 01:01:41'),
(91, 5, 'purchase', -50.00, 99, '2026-03-30 01:05:40'),
(92, 5, 'purchase', 0.00, 100, '2026-03-30 05:02:25'),
(93, 5, 'purchase', 0.00, 101, '2026-03-30 05:04:29'),
(94, 5, 'purchase', -30.00, 102, '2026-03-30 05:33:44'),
(95, 5, 'purchase', -30.00, 103, '2026-03-30 05:37:04'),
(96, 5, 'purchase', -30.00, 104, '2026-03-30 05:37:36'),
(97, 5, 'purchase', -129.00, 105, '2026-03-30 05:39:30'),
(98, 5, 'purchase', -50.00, 106, '2026-03-30 07:39:07'),
(99, 5, 'purchase', -149.00, 107, '2026-03-30 07:49:20'),
(100, 5, 'refund', 149.00, 107, '2026-03-30 07:49:39'),
(101, 5, 'purchase', -1500.00, 108, '2026-03-30 08:40:15'),
(102, 5, 'purchase', -20.00, 109, '2026-03-30 08:51:17'),
(103, 5, 'purchase', -20.00, 110, '2026-03-30 08:51:29'),
(104, 5, 'purchase', 0.00, 111, '2026-03-30 09:21:21'),
(105, 11, 'topup', 50.00, NULL, '2026-03-30 10:35:54'),
(106, 11, 'topup', 50.00, NULL, '2026-03-30 10:35:58'),
(107, 11, 'purchase', -30.00, 112, '2026-03-30 13:01:05'),
(108, 11, 'refund', 30.00, 112, '2026-03-30 13:01:16'),
(109, 11, 'topup', 90000.00, NULL, '2026-03-30 14:19:19'),
(110, 11, 'purchase', -449.00, 113, '2026-03-30 15:04:21'),
(111, 11, 'refund', 449.00, 113, '2026-03-30 15:04:28'),
(112, 11, 'purchase', -600.00, 114, '2026-03-30 15:05:55'),
(113, 11, 'refund', 600.00, 114, '2026-03-30 15:06:05'),
(114, 11, 'purchase', -600.00, 115, '2026-03-30 15:07:26'),
(115, 11, 'purchase', -600.00, 116, '2026-03-30 15:07:43'),
(116, 11, 'refund', 600.00, 116, '2026-03-30 15:07:51'),
(117, 11, 'purchase', -600.00, 117, '2026-03-30 15:18:36'),
(118, 11, 'purchase', 0.00, 118, '2026-03-30 15:19:44'),
(119, 11, 'refund', 0.00, 118, '2026-03-30 15:20:44'),
(120, 11, 'purchase', 0.00, 119, '2026-03-30 15:23:20'),
(121, 11, 'refund', 0.00, 119, '2026-03-30 15:23:43'),
(122, 11, 'purchase', 0.00, 120, '2026-03-30 15:27:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `points` int DEFAULT '0',
  `status` enum('active','banned') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `password`, `email`, `phone`, `balance`, `created_at`, `points`, `status`) VALUES
(1, 'player1', 'John', 'Smith', '1234', 'player1@email.com', '0811111111', 13.00, '2026-03-13 04:02:12', 1, 'active'),
(2, 'player2', 'Mike', 'Johnson', '1234', 'player2@email.com', '0822222222', 300.00, '2026-03-13 04:02:12', 0, 'active'),
(3, 'gamerx', 'Alex', 'Wong', '1234', 'gamerx@email.com', '0833333333', 1200.00, '2026-03-13 04:02:12', 800, 'active'),
(4, 'traveler', 'Lumine', 'Traveler', '1234', 'traveler@email.com', '0812345678', 500.00, '2026-03-13 04:10:00', 0, 'active'),
(5, 'PunnBigD_ata', 'Punn', 'InwzA', '007', 'panyawatfaktim@email.com', '0616742970', 3321.00, '2026-03-14 04:46:43', 69153, 'active'),
(6, 'iamveryhandsome', 'sudlor', 'punnpunn', '123456', 'PanyawatFaktim1209@gmail.com', '0984606569', 0.00, '2026-03-14 04:55:25', 0, 'active'),
(7, 'PunnyS', 'kuy', 'yaimakmak', '1234', 'abc@email.com', '0616742970', 0.00, '2026-03-25 06:03:15', 0, 'active'),
(9, 'PunnyYY', 'ปัญญวัฒน์', 'ฟักทิม', 'pppp1248', 'panyawatfaktim@gmail.com', '', 0.00, '2026-03-30 02:27:37', 0, 'active'),
(10, 'iamveryhandsomeS', 'ปัญญวัฒน์', 'ฟักทิม', '1234', 'panyawatfaktim@gmail.com', '0861454050', 0.00, '2026-03-30 05:57:13', 0, 'banned'),
(11, 'PanyaOn', 'notpanyawat', 'alsonotfaktim', '$2y$10$FKImaCnZJ.9JewvuhbvSpOP2fEBZBfZiTOJXJc7ZeZknQyOJD3l8K', 'notpanyawatfaktim@gmail.com', '0984606569', 88900.00, '2026-03-30 10:24:24', 8050, 'active'),
(12, 's', 's', 's', '$2y$10$EedkarYf28LN.L4v7hNQ4ulCGIlHPooBDHtVIiPWbC7z6bfnZw8oG', 'panyawatfaktim@gmail.com', '09846', 0.00, '2026-03-30 14:55:15', 0, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_rewards`
--

CREATE TABLE `user_rewards` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `reward_id` int NOT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('success','cancel') DEFAULT 'success'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_rewards`
--

INSERT INTO `user_rewards` (`id`, `user_id`, `reward_id`, `detail`, `created_at`, `status`) VALUES
(33, 5, 19, '+100 บาท', '2026-03-30 08:23:17', 'success'),
(34, 5, 31, '+0 บาท', '2026-03-30 08:27:54', 'success'),
(35, 5, 31, '+0 บาท', '2026-03-30 08:27:59', 'success'),
(36, 5, 16, '+10 บาท', '2026-03-30 08:33:48', 'success'),
(37, 5, 16, '+10 บาท', '2026-03-30 08:33:50', 'success'),
(38, 5, 16, '+10 บาท', '2026-03-30 08:33:51', 'success'),
(39, 5, 21, 'BONUSEABD04', '2026-03-30 09:21:15', 'success'),
(40, 11, 21, 'BONUS816AEA', '2026-03-30 15:19:37', 'success'),
(41, 11, 23, 'BONUS953BE2', '2026-03-30 15:23:12', 'success'),
(42, 11, 22, 'BONUS54AEA6', '2026-03-30 15:27:08', 'success'),
(43, 11, 22, 'BONUSAE253A', '2026-03-30 15:32:24', 'success'),
(44, 11, 22, 'BONUS4821AE', '2026-03-30 15:32:25', 'success'),
(45, 11, 22, 'BONUSD92E03', '2026-03-30 15:34:18', 'success'),
(46, 11, 22, 'BONUSB2467F', '2026-03-30 15:34:19', 'success');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bonus_codes`
--
ALTER TABLE `bonus_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_bonus_package` (`package_id`);

--
-- Indexes for table `discount_codes`
--
ALTER TABLE `discount_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game_uids`
--
ALTER TABLE `game_uids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `game_uids_ibfk_2` (`game_id`);

--
-- Indexes for table `giftcard_stock`
--
ALTER TABLE `giftcard_stock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `reward_id` (`reward_id`),
  ADD KEY `used_by` (`used_by`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `packages_ibfk_1` (`game_id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reward_package` (`package_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_rewards`
--
ALTER TABLE `user_rewards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `reward_id` (`reward_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bonus_codes`
--
ALTER TABLE `bonus_codes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `discount_codes`
--
ALTER TABLE `discount_codes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `game_uids`
--
ALTER TABLE `game_uids`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `giftcard_stock`
--
ALTER TABLE `giftcard_stock`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_rewards`
--
ALTER TABLE `user_rewards`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bonus_codes`
--
ALTER TABLE `bonus_codes`
  ADD CONSTRAINT `bonus_codes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_bonus_package` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`);

--
-- Constraints for table `game_uids`
--
ALTER TABLE `game_uids`
  ADD CONSTRAINT `game_uids_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `game_uids_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `giftcard_stock`
--
ALTER TABLE `giftcard_stock`
  ADD CONSTRAINT `giftcard_stock_ibfk_1` FOREIGN KEY (`reward_id`) REFERENCES `rewards` (`id`),
  ADD CONSTRAINT `giftcard_stock_ibfk_2` FOREIGN KEY (`used_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rewards`
--
ALTER TABLE `rewards`
  ADD CONSTRAINT `fk_reward_package` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `user_rewards`
--
ALTER TABLE `user_rewards`
  ADD CONSTRAINT `user_rewards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_rewards_ibfk_2` FOREIGN KEY (`reward_id`) REFERENCES `rewards` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
