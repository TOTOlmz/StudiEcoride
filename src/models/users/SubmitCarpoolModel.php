<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de récupérer les covoiturages,
    les véhicules et les avis liés à l'utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models\users;

use App\Models\BaseModel;

class SubmitCarpoolModel extends BaseModel {

    // Fonction permettant d'ajouter un participant au covoiturage
    public static function addDriver($userId, $carpoolId) {
        if (empty($userId) || empty($carpoolId)) {
            throw new \InvalidArgumentException('User ID and Carpool ID are required.');
        }
        $sql = 'INSERT INTO participations (user_id, carpool_id, is_passenger, is_confirmed, is_satisfied, pending_credits)
                VALUES (?, ?, 0, 0, 0, 0)';
        return self::executeQuery($sql, [$userId, $carpoolId])->rowCount();
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
        
        $sql ='
            INSERT INTO carpools (date, departure_time, departure_city, departure_postalcode, departure_lat, departure_lon,
            arrival_time, arrival_city, arrival_postalcode, arrival_lat, arrival_lon, 
            duration, status, seats, available_seats, price, driver_id, car_id, is_ecological, smoke, animals, preferences, commission)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0) ';
        self::executeQuery($sql, [$date, $departureTime, $departureCity, $departurePostalcode, $departureLat, $departureLon,
        $arrivalTime, $arrivalCity, $arrivalPostalcode, $arrivalLat, $arrivalLon, 
        $duration, $status, $seats, $availableSeats, $price, $driverId, $carId, $isEcological, $smoke, $animals, $preferences]);
        return self::lastInsert($sql, [$date, $departureTime, $departureCity, $departurePostalcode, $departureLat, $departureLon,
        $arrivalTime, $arrivalCity, $arrivalPostalcode, $arrivalLat, $arrivalLon, 
        $duration, $status, $seats, $availableSeats, $price, $driverId, $carId, $isEcological, $smoke, $animals, $preferences]);
    }

}
