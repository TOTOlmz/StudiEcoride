<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle gérant les connexions utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models;

use App\Models\BaseModel;

class ConnectionModel extends BaseModel {
    
    // Fonction permettant de gérer la connexion utilisateur
    public static function connection(string $email, string $password) {
        if (empty($email) || empty($password)) {
            throw new \Exception('Email and password are required.');
        }
        
        $sql = 'SELECT * FROM users WHERE email = ?';
        $user = self::fetchOne($sql, [$email]);
        
        // Vérifier la correspondance du mot de passe
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
}