<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle gérant les détails des covoiturages
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models;

use App\Models\BaseModel;

class CarpoolDetailsModel extends BaseModel {

    // Fonction permettant de récupérer un covoiturage par son ID
    public static function getCarpoolById(int $id): ?array {
        if ($id <= 0) {
            throw new \Exception('Invalid carpool ID: ID must be a positive integer.');
        }
        
        $sql = 'SELECT * FROM carpools WHERE id = ?';
        return self::fetchOne($sql, [$id]);
    }

    // Fonction permettant de récupérer les covoiturages selon des filtres
    public static function getCarpoolsByFilters(array $filters): array {
        $sql = 'SELECT * FROM carpools WHERE 1=1';
        $params = [];
        
        // Conditions pour rajouter les filtres à la requête
        if (!empty($filters['driver_id'])) {
            $sql .= ' AND driver_id = ?';
            $params[] = $filters['driver_id'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= ' AND status = ?';
            $params[] = $filters['status'];
        }
        
        $sql .= ' ORDER BY date DESC';
        return self::fetchAll($sql, $params);
    }

    // Fonction permettant de vérifier l'existence d'un covoiturage par son ID
    public static function exists(int $id): bool {
        if ($id <= 0) {
            return false;
        }
        
        $sql = 'SELECT COUNT(*) FROM carpools WHERE id = ?';
        return self::count($sql, [$id]) > 0;
    }
}