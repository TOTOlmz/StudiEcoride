<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
Modèle permettant de gérer les confirmations de covoiturage
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */


require_once __DIR__ . '/../../database/dbConnection.php';

class UserValidationModel {

    // Fonction permettant de modifier la confirmation et la satisfaction d'un covoitureur
    public static function confirmationUpdate($userId, $carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE participations SET is_confirmed = 1 WHERE user_id = ? AND carpool_id = ?');
        $stmt->execute([$userId, $carpoolId]);
        return $stmt->rowCount();
    }

    // Fonction permettant de modifier la confirmation et la satisfaction d'un covoitureur
    public static function satisfactionUpdate($userId, $carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE participations SET is_satisfied= 1 WHERE user_id = ? AND carpool_id = ?');
        $stmt->execute([$userId, $carpoolId]);
        return $stmt->rowCount();
    }

    // Fonction permettant de récupérer les crédits d'un covoitureur
    public static function getPendingCredits($userId, $carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT pending_credits FROM participations WHERE user_id = ? AND carpool_id = ? AND is_passenger = 1');
        $stmt->execute([$userId, $carpoolId]);
        return $stmt->fetchColumn();
    }

    // Fonction permettant de vider les crédits en attente
    public static function deletePendingCredits($userId, $carpoolId, $pendingCredits) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE participations SET pending_credits = pending_credits - ? WHERE user_id = ? AND carpool_id = ? AND is_passenger = 1');
        $stmt->execute([$pendingCredits, $userId, $carpoolId]);
        return $stmt->rowCount();
    }

    // Fonction permettant de récupérer l'état de la commission
    public static function returnCarpoolCommission($carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT commission FROM carpools WHERE id = ?');
        $stmt->execute([$carpoolId]);
        return $stmt->fetchColumn(); 
    }

    // Fonction permettant de mettre à jour l'état de la commission
    public static function updateCarpoolCommission($carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE carpools SET commission = 1 WHERE id = ?');
        $stmt->execute([$carpoolId]);
        return $stmt->fetchColumn(); 
    }

    
    // Fonction permettant d'ajuster les crédits d'un utilisateur
    public static function adjustCredits($userId, $credits) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE users SET credits = credits + ? WHERE id = ?');
        $stmt->execute([$credits, $userId]);
        return $stmt->rowcount() > 0;
    }

    // Fonction permettant d'ajuster les crédits d'un utilisateur
    public static function everyoneSatisfied($carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM participations WHERE carpool_id = ? AND is_passenger = 1 AND is_satisfied = 0');
        $stmt->execute([$carpoolId]);
        return $stmt->fetchColumn();
    }

}