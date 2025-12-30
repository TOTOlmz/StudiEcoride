<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle gérant la partie entreprise (Staff)
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models\staff;

use App\Models\BaseModel;

class StaffModel extends BaseModel {

    // Fonction permettant de susprendre un compte
    public static function suspendAccount(int $userId): bool {
        if ($userId <= 0) {
            throw new \Exception('Invalid user ID provided.');
        }
        $sql = 'UPDATE users SET is_suspended = 1 WHERE id = ?';
        $stmt = self::executeQuery($sql, [$userId]);
        return $stmt->rowCount() > 0;
    }

    // Fonction permettant de réactiver un compte
    public static function reactivateAccount(int $userId): bool {
        if ($userId <= 0) {
            throw new \Exception('Invalid user ID provided.');
        }
        $sql = 'UPDATE users SET is_suspended = 0 WHERE id = ?';
        $stmt = self::executeQuery($sql, [$userId]);
        return $stmt->rowCount() > 0;
    }

    // Fonction permettant de récupérer le nombre de covoiturages par jour
    public static function getCarpoolCountPerDay(): array {
        $sql = "
            SELECT date, COUNT(*) AS total
            FROM carpools
            GROUP BY date
            ORDER BY date ASC
        ";
        return self::fetchAll($sql);
    }

    // Fonction permettant de récupérer le nombre de covoiturages avec commission complète
    public static function getFullCommission(): int {
        $sql = 'SELECT COUNT(*) FROM carpools WHERE commission = 1';
        return self::count($sql);
    }

    // Fonction permettant de récupérer les crédits générés par jour
    public static function getCreditsPerDay(): array {
        $sql = "
            SELECT date, SUM(commission) AS total_credits
            FROM carpools
            GROUP BY date
            ORDER BY date ASC
        ";
        return self::fetchAll($sql);
    }

    // Fonction permettant de valider un avis utilisateur
    public static function validateReview(int $reviewId): bool {
        if ($reviewId <= 0) {
            throw new \Exception('Invalid review ID provided.');
        }
        $sql = 'UPDATE reviews SET validate = 1 AND consulted = 1 WHERE id = ?';
        $stmt = self::executeQuery($sql, [$reviewId]);
        return $stmt->rowCount() > 0;
    }

    // Fonction permettant de refuser un avis utilisateur
    public static function deleteReview(int $reviewId): bool {
        if ($reviewId <= 0) {
            throw new \Exception('Invalid review ID provided.');
        }
        $sql = 'UPDATE reviews SET validate = 0 AND consulted = 1 WHERE id = ?';
        $stmt = self::executeQuery($sql, [$reviewId]);
        return $stmt->rowCount() > 0;
    }

    // Fonction permettant de récupérer les avis en attente de validation
    public static function getPendingReviews(): array {
        $sql = '
            SELECT r.id, r.commentary, r.rate, r.carpool_id, 
                    u.id AS user_id, u.email, u.pseudo
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.consulted = 0
            ORDER BY r.created_at DESC
        ';
        return self::fetchAll($sql);
    }
}