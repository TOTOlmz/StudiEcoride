<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de récupérer les covoiturages,
    les véhicules et les avis liés à l'utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */


require_once __DIR__ . '/../../database/dbConnection.php';

class ReviewsModel {

    // Fonction permettant de récupérer la note moyenne de l'utilisateur
    public static function getUserAverage($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT AVG(rate) FROM reviews WHERE driver_id = ? AND validate = 1');
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    // Fonction permettant de récupérer les avis reçus par l'utilisateur
    public static function getUserReviewsReceived($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT r.commentary, r.rate, r.validate, r.carpool_id, u.photo AS user_photo, u.pseudo AS user_pseudo 
        FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.driver_id = ? AND r.validate = 1');
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de récupérer les avis émis par l'utilisateur
    public static function getUserReviewsLeft($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT r.commentary, r.rate, r.validate, r.carpool_id, u.photo AS user_photo, u.pseudo AS user_pseudo 
        FROM reviews r JOIN users u ON r.driver_id = u.id WHERE r.user_id = ? ');
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de savoir si l'utilisateur a laissé un avis  
    public static function userHasLeftReview($userId, $carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM reviews WHERE user_id = ? AND carpool_id = ?');
        $stmt->execute([$userId, $carpoolId]);
        return $stmt->fetchColumn() > 0;
    }

    // Fonction permettant d'ajouter un avis
    public static function addReview($userId, $carpoolId, $driverId, $rate, $commentary) {
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO reviews (rate, commentary, validate, user_id, driver_id, carpool_id) 
        VALUES (?, ?, 0, ?, ?, ?)');
        $stmt->execute([$rate, $commentary, $userId, $driverId, $carpoolId]);
        return $stmt->rowCount() > 0;
    }  

    // Fonction permettant de valider un avis
    public static function validateReview($reviewId) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE reviews SET validate = 1 WHERE id = ?');
        $stmt->execute([$reviewId]);
        return $stmt->rowCount() > 0;
    }  

    // Fonction permettant de supprimer un avis
    public static function deleteReview($reviewId) {
        global $pdo;
        $stmt = $pdo->prepare('DELETE FROM reviews WHERE id = ?');
        $stmt->execute([$reviewId]);
        return $stmt->rowCount() > 0;
    }  

    // Fonction permettant de récupérer les avis en attente de validation
    public static function getPendingReviews() {
        global $pdo;
        $stmt = $pdo->prepare('SELECT r.id, r.commentary, r.rate, r.carpool_id, u.id AS user_id, u.email, u.pseudo
        FROM reviews r JOIN users u ON r.user_id = u.id WHERE  r.validate = 0');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }  


}
