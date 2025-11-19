<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
 Modèle permettant de gérer les covoiturages d'un l'utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */


require_once __DIR__ . '/../../database/dbConnection.php';

class CarpoolsModel {

    // Fonction permettant de récupérer les covoiturages de l'utilisateur
    public static function getUserCarpools($userId) {
        global $pdo;
        $stmt = $pdo->prepare('
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
        ');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Fonction permettant de récupérer les covoiturages de l'utilisateur
    public static function addUserCarpools(
        $date,
        $departureTime,
        $departureCity,
        $departurePostalcode,
        $departureLon,
        $departureLat,
        $arrivalTime,
        $arrivalCity,
        $arrivalPostalcode,
        $arrivalLon,
        $arrivalLat,
        $duration,
        $status,
        $seats,
        $availableSeats,
        $price,
        $driverId,
        $carId,
        $isEcological,
        $smoke,
        $animals,
        $preferences) {
        global $pdo;
        $stmt = $pdo->prepare('
            INSERT INTO `carpools` (`date`, `departure_time`, `departure_city`, `departure_postalcode`, `departure_lat`, `departure_lon`,
            `arrival_time`, `arrival_city`, `arrival_postalcode`, `arrival_lat`, `arrival_lon`, 
            `duration`, `status`, `seats`, `available_seats`, `price`, `driver_id`, `car_id`, `is_ecological`, `smoke`, `animals`, `preferences`, `commission`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0) ');
        $stmt->execute([$date, $departureTime, $departureCity, $departurePostalcode, $departureLat, $departureLon,
        $arrivalTime, $arrivalCity, $arrivalPostalcode, $arrivalLat, $arrivalLon, 
        $duration, $status, $seats, $availableSeats, $price, $driverId, $carId, $isEcological, $smoke, $animals, $preferences]);
        return $pdo->lastInsertId();
    }


    // Fonction permettant de récupérer les covoiturages de l'utilisateur
    public static function updateCarpoolStatus($carpoolId, $carpoolStatus) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE `carpools` SET `status` = ? WHERE `id` = ? ');
        $stmt->execute([$carpoolStatus, $carpoolId]);
        return $stmt->rowCount();
    }

    // Fonction permettant de supprimer un covoiturage
    public static function updateCarpoolSeats($carpoolId, $seats) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE carpools SET available_seats = available_seats + ? WHERE id = ?');
        $stmt->execute([$seats, $carpoolId]);
        return $stmt->rowCount(); 
    }

    // Fonction permettant de supprimer un covoiturage
    public static function deleteCarpool($carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('DELETE FROM `carpools` WHERE `id` = ? ');
        $stmt->execute([$carpoolId]);
        return $stmt->rowCount();
    }
    
}