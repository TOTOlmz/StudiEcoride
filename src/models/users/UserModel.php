<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de gérer les infos d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models\users;

use App\Models\BaseModel;

class UserModel extends BaseModel {
    
    // Fonction pour récupérer un utilisateur par son ID
    public static function getUserById(int $id): ?array {
        if ($id <= 0) {
            throw new \Exception('Identifiant utilisateur manquant.');
        }

        $sql = 'SELECT * FROM users WHERE id = ?';
        return self::fetchOne($sql, [$id]);
    }

    // Fonction vérifiant si un email existe dans la base de données
    public static function emailExists(string $email): bool {
        if (empty($email)) {
            throw new \Exception('Email is required.');
        }

        $sql = 'SELECT COUNT(*) FROM users WHERE email = ?';
        return self::count($sql, [$email]) > 0;
    }
    
    // Fonction vérifiant si un pseudo existe dans la base de données
    public static function pseudoExists(string $pseudo): bool {
        if (empty($pseudo)) {
            throw new \Exception('Pseudo is required.');
        }

        $sql = 'SELECT COUNT(*) FROM users WHERE pseudo = ?';
        return self::count($sql, [$pseudo]) > 0;
    }

    // Fonction pour créer un nouvel utilisateur
    public static function create(string $pseudo, string $email, string $password, int $credits, string $role) {
        if (empty($pseudo) || empty($email) || empty($password)) {
            throw new \Exception('Pseudo, email, and password are required.');
        }

        // Hasher le mot de passe
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        
        $sql = 'INSERT INTO users (pseudo, email, password, photo, credits, roles) 
                VALUES (?, ?, ?, "default.png", ?, ?)';
        
        $stmt = self::executeQuery($sql, [$pseudo, $email, $passwordHash, $credits, $role]);
        
        // Récupérer l'ID du nouvel utilisateur
        return self::getPdo()->lastInsertId() ?: false;
    }

    // Fonction pour mettre à jour les informations d'un utilisateur
    public static function update(int $userId, array $data): int {
        if ($userId <= 0 || empty($data)) {
            throw new \Exception('Invalid user ID or empty data.');
        }

        $allowedFields = ['pseudo', 'email', 'photo', 'credits', 'roles', 'is_suspended'];
        $setClause = [];
        $params = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $setClause[] = "$key = ?";
                $params[] = $value;
            }
        }

        if (empty($setClause)) {
            throw new \Exception('No valid fields to update.');
        }

        $params[] = $userId;
        $sql = 'UPDATE users SET ' . implode(', ', $setClause) . ' WHERE id = ?';
        
        $stmt = self::executeQuery($sql, $params);
        return $stmt->rowCount();
    }

    // Fonction pour supprimer un utilisateur
    public static function delete(int $userId): int {
        if ($userId <= 0) {
            throw new \Exception('Invalid user ID provided.');
        }

        $sql = 'DELETE FROM users WHERE id = ?';
        $stmt = self::executeQuery($sql, [$userId]);
        return $stmt->rowCount();
    }
}