-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2025 at 02:56 PM
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
-- Database: `ecoride-v0`
--

-- --------------------------------------------------------

--
-- Table structure for table `carpools`
--

CREATE TABLE `carpools` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `departure_city` varchar(255) DEFAULT NULL,
  `departure_postcode` int(11) DEFAULT NULL,
  `departure_inseecode` int(11) DEFAULT NULL,
  `arrival_time` time DEFAULT NULL,
  `arrival_city` varchar(255) DEFAULT NULL,
  `arrival_postcode` int(11) DEFAULT NULL,
  `arrival_inseecode` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `status` enum('Planifié','En cours','Terminé','A valider') NOT NULL DEFAULT 'Planifié',
  `seats` int(2) NOT NULL,
  `available_seats` int(2) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `driver_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `is_ecological` tinyint(1) DEFAULT 0,
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
  `energy` enum('Essence','Diesel','Hybride','Electrique') DEFAULT NULL,
  `plate_number` varchar(20) DEFAULT NULL,
  `first_registration` date DEFAULT NULL,
  `driver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `participation`
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `email` varchar(180) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'default.png',
  `credits` int(11) DEFAULT 20,
  `roles` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `password`, `photo`, `credits`, `roles`) VALUES
(1, 'Admin', 'admin@ecoride.fr', '$2y$12$7HiXnfPV7RzA0eaymlqAI.JEpVY/1oKdY31JD8yjYipiIvK1uxoPS', 'ecoride.png', 0, 'ADMIN');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
