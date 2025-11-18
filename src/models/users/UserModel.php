<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de gérer les infos d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../../database/dbConnection.php';


class UserModel {
    
    // Fonction permettant de récupérer la ligne correspondant à un ID dans une table donnée
    public static function getUserById($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fonction vérifiant l'existance du mail dans la bdd
    public static function emailExists($email) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
    
    // Fonction vérifiant l'existance du pseudo dans la bdd
    public static function pseudoExists($pseudo) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE pseudo = ?');
        $stmt->execute([$pseudo]);
        return $stmt->fetchColumn() > 0;
    }

    // Fonction permettant de créer un nouvel utilisateur dans la bdd
    public static function create($pseudo, $email, $password, $credits, $role) {
        global $pdo;
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        // On insert une nouvelle ligne dans la table users
        $stmt = $pdo->prepare('INSERT INTO users (pseudo, email, password, photo, credits, roles) 
                              VALUES (?, ?, ?, "default.png", ?, ?)');
        $stmt->execute([$pseudo, $email, $passwordHash, $credits, $role]);
        // On récupère l'ID du nouvel utilisateur
        return $pdo->lastInsertId();
    }

    
}