<?php
require_once __DIR__ . '/../../database/dbConnection.php';

class UserRegistrationModel {
    
    // Fonction permettant de vérifier l'existance du mail dans la bdd
    public static function emailExists($email) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
    
    // Fonction permettant de vérifier l'existance du pseudo dans la bdd
    public static function pseudoExists($pseudo) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE pseudo = ?');
        $stmt->execute([$pseudo]);
        return $stmt->fetchColumn() > 0;
    }


    // Fonction permettant de créer un nouvel utilisateur dans la bdd
    public static function create($pseudo, $email, $password) {
        global $pdo;
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        // On insert une nouvelle ligne dans la table users
        $stmt = $pdo->prepare("INSERT INTO users (pseudo, email, password, photo, credits, roles) 
                              VALUES (?, ?, ?, 'default.png', 20, 'USER')");
        $stmt->execute([$pseudo, $email, $passwordHash]);
        // On récupère l'ID du nouvel utilisateur
        return $pdo->lastInsertId();
    }

}