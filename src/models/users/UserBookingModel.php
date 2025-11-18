<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
 Modèle permettant de gérer réservations
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */


require_once __DIR__ . '/../../database/dbConnection.php';

class UserBookingModel {

    // Fonction permettant d'ajuster les crédits d'un utilisateur
    public static function adjustCredits($userId, $credits) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE users SET credits = credits + ? WHERE id = ?');
        $stmt->execute([$credits, $userId]);
        return $stmt->rowcount() > 0;
    }

    // Fonction permettant de mettre à jour le nombre de sièges
    public static function updateCarpoolSeats($carpoolId, $seats) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE carpools SET available_seats = available_seats + ? WHERE id = ?');
        $stmt->execute([$seats, $carpoolId]);
        return $stmt->rowCount(); 
    }

    // Fonction permettant d'ajouter un participant au covoiturage
    public static function addPassenger($userId, $carpoolId, $pendingCredits) {
        global $pdo;
        $stmt = $pdo->prepare('
            INSERT INTO participations (user_id, carpool_id, is_passenger, is_confirmed, is_satisfied, pending_credits)
            VALUES (?, ?, 1, 0, 0, ?) ');
        $stmt->execute([$userId, $carpoolId, $pendingCredits]);
        return $pdo->lastInsertId();
    }
}
