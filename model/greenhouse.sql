-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2021 at 06:43 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `greenhouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `measure` varchar(255) NOT NULL COMMENT '% for humidity or lux for light',
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `measure`, `created_at`) VALUES
(1, 'Temperature', '', ' ºC', 2147483647),
(2, 'Air Humidity', '', '%', 2147483647),
(3, 'Wind', '', '%', 2147483647),
(4, 'Light', '', '%', 2147483647),
(5, 'Co2', '', '%', 2147483647),
(6, 'Motion', '', '%', 2147483647),
(7, 'Water', '', '%', 2147483647),
(8, 'Sprinkler', '', '%', 2147483647),
(9, 'Window', '', '%', 2147483647),
(10, 'Fan', '', '%', 2147483647),
(11, 'Soil Moisture', '', '%', 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name_local` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `line` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `type` enum('sensor','actuators','other','') NOT NULL,
  `force_on` tinyint(1) NOT NULL,
  `switch_value` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`id`, `category_id`, `name_local`, `name`, `description`, `line`, `position`, `type`, `force_on`, `switch_value`, `is_active`, `created_at`) VALUES
(1, 1, 'temp_1_1', 'Temperatura', '                                                                                                                                                        ', 2, 3, 'sensor', 0, 74, 1, '2021-05-03 01:46:52'),
(2, 10, 'fan_1_2', 'Fan 1-2', '                                                                                                                                                                                                                                                                                                                                                                                            ', 3, 1, 'actuators', 0, 0, 1, '2021-05-02 15:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `device_id`, `value`, `date`, `created_at`) VALUES
(1, 1, '20', '2021-05-02 21:10:00', '2021-05-02 19:18:44'),
(2, 1, '20', '2021-05-02 21:11:00', '2021-05-02 19:18:44'),
(3, 1, '19', '2021-05-02 21:12:00', '2021-05-02 19:18:44'),
(4, 1, '19', '2021-05-02 21:13:00', '2021-05-02 19:18:44'),
(5, 1, '18', '2021-05-02 21:14:00', '2021-05-02 19:18:44'),
(6, 1, '18', '2021-05-02 21:15:00', '2021-05-02 19:18:44'),
(7, 1, '17', '2021-05-02 21:16:00', '2021-05-02 19:18:44'),
(8, 1, '17', '2021-05-02 21:17:00', '2021-05-02 19:18:44'),
(9, 1, '16', '2021-05-02 21:18:00', '2021-05-02 19:18:44'),
(10, 1, '16', '2021-05-02 21:19:00', '2021-05-02 19:18:44'),
(11, 1, '16', '2021-05-02 21:20:00', '2021-05-02 19:18:44'),
(12, 1, '15', '2021-05-02 21:21:00', '2021-05-02 19:18:44'),
(13, 1, '15', '2021-05-02 21:22:00', '2021-05-02 19:18:44'),
(14, 1, '15', '2021-05-02 21:23:00', '2021-05-02 19:18:44'),
(15, 1, '15', '2021-05-02 21:24:00', '2021-05-02 19:18:44'),
(16, 1, '14', '2021-05-02 21:25:00', '2021-05-02 19:18:44'),
(17, 1, '13', '2021-05-02 21:26:00', '2021-05-02 19:18:44'),
(18, 1, '13', '2021-05-02 21:27:00', '2021-05-02 19:18:44'),
(19, 1, '13', '2021-05-02 21:28:00', '2021-05-02 19:18:44'),
(20, 1, '10', '2021-05-02 21:29:00', '2021-05-02 19:18:44'),
(23, 1, '23', '2021-05-02 22:05:00', '2021-05-02 20:58:01'),
(24, 1, '23', '2021-05-02 22:15:00', '2021-05-02 23:43:15'),
(25, 1, '23', '2021-05-02 22:25:00', '2021-05-03 00:10:49'),
(26, 1, '17', '2021-05-02 22:45:00', '2021-05-03 02:31:09'),
(27, 1, '12', '2021-05-02 22:55:00', '2021-05-03 02:31:31');

-- --------------------------------------------------------

--
-- Table structure for table `plant`
--

CREATE TABLE `plant` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `line` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `webcam` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plant`
--

INSERT INTO `plant` (`id`, `name`, `line`, `position`, `cover`, `webcam`, `is_active`, `created_at`, `created_by`) VALUES
(1, 'morangos', 2, 3, '/storage/1725fca7-f369-4b13-a6ea-87dbfee88aa9.jpg', 'http://192.168.1.254/', 1, '2021-04-29 02:43:18', 1),
(2, 'Maças', 3, 3, '/storage/e2e83b21-c3fb-4115-8501-23b7b0c6a99a.jpg', 'http://192.168.1.253/', 1, '2021-04-29 02:43:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','gardener','user') NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `name`, `password`, `role`, `is_active`, `created_at`) VALUES
(1, 'admin@email.com', 'Admin', '$2y$10$y3AgQfOUwljeM2jgUI6WBe80apLSnI3bgjMSLoLiSeLnc7GpmD.lm', 'admin', 1, '2021-05-03 01:44:46'),
(2, 'gardener@email.com', 'Gardener', '$2y$10$y3AgQfOUwljeM2jgUI6WBe80apLSnI3bgjMSLoLiSeLnc7GpmD.lm', 'gardener', 1, '2021-04-27 12:50:37'),
(3, 'user@email.com', 'User', '$2y$10$y3AgQfOUwljeM2jgUI6WBe80apLSnI3bgjMSLoLiSeLnc7GpmD.lm', 'user', 1, '2021-04-27 12:50:37'),
(4, 'greenhouse@email.com', 'Greenhouse', '$2y$10$y3AgQfOUwljeM2jgUI6WBe80apLSnI3bgjMSLoLiSeLnc7GpmD.lm', 'gardener', 1, '2021-04-27 12:50:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_local` (`name_local`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_id` (`device_id`);

--
-- Indexes for table `plant`
--
ALTER TABLE `plant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `plant`
--
ALTER TABLE `plant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `device`
--
ALTER TABLE `device`
  ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `device_id` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
