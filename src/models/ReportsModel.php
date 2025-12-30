<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de gérer les signalements (reports)
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models;

use App\Models\BaseModel;

class ReportsModel extends BaseModel {

    // Fonction permettant d'ajouter un nouveau rapport
    public static function addReport(
        int $userId, string $userPseudo, string $userEmail,
        int $driverId, string $driverPseudo, string $driverEmail,
        int $carpoolId, string $date, string $departureCity, string $departureTime, 
        string $arrivalCity, string $arrivalTime,
        string $subject, string $description
    ) {
        if ($userId <= 0 || $driverId <= 0 || $carpoolId <= 0) {
            throw new \Exception('Invalid user, driver, or carpool ID provided.');
        }
        
        $sql = '
            INSERT INTO reports (
                user_id, user_pseudo, user_email, 
                driver_id, driver_pseudo, driver_email, 
                carpool_id, date, departure_city, departure_time, arrival_city, arrival_time, 
                subject, description, is_consulted, is_closed
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0)
        ';
        
        $stmt = self::executeQuery($sql, [
            $userId, $userPseudo, $userEmail,
            $driverId, $driverPseudo, $driverEmail,
            $carpoolId, $date, $departureCity, $departureTime, $arrivalCity, $arrivalTime,
            $subject, $description
        ]);
        
        // Récupérer l'ID du rapport créé
        return self::getPdo()->lastInsertId() ?: false;
    }

    // Fonction permettant de récupérer les rapports non consultés
    public static function getPendingReports(): array {
        $sql = 'SELECT * FROM reports WHERE is_consulted = 0 ORDER BY created_at DESC';
        return self::fetchAll($sql);
    }

    // Fonction permettant de récupérer les rapports consultés mais non fermés
    public static function getCurrentReports(): array {
        $sql = 'SELECT * FROM reports WHERE is_consulted = 1 AND is_closed = 0 ORDER BY created_at DESC';
        return self::fetchAll($sql);
    }

    // Fonction permettant de récupérer les rapports fermés
    public static function getClosedReports(): array {
        $sql = 'SELECT * FROM reports WHERE is_closed = 1 ORDER BY created_at DESC';
        return self::fetchAll($sql);
    }

    // Fonction permettant d'ouvrir un rapport (le marquer comme consulté)
    public static function openReport(int $reportId): bool {
        if ($reportId <= 0) {
            throw new \Exception('Invalid report ID provided.');
        }
        
        $sql = 'UPDATE reports SET is_consulted = 1 WHERE id = ?';
        $stmt = self::executeQuery($sql, [$reportId]);
        return $stmt->rowCount() > 0;
    }

    // Fonction permettant de fermer un rapport (le marquer comme traité)
    public static function closeReport(int $reportId): bool {
        if ($reportId <= 0) {
            throw new \Exception('Invalid report ID provided.');
        }
        
        $sql = 'UPDATE reports SET is_closed = 1 WHERE id = ?';
        $stmt = self::executeQuery($sql, [$reportId]);
        return $stmt->rowCount() > 0;
    }

    // Fonction permettant de récupérer un rapport par son ID
    public static function getReportById(int $reportId): ?array {
        if ($reportId <= 0) {
            throw new \Exception('Invalid report ID provided.');
        }
        
        $sql = 'SELECT * FROM reports WHERE id = ?';
        return self::fetchOne($sql, [$reportId]);
    }
}