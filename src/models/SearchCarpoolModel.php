<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
 Modèle gérant les recherches de covoiturages
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */


require_once __DIR__ . '/../database/dbConnection.php';

class SearchCarpoolModel {

    // Fonction permettant de chercher les covoiturages par date
    public static function getCarpoolsByDate($date) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM carpools WHERE date = ? ');
        $stmt->execute([$date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de chercher les covoiturages par date
    public static function getCarpoolsByStatus($date) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM carpools WHERE status = "Planifié" ORDER BY ABS(DATEDIFF(date, ?)) ASC');
        $stmt->execute([$date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction permettant de récupérer la note moyenne de l'utilisateur
    public static function getDriverAverage($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT AVG(rate) FROM reviews WHERE driver_id = ? AND validate = 1');
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }


}