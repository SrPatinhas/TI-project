-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Jun-2021 às 00:18
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `greenhouse`
--
CREATE DATABASE IF NOT EXISTS `greenhouse` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `greenhouse`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `measure` varchar(255) NOT NULL COMMENT '% for humidity or lux for light',
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `category`
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
-- Estrutura da tabela `device`
--

DROP TABLE IF EXISTS `device`;
CREATE TABLE `device` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name_local` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `line` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `type` enum('sensor','actuators','other') NOT NULL,
  `force_on` tinyint(1) NOT NULL,
  `switch_value` int(11) NOT NULL,
  `device_bridge_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `device`
--

INSERT INTO `device` (`id`, `category_id`, `name_local`, `name`, `description`, `line`, `position`, `type`, `force_on`, `switch_value`, `device_bridge_id`, `is_active`, `created_at`) VALUES
(1, 11, 'humidity_sensor_1_1', 'Humidity Sensor', '                                                                            ', 1, 1, 'sensor', 0, 70, 13, 1, '2021-06-05 19:55:35'),
(2, 11, 'humidity_sensor_1_2', 'Humidity Sensor', '                                                                            ', 1, 2, 'sensor', 0, 70, 14, 1, '2021-06-05 19:55:50'),
(3, 11, 'humidity_sensor_1_3', 'Humidity Sensor', ' ', 1, 3, 'sensor', 0, 70, 15, 0, '2021-06-05 19:53:58'),
(4, 11, 'humidity_sensor_1_4', 'Humidity Sensor', ' ', 1, 4, 'sensor', 0, 70, 16, 1, '2021-06-05 19:55:38'),
(5, 11, 'humidity_sensor_2_1', 'Humidity Sensor', ' ', 2, 1, 'sensor', 0, 70, 17, 1, '2021-06-05 19:55:51'),
(6, 11, 'humidity_sensor_2_2', 'Humidity Sensor', ' ', 2, 2, 'sensor', 0, 70, 18, 0, '2021-06-05 19:53:57'),
(7, 11, 'humidity_sensor_2_3', 'Humidity Sensor', ' ', 2, 3, 'sensor', 0, 70, 19, 1, '2021-06-05 19:55:55'),
(8, 11, 'humidity_sensor_2_4', 'Humidity Sensor', ' ', 2, 4, 'sensor', 0, 70, 20, 1, '2021-06-05 19:55:56'),
(9, 11, 'humidity_sensor_3_1', 'Humidity Sensor', ' ', 3, 1, 'sensor', 0, 70, 21, 0, '2021-06-05 19:53:54'),
(10, 11, 'humidity_sensor_3_2', 'Humidity Sensor', ' ', 3, 2, 'sensor', 0, 70, 22, 1, '2021-06-05 16:39:40'),
(11, 11, 'humidity_sensor_3_3', 'Humidity Sensor', ' ', 3, 3, 'sensor', 0, 70, 23, 1, '2021-06-05 16:39:43'),
(12, 11, 'humidity_sensor_3_4', 'Humidity Sensor', ' ', 3, 4, 'sensor', 0, 70, 24, 1, '2021-06-05 16:39:47'),
(13, 8, 'sprinkler_1_1', 'Sprinkler', '                                                                            ', 1, 1, 'actuators', 1, 71, 1, 1, '2021-06-05 19:56:07'),
(14, 8, 'sprinkler_1_2', 'Sprinkler', '                                                                            ', 1, 2, 'actuators', 0, 71, 1, 1, '2021-06-05 16:24:35'),
(15, 8, 'sprinkler_1_3', 'Sprinkler', '                                                                             ', 1, 3, 'actuators', 0, 27, 3, 1, '2021-06-05 17:03:34'),
(16, 8, 'sprinkler_1_4', 'Sprinkler', ' ', 1, 4, 'actuators', 1, 71, 4, 1, '2021-06-05 19:56:05'),
(17, 8, 'sprinkler_2_1', 'Sprinkler', ' ', 2, 1, 'actuators', 1, 71, 5, 1, '2021-06-05 19:48:23'),
(18, 8, 'sprinkler_2_2', 'Sprinkler', ' ', 2, 2, 'actuators', 0, 71, 6, 1, '2021-06-05 16:28:20'),
(19, 8, 'sprinkler_2_3', 'Sprinkler', ' ', 2, 3, 'actuators', 1, 71, 7, 1, '2021-06-05 19:56:01'),
(20, 8, 'sprinkler_2_4', 'Sprinkler', ' ', 2, 4, 'actuators', 0, 71, 8, 1, '2021-06-05 16:28:42'),
(21, 8, 'sprinkler_3_1', 'Sprinkler', ' ', 3, 1, 'actuators', 0, 71, 9, 1, '2021-06-05 16:28:58'),
(22, 8, 'sprinkler_3_2', 'Sprinkler', ' ', 3, 2, 'actuators', 0, 71, 10, 1, '2021-06-05 16:29:35'),
(23, 8, 'sprinkler_3_3', 'Sprinkler', ' ', 3, 3, 'actuators', 0, 71, 11, 1, '2021-06-05 16:29:44'),
(24, 8, 'sprinkler_3_4', 'Sprinkler', ' ', 3, 4, 'actuators', 0, 71, 12, 1, '2021-06-05 16:29:52'),
(25, 11, 'humidity_sensor_4_1', 'Humidity Sensor', ' ', 4, 1, 'sensor', 0, 70, 24, 1, '2021-06-05 16:39:47'),
(26, 11, 'humidity_sensor_4_2', 'Humidity Sensor', ' ', 4, 2, 'sensor', 0, 70, 24, 1, '2021-06-05 18:25:46'),
(27, 11, 'humidity_sensor_4_3', 'Humidity Sensor', ' ', 4, 3, 'sensor', 0, 70, 24, 1, '2021-06-05 18:25:53'),
(28, 11, 'humidity_sensor_4_4', 'Humidity Sensor', ' ', 4, 4, 'sensor', 0, 70, 24, 1, '2021-06-05 18:26:00'),
(29, 8, 'sprinkler_4_1', 'Sprinkler', ' ', 4, 1, 'actuators', 0, 71, 25, 1, '2021-06-05 16:29:52'),
(30, 8, 'sprinkler_4_2', 'Sprinkler', ' ', 4, 2, 'actuators', 0, 71, 26, 1, '2021-06-05 18:26:58'),
(31, 8, 'sprinkler_4_3', 'Sprinkler', ' ', 4, 3, 'actuators', 0, 71, 27, 1, '2021-06-05 18:27:11'),
(32, 8, 'sprinkler_4_4', 'Sprinkler', ' ', 4, 4, 'actuators', 0, 71, 28, 1, '2021-06-05 18:27:22');

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `log`
--

INSERT INTO `log` (`id`, `device_id`, `value`, `date`, `created_at`) VALUES
(1, 1, '21', '2021-05-02 21:10:00', '2021-06-05 16:54:15'),
(2, 1, '20', '2021-05-02 21:10:00', '2021-06-05 16:54:17'),
(3, 1, '22', '2021-05-02 21:10:00', '2021-06-05 16:54:19'),
(4, 1, '22', '2021-05-02 21:12:00', '2021-06-05 16:54:20'),
(5, 1, '22', '2021-05-02 21:13:00', '2021-06-05 16:54:22'),
(6, 1, '22', '2021-05-02 21:14:00', '2021-06-05 16:54:23'),
(7, 1, '21', '2021-05-02 21:15:00', '2021-06-05 16:54:25'),
(8, 3, '29', '2021-05-02 21:12:00', '2021-06-05 16:54:42'),
(9, 3, '28', '2021-05-02 21:13:00', '2021-06-05 16:54:51'),
(10, 3, '27', '2021-05-02 21:15:00', '2021-06-05 16:54:57'),
(11, 3, '30', '2021-05-02 21:16:00', '2021-06-05 16:55:06'),
(12, 3, '21', '2021-05-02 21:17:00', '2021-06-05 16:55:16'),
(13, 3, '26', '2021-05-02 21:18:00', '2021-06-05 17:03:13'),
(14, 3, '28', '2021-05-02 21:19:00', '2021-06-05 17:03:51');

-- --------------------------------------------------------

--
-- Estrutura da tabela `plant`
--

DROP TABLE IF EXISTS `plant`;
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
-- Extraindo dados da tabela `plant`
--

INSERT INTO `plant` (`id`, `name`, `line`, `position`, `cover`, `webcam`, `is_active`, `created_at`, `created_by`) VALUES
(1, 'morangos', 1, 3, '/storage/1725fca7-f369-4b13-a6ea-87dbfee88aa9.jpg', 'http://178.203.161.161:81/mjpg/video.mjpg', 1, '2021-04-29 02:43:18', 1),
(2, 'Maças', 3, 3, '/storage/e2e83b21-c3fb-4115-8501-23b7b0c6a99a.jpg', 'http://79.108.129.167:9000/mjpg/video.mjpg', 1, '2021-04-29 02:43:31', 1),
(3, 'Watermelon', 1, 1, '/storage/55f918dc-8f2c-4373-8646-aba0e72a59e8.jpg', 'http://201.213.190.16:80/mjpg/video.mjpg', 1, '2021-05-03 18:49:14', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','gardener','user','device') NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `email`, `name`, `password`, `role`, `is_active`, `created_at`) VALUES
(1, 'admin@email.com', 'Admin', '$2y$10$y3AgQfOUwljeM2jgUI6WBe80apLSnI3bgjMSLoLiSeLnc7GpmD.lm', 'admin', 1, '2021-05-03 01:44:46'),
(2, 'gardener@email.com', 'Gardener', '$2y$10$y3AgQfOUwljeM2jgUI6WBe80apLSnI3bgjMSLoLiSeLnc7GpmD.lm', 'gardener', 1, '2021-04-27 12:50:37'),
(3, 'user@email.com', 'User', '$2y$10$y3AgQfOUwljeM2jgUI6WBe80apLSnI3bgjMSLoLiSeLnc7GpmD.lm', 'user', 1, '2021-04-27 12:50:37'),
(4, 'greenhouse@email.com', 'Greenhouse', '$2y$10$y3AgQfOUwljeM2jgUI6WBe80apLSnI3bgjMSLoLiSeLnc7GpmD.lm', 'gardener', 1, '2021-04-27 12:50:37'),
(5, 'mcu_line1@email.com', 'MCU Linha 1', '$2y$10$7htXxHNDo0d0EiqpNjL3uulymx7IbQTevknl/d2XPcfzNE/VdB5q.', 'device', 1, '2021-05-29 16:37:49'),
(6, 'mcu_line2@email.com', 'MCU Linha 2', '$2y$10$1.j2EWf/kXCmyerFZmhEUu3Vpqzu1Ix49NfR3fVYjMr1LEavGh85q', 'device', 1, '2021-05-29 16:38:04'),
(7, 'mcu_line3@email.com', 'MCU Linha 3', '$2y$10$7/UI.IaBp4lNOHDSwHxoHe/St7AoYiM/SAPc4zevstjoxbePSMExu', 'device', 1, '2021-05-29 16:38:14');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_local` (`name_local`),
  ADD KEY `category_id` (`category_id`);

--
-- Índices para tabela `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_id` (`device_id`);

--
-- Índices para tabela `plant`
--
ALTER TABLE `plant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `device`
--
ALTER TABLE `device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `plant`
--
ALTER TABLE `plant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `device`
--
ALTER TABLE `device`
  ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Limitadores para a tabela `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `device_id` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
