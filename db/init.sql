-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 30, 2026 at 04:54 AM
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
(11, 5, 'BONUS49A015', 'unused', NULL, '2026-03-30 04:51:58', 1);

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
  `status` enum('ACTIVE','USED','EXPIRED') DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `discount_codes`
--

INSERT INTO `discount_codes` (`id`, `code`, `discount_amount`, `min_price`, `usage_limit`, `used_count`, `status`, `created_at`) VALUES
(1, 'SE20', 20.00, 50.00, 100, 0, 'ACTIVE', '2026-03-27 08:53:39'),
(2, 'WELCOME50', 50.00, 200.00, 50, 0, 'ACTIVE', '2026-03-27 08:53:39'),
(3, 'PUNN10', 10.00, 0.00, 999, 0, 'ACTIVE', '2026-03-27 08:53:39'),
(4, 'FLASH100', 100.00, 500.00, 10, 0, 'ACTIVE', '2026-03-27 08:53:39'),
(5, 'NEWUSER30', 30.00, 100.00, 1, 0, 'ACTIVE', '2026-03-27 08:53:39'),
(6, 'SE7943', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-27 15:26:01'),
(7, 'SE7687', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-27 15:26:03'),
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
(23, 'SE1179', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-29 10:01:48'),
(24, 'SE8876', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-29 10:01:53'),
(25, 'SE3531', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-29 10:02:09'),
(26, 'SE3248', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-29 10:05:28'),
(27, 'SE1130', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-29 13:02:32'),
(28, 'SE1953', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-29 23:35:17');

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
(7, 'P U N N', 'uploads/1773462609_sdsdadas.png', 'ON', '2026-03-14 04:30:09', 'pc'),
(100, 'Valorant', 'uploads/valorant.jpg', 'ON', '2026-03-29 07:29:18', 'pc'),
(101, 'League of Legends', 'uploads/lol.jpg', 'ON', '2026-03-29 07:29:18', 'pc'),
(102, 'Honkai Star Rail', 'uploads/hsr.jpg', 'ON', '2026-03-29 07:29:18', 'mobile'),
(103, 'Call of Duty Mobile', 'uploads/codm.jpg', 'ON', '2026-03-29 07:29:18', 'mobile'),
(104, 'Netflix Subscription', 'uploads/netflix.jpg', 'ON', '2026-03-29 07:29:18', 'sub'),
(105, 'Spotify Premium', 'uploads/spotify.jpg', 'ON', '2026-03-29 07:29:18', 'sub'),
(106, 'Steam Wallet', 'uploads/steam.jpg', 'ON', '2026-03-29 07:29:18', 'gift'),
(107, 'PlayStation Gift Card', 'uploads/ps.jpg', 'ON', '2026-03-29 07:29:18', 'gift'),
(108, 'Arena Breakout', 'uploads/arena.jpg', 'ON', '2026-03-29 07:29:18', 'mobile'),
(109, 'EA Sports FC Mobile', 'uploads/fc.jpg', 'OFF', '2026-03-29 07:29:18', 'mobile');

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
(5, 7, 7, 'PunnNAJA#fyck', '2026-03-25 06:04:08'),
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
(18, 5, 2, 'PunnNAJA#fyck', '2026-03-30 00:25:12');

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
(1, 6, 'GIFT100-A1B2C3', 'available', NULL, NULL, '2026-03-27 14:25:36'),
(2, 6, 'GIFT100-D4E5F6', 'available', NULL, NULL, '2026-03-27 14:25:36'),
(3, 6, 'GIFT100-G7H8I9', 'available', NULL, NULL, '2026-03-27 14:25:36'),
(4, 7, 'GIFT300-X1Y2Z3', 'used', 5, '2026-03-29 23:54:34', '2026-03-27 14:25:36'),
(5, 7, 'GIFT300-L4M5N6', 'used', 5, '2026-03-29 23:54:56', '2026-03-27 14:25:36');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `package_id` int NOT NULL,
  `game_uid` varchar(100) NOT NULL,
  `status` enum('pending','success','cancel') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `package_id`, `game_uid`, `status`, `created_at`, `price`) VALUES
(9, 1, 1, '123456789', 'success', '2026-03-11 04:30:00', 30.00),
(10, 2, 2, '987654321', 'success', '2026-03-12 04:04:30', 149.00),
(11, 3, 3, '555666777', 'cancel', '2026-03-13 04:04:30', 50.00),
(12, 1, 4, '888999000', 'success', '2026-03-13 04:04:30', 150.00),
(15, 4, 8, '800123456', 'success', '2026-03-13 04:11:24', 29.00),
(16, 4, 9, '800123456', 'success', '2026-03-23 04:11:24', 149.00),
(17, 4, 10, '800987654', 'success', '2026-03-25 04:11:24', 449.00),
(18, 1, 9, 'PunnNAJA#fyck', 'success', '2026-03-27 10:32:19', 149.00),
(19, 1, 9, 'kuyrai#sus', 'success', '2026-03-27 10:37:11', 149.00),
(20, 1, 4, 'PunnzaPubg', 'success', '2026-03-27 10:41:11', 150.00),
(21, 1, 8, 'kuyrai#sus', 'success', '2026-03-27 10:46:02', 29.00),
(22, 3, 9, 'PunnNAJA#fyck', 'success', '2026-03-27 11:17:20', 149.00),
(71, 3, 8, 'PunnNAJA#fyck', 'success', '2026-03-27 11:45:14', 29.00),
(72, 3, 9, 'PunnNAJA#fyck', 'success', '2026-03-27 11:55:11', 129.00),
(73, 1, 1, '987654321', 'success', '2026-03-28 12:29:39', 10.00),
(74, 5, 36, 'PunnInwza007', 'success', '2026-03-29 08:00:40', 150.00),
(75, 5, 36, 'PunnInwza007', 'success', '2026-03-29 08:01:00', 150.00),
(76, 5, 36, 'PunnInwza007', 'success', '2026-03-29 08:01:10', 150.00),
(77, 5, 36, 'PunnInwza007', 'success', '2026-03-29 08:02:19', 130.00),
(78, 5, 15, 'PunnNAJA#fyck', 'success', '2026-03-29 08:05:42', 600.00),
(79, 5, 15, 'PunnNAJA#fyck', 'success', '2026-03-29 08:06:18', 600.00),
(80, 5, 21, 'SudlorPunnPunn#007', 'success', '2026-03-29 10:13:04', 29.00),
(81, 5, 21, 'SudlorPunnPunn#007', 'success', '2026-03-29 10:13:13', 29.00),
(82, 5, 21, 'SudlorPunnPunn#007', 'success', '2026-03-29 10:13:28', 29.00),
(83, 5, 21, 'SudlorPunnPunn#007', 'success', '2026-03-29 10:13:36', 29.00),
(84, 5, 21, 'SudlorPunnPunn#007', 'success', '2026-03-29 10:13:43', 29.00),
(85, 5, 21, 'SudlorPunnPunn#007', 'success', '2026-03-29 10:13:53', 29.00),
(86, 5, 17, 'd0esnotex1st#fyck', 'success', '2026-03-29 10:15:11', 400.00),
(87, 5, 16, 'd0esnotex1st#fyck', 'success', '2026-03-29 10:15:21', 200.00),
(88, 5, 16, 'd0esnotex1st#fyck', 'success', '2026-03-29 10:15:29', 200.00),
(89, 5, 16, 'd0esnotex1st#fyck', 'success', '2026-03-29 10:15:54', 200.00),
(90, 5, 16, 'd0esnotex1st#fyck', 'success', '2026-03-29 10:16:10', 200.00),
(91, 5, 16, 'PunnNAJA#fyck', 'success', '2026-03-29 10:16:22', 200.00),
(92, 5, 13, 'PunnNAJA#fyck', 'success', '2026-03-29 12:50:23', 150.00),
(93, 5, 3, '5', 'cancel', '2026-03-30 00:39:53', 0.00),
(94, 5, 3, '5', 'pending', '2026-03-30 00:47:08', 50.00),
(95, 5, 3, '5', 'pending', '2026-03-30 00:52:18', 30.00),
(96, 5, 3, '5', 'pending', '2026-03-30 00:53:05', 30.00),
(97, 5, 3, '5', 'pending', '2026-03-30 00:56:37', 50.00),
(98, 5, 3, '5', 'pending', '2026-03-30 01:01:41', 50.00),
(99, 5, 3, 'PunnNAJA#fyck', 'pending', '2026-03-30 01:05:40', 50.00);

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
  `package_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `name`, `type`, `point_cost`, `created_at`, `package_id`) VALUES
(1, 'เงิน 10 บาท', 'balance', 100, '2026-03-27 14:25:29', NULL),
(2, 'เงิน 20 บาท', 'balance', 180, '2026-03-27 14:25:29', NULL),
(3, 'เงิน 50 บาท', 'balance', 450, '2026-03-27 14:25:29', NULL),
(4, 'ROV 325 UC', 'code', 200, '2026-03-27 14:25:29', 1),
(5, 'Free Fire 100 Diamonds', 'code', 450, '2026-03-27 14:25:29', 3),
(6, 'Gift Card 100฿', 'giftcard', 900, '2026-03-27 14:25:29', NULL),
(7, 'Gift Card 300฿', 'giftcard', 2500, '2026-03-27 14:25:29', NULL),
(8, 'เงิน 5 บาท', 'balance', 50, '2026-03-29 07:29:31', NULL),
(9, 'เงิน 100 บาท', 'balance', 900, '2026-03-29 07:29:31', NULL),
(10, 'Bonus RP +100', 'code', 300, '2026-03-29 07:29:31', NULL),
(11, 'Bonus VP +200', 'code', 500, '2026-03-29 07:29:31', NULL),
(12, 'Steam Wallet 50฿', 'giftcard', 450, '2026-03-29 07:29:31', NULL),
(13, 'Steam Wallet 100฿', 'giftcard', 900, '2026-03-29 07:29:31', NULL),
(14, 'Netflix 1 เดือน', 'giftcard', 1500, '2026-03-29 07:29:31', NULL),
(15, 'Spotify 1 เดือน', 'giftcard', 1200, '2026-03-29 07:29:31', NULL);

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
(91, 5, 'purchase', -50.00, 99, '2026-03-30 01:05:40');

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
  `points` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `password`, `email`, `phone`, `balance`, `created_at`, `points`) VALUES
(1, 'player1', 'John', 'Smith', '1234', 'player1@email.com', '0811111111', 13.00, '2026-03-13 04:02:12', 1),
(2, 'player2', 'Mike', 'Johnson', '1234', 'player2@email.com', '0822222222', 300.00, '2026-03-13 04:02:12', 0),
(3, 'gamerx', 'Alex', 'Wong', '1234', 'gamerx@email.com', '0833333333', 1200.00, '2026-03-13 04:02:12', 800),
(4, 'traveler', 'Lumine', 'Traveler', '1234', 'traveler@email.com', '0812345678', 500.00, '2026-03-13 04:10:00', 0),
(5, 'PunnBigD_ata', 'Punn', 'InwzA', '007', 'panyawatfaktim@email.com', '0616742970', 0.00, '2026-03-14 04:46:43', 2326),
(6, 'iamveryhandsome', 'sudlor', 'punnpunn', '123456', 'PanyawatFaktim1209@gmail.com', '0984606569', 0.00, '2026-03-14 04:55:25', 0),
(7, 'PunnyS', 'kuy', 'yaimakmak', '1234', 'abc@email.com', '0616742970', 0.00, '2026-03-25 06:03:15', 0),
(9, 'PunnyYY', 'ปัญญวัฒน์', 'ฟักทิม', 'pppp1248', 'panyawatfaktim@gmail.com', '', 0.00, '2026-03-30 02:27:37', 0);

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
(1, 1, 1, '+10 balance', '2026-03-27 14:25:46', 'success'),
(2, 1, 4, 'BONUS20-AAA111', '2026-03-27 14:25:46', 'success'),
(3, 1, 6, 'GIFT100-A1B2C3', '2026-03-27 14:25:46', 'success'),
(4, 2, 2, '+20 balance', '2026-03-27 14:25:46', 'success'),
(5, 2, 7, 'GIFT300-X1Y2Z3', '2026-03-27 14:25:46', 'success'),
(6, 5, 1, '+10 balance', '2026-03-29 10:01:17', 'success'),
(7, 5, 4, 'BONUS20-XYZ123', '2026-03-29 10:01:17', 'success'),
(8, 5, 6, 'GIFT100-Z9X8C7', '2026-03-29 10:01:17', 'success'),
(9, 5, 8, '+5 balance', '2026-03-29 10:04:40', 'success'),
(10, 5, 8, '+5 balance', '2026-03-29 10:05:16', 'success'),
(11, 5, 4, 'SE3248', '2026-03-29 10:05:28', 'success'),
(12, 5, 1, '+10 balance', '2026-03-29 10:34:32', 'success'),
(13, 5, 2, '+20 balance', '2026-03-29 12:52:36', 'success'),
(14, 5, 8, '+5 balance', '2026-03-29 12:55:32', 'success'),
(15, 5, 8, '+5 balance', '2026-03-29 12:56:39', 'success'),
(16, 5, 8, '+5 balance', '2026-03-29 12:56:42', 'success'),
(17, 5, 8, '+5 balance', '2026-03-29 12:56:43', 'success'),
(18, 5, 4, 'SE1130', '2026-03-29 13:02:32', 'success'),
(19, 5, 8, '+5 balance', '2026-03-29 23:27:30', 'success'),
(20, 5, 4, 'SE1953', '2026-03-29 23:35:17', 'success'),
(21, 5, 11, 'BONUS2681', '2026-03-29 23:47:38', 'success'),
(22, 5, 7, 'GIFT300-X1Y2Z3', '2026-03-29 23:54:34', 'success'),
(23, 5, 7, 'GIFT300-L4M5N6', '2026-03-29 23:54:56', 'success'),
(24, 5, 11, 'BONUS3788', '2026-03-30 00:06:02', 'success'),
(25, 5, 4, 'BONUS3958', '2026-03-30 00:10:15', 'success'),
(26, 5, 4, 'BONUSFBC22F', '2026-03-30 00:11:07', 'success'),
(27, 5, 4, 'BONUSAC8ABD', '2026-03-30 00:15:07', 'success'),
(28, 5, 4, 'BONUS7B5A80', '2026-03-30 00:32:03', 'success'),
(29, 5, 4, 'BONUSAE0E5B', '2026-03-30 01:05:32', 'success'),
(30, 5, 4, 'BONUS49A015', '2026-03-30 04:51:58', 'success');

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
  ADD KEY `game_id` (`game_id`);

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
  ADD KEY `game_id` (`game_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `discount_codes`
--
ALTER TABLE `discount_codes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `game_uids`
--
ALTER TABLE `game_uids`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `giftcard_stock`
--
ALTER TABLE `giftcard_stock`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_rewards`
--
ALTER TABLE `user_rewards`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
  ADD CONSTRAINT `game_uids_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`);

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
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`);

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`);

--
-- Constraints for table `rewards`
--
ALTER TABLE `rewards`
  ADD CONSTRAINT `fk_reward_package` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`);

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
