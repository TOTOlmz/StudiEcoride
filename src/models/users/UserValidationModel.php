<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
Modèle permettant de gérer les confirmations de covoiturage
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models\users;


use App\Models\BaseModel;

class UserValidationModel extends BaseModel {

    // Fonction permettant de modifier la confirmation et la satisfaction d'un covoitureur
    public static function confirmationUpdate($userId, $carpoolId) {
        if (empty($userId) || empty($carpoolId)) {
            throw new \InvalidArgumentException('identifiant de l\'utilisateur ou du covoiturage manquant');
        }
        $sql = 'UPDATE participations SET is_confirmed = 1 WHERE user_id = ? AND carpool_id = ?';
        return self::executeQuery($sql, [$userId, $carpoolId])->rowCount();
    }

    // Fonction permettant de modifier la confirmation et la satisfaction d'un covoitureur
    public static function satisfactionUpdate($userId, $carpoolId) {
        if (empty($userId) || empty($carpoolId)) {
            throw new \InvalidArgumentException('identifiant de l\'utilisateur ou du covoiturage manquant');
        }
        $sql = 'UPDATE participations SET is_satisfied= 1 WHERE user_id = ? AND carpool_id = ?';
        return self::executeQuery($sql, [$userId, $carpoolId])->rowCount();
    }

    // Fonction permettant de récupérer les crédits d'un covoitureur
    public static function getPendingCredits($userId, $carpoolId) {
        if (empty($userId) || empty($carpoolId)) {
            throw new \InvalidArgumentException('identifiant de l\'utilisateur ou du covoiturage manquant');
        }
        $sql = 'SELECT pending_credits FROM participations WHERE user_id = ? AND carpool_id = ? AND is_passenger = 1';
        return self::fetchOne($sql, [$userId, $carpoolId]);
    }

    // Fonction permettant de vider les crédits en attente
    public static function deletePendingCredits($userId, $carpoolId, $pendingCredits) {
        if (empty($userId) || empty($carpoolId) || empty($pendingCredits)) {
            throw new \InvalidArgumentException('identifiant de l\'utilisateur, du covoiturage ou des crédits en attente manquant');
        }
        $sql = 'UPDATE participations SET pending_credits = pending_credits - ? WHERE user_id = ? AND carpool_id = ? AND is_passenger = 1';
        return self::executeQuery($sql, [$pendingCredits, $userId, $carpoolId])->rowCount();
    }

    // Fonction permettant de récupérer l'état de la commission
    public static function returnCarpoolCommission($carpoolId) {
        if (empty($carpoolId)) {
            throw new \InvalidArgumentException('identifiant du covoiturage manquant');
        }
        $sql = 'SELECT commission FROM carpools WHERE id = ?';
        return self::fetchOne($sql, [$carpoolId]);
    }

    // Fonction permettant de mettre à jour l'état de la commission
    public static function updateCarpoolCommission($carpoolId) {
        if (empty($carpoolId)) {
            throw new \InvalidArgumentException('identifiant du covoiturage manquant');
        }
        $sql = 'UPDATE carpools SET commission = 1 WHERE id = ?';
        return self::executeQuery($sql, [$carpoolId])->rowCount();
    }

    // Fonction permettant d'ajuster les crédits d'un utilisateur
    public static function adjustCredits($userId, $credits) {
        if (empty($userId) || empty($credits)) {
            throw new \InvalidArgumentException('identifiant de l\'utilisateur ou des crédits manquant');
        }
        $sql = 'UPDATE users SET credits = credits + ? WHERE id = ?';
        return self::executeQuery($sql, [$credits, $userId])->rowCount();
    }

    // Fonction permettant de vérifier si tous les passagers sont satisfaits
    public static function everyoneSatisfied($carpoolId) {
        if (empty($carpoolId)) {
            throw new \InvalidArgumentException('identifiant du covoiturage manquant');
        }
        $sql = 'SELECT COUNT(*) FROM participations WHERE carpool_id = ? AND is_passenger = 1 AND is_satisfied = 0';
        return self::fetchOne($sql, [$carpoolId]);
    }

}