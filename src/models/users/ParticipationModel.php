<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de gérer les participations 
    d'un utilisateur à un covoiturage
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models\users;

use App\Models\BaseModel;

class ParticipationModel extends BaseModel {


    // Fonction permettant d'ajouter le conducteur à un covoiturage
    public static function addDriver($userId, $carpoolId) {
        if (empty($userId) || empty($carpoolId)) {
            throw new \InvalidArgumentException('Identifiant utilisateur ou de covoiturage manquant.');
        }
        $sql ='
            INSERT INTO `participations` (`user_id`, `carpool_id`, `is_passenger`, `is_confirmed`, `is_satisfied`, `pending_credits`)
            VALUES (?, ?, 0, 0, 0, 0) ';
        self::executeQuery($sql, [$userId, $carpoolId]);
        return self::lastInsert($sql, [$userId, $carpoolId]);
    }

    // Fonction permettant d'ajouter un participant au covoiturage
    public static function addPassenger($userId, $carpoolId, $pendingCredits) {
        if (empty($userId) || empty($carpoolId)) {
            throw new \InvalidArgumentException('Identifiant utilisateur ou de covoiturage manquant.');
        }
        $sql ='
            INSERT INTO `participations` (`user_id`, `carpool_id`, `is_passenger`, `is_confirmed`, `is_satisfied`, `pending_credits`)
            VALUES (?, ?, 1, 0, 0, ?) ';
        self::executeQuery($sql, [$userId, $carpoolId, $pendingCredits]);
        return self::lastInsert($sql, [$userId, $carpoolId, $pendingCredits]);
    }

    // Fonction permettant de lister les passagers d'un covoiturage
    public static function listPassengers($carpoolId) {
        if (empty($carpoolId)) {
            throw new \InvalidArgumentException('Identifiant de covoiturage manquant.');
        }
        $sql = 'SELECT * FROM `participations` WHERE `carpool_id` = ? AND `is_passenger` = 1';
        return self::fetchAll($sql, [$carpoolId]);
    }


    // Fonction permettant de retourner les covoiturages en tant que conducteur ou passager
    public static function leaveCarpool($userId, $carpoolId) {
        if (empty($userId) || empty($carpoolId)) {
            throw new \InvalidArgumentException('Identifiant utilisateur ou de covoiturage manquant.');
        }
        $sql = 'DELETE FROM `participations` WHERE `user_id` = ? AND `carpool_id` = ? LIMIT 1';
        self::executeQuery($sql, [$userId, $carpoolId]);
        return self::fetchAll($sql, [$userId, $carpoolId]);
    }

    // Fonction permettant de supprimer un covoiturage
    public static function deleteCarpool($driverId) {
        if (empty($driverId)) {
            throw new \InvalidArgumentException('Identifiant de conducteur manquant.');
        }
        $sql = 'SELECT count(*) FROM `participations` WHERE `driver_id` = ?';
        $number = self::count($sql, [$driverId]);
        $sql = 'DELETE FROM `participations` WHERE `driver_id` = ?';
        self::executeQuery($sql, [$driverId]);
        return $number;
    }



}