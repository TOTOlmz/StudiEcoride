<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de récupérer les covoiturages,
    les véhicules et les avis liés à l'utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */


require_once __DIR__ . '/../../database/dbConnection.php';

class UserSpaceModel {
    
    // Fonction permettant de récupérer la ligne correspondant à un ID dans une table donnée
    public static function getUserData($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de récupérer les covoiturages de l'utilisateur
    public static function getUserCarpools($id) {
        global $pdo;
        $stmt = $pdo->prepare('
        SELECT p.is_passenger AS user_is_passenger, 
            c.date, c.departure_time, c.departure_city, c.arrival_time, c.arrival_city,
            c.duration, c.is_ecological, 
            u.pseudo AS driver_pseudo, u.photo AS driver_photo, 
            AVG(r.rate) AS driver_average
        FROM participations p 
            JOIN carpools c ON p.carpool_id = c.id
            JOIN users u ON c.driver_id = u.id
            JOIN reviews r ON r.driver_id = u.id
        WHERE p.user_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de récupérer les véhicules de l'utilisateur
    public static function getUserCars($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM cars WHERE driver_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de récupérer la note moyenne de l'utilisateur
    public static function getUserAverage($id) {
        global $pdo;
        $stmt = $pdo->prepare('
        SELECT AVG(rate) AS average, COUNT(*) AS nbReviews
        FROM reviews WHERE driver_id = ? AND validate = 1');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de récupérer les avis reçus par l'utilisateur
    public static function getUserReviewsReceived($id) {
        global $pdo;
        $stmt = $pdo->prepare('
        SELECT commentary, rate 
        FROM reviews WHERE driver_id = ? AND validate = 1');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de récupérer les avis émis par l'utilisateur
    public static function getUserReviewsLeft($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM reviews WHERE user_id = ? AND validate = 1');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de savoir si l'utilisateur a laissé un avis  
    public static function userHasLeftReview($userId, $carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM reviews WHERE user_id = ? AND carpool_id = ?');
        $stmt->execute([$userId, $carpoolId]);
        return $stmt->fetchColumn() > 0;
    }

    // Fonction permettant de mettre à jour la photo de profil de l'utilisateur
    public static function updatePhoto($fileName, $userId) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE users SET photo = ? WHERE id = ?');
        $stmt->execute([$fileName, $userId]);
        return $stmt->rowcount() > 0;
    }

    
}
