<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de gérer les véhicules d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models\users;

use App\Models\BaseModel;

class CarsModel extends BaseModel {

    // Fonction permettant de récupérer les véhicules d'un utilisateur
    public static function getUserCars(int $driverId): array {
        if ($driverId <= 0) {
            throw new \Exception('Invalid driver ID provided.');
        }

        $sql = 'SELECT * FROM cars WHERE driver_id = ? ORDER BY brand ASC';
        return self::fetchAll($sql, [$driverId]);
    }

    // Fonction permettant de récupérer un véhicule par son ID
    public static function getCarById(int $carId): ?array {
        if ($carId <= 0) {
            throw new \Exception('Invalid car ID provided.');
        }

        $sql = 'SELECT * FROM cars WHERE id = ?';
        return self::fetchOne($sql, [$carId]);
    }

    // Fonction permettant de récupérer un véhicule spécifique d'un utilisateur
    public static function getOneCar(int $driverId, int $carId): ?array {
        if ($driverId <= 0 || $carId <= 0) {
            throw new \Exception('Invalid driver ID or car ID provided.');
        }

        $sql = 'SELECT * FROM cars WHERE driver_id = ? AND id = ?';
        return self::fetchOne($sql, [$driverId, $carId]);
    }

    // Fonction permettant d'ajouter un véhicule pour un utilisateur
    public static function addUserCar(
        string $brand,
        string $model,
        string $color,
        string $energy,
        string $plateNumber,
        string $firstRegistration,
        int $driverId
    ) {
        if ($driverId <= 0 || empty($brand) || empty($model)) {
            throw new \Exception('Invalid driver ID or missing car information.');
        }

        $sql = '
            INSERT INTO cars (
                brand, model, color, energy, plate_number, first_registration, driver_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?)
        ';
        
        $stmt = self::executeQuery($sql, [
            $brand, $model, $color, $energy, $plateNumber, $firstRegistration, $driverId
        ]);
        
        return self::getPdo()->lastInsertId() ?: false;
    }

    // Fonction permettant de supprimer un véhicule
    public static function deleteCar(int $carId): int {
        if ($carId <= 0) {
            throw new \Exception('Invalid car ID provided.');
        }

        $sql = 'DELETE FROM cars WHERE id = ?';
        $stmt = self::executeQuery($sql, [$carId]);
        return $stmt->rowCount();
    }
}