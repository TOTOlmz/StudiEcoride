<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de gérer les infos d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../../database/dbConnection.php';


class UserModel {
    
    // Fonction permettant de récupérer la ligne correspondant à un ID dans une table donnée
    public static function getUserData($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Fonction permettant de mettre à jour la photo de profil de l'utilisateur
    public static function updatePhoto($fileName, $userId) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE users SET photo = ? WHERE id = ?');
        $stmt->execute([$fileName, $userId]);
        return $stmt->rowcount() > 0;
    }


    /* |||||||||||||||||||||| Fonctions liées à l'inscription |||||||||||||||||||||| */
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

    // Fonction permettant dd'ajuster les crédits d'un utilisateur
    public static function adjustCredits($userId, $credits) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE users SET credits = credits + ? WHERE id = ?');
        $stmt->execute([$credits, $userId]);
        return $stmt->rowcount() > 0;
    }

    // Fonction permettant de récupérer l'email des utilisateurs
    public static function getEmail($userId) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT email FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }


    
}