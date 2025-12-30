<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de gérer les covoiturages d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models\users;

use App\Models\BaseModel;

class CarpoolsModel extends BaseModel {

    // Fonction permettant de récupérer les covoiturages d'un utilisateur
    public static function getUserCarpools(int $userId): array {
        if ($userId <= 0) {
            throw new \Exception('Invalid user ID provided.');
        }

        $sql = '
        SELECT p.is_passenger AS user_is_passenger, 
            c.id, c.date, c.departure_time, c.departure_city, c.arrival_time, c.arrival_city,
            c.duration, c.status, c.seats, c.available_seats, c.price, c.driver_id, c.is_ecological, c.smoke, c.animals, c.preferences,
            u.pseudo AS driver_pseudo, u.photo AS driver_photo, 
            COALESCE(ROUND(AVG(r.rate),2), 0) AS driver_average
        FROM participations p 
            JOIN carpools c ON p.carpool_id = c.id
            JOIN users u ON c.driver_id = u.id
            LEFT JOIN reviews r ON r.driver_id = u.id
        WHERE p.user_id = ? 
        GROUP BY c.id, p.is_passenger, c.date, 
        c.departure_time, c.departure_city, c.arrival_time, c.arrival_city, c.duration, 
        c.status, c.seats, c.available_seats, c.price, c.driver_id, c.is_ecological, c.smoke, c.animals, c.preferences, u.pseudo, u.photo
        ORDER BY c.date DESC
        ';
        
        return self::fetchAll($sql, [$userId]);
    }

    // Fonction permettant d'ajouter un covoiturage
    public static function addUserCarpools(
        string $date,
        string $departureTime,
        string $departureCity,
        string $departurePostalcode,
        float $departureLon,
        float $departureLat,
        string $arrivalTime,
        string $arrivalCity,
        string $arrivalPostalcode,
        float $arrivalLon,
        float $arrivalLat,
        string $duration,
        string $status,
        int $seats,
        int $availableSeats,
        float $price,
        int $driverId,
        int $carId,
        bool $isEcological,
        bool $smoke,
        bool $animals,
        string $preferences
    ) {
        if ($driverId <= 0 || $carId <= 0) {
            throw new \Exception('Invalid driver ID or car ID provided.');
        }

        $sql = '
            INSERT INTO carpools (
                date, departure_time, departure_city, departure_postalcode, departure_lat, departure_lon,
                arrival_time, arrival_city, arrival_postalcode, arrival_lat, arrival_lon, 
                duration, status, seats, available_seats, price, driver_id, car_id, 
                is_ecological, smoke, animals, preferences, commission
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)
        ';
        
        $stmt = self::executeQuery($sql, [
            $date, $departureTime, $departureCity, $departurePostalcode, $departureLat, $departureLon,
            $arrivalTime, $arrivalCity, $arrivalPostalcode, $arrivalLat, $arrivalLon, 
            $duration, $status, $seats, $availableSeats, $price, $driverId, $carId, 
            $isEcological, $smoke, $animals, $preferences
        ]);
        
        return self::getPdo()->lastInsertId() ?: false;
    }

    // Fonction permettant de mettre à jour le statut d'un covoiturage
    public static function updateCarpoolStatus(int $carpoolId, string $carpoolStatus): int {
        if ($carpoolId <= 0) {
            throw new \Exception('Invalid carpool ID provided.');
        }

        $sql = 'UPDATE carpools SET status = ? WHERE id = ?';
        $stmt = self::executeQuery($sql, [$carpoolStatus, $carpoolId]);
        return $stmt->rowCount();
    }

    // Fonction mettant à jour le nombre de sièges disponibles
    public static function updateCarpoolSeats(int $carpoolId, int $seats): int {
        if ($carpoolId <= 0) {
            throw new \Exception('Invalid carpool ID provided.');
        }

        $sql = 'UPDATE carpools SET available_seats = available_seats + ? WHERE id = ?';
        $stmt = self::executeQuery($sql, [$seats, $carpoolId]);
        return $stmt->rowCount();
    }

    // Fonction permettant de supprimer un covoiturage
    public static function deleteCarpool(int $carpoolId): int {
        if ($carpoolId <= 0) {
            throw new \Exception('Invalid carpool ID provided.');
        }

        $sql = 'DELETE FROM carpools WHERE id = ?';
        $stmt = self::executeQuery($sql, [$carpoolId]);
        return $stmt->rowCount();
    }

    // Fonction permettant de vérifier l'existence d'un covoiturage
    public static function exists(int $carpoolId): bool {
        if ($carpoolId <= 0) {
            return false;
        }

        $sql = 'SELECT COUNT(*) FROM carpools WHERE id = ?';
        return self::count($sql, [$carpoolId]) > 0;
    }
}