<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
 Modèle permettant de gérer les covoiturages d'un l'utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */


require_once __DIR__ . '/../../database/dbConnection.php';

class UserCarpoolsModel {

    // Fonction permettant de récupérer les covoiturages de l'utilisateur
    public static function getCarpoolsByUserId($userId) {
        global $pdo;
        $stmt = $pdo->prepare('
        SELECT p.is_passenger AS user_is_passenger, p.is_confirmed AS user_confirmed, 
            c.id, c.date, c.departure_time, c.departure_city, c.arrival_time, c.arrival_city,
            c.duration, c.status, c.seats, c.available_seats, c.price, c.driver_id, c.is_ecological, c.smoke, c.animals, c.preferences,
            u.pseudo AS driver_pseudo, u.photo AS driver_photo, 
            COALESCE(ROUND(AVG(r.rate),2), 0) AS driver_average
        FROM participations p 
            JOIN carpools c ON p.carpool_id = c.id
            JOIN users u ON c.driver_id = u.id
            LEFT JOIN reviews r ON r.driver_id = u.id
        WHERE p.user_id = ? 
        GROUP BY c.id, p.is_passenger, p.is_confirmed, c.date, 
        c.departure_time, c.departure_city, c.arrival_time, c.arrival_city, c.duration, 
        c.status, c.seats, c.available_seats, c.price, c.driver_id, c.is_ecological, c.smoke, c.animals, c.preferences, u.pseudo, u.photo
        ');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Fonction permettant de mettre à jour le statut du covoiturage
    public static function updateCarpoolStatus($carpoolId, $carpoolStatus) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE carpools SET status = ? WHERE id = ? ');
        $stmt->execute([$carpoolStatus, $carpoolId]);
        return $stmt->rowCount();
    }


    // Fonction permettant de lister les passagers d'un covoiturage
    public static function getPassengers($carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM participations WHERE carpool_id = ? AND is_passenger = 1');
        $stmt->execute([$carpoolId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de récupérer un passager
    public static function getPassenger($userId, $carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM participations WHERE carpool_id = ? AND user_id = ?');
        $stmt->execute([$carpoolId, $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de supprimer un passager
    public static function leaveCarpool($userId, $carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('DELETE FROM participations WHERE user_id = ? AND carpool_id = ? LIMIT 1');
        $stmt->execute([$userId, $carpoolId]);
        return $stmt->rowCount();
    }

    // Fonction permettant de supprimer un covoiturage
    public static function deleteCarpool($carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('DELETE FROM carpools WHERE id = ?');
        $stmt->execute([$carpoolId]);
        return $stmt->rowCount();
    }

    // Fonction permettant d'ajuster les crédits d'un utilisateur
    public static function adjustPassengerCredits($passengerId, $credits) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE users SET credits = credits + ? WHERE id = ?');
        $stmt->execute([$credits, $passengerId]);
        return $stmt->rowcount() > 0;
    }

    // Fonction permettant de récupéer le mail d'un utilisateur
    public static function getPassengerEmail($passengerId) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT email FROM users WHERE id = ?');
        $stmt->execute([$passengerId]);
        return $stmt->fetchColumn();
    }

    // Fonction permettant de mettre à jour le nombre de sièges
    public static function updateCarpoolSeats($carpoolId, $seats) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE carpools SET available_seats = available_seats + ? WHERE id = ?');
        $stmt->execute([$seats, $carpoolId]);
        return $stmt->rowCount(); 
    }

}