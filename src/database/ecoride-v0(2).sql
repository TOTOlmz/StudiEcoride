-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2025 at 08:15 AM
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

--
-- Dumping data for table `carpools`
--

INSERT INTO `carpools` (`id`, `date`, `departure_time`, `departure_city`, `departure_postalcode`, `departure_lat`, `departure_lon`, `arrival_time`, `arrival_city`, `arrival_postalcode`, `arrival_lat`, `arrival_lon`, `duration`, `status`, `seats`, `available_seats`, `price`, `driver_id`, `car_id`, `is_ecological`, `smoke`, `animals`, `preferences`, `commission`) VALUES
(1, '2025-11-20', '08:00:00', 'Dijon', 21000, 47.322047, 5.04148, '11:00:00', 'Lyon', 69003, 45.764043, 4.835659, 180, 'A valider', 5, 0, 45, 3, 1, 0, 0, 0, '', 1),
(2, '2025-11-20', '07:30:00', 'Longvic', 21600, 47.2872, 5.0978, '10:45:00', 'Villeurbanne', 69100, 45.766667, 4.866667, 195, 'Planifié', 3, 2, 50, 5, 2, 1, 0, 0, '', 0),
(3, '2025-11-20', '09:15:00', 'Chenôve', 21300, 47.3175, 5.0285, '12:10:00', 'Bron', 69500, 45.732, 4.911, 175, 'En cours', 4, 4, 40, 3, 4, 0, 1, 0, 'Pas de fumeur', 0),
(4, '2025-11-20', '06:45:00', 'Quetigny', 21800, 47.299, 5.071, '10:00:00', 'Vénissieux', 69200, 45.72, 4.885, 195, 'Planifié', 5, 3, 55, 7, 3, 0, 0, 1, '', 0),
(5, '2025-11-21', '08:30:00', 'Talant', 21240, 47.367, 5.002, '11:50:00', 'Oullins', 69600, 45.743, 4.81, 200, 'Planifié', 3, 1, 48, 4, 5, 1, 0, 0, 'Animaux ok', 0),

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

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `color`, `energy`, `plate_number`, `first_registration`, `driver_id`) VALUES
(1, 'Renault', 'Zoe', 'Rouge', 'essence', 'ME-458-MA', '2012-12-12', 3),
(2, 'Peugeot', '308', 'Bleu', 'diesel', 'AB-123-CD', '2015-06-15', 1),
(3, 'Citroën', 'C3', 'Noir', 'essence', 'BC-234-DE', '2018-03-20', 2),
(4, 'Toyota', 'Yaris', 'Blanc', 'hybride', 'CD-345-EF', '2020-11-05', 4),
(5, 'Volkswagen', 'Golf', 'Gris', 'diesel', 'DE-456-FG', '2010-01-10', 5),
(6, 'BMW', '320i', 'Vert', 'essence', 'EF-567-GH', '2019-09-09', 3),
(7, 'Audi', 'A3', 'Jaune', 'essence', 'FG-678-HI', '2016-04-22', 2),
(8, 'Ford', 'Focus', 'Argent', 'diesel', 'GH-789-IJ', '2013-07-30', 1),
(9, 'Mercedes', 'C-Class', 'Marron', 'hybride', 'HI-890-JK', '2021-02-14', 4),
(10, 'Nissan', 'Leaf', 'Bleu foncé', 'electrique', 'IJ-901-KL', '2014-08-08', 5);

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

--
-- Dumping data for table `participations`
--

INSERT INTO `participations` (`id`, `user_id`, `carpool_id`, `is_passenger`, `is_confirmed`, `is_satisfied`, `pending_credits`) VALUES
(4, 3, 4, 1, 0, 0, 0),
(13, 2, 56, 0, 0, 0, 0),
(14, 3, 1, 0, 0, 0, 0),
(15, 2, 1, 1, 1, 0, 45);

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
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `user_email`, `user_pseudo`, `driver_id`, `driver_email`, `driver_pseudo`, `carpool_id`, `date`, `departure_city`, `departure_time`, `arrival_city`, `arrival_time`, `subject`, `description`, `is_consulted`, `is_closed`) VALUES
(4, 2, 'ecoride-studi-passager@proton.me', 'Passager', 3, 'ecoride-studi-conductrice@proton.me', 'Conductrice', 1, '2025-11-12', 'Dijon', '08:00:00', 'Lyon', '11:00:00', 'pas content', 'Il roule a contre-sens', 1, 1);

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

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `rate`, `commentary`, `validate`, `user_id`, `driver_id`, `carpool_id`) VALUES
(1, 5, 'Super je suis content', 1, 3, 2, 4),
(3, 5, 'Très bon conducteur, ponctuel', 1, 5, 1, 5),
(5, 5, 'Excellent service', 1, 7, 2, 7),
(6, 5, 'Peut mieux faire franchement je trouve que c\'est moyen. copie à revoir. oh my god a honte. j\'ai cru mourir tellement il etait ennuyant. et je ne parle pas de sa conduite. Bon, vu que j\'ai tapé son chien je mets quand meme 5 étoiles', 1, 8, 4, 8),
(7, 1, 'Sympa et prudent', 1, 9, 3, 9),
(8, 5, 'Voyage très agréable', 1, 10, 5, 10),
(10, 4, 'Bonne expérience', 1, 12, 3, 12),
(11, 5, 'Recommande vivement', 1, 7, 13, 13),
(12, 4, 'OK', 1, 3, 13, 13),
(13, 4, 'Correct', 1, 15, 3, 15),
(14, 2, 'Mauvaise odeur dans la voiture', 0, 16, 9, 16),
(15, 5, 'Parfait', 1, 3, 3, 17),
(16, 4, 'Confortable et sûr', 1, 18, 3, 18),
(18, 4, 'Super voyage trop top moumoute', 0, 2, 3, 1);

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
(1, 'Admin', 'ecoride-studi-to@gmail.com', '$2y$12$nX.GJIosY1QNNSUgpfXvTe8KaeWcKjUWOcHe6WfeTnREzBGyHq6km', 'ecoride.png', 2, 'ADMIN'),
(2, 'Passager', 'ecoride-studi-passager@proton.me', '$2y$12$VyjNn.s4DsMkzAXGqVWz.O55W95IL.znOIeRsvv4tFwnMp3X3OXCy', 'Passager.jpg', 221, 'USER'),
(3, 'Conductrice', 'ecoride-studi-conductrice@proton.me', '$2y$12$uvwlSeKaOb/z11yl4wn.6us5Sxu3ZudIuF/ibNVVonQYN9F9akn66', 'Conductrice.jpg', 149, 'USER'),
(4, 'Alice', 'exemple1@mail.com', '', 'default.png', 10, 'USER'),
(5, 'Benoit', 'exemple2@mail.com', '', 'default.png', 15, 'USER'),
(6, 'Chloe', 'exemple3@mail.com', '', 'default.png', 20, 'USER'),
(7, 'Damien', 'exemple4@mail.com', '', 'default.png', 25, 'USER'),
(8, 'Emilie', 'exemple5@mail.com', '', 'default.png', 30, 'USER'),
(9, 'Fabien', 'exemple6@mail.com', '', 'default.png', 5, 'USER'),
(10, 'Gabrielle', 'exemple7@mail.com', '', 'default.png', 40, 'USER'),
(11, 'Hugo', 'exemple8@mail.com', '', 'default.png', 12, 'USER'),
(12, 'Ines', 'exemple9@mail.com', '', 'default.png', 18, 'USER'),
(13, 'Julien', 'exemple10@mail.com', '', 'default.png', 200, 'USER'),
(14, 'Karine', 'exemple11@mail.com', '', 'default.png', 7, 'USER'),
(15, 'Laurent', 'exemple12@mail.com', '', 'default.png', 50, 'USER'),
(16, 'employe', 'employee@ecoride.fr', '$2y$12$3jakAUj/TWh4QmleFkqhmOPi8ebdfBNwwyQpeO.eKdeiTSG5N9YTq', 'staff.png', 20, 'STAFF'),
(17, 'JeanMoustache', 'JMlerigolo@maiol.com', '$2y$12$hvg5onpU4k5jdd1LfTGg4.iDM4OY5MPGhBi8/7Zq2VBL8Dq3.T0zG', 'default.png', 20, 'USER'),
(18, 'JeanProut', 'Je@maail.bien', '$2y$12$3360yvtE2GuKmDmC8Yn.GOHXPrV5jb/QLXUOueUbNjONgGstKgtdm', 'default.png', 0, 'STAFF');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `participations`
--
ALTER TABLE `participations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
