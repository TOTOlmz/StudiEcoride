<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle gérant les recherches de covoiturages
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models;

use App\Models\BaseModel;

class SearchCarpoolModel extends BaseModel {

    // Fonction permettant de récupérer les covoiturages par date
    public static function getCarpoolsByDate(string $date): array {
        if (empty($date)) {
            throw new \Exception('Date is required.');
        }
        
        $sql = 'SELECT * FROM carpools WHERE DATE(date) = ? ORDER BY departure_time ASC';
        return self::fetchAll($sql, [$date]);
    }

    // Fonction permettant de récupérer les covoiturages par statut
    public static function getCarpoolsByStatus(string $date): array {
        if (empty($date)) {
            throw new \Exception('Date is required.');
        }
        
        $sql = 'SELECT * FROM carpools 
                WHERE status = "Planifié" 
                ORDER BY ABS(DATEDIFF(date, ?)) ASC 
                LIMIT 50';
        return self::fetchAll($sql, [$date]);
    }

    // Fonction permettant de récupérer la note moyenne d'un conducteur
    public static function getDriverAverage(int $driverId): ?float {
        if ($driverId <= 0) {
            throw new \Exception('Invalid driver ID provided.');
        }
        
        $sql = 'SELECT AVG(rate) FROM reviews WHERE driver_id = ? AND validate = 1';
        $result = self::count($sql, [$driverId]);
        return $result ? (float) $result : null;
    }

    // Fonction permettant de rechercher des covoiturages spécifiques
    public static function searchWithFilters(array $filters): array {
        $sql = 'SELECT * FROM carpools WHERE 1=1';
        $params = [];
        
        if (!empty($filters['departure_city'])) {
            $sql .= ' AND departure_city = ?';
            $params[] = $filters['departure_city'];
        }
        
        if (!empty($filters['arrival_city'])) {
            $sql .= ' AND arrival_city = ?';
            $params[] = $filters['arrival_city'];
        }
        
        if (!empty($filters['date'])) {
            $sql .= ' AND DATE(date) = ?';
            $params[] = $filters['date'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= ' AND status = ?';
            $params[] = $filters['status'];
        }
        
        $sql .= ' ORDER BY date ASC';
        return self::fetchAll($sql, $params);
    }
}