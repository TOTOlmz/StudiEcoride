<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de gérer l'enregistrement d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models\users;

use App\Models\BaseModel;

class UserRegistrationModel extends BaseModel {
    
    // Fonction pour vérifier si un email existe
    public static function emailExists(string $email): bool {
        if (empty($email)) {
            throw new \Exception('Email is required.');
        }

        $sql = 'SELECT COUNT(*) FROM users WHERE email = ?';
        return self::count($sql, [$email]) > 0;
    }
    
    // Fonction pour vérifier si un pseudo existe
    public static function pseudoExists(string $pseudo): bool {
        if (empty($pseudo)) {
            throw new \Exception('Pseudo is required.');
        }

        $sql = 'SELECT COUNT(*) FROM users WHERE pseudo = ?';
        return self::count($sql, [$pseudo]) > 0;
    }

    // Fonction pour créer un nouvel utilisateur
    public static function create(string $pseudo, string $email, string $password) {
        if (empty($pseudo) || empty($email) || empty($password)) {
            throw new \Exception('Pseudo, email, and password are required.');
        }

        // Hasher le mot de passe
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        
        // Créer l'utilisateur avec les paramètres par défaut : 20 crédits, rôle USER
        $sql = "
            INSERT INTO users (pseudo, email, password, photo, credits, roles, created_at) 
            VALUES (?, ?, ?, 'default.png', 20, 'USER', NOW())
        ";
        
        $stmt = self::executeQuery($sql, [$pseudo, $email, $passwordHash]);
        
        // Récupérer l'ID du nouvel utilisateur
        return self::getPdo()->lastInsertId() ?: false;
    }
}