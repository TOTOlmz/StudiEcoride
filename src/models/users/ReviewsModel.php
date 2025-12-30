<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de gérer les avis des utilisateurs
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models\users;

use App\Models\BaseModel;

class ReviewsModel extends BaseModel {

    // Fonction permettant de récupérer la note moyenne d'un utilisateur
    public static function getUserAverage(int $driverId): ?float {
        if ($driverId <= 0) {
            throw new \Exception('Invalid driver ID provided.');
        }

        $sql = 'SELECT AVG(rate) FROM reviews WHERE driver_id = ? AND validate = 1';
        $result = self::count($sql, [$driverId]);
        return $result ? (float) $result : null;
    }

    // Fonction permettant de récupérer les avis reçus par un utilisateur
    public static function getUserReviewsReceived(int $driverId): array {
        if ($driverId <= 0) {
            throw new \Exception('Invalid driver ID provided.');
        }

        $sql = '
            SELECT r.id, r.commentary, r.rate, r.validate, r.carpool_id, r.created_at,
                    u.photo AS user_photo, u.pseudo AS user_pseudo 
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.driver_id = ? AND r.validate = 1
            ORDER BY r.created_at DESC
        ';
        
        return self::fetchAll($sql, [$driverId]);
    }

    // Fonction permettant de récupérer les avis émis par un utilisateur
    public static function getUserReviewsLeft(int $userId): array {
        if ($userId <= 0) {
            throw new \Exception('Invalid user ID provided.');
        }

        $sql = '
            SELECT r.id, r.commentary, r.rate, r.validate, r.carpool_id, r.created_at,
                   u.photo AS user_photo, u.pseudo AS user_pseudo 
            FROM reviews r 
            JOIN users u ON r.driver_id = u.id 
            WHERE r.user_id = ? 
            ORDER BY r.created_at DESC
        ';
        
        return self::fetchAll($sql, [$userId]);
    }

    // Fonction permettant de vérifier si un utilisateur a déjà laissé un avis pour un covoiturage donné
    public static function userHasLeftReview(int $userId, int $carpoolId): bool {
        if ($userId <= 0 || $carpoolId <= 0) {
            throw new \Exception('Invalid user ID or carpool ID provided.');
        }

        $sql = 'SELECT COUNT(*) FROM reviews WHERE user_id = ? AND carpool_id = ?';
        return self::count($sql, [$userId, $carpoolId]) > 0;
    }

    // Fonction permettant d'ajouter un nouvel avis
    public static function addReview(int $userId, int $carpoolId, int $driverId, int $rate, string $commentary): bool {
        if ($userId <= 0 || $carpoolId <= 0 || $driverId <= 0 || $rate < 0 || $rate > 5) {
            throw new \Exception('Invalid parameters for review.');
        }

        $sql = '
            INSERT INTO reviews (rate, commentary, validate, user_id, driver_id, carpool_id, created_at) 
            VALUES (?, ?, 0, ?, ?, ?, NOW())
        ';
        
        $stmt = self::executeQuery($sql, [$rate, $commentary, $userId, $driverId, $carpoolId]);
        return $stmt->rowCount() > 0;
    }

    // Fonction permettant de valider un avis
    public static function validateReview(int $reviewId): bool {
        if ($reviewId <= 0) {
            throw new \Exception('Invalid review ID provided.');
        }

        $sql = 'UPDATE reviews SET validate = 1 AND consulted = 1 WHERE id = ?';
        $stmt = self::executeQuery($sql, [$reviewId]);
        return $stmt->rowCount() > 0;
    }

    // Fonction permettant de rejeter un avis
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
            SELECT r.id, r.commentary, r.rate, r.carpool_id, r.created_at,
                   u.id AS user_id, u.email, u.pseudo
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.validate = 0
            ORDER BY r.created_at ASC
        ';
        
        return self::fetchAll($sql);
    }
}

