-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2025 at 02:30 AM
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
-- Database: `cloud_cage`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$examplehashforadmin123'),
(2, 'admin2', '$2y$10$TzPfgt3W4jzPh2Xhpoo62OI.E/m6momdjrudfau1lc3ut0GI505t6');

-- --------------------------------------------------------

--
-- Table structure for table `click_stats`
--

CREATE TABLE `click_stats` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `action` enum('open','download') NOT NULL,
  `count` int(11) DEFAULT 0,
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `click_stats`
--

INSERT INTO `click_stats` (`id`, `post_id`, `action`, `count`, `last_updated`) VALUES
(3, 3, 'open', 5, '2025-07-09 06:23:30'),
(5, 5, 'open', 3, '2025-07-09 06:14:31'),
(9, 9, 'open', 2, '2025-07-09 06:40:30'),
(13, 13, 'download', 2, '2025-07-09 06:22:51'),
(16, 16, 'download', 2, '2025-07-09 06:23:28'),
(17, 17, 'download', 2, '2025-07-09 06:26:45'),
(18, 18, 'open', 1, '2025-07-09 07:10:53');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `type` enum('website','mobile') NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` enum('new','current','old') NOT NULL DEFAULT 'new',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `type`, `title`, `description`, `link`, `file_path`, `status`, `created_at`) VALUES
(3, 'website', 'BasicMath Calculator', 'Add, minus, multiply, and devide only calculator.', 'https://www.calculator.net/', NULL, 'new', '2025-07-08 22:56:37'),
(5, 'website', 'AlgebraCalculator', 'for algebra math solver', 'https://www.mathpapa.com/algebra-calculator.html', NULL, 'new', '2025-07-08 23:00:08'),
(9, 'website', 'test', 'aasdasd', 'https://egg.com', NULL, 'new', '2025-07-09 03:21:30'),
(13, 'mobile', 'Renator', 'waeawe', 'https://facebook.com', NULL, 'new', '2025-07-09 06:01:08'),
(16, 'mobile', 'grandmall', 'aweawe', NULL, NULL, 'new', '2025-07-09 06:23:05'),
(17, 'mobile', 'facebook', 'aweawe', 'https://gaisanograndmalls.com/', NULL, 'new', '2025-07-09 06:26:25'),
(18, 'website', '10k', 'aweaweaw', 'https://10Kroses.com', NULL, 'current', '2025-07-09 07:10:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `click_stats`
--
ALTER TABLE `click_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `click_stats`
--
ALTER TABLE `click_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `click_stats`
--
ALTER TABLE `click_stats`
  ADD CONSTRAINT `click_stats_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
