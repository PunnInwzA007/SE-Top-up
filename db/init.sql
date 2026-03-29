-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 29, 2026 at 09:54 AM
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
  `type` varchar(50) DEFAULT NULL,
  `value` int DEFAULT NULL,
  `status` enum('unused','used') DEFAULT 'unused',
  `used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bonus_codes`
--

INSERT INTO `bonus_codes` (`id`, `user_id`, `code`, `type`, `value`, `status`, `used_at`, `created_at`) VALUES
(1, 1, 'BONUS20-AAA111', 'diamond', 20, 'unused', NULL, '2026-03-27 14:25:41'),
(2, 1, 'BONUS50-BBB222', 'diamond', 50, 'used', NULL, '2026-03-27 14:25:41'),
(3, 2, 'BONUS20-CCC333', 'diamond', 20, 'unused', NULL, '2026-03-27 14:25:41');

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
(22, 'SE4539', 20.00, 0.00, 1, 0, 'ACTIVE', '2026-03-29 09:53:38');

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
(5, 7, 7, 'PunnNAJA#fyck', '2026-03-25 06:04:08'),
(8, 1, 4, 'kuyrai#sus', '2026-03-27 10:22:45'),
(9, 1, 4, 'PunnNAJA#fyck', '2026-03-27 10:22:59'),
(10, 1, 3, 'PunnzaPubg', '2026-03-27 10:40:59'),
(11, 3, 4, 'PunnNAJA#fyck', '2026-03-27 11:17:13'),
(12, 5, 109, 'PunnInwza007', '2026-03-29 08:00:56'),
(13, 5, 100, 'PunnNAJA#fyck', '2026-03-29 08:05:30'),
(14, 5, 100, 'PunnNAJA#fyck', '2026-03-29 08:06:13');

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
(4, 7, 'GIFT300-X1Y2Z3', 'available', NULL, NULL, '2026-03-27 14:25:36'),
(5, 7, 'GIFT300-L4M5N6', 'available', NULL, NULL, '2026-03-27 14:25:36');

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
(79, 5, 15, 'PunnNAJA#fyck', 'success', '2026-03-29 08:06:18', 600.00);

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
  `value` int NOT NULL,
  `point_cost` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `name`, `type`, `value`, `point_cost`, `created_at`, `image`) VALUES
(1, 'เงิน 10 บาท', 'balance', 10, 100, '2026-03-27 14:25:29', NULL),
(2, 'เงิน 20 บาท', 'balance', 20, 180, '2026-03-27 14:25:29', NULL),
(3, 'เงิน 50 บาท', 'balance', 50, 450, '2026-03-27 14:25:29', NULL),
(4, 'Bonus Diamonds +20', 'code', 20, 200, '2026-03-27 14:25:29', NULL),
(5, 'Bonus Diamonds +50', 'code', 50, 450, '2026-03-27 14:25:29', NULL),
(6, 'Gift Card 100฿', 'giftcard', 100, 900, '2026-03-27 14:25:29', NULL),
(7, 'Gift Card 300฿', 'giftcard', 300, 2500, '2026-03-27 14:25:29', NULL),
(8, 'เงิน 5 บาท', 'balance', 5, 50, '2026-03-29 07:29:31', NULL),
(9, 'เงิน 100 บาท', 'balance', 100, 900, '2026-03-29 07:29:31', NULL),
(10, 'Bonus RP +100', 'code', 100, 300, '2026-03-29 07:29:31', NULL),
(11, 'Bonus VP +200', 'code', 200, 500, '2026-03-29 07:29:31', NULL),
(12, 'Steam Wallet 50฿', 'giftcard', 50, 450, '2026-03-29 07:29:31', NULL),
(13, 'Steam Wallet 100฿', 'giftcard', 100, 900, '2026-03-29 07:29:31', NULL),
(14, 'Netflix 1 เดือน', 'giftcard', 199, 1500, '2026-03-29 07:29:31', NULL),
(15, 'Spotify 1 เดือน', 'giftcard', 129, 1200, '2026-03-29 07:29:31', NULL);

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
(71, 5, 'purchase', -600.00, 79, '2026-03-29 08:06:18');

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
(5, 'PunnBigD_ata', 'Punn', 'InwzA', '007', 'panyawatfaktim@email.com', '0616742970', 3220.00, '2026-03-14 04:46:43', 778),
(6, 'iamveryhandsome', 'sudlor', 'punnpunn', '123456', 'PanyawatFaktim1209@gmail.com', '0984606569', 0.00, '2026-03-14 04:55:25', 0),
(7, 'PunnyS', 'kuy', 'yaimakmak', '1234', 'abc@email.com', '0616742970', 0.00, '2026-03-25 06:03:15', 0);

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
(5, 2, 7, 'GIFT300-X1Y2Z3', '2026-03-27 14:25:46', 'success');

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
  ADD KEY `user_id` (`user_id`);

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `discount_codes`
--
ALTER TABLE `discount_codes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `game_uids`
--
ALTER TABLE `game_uids`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `giftcard_stock`
--
ALTER TABLE `giftcard_stock`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_rewards`
--
ALTER TABLE `user_rewards`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bonus_codes`
--
ALTER TABLE `bonus_codes`
  ADD CONSTRAINT `bonus_codes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
