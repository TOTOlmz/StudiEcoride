<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
Modèle gérant la partie entreprise
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */


require_once __DIR__ . '/../../database/dbConnection.php';

class StaffModel {

    // Fonction permettant de suspendre un compte
    public static function suspendAccount($userId) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE users SET is_suspended = 1 WHERE id = ?');
        $stmt->execute([$userId]);
        return $stmt->rowCount() > 0;
    }

    // Fonction permettant de réactiver un compte
    public static function reactivateAccount($userId) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE users SET is_suspended = 0 WHERE id = ?');
        $stmt->execute([$userId]);
        return $stmt->rowCount() > 0;
    }


    // Fonction permettant de récupérer le nombre de covoiturages par jour
    public static function getCarpoolCountPerDay() {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT date, COUNT(*) AS total
            FROM carpools
            GROUP BY date
            ORDER BY date ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de récupérer les covoiturages sur une journée
    public static function getFullCommission() {
        global $pdo;
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM carpools WHERE commission = 1');
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Fonction permettant de récupérer les covoiturages sur une journée
    public static function getCreditsPerDay() {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT date, SUM(commission) AS total_credits
            FROM carpools
            GROUP BY date
            ORDER BY date ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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