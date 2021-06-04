-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04-Jun-2021 às 17:42
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
-- Truncar tabela antes do insert `category`
--

TRUNCATE TABLE `category`;
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
  `type` enum('sensor','actuators','other','') NOT NULL,
  `force_on` tinyint(1) NOT NULL,
  `switch_value` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncar tabela antes do insert `device`
--

TRUNCATE TABLE `device`;
--
-- Extraindo dados da tabela `device`
--

INSERT INTO `device` (`id`, `category_id`, `name_local`, `name`, `description`, `line`, `position`, `type`, `force_on`, `switch_value`, `is_active`, `created_at`) VALUES
(1, 1, 'temp_1_1', 'Temperatura', '                                                                                                                                                                                                                                    ', 2, 3, 'sensor', 1, 74, 1, '2021-05-03 19:05:52'),
(2, 10, 'fan_1_2', 'Fan 1-2', '                                                                                                                                                                                                                                                                                                                                                                                            ', 3, 1, 'actuators', 0, 0, 1, '2021-05-02 15:44:33'),
(3, 11, 'soil_moisture_1_1', 'Soil Moisture', '                                                                            ', 2, 3, 'sensor', 0, 36, 1, '2021-05-03 19:17:12'),
(4, 2, 'air_humidity_2_3', 'Air Humidity', '                                                                            ', 2, 3, 'sensor', 1, 38, 1, '2021-05-03 21:07:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `device_brigde`
--

DROP TABLE IF EXISTS `device_brigde`;
CREATE TABLE `device_brigde` (
  `sensor_id` int(11) NOT NULL,
  `atuator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncar tabela antes do insert `device_brigde`
--

TRUNCATE TABLE `device_brigde`;
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
-- Truncar tabela antes do insert `log`
--

TRUNCATE TABLE `log`;
--
-- Extraindo dados da tabela `log`
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
(27, 1, '12', '2021-05-02 22:55:00', '2021-05-03 02:31:31'),
(28, 3, '86', '2021-05-03 21:10:00', '2021-05-03 19:18:18'),
(29, 3, '84', '2021-05-03 21:15:00', '2021-05-03 19:18:18'),
(30, 4, '98', '2021-05-03 23:07:00', '2021-05-03 21:07:49'),
(31, 4, '97', '2021-05-03 23:05:00', '2021-05-03 21:07:49');

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
-- Truncar tabela antes do insert `plant`
--

TRUNCATE TABLE `plant`;
--
-- Extraindo dados da tabela `plant`
--

INSERT INTO `plant` (`id`, `name`, `line`, `position`, `cover`, `webcam`, `is_active`, `created_at`, `created_by`) VALUES
(1, 'morangos', 2, 3, '/storage/1725fca7-f369-4b13-a6ea-87dbfee88aa9.jpg', 'http://192.168.1.254/', 1, '2021-04-29 02:43:18', 1),
(2, 'Maças', 3, 3, '/storage/e2e83b21-c3fb-4115-8501-23b7b0c6a99a.jpg', 'http://192.168.1.253/', 1, '2021-04-29 02:43:31', 1),
(3, 'Watermelon', 2, 3, '/storage/55f918dc-8f2c-4373-8646-aba0e72a59e8.jpg', '', 1, '2021-05-03 18:49:14', 3);

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
-- Truncar tabela antes do insert `user`
--

TRUNCATE TABLE `user`;
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
(7, 'mcu_line3@email.com', 'MCU Linha 3', '$2y$10$7/UI.IaBp4lNOHDSwHxoHe/St7AoYiM/SAPc4zevstjoxbePSMExu', 'device', 1, '2021-05-29 16:38:14'),
(7, 'mcu_generic@email.com', 'MCU Generic', '$2y$10$7/UI.IaBp4lNOHDSwHxoHe/St7AoYiM/SAPc4zevstjoxbePSMExu', 'device', 1, '2021-05-29 16:38:24');

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
-- Índices para tabela `device_brigde`
--
ALTER TABLE `device_brigde`
  ADD KEY `atuator_id_relation` (`atuator_id`),
  ADD KEY `sensor_id_relation` (`sensor_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
-- Limitadores para a tabela `device_brigde`
--
ALTER TABLE `device_brigde`
  ADD CONSTRAINT `atuator_id_relation` FOREIGN KEY (`atuator_id`) REFERENCES `device` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sensor_id_relation` FOREIGN KEY (`sensor_id`) REFERENCES `device` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `device_id` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
