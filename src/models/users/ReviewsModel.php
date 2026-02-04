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
            throw new \Exception('Identifiant de conducteur incorrect.');
        }

        $sql = 'SELECT AVG(rate) FROM reviews WHERE driver_id = ? AND validate = 1';
        $result = self::count($sql, [$driverId]);
        return $result ? (float) $result : null;
    }

    // Fonction permettant de récupérer les avis reçus par un utilisateur
    public static function getUserReviewsReceived(int $driverId): array {
        if ($driverId <= 0) {
            throw new \Exception('Identifiant de conducteur incorrect.');
        }

        $sql = '
            SELECT r.id, r.commentary, r.rate, r.validate, r.carpool_id,
                    u.photo AS user_photo, u.pseudo AS user_pseudo 
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.driver_id = ? AND r.validate = 1
            ORDER BY r.id ASC
        ';
        
        return self::fetchAll($sql, [$driverId]);
    }

    // Fonction permettant de récupérer les avis émis par un utilisateur
    public static function getUserReviewsLeft(int $userId): array {
        if ($userId <= 0) {
            throw new \Exception('Identifiant d\'utilisateur incorrect.');
        }

        $sql = '
            SELECT r.id, r.commentary, r.rate, r.consulted, r.validate, r.carpool_id,
            u.photo AS user_photo, u.pseudo AS user_pseudo 
            FROM reviews r 
            JOIN users u ON r.driver_id = u.id 
            WHERE r.user_id = ? 
            ORDER BY r.id ASC
        ';
        
        return self::fetchAll($sql, [$userId]);
    }

    // Fonction permettant de vérifier si un utilisateur a déjà laissé un avis pour un covoiturage donné
    public static function userHasLeftReview(int $userId, int $carpoolId): bool {
        if ($userId <= 0 || $carpoolId <= 0) {
            throw new \Exception('Identifiant utilisateur ou carpool incorrect.');
        }

        $sql = 'SELECT COUNT(*) FROM reviews WHERE user_id = ? AND carpool_id = ?';
        return self::count($sql, [$userId, $carpoolId]) > 0;
    }

    // Fonction permettant d'ajouter un nouvel avis
    public static function addReview(int $userId, int $carpoolId, int $driverId, int $rate, string $commentary): bool {
        if ($userId <= 0 || $carpoolId <= 0 || $driverId <= 0 || $rate < 0 || $rate > 5) {
            throw new \Exception('Paramètres invalides pour l\'avis.');
        }

        $sql = '
            INSERT INTO reviews (rate, commentary, validate, consulted, user_id, driver_id, carpool_id) 
            VALUES (?, ?, 0, 0, ?, ?, ?)
        ';
        
        $stmt = self::executeQuery($sql, [$rate, $commentary, $userId, $driverId, $carpoolId]);
        return $stmt->rowCount() > 0;
    }

    // Fonction permettant de valider un avis
    public static function validateReview(int $reviewId): bool {
        if ($reviewId <= 0) {
            throw new \Exception('Identifiant d\'avis incorrect.');
        }

        $sql = 'UPDATE reviews SET consulted = 1, validate = 1 WHERE id = ?';
        $stmt = self::executeQuery($sql, [$reviewId]);
        return $stmt->rowCount() > 0;
    }

    // Fonction permettant de rejeter un avis
    public static function rejectReview(int $reviewId): bool {
        if ($reviewId <= 0) {
            throw new \Exception('Identifiant d\'avis incorrect.');
        }

        $sql = 'UPDATE reviews SET consulted = 1, validate = 0 WHERE id = ?';
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
            WHERE r.validate = 0
            ORDER BY r.id ASC
        ';
        
        return self::fetchAll($sql);
    }
}

