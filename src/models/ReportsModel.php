<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
 Modèle permettant de gérer les signalements
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */


require_once __DIR__ . '/../database/dbConnection.php';

class ReportsModel {


    // Fonction permettant d'ajouter un rapport d'incident
    public static function addReport($uId, $uPseudo, $uEmail,
                                     $dId, $dPseudo, $dEmail,
                                     $cId, $date, $departureCity, $departureTime, $arrivalCity, $arrivalTime,
                                     $subject, $description) {
        global $pdo;
        $stmt = $pdo->prepare('
            INSERT INTO reports (
            user_id, user_pseudo, user_email, 
            driver_id, driver_pseudo, driver_email, 
            carpool_id, date, departure_city, departure_time, arrival_city, arrival_time, 
            subject, description, is_consulted, is_closed) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0) ');
        $stmt->execute([
            $uId, $uPseudo, $uEmail,
            $dId, $dPseudo, $dEmail,
            $cId, $date, $departureCity, $departureTime, $arrivalCity, $arrivalTime,
            $subject, $description]);
        return $pdo->lastInsertId();
    }

    // Fonction permettant de récupérer les raports non traités
    public static function getPendingReports() {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM reports WHERE is_consulted = 0');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de récupérer les raports en cours
    public static function getCurrentReports() {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM reports WHERE is_consulted = 1 AND is_closed = 0');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de récupérer les raports terminés
    public static function getClosedReports() {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM reports WHERE is_closed = 1');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de récupérer les raports terminés
    public static function openReport($id) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE reports SET is_consulted = 1 WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    // Fonction permettant de récupérer les raports terminés
    public static function closeReport($id) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE reports SET is_closed = 1 WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

}