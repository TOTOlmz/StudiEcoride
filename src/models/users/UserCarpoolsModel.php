<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
Modèle permettant de gérer les covoiturages d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models\users;

use App\Models\BaseModel;

class UserCarpoolsModel extends BaseModel {

    // Fonction permettant de récupérer les covoiturages d'un utilisateur
    public static function getCarpoolsByUserId($userId) {
        if (empty($userId)) {
            throw new \InvalidArgumentException('identifiant de l\'utilisateur manquant');
        }
        $sql = 'SELECT p.is_passenger AS user_is_passenger, p.is_confirmed AS user_confirmed, 
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
                ';
        return self::fetchAll($sql, [$userId]);
    }


    // Fonction permettant de mettre à jour le statut du covoiturage
    public static function updateCarpoolStatus($carpoolId, $carpoolStatus) {
        if (empty($carpoolId) || empty($carpoolStatus)) {
            throw new \InvalidArgumentException('identifiant du covoiturage ou statut manquant');
        }
        $sql = 'UPDATE carpools SET status = ? WHERE id = ? ';
        return self::executeQuery($sql, [$carpoolStatus, $carpoolId])->rowCount();
    }


    // Fonction permettant de lister les passagers d'un covoiturage
    public static function getPassengers($carpoolId) {
        if (empty($carpoolId)) {
            throw new \InvalidArgumentException('identifiant du covoiturage manquant');
        }
        $sql = 'SELECT * FROM participations WHERE carpool_id = ? AND is_passenger = 1';
        return self::fetchAll($sql, [$carpoolId]);
    }

    // Fonction permettant de récupérer un passager
    public static function getPassenger($userId, $carpoolId) {
        if (empty($userId) || empty($carpoolId)) {
            throw new \InvalidArgumentException('identifiant de l\'utilisateur ou du covoiturage manquant');
        }
        $sql = 'SELECT * FROM participations WHERE carpool_id = ? AND user_id = ?';
        return self::fetchOne($sql, [$carpoolId, $userId]);
    }

    // Fonction permettant de supprimer un passager
    public static function leaveCarpool($userId, $carpoolId) {
        if (empty($userId) || empty($carpoolId)) {
            throw new \InvalidArgumentException('identifiant de l\'utilisateur ou du covoiturage manquant');
        }
        $sql = 'DELETE FROM participations WHERE user_id = ? AND carpool_id = ? LIMIT 1';
        return self::executeQuery($sql, [$userId, $carpoolId])->rowCount();
    }

    // Fonction permettant de supprimer un covoiturage
    public static function deleteCarpool($carpoolId) {
        if (empty($carpoolId)) {
            throw new \InvalidArgumentException('identifiant du covoiturage manquant');
        }
        $sql = 'DELETE FROM carpools WHERE id = ?';
        return self::executeQuery($sql, [$carpoolId])->rowCount();
    }

    // Fonction permettant d'ajuster les crédits d'un utilisateur
    public static function adjustPassengerCredits($passengerId, $credits) {
        if (empty($passengerId) || empty($credits)) {
            throw new \InvalidArgumentException('identifiant du passager ou crédits manquants');
        }
        $sql = 'UPDATE users SET credits = credits + ? WHERE id = ?';
        return self::executeQuery($sql, [$credits, $passengerId])->rowCount() > 0;
    }

    // Fonction permettant de récupéer le mail d'un utilisateur
    public static function getPassengerEmail($passengerId) {
        if (empty($passengerId)) {
            throw new \InvalidArgumentException('identifiant du passager manquant');
        }
        $sql = 'SELECT email FROM users WHERE id = ?';
        return self::fetchOne($sql, [$passengerId]);
    }

    // Fonction permettant de mettre à jour le nombre de sièges
    public static function updateCarpoolSeats($carpoolId, $seats) {
        if (empty($carpoolId) || empty($seats)) {
            throw new \InvalidArgumentException('identifiant du covoiturage ou nombre de sièges manquant');
        }
        $sql = 'UPDATE carpools SET available_seats = available_seats + ? WHERE id = ?';
        return self::executeQuery($sql, [$seats, $carpoolId])->rowCount();
    }

}