<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de gérer les infos d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../../database/dbConnection.php';


class UserProfileModel {

    // Fonction permettant de mettre à jour la photo de profil de l'utilisateur
    public static function updatePhoto($fileName, $userId) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE users SET photo = ? WHERE id = ?');
        $stmt->execute([$fileName, $userId]);
        return $stmt->rowcount() > 0;
    }

    // Fonction permettant de récupérer la note moyenne de l'utilisateur
    public static function getUserAverage($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT AVG(rate) AS average FROM reviews WHERE driver_id = ? AND validate = 1');
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    // Fonction permettant de récupérer les avis reçus par l'utilisateur
    public static function getUserReviewsReceived($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT commentary, rate FROM reviews WHERE driver_id = ? AND validate = 1');
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de récupérer les avis émis par l'utilisateur
    public static function getUserReviewsLeft($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM reviews WHERE user_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
