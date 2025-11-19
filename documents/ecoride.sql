-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2025 at 09:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecoride`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `email` varchar(180) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'default.png',
  `credits` int(11) DEFAULT 20,
  `roles` longtext DEFAULT NULL,
  `is_suspended` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- --------------------------------------------------------

--
-- Table structure for table `carpools`
--

CREATE TABLE `carpools` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `departure_city` varchar(255) DEFAULT NULL,
  `departure_postalcode` int(11) DEFAULT NULL,
  `departure_lat` double DEFAULT NULL,
  `departure_lon` double DEFAULT NULL,
  `arrival_time` time DEFAULT NULL,
  `arrival_city` varchar(255) DEFAULT NULL,
  `arrival_postalcode` int(11) DEFAULT NULL,
  `arrival_lat` double DEFAULT NULL,
  `arrival_lon` double DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `status` enum('Planifié','En cours','Terminé','A valider') NOT NULL DEFAULT 'Planifié',
  `seats` int(2) NOT NULL,
  `available_seats` int(2) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `driver_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `is_ecological` tinyint(1) NOT NULL,
  `smoke` tinyint(1) NOT NULL,
  `animals` tinyint(1) NOT NULL,
  `preferences` text NOT NULL,
  `commission` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `energy` enum('essence','diesel','hybride','electrique') DEFAULT NULL,
  `plate_number` varchar(20) DEFAULT NULL,
  `first_registration` date DEFAULT NULL,
  `driver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `participations`
--

CREATE TABLE `participations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `carpool_id` int(11) NOT NULL,
  `is_passenger` tinyint(1) DEFAULT 1,
  `is_confirmed` tinyint(1) DEFAULT 0,
  `is_satisfied` tinyint(1) DEFAULT 0,
  `pending_credits` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_email` text NOT NULL,
  `user_pseudo` text NOT NULL,
  `driver_id` int(11) NOT NULL,
  `driver_email` text NOT NULL,
  `driver_pseudo` text NOT NULL,
  `carpool_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `departure_city` text NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_city` text NOT NULL,
  `arrival_time` time NOT NULL,
  `subject` text NOT NULL,
  `description` longtext NOT NULL,
  `is_consulted` tinyint(1) NOT NULL DEFAULT 0,
  `is_closed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `rate` tinyint(1) DEFAULT NULL,
  `commentary` text DEFAULT NULL,
  `validate` tinyint(1) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `carpool_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------


--
-- Indexes for dumped tables
--

--
-- Indexes for table `carpools`
--
ALTER TABLE `carpools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `participations`
--
ALTER TABLE `participations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carpools`
--
ALTER TABLE `carpools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `participations`
--
ALTER TABLE `participations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
