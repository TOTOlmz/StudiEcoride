<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de récupérer les covoiturages,
    les véhicules et les avis liés à l'utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models\users;

use App\Models\BaseModel;

class UserSpaceModel extends BaseModel {


    // Fonction permettant de récupérer la ligne correspondant à un ID dans une table donnée
    public static function getUserById($id) {
        if ($id <= 0) {
            throw new \Exception('Invalid user ID provided.');
        }
        $sql = 'SELECT * FROM users WHERE id = ?';
        return self::fetchOne($sql, [$id]);
    }

    // Fonction permettant de récupérer les covoiturages de l'utilisateur
    public static function getUserCarpools($id) {
        if ($id <= 0) {
            throw new \Exception('Invalid user ID provided.');
        }

        $sql = '
        SELECT p.is_passenger AS user_is_passenger, 
            c.id AS carpool_id,
            c.date, c.departure_time, c.departure_city, c.arrival_time, c.arrival_city,
            c.duration, c.is_ecological, 
            u.pseudo AS driver_pseudo, u.photo AS driver_photo, 
            AVG(r.rate) AS driver_average
        FROM participations p 
            JOIN carpools c ON p.carpool_id = c.id
            JOIN users u ON c.driver_id = u.id
            LEFT JOIN reviews r ON r.driver_id = u.id
        WHERE p.user_id = ?
        GROUP BY c.id
        ORDER BY c.date DESC';
        
        return self::fetchAll($sql, [$id]);
    }

    // Fonction permettant de récupérer les véhicules de l'utilisateur
    public static function getUserCars(int $id): array {
        if ($id <= 0) {
            throw new \Exception('Invalid user ID provided.');
        }

        $sql = 'SELECT * FROM cars WHERE driver_id = ? ORDER BY brand ASC';
        return self::fetchAll($sql, [$id]);
    }

    // Fonction permettant de récupérer la note moyenne de l'utilisateur
    public static function getUserAverage(int $id): ?array {
        if ($id <= 0) {
            throw new \Exception('Invalid user ID provided.');
        }

        $sql = '
        SELECT AVG(rate) AS average, COUNT(*) AS nbReviews
        FROM reviews 
        WHERE driver_id = ? AND validate = 1';
        
        return self::fetchOne($sql, [$id]);
    }

    // Fonction permettant de récupérer les avis reçus par l'utilisateur
    public static function getUserReviewsReceived($id) {
        if ($id <= 0) {
            throw new \Exception('Invalid user ID provided.');
        }

        $sql = '
        SELECT commentary, rate 
        FROM reviews WHERE driver_id = ? AND validate = 1';

        return self::fetchAll($sql, [$id]);
    }

    // Fonction permettant de récupérer les avis émis par l'utilisateur
    public static function getUserReviewsLeft($id) {
        if ($id <= 0) {
            throw new \Exception('Invalid user ID provided.');
        }

        $sql = '
        SELECT * FROM reviews 
        WHERE user_id = ? AND validate = 1
        ORDER BY created_at DESC';
        
        return self::fetchAll($sql, [$id]);
    }

    // Fonction permettant de savoir si l'utilisateur a laissé un avis  
    public static function userHasLeftReview(int $userId, int $carpoolId): bool {
        if ($userId <= 0 || $carpoolId <= 0) {
            throw new \Exception('Invalid user or carpool ID provided.');
        }

        $sql = 'SELECT COUNT(*) FROM reviews WHERE user_id = ? AND carpool_id = ?';
        return self::count($sql, [$userId, $carpoolId]) > 0;
    }

    // Fonction permettant de mettre à jour la photo de profil de l'utilisateur
    public static function updatePhoto(string $fileName, int $userId): bool {
        if ($userId <= 0 || empty($fileName)) {
            throw new \Exception('Invalid user ID or file name.');
        }

        $sql = 'UPDATE users SET photo = ? WHERE id = ?';
        $stmt = self::executeQuery($sql, [$fileName, $userId]);
        return $stmt->rowCount() > 0;
    }

    
}
