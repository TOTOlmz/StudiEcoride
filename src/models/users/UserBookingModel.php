<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
 Modèle permettant de gérer réservations
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models\users;

use App\Models\BaseModel;

class UserBookingModel extends BaseModel {

    // Fonction permettant d'ajuster les crédits d'un utilisateur
    public static function adjustCredits($userId, $credits) {
        if (intval($userId) <= 0) {
            throw new \Exception('Identifiant utilisateur invalide.');
        }
        $sql = 'UPDATE users SET credits = credits + ? WHERE id = ?';
        return self::executeQuery($sql, [$credits, $userId])->rowCount() > 0;
    }

    // Fonction permettant de mettre à jour le nombre de sièges
    public static function updateCarpoolSeats($carpoolId, $seats) {
        if (intval($carpoolId) <= 0) {
            throw new \Exception('Identifiant de covoiturage invalide.');
        }
        if (intval($seats) <= 0) {
            throw new \Exception('Nombre de sièges invalide.');
        }
        $sql = 'UPDATE carpools SET available_seats = available_seats + ? WHERE id = ?';
        return self::executeQuery($sql, [$seats, $carpoolId])->rowCount();
    }

    // Fonction permettant d'ajouter un participant au covoiturage
    public static function addPassenger($userId, $carpoolId, $pendingCredits) {
        if (intval($userId) <= 0 || intval($carpoolId) <= 0) {
            throw new \Exception('Identifiant utilisateur ou de covoiturage invalide.');
        }
        $sql = 'INSERT INTO participations (user_id, carpool_id, is_passenger, is_confirmed, is_satisfied, pending_credits)
                VALUES (?, ?, 1, 0, 0, ?)';
        return self::executeQuery($sql, [$userId, $carpoolId, $pendingCredits])->rowCount();
    }
}
