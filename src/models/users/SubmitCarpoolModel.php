<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de récupérer les covoiturages,
    les véhicules et les avis liés à l'utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */


require_once __DIR__ . '/../../database/dbConnection.php';

class SubmitCarpoolModel {

    // Fonction permettant d'ajouter un participant au covoiturage
    public static function addDriver($userId, $carpoolId) {
        global $pdo;
        $stmt = $pdo->prepare('
            INSERT INTO participations (user_id, carpool_id, is_passenger, is_confirmed, is_satisfied, pending_credits)
            VALUES (?, ?, 0, 0, 0, 0) ');
        $stmt->execute([$userId, $carpoolId]);
        return $pdo->lastInsertId();
    }


    // Fonction permettant d'ajouter un covoiturages
    public static function addCarpool(
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
            INSERT INTO carpools (date, departure_time, departure_city, departure_postalcode, departure_lat, departure_lon,
            arrival_time, arrival_city, arrival_postalcode, arrival_lat, arrival_lon, 
            duration, status, seats, available_seats, price, driver_id, car_id, is_ecological, smoke, animals, preferences, commission)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0) ');
        $stmt->execute([$date, $departureTime, $departureCity, $departurePostalcode, $departureLat, $departureLon,
        $arrivalTime, $arrivalCity, $arrivalPostalcode, $arrivalLat, $arrivalLon, 
        $duration, $status, $seats, $availableSeats, $price, $driverId, $carId, $isEcological, $smoke, $animals, $preferences]);
        return $pdo->lastInsertId();
    }

}
