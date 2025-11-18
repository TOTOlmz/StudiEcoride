<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
 Modèle gérant les recherches de covoiturages
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */


require_once __DIR__ . '/../database/dbConnection.php';

class CarpoolDetailsModel {

    // Fonction permettant de récupérer un covoiturage avec son id
    public static function getCarpoolById($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM carpools WHERE id = ? ');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}