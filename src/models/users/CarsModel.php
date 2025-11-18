<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
Modèle permettant de gérer les véhicules d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */


require_once __DIR__ . '/../../database/dbConnection.php';

class CarsModel {

    // Fonction permettant de récupérer les véhicules de l'utilisateur
    public static function getUserCars($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM cars WHERE driver_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de récupérer une voiture par id
    public static function getCarById($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM cars WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de récupérer une seule voiture
    public static function getOneCar($driverId, $carId) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM cars WHERE driver_id = ? AND id = ?');
        $stmt->execute([$driverId, $carId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fonction permettant d'ajouter un véhicule
    public static function addUserCar($brand, $model, $color, $energy, $plate_number, $first_registration, $driverId) {
        global $pdo;
        $stmt = $pdo->prepare('
            INSERT INTO cars (
            brand, 
            model, 
            color, 
            energy, 
            plate_number, 
            first_registration, 
            driver_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)');
        return $stmt->execute([$brand, $model, $color, $energy, $plate_number, $first_registration, $driverId]);
    }

}
    