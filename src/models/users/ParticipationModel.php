<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
 Modèle permettant de gérer les participations 
 d'un l'utilisateur à un covoiturage
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */


require_once __DIR__ . '/../../database/dbConnection.php';

class ParticipationModel {


    // Fonction permettant d'ajouter le conducteur à un covoiturage
    public static function addDriver($userId, $carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('
            INSERT INTO `participations` (`user_id`, `carpool_id`, `is_passenger`, `is_confirmed`, `is_satisfied`, `pending_credits`)
            VALUES (?, ?, 0, 0, 0, 0) ');
        $stmt->execute([$userId, $carpoolId]);
        return $pdo->lastInsertId();
    }

    // Fonction permettant d'ajouter un participant au covoiturage
    public static function addPassenger($userId, $carpoolId, $pendingCredits) {
        global $pdo;
        $stmt = $pdo->prepare('
            INSERT INTO `participations` (`user_id`, `carpool_id`, `is_passenger`, `is_confirmed`, `is_satisfied`, `pending_credits`)
            VALUES (?, ?, 1, 0, 0, ?) ');
        $stmt->execute([$userId, $carpoolId, $pendingCredits]);
        return $pdo->lastInsertId();
    }

    // Fonction permettant de lister les passagers d'un covoiturage
    public static function listPassengers($carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM `participations` WHERE `carpool_id` = ? AND `is_passenger` = 1');
        $stmt->execute([$carpoolId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Fonction permettant de retourner les covoiturages en tant que conducteur ou passager
    public static function leaveCarpool($userId, $carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('DELETE FROM `participations` WHERE `user_id` = ? LIMIT 1');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de supprimer un covoiturage
    public static function deleteCarpool($driverId) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT count(*) FROM `participations` WHERE `driver_id` = ?');
        $stmt->execute([$driverId]);
        $number = $stmt->fetchColumn();
        $stmt = $pdo->prepare('DELETE FROM `participations` WHERE `driver_id` = ?');
        $stmt->execute([$driverId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}