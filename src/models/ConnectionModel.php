<?php

require_once __DIR__ . '/../database/dbConnection.php';

class ConnectionModel {
    
    // Fonction permettant de récupérer les informations utilisateur dans la bdd
    public static function connection($email, $password) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // On vérifie la carrespondance du mot de passe
        if ($user && password_verify($password, $user['password'])) {  
            return $user;
        }
        return false;
    }
}
