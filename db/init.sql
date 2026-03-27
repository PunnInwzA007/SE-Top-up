-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 27, 2026 at 11:58 AM
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
(72, 3, 9, 'PunnNAJA#fyck', 'success', '2026-03-27 11:55:11', 129.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `package_id` (`package_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
