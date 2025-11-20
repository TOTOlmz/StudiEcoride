--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `password`, `photo`, `credits`, `roles`, `is_suspended`) VALUES
(1, 'Admin', 'ecoride.studi.to@gmail.com', '$2y$12$nX.GJIosY1QNNSUgpfXvTe8KaeWcKjUWOcHe6WfeTnREzBGyHq6km', 'default.png', 12, 'ADMIN', 0),
(2, 'employe', 'employee@ecoride.fr', '$2y$12$3jakAUj/TWh4QmleFkqhmOPi8ebdfBNwwyQpeO.eKdeiTSG5N9YTq', 'default.png', 0, 'STAFF', 0),
(3, 'Conductrice', 'ecoride-studi-conductrice@proton.me', '$2y$12$uvwlSeKaOb/z11yl4wn.6us5Sxu3ZudIuF/ibNVVonQYN9F9akn66', 'Conductrice.jpg', 200, 'USER', 0),
(4, 'Passager', 'ecoride-studi-passager@proton.me', '$2y$12$VyjNn.s4DsMkzAXGqVWz.O55W95IL.znOIeRsvv4tFwnMp3X3OXCy', 'Passager.jpg', 200, 'USER', 0),
(5, 'Lucas', 'lucas@mail.fr', '$2y$12$VyjNn.s4DsMkzAXGqVWz.O55W95IL.znOIeRsvv4tFwnMp3X3OXCy', 'default.png', 100, 'USER', 0),
(6, 'Emma', 'emma@mail.fr', '$2y$12$VyjNn.s4DsMkzAXGqVWz.O55W95IL.znOIeRsvv4tFwnMp3X3OXCy', 'default.png', 100, 'USER', 0),
(7, 'Hugo', 'hugo@mail.fr', '$2y$12$VyjNn.s4DsMkzAXGqVWz.O55W95IL.znOIeRsvv4tFwnMp3X3OXCy', 'default.png', 100, 'USER', 0),
(8, 'Camille', 'camille@mail.fr', '$2y$12$VyjNn.s4DsMkzAXGqVWz.O55W95IL.znOIeRsvv4tFwnMp3X3OXCy', 'default.png', 100, 'USER', 0),
(9, 'Gabriel', 'gabriel@mail.fr', '$2y$12$VyjNn.s4DsMkzAXGqVWz.O55W95IL.znOIeRsvv4tFwnMp3X3OXCy', 'default.png', 100, 'USER', 0),
(10, 'Chloe', 'chloe@mail.fr', '$2y$12$VyjNn.s4DsMkzAXGqVWz.O55W95IL.znOIeRsvv4tFwnMp3X3OXCy', 'default.png', 100, 'USER', 0),
(11, 'Lea', 'lea@mail.fr', '$2y$12$VyjNn.s4DsMkzAXGqVWz.O55W95IL.znOIeRsvv4tFwnMp3X3OXCy', 'default.png', 100, 'USER', 0),
(12, 'Antoine', 'antoine@mail.fr', '$2y$12$VyjNn.s4DsMkzAXGqVWz.O55W95IL.znOIeRsvv4tFwnMp3X3OXCy', 'default.png', 100, 'USER', 0),
(13, 'Manon', 'manon@mail.fr', '$2y$12$VyjNn.s4DsMkzAXGqVWz.O55W95IL.znOIeRsvv4tFwnMp3X3OXCy', 'default.png', 100, 'USER', 0),
(14, 'Maxime', 'maxime@mail.fr', '$2y$12$VyjNn.s4DsMkzAXGqVWz.O55W95IL.znOIeRsvv4tFwnMp3X3OXCy', 'default.png', 100, 'USER', 0);

--
-- Dumping data for table `carpools`
--

INSERT INTO `carpools` (`id`, `date`, `departure_time`, `departure_city`, `departure_postalcode`, `departure_lat`, `departure_lon`, `arrival_time`, `arrival_city`, `arrival_postalcode`, `arrival_lat`, `arrival_lon`, `duration`, `status`, `seats`, `available_seats`, `price`, `driver_id`, `car_id`, `is_ecological`, `smoke`, `animals`, `preferences`, `commission`) VALUES
(1, '2025-11-20','08:00:00','Paris',75001,48.8566,2.3522,'11:30:00','Lille',59000,50.6292,3.0573,210,'Planifié',4,4,30,3,1,0,0,0,'',0),
(2, '2025-11-20','07:30:00','Lille',59000,50.6292,3.0573,'10:45:00','Amiens',80000,49.895,2.302,195,'A valider',3,0,20,5,2,0,0,0,'',1),
(3, '2025-11-20','09:15:00','Rennes',35000,48.1173,-1.6778,'12:10:00','Nantes',44000,47.2184,-1.5536,175,'En cours',4,2,25,3,4,0,1,0,'Pas de fumeur',0),
(4, '2025-11-21','06:45:00','Brest',29200,48.3904,-4.4861,'10:15:00','Quimper',29000,48.0006,-4.0962,210,'Planifié',3,3,18,6,3,0,0,0,'',0),
(5, '2025-11-22','12:00:00','Nantes',44000,47.2184,-1.5536,'15:30:00','Bordeaux',33000,44.8378,-0.5792,210,'Terminé',5,0,60,7,5,0,0,0,'',1),
(6, '2025-11-23','07:10:00','Bordeaux',33000,44.8378,-0.5792,'09:40:00','Arcachon',33120,44.6544,-1.169,150,'Planifié',3,3,12,8,6,0,0,1,'Animaux ok',0),
(7, '2025-11-24','14:30:00','Biarritz',64200,43.4832,-1.5586,'17:45:00','Bayonne',64100,43.4925,-1.4743,195,'A valider',4,0,28,5,4,0,0,0,'',1),
(8, '2025-11-25','10:00:00','Toulouse',31000,43.6045,1.444,'12:30:00','Montpellier',34000,43.6119,3.8772,150,'En cours',3,1,35,3,2,0,0,0,'Musique faible',0),
(9, '2025-11-26','18:15:00','Montpellier',34000,43.6119,3.8772,'21:45:00','Marseille',13000,43.2965,5.3698,210,'Terminé',5,0,45,6,8,0,0,0,'',1),
(10,'2025-11-27','08:30:00','Perpignan',66000,42.6887,2.8948,'10:00:00','Narbonne',11100,43.1847,3.005,90,'Planifié',2,2,15,7,1,0,1,0,'',0),
(11,'2025-11-28','09:00:00','Nice',06000,43.7102,7.262,'11:30:00','Cannes',06400,43.5528,7.0174,150,'En cours',4,2,22,8,3,0,0,0,'Pas d''alcool',0),
(12,'2025-11-28','13:00:00','Marseille',13000,43.2965,5.3698,'16:30:00','Aix-en-Provence',13100,43.5297,5.4474,210,'A valider',5,0,30,5,6,1,0,0,'',1),
(13,'2025-11-29','07:45:00','Avignon',84000,43.9493,4.8055,'09:45:00','Nîmes',30000,43.8367,4.3601,120,'Planifié',3,3,18,6,2,0,0,0,'',0),
(14,'2025-11-29','11:20:00','Lyon',69000,45.764,4.8357,'14:50:00','Grenoble',38000,45.1885,5.7245,210,'Terminé',4,0,40,7,7,0,0,0,'',1),
(15,'2025-11-30','16:00:00','Grenoble',38000,45.1885,5.7245,'18:30:00','Chambéry',73000,45.5646,5.9178,150,'En cours',4,1,22,3,4,1,0,0,'Pas de musique forte',0),
(16,'2025-12-01','06:30:00','Clermont-Ferrand',63000,45.7772,3.087,'09:00:00','Lyon',69000,45.764,4.8357,150,'Planifié',3,3,28,5,5,0,0,1,'',0),
(17,'2025-12-01','20:00:00','Angers',49000,47.4784,-0.5632,'23:30:00','Le Mans',72000,48.0061,0.1996,210,'A valider',5,0,26,6,8,0,0,0,'',1),
(18,'2025-12-02','09:10:00','Le Havre',76600,49.4944,0.1079,'11:00:00','Rouen',76000,49.4432,1.0993,110,'En cours',2,0,20,3,1,0,1,0,'Rapide',0),
(19,'2025-12-02','12:30:00','Caen',14000,49.1829,-0.3707,'15:30:00','Saint-Lô',50000,49.1156,-1.0884,180,'Terminé',4,0,34,7,2,1,0,0,'',1),
(20,'2025-12-03','07:00:00','Dijon',21000,47.322,5.0415,'10:00:00','Besançon',25000,47.2378,6.0241,180,'Planifié',5,5,45,8,3,0,0,0,'',0),
(21,'2025-12-03','14:15:00','Besançon',25000,47.2378,6.0241,'16:45:00','Bourg-en-Bresse',01000,46.2051,5.2254,150,'En cours',3,1,20,5,4,0,0,0,'',0),
(22,'2025-12-04','08:20:00','Mont-de-Marsan',40000,43.891,0.5026,'10:50:00','Pau',64000,43.2951,-0.3708,150,'Planifié',3,3,30,6,5,0,1,0,'',0),
(23,'2025-12-04','18:00:00','Nîmes',30000,43.8367,4.3601,'21:00:00','Montpellier',34000,43.6119,3.8772,180,'A valider',5,0,34,7,6,0,0,0,'',1),
(24,'2025-12-05','06:45:00','Perigueux',24000,45.1847,0.7216,'08:30:00','Périgueux',24000,45.1847,0.7216,105,'En cours',2,2,12,3,2,1,0,0,'',0),
(25,'2025-12-05','10:00:00','Bordeaux',33000,44.8378,-0.5792,'13:30:00','Toulouse',31000,43.6045,1.444,210,'Terminé',4,0,55,8,7,0,0,0,'',1),
(26,'2025-12-06','09:30:00','Toulon',83000,43.1242,5.928,'11:15:00','Aix-en-Provence',13100,43.5297,5.4474,105,'Planifié',3,3,20,5,1,0,0,0,'',0),
(27,'2025-12-06','15:45:00','Nice',06000,43.7102,7.262,'18:30:00','Marseille',13000,43.2965,5.3698,165,'A valider',4,0,38,6,4,0,1,0,'',1),
(28,'2025-12-07','07:20:00','Mulhouse',68100,47.7508,7.3359,'09:50:00','Strasbourg',67000,48.5734,7.7521,150,'En cours',3,1,22,7,2,0,0,0,'',0),
(29,'2025-12-07','20:10:00','Strasbourg',67000,48.5734,7.7521,'23:00:00','Metz',57000,49.1193,6.1757,170,'Terminé',5,0,48,8,8,1,0,0,'',1),
(30,'2025-12-08','12:40:00','Metz',57000,49.1193,6.1757,'14:10:00','Nancy',54000,48.6921,6.1844,90,'Planifié',2,2,12,3,1,0,0,0,'',0),
(31,'2025-12-08','17:00:00','Nancy',54000,48.6921,6.1844,'20:15:00','Reims',51100,49.2583,4.0317,195,'En cours',4,2,40,5,3,0,0,1,'',0),
(32,'2025-12-09','08:50:00','Reims',51100,49.2583,4.0317,'11:20:00','Troyes',10000,48.2973,4.0744,150,'A valider',3,0,28,6,5,0,0,0,'',1),
(33,'2025-12-09','13:30:00','Troyes',10000,48.2973,4.0744,'16:00:00','Dijon',21000,47.322,5.0415,150,'Terminé',4,0,36,7,4,0,0,0,'',1),
(34,'2025-12-10','09:00:00','Dijon',21000,47.322,5.0415,'11:00:00','Besançon',25000,47.2378,6.0241,120,'Planifié',3,3,16,8,2,0,1,0,'',0),
(35,'2025-12-10','19:15:00','Annecy',74000,45.8992,6.1294,'22:45:00','Chamonix',74400,45.9237,6.8694,210,'En cours',5,2,60,5,7,0,0,0,'',0),
(36,'2025-12-11','06:00:00','Chambéry',73000,45.5646,5.9178,'08:10:00','Albertville',73200,45.6759,6.3906,130,'A valider',2,0,14,6,1,0,0,0,'',1),
(37,'2025-12-11','11:30:00','Bordeaux',33000,44.8378,-0.5792,'14:45:00','Pau',64000,43.2951,-0.3708,195,'Terminé',4,0,50,7,8,1,0,0,'',1),
(38,'2025-12-12','08:10:00','Pau',64000,43.2951,-0.3708,'10:30:00','Bayonne',64100,43.4925,-1.4743,140,'En cours',3,1,18,3,5,0,0,0,'',0),
(39,'2025-12-12','15:00:00','Agen',47000,44.202,0.6292,'17:30:00','Toulouse',31000,43.6045,1.444,150,'Planifié',4,4,28,5,3,0,1,0,'',0),
(40,'2025-12-13','07:40:00','Béziers',34500,43.3445,3.2158,'09:40:00','Narbonne',11100,43.1847,3.005,120,'A valider',3,0,18,6,2,0,0,0,'',1),
(41,'2025-12-13','18:20:00','Toulouse',31000,43.6045,1.444,'21:50:00','Biarritz',64200,43.4832,-1.5586,210,'Terminé',5,0,55,8,8,0,0,0,'',1),
(42,'2025-12-14','09:15:00','Albi',81000,43.9285,2.1431,'11:00:00','Cahors',46000,44.4473,1.4408,105,'En cours',2,1,16,7,1,0,0,0,'',0),
(43,'2025-12-14','12:00:00','Limoges',87000,45.8336,1.2611,'15:00:00','Brive-la-Gaillarde',19100,45.1596,1.5338,180,'Planifié',4,4,35,5,3,1,0,0,'',0),
(44,'2025-12-15','06:45:00','Rodez',12000,44.3512,2.5736,'09:30:00','Mende',48000,44.5185,3.5019,165,'A valider',3,0,22,6,5,0,0,0,'',1),
(45,'2025-12-15','17:30:00','Valence',26000,44.9333,4.8924,'20:00:00','Montélimar',26200,44.5586,4.7437,150,'En cours',3,2,20,7,4,0,0,0,'',0),
(46,'2025-12-16','08:25:00','Toulouse',31000,43.6045,1.444,'10:55:00','Albi',81000,43.9285,2.1431,150,'Terminé',4,0,26,6,2,0,0,0,'',1),
(47,'2025-12-16','19:50:00','Ajaccio',20000,41.9192,8.7386,'23:00:00','Bastia',20200,42.6977,9.4509,190,'A valider',5,0,70,5,7,1,0,0,'',1);

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `color`, `energy`, `plate_number`, `first_registration`, `driver_id`) VALUES
(1, 'Peugeot', '308', 'Bleu', 'diesel', 'AB-123-CD', '2015-06-15', 3),
(2, 'Citroën', 'C3', 'Noir', 'essence', 'BC-234-DE', '2018-03-20', 3),
(3, 'Toyota', 'Yaris', 'Blanc', 'hybride', 'CD-345-EF', '2020-11-05', 8),
(4, 'Nissan', 'Leaf', 'Bleu foncé', 'electrique', 'IJ-901-KL', '2014-08-08', 5),
(5, 'Renault', 'Clio', 'Gris', 'essence', 'EF-456-GH', '2016-04-10', 6),
(6, 'Volkswagen', 'Golf', 'Noir', 'diesel', 'GH-567-IJ', '2017-09-12', 7),
(7, 'Ford', 'Focus', 'Rouge', 'essence', 'KL-678-MN', '2019-02-02', 5),
(8, 'Tesla', 'Model 3', 'Blanc', 'electrique', 'MN-789-OP', '2021-06-30', 3);

--
-- Dumping data for table `participations`
--

INSERT INTO `participations` (`id`, `user_id`, `carpool_id`, `is_passenger`, `is_confirmed`, `is_satisfied`, `pending_credits`) VALUES
(1, 3, 1, 0, 0, 0, 30),
(2, 4, 2, 1, 0, 0, 20),
(3, 3, 7, 1, 1, 0, 25),
(4, 6, 5, 1, 1, 1, 0),
(5, 7, 9, 1, 1, 1, 0),
(6, 8, 12, 1, 0, 0, 30),
(7, 9, 14, 1, 1, 1, 0),
(8, 10, 17, 1, 0, 0, 26),
(9, 11, 19, 1, 1, 1, 0),
(10, 12, 20, 1, 0, 0, 45),
(11, 13, 21, 1, 0, 0, 20),
(12, 14, 22, 1, 0, 0, 30),
(13, 3, 23, 1, 0, 0, 34),
(14, 4, 25, 1, 1, 1, 0),
(15, 5, 27, 1, 0, 0, 32),
(16, 6, 29, 1, 1, 1, 0),
(17, 7, 31, 1, 0, 0, 40),
(18, 8, 32, 1, 0, 0, 28),
(19, 9, 33, 1, 1, 1, 0),
(20, 10, 35, 1, 0, 0, 60),
(21, 11, 36, 1, 0, 0, 14),
(22, 12, 37, 1, 1, 1, 0),
(23, 13, 38, 1, 0, 0, 18),
(24, 14, 39, 1, 0, 0, 28),
(25, 3, 40, 1, 0, 0, 18),
(26, 4, 41, 1, 1, 1, 0),
(27, 5, 44, 1, 0, 0, 22),
(28, 6, 46, 0, 1, 1, 0),
(29, 7, 47, 1, 0, 0, 70),
(30, 8, 4, 1, 0, 0, 18);

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `user_email`, `user_pseudo`, `driver_id`, `driver_email`, `driver_pseudo`, `carpool_id`, `date`, `departure_city`, `departure_time`, `arrival_city`, `arrival_time`, `subject`, `description`, `is_consulted`, `is_closed`) VALUES
(7, 3, 'ecoride-studi-conductrice@proton.me', 'Conductrice', 5, 'lucas@mail.fr', 'Lucas', 7, '2025-11-24', 'Biarritz', '14:30:00', 'Bayonne', '17:45:00', 'Somnolence au volant', 'Il piquait du nez et refusait que je le remplace pour conduire.', 0, 0);
-- --------------------------------------------------------

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `rate`, `commentary`, `validate`, `user_id`, `driver_id`, `carpool_id`) VALUES
(1, 3, 'Correct et professionnel, je reviendrai', 0, 8, 6, 4),
(2, 2, 'Conducteur en retard, trajet correct mais déçu', 0, 3, 3, 1),
(3, 1, 'Mauvaise communication, il ne m''a pas prévenu', 0, 4, 5, 2),
(4, 2, 'Confort moyen, voiture propre mais conduite rapide', 0, 3, 5, 7),
(5, 2, 'Arrivée en retard et peu d''explications', 0, 8, 5, 12),
(6, 3, 'Bon trajet, conversation agréable', 0, 10, 6, 17),
(7, 2, 'Musique trop forte, passable', 0, 12, 8, 20),
(8, 3, 'Ponctuel et poli', 0, 13, 5, 21),
(9, 2, 'Trajet stressant, attention à la vitesse', 0, 14, 6, 22),
(10, 1, 'Annulation de dernière minute, décevant', 0, 3, 7, 23),
(11, 2, 'Voiture propre mais climatisation défaillante', 0, 5, 6, 27),
(12, 3, 'Bonne expérience, je recommande', 0, 7, 5, 31),
(13, 2, 'Mauvaise organisation pour les bagages', 0, 8, 6, 32),
(14, 1, 'Trajet trop long et arrêts non prévus', 0, 10, 5, 35),
(15, 2, 'Confort acceptable mais pourrait s''améliorer', 0, 11, 6, 36),
(16, 3, 'Très bon conducteur, trajet fluide', 0, 13, 3, 38),
(17, 2, 'Arrêts imprévus, retardé', 0, 14, 5, 39),
(18, 2, 'Prix élevé pour la distance parcourue', 0, 3, 6, 40),
(19, 1, 'Comportement inadapté pendant le trajet', 0, 5, 6, 44),
(20, 2, 'Respect des règles moyen, correct mais perfectible', 0, 7, 5, 47);
