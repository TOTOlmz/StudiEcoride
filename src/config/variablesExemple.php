<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Configuration des variables d'environnement
    Fichier de configuration de la base de données
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

// Configuration de la base de données
$_ENV['DB_HOST'] = 'localhost';
$_ENV['DB_NAME'] = 'nom de la base';
$_ENV['DB_USER'] = 'nom d\'utilisateur';
$_ENV['DB_PASS'] = 'mot de passe';
$_ENV['DB_PORT'] = 'port';

// Options de connexion PDO (optionnel, pour les cas avancés)
$_ENV['DB_CHARSET'] = 'utf8mb4';
$_ENV['DB_TIMEZONE'] = 'Europe/Paris';
