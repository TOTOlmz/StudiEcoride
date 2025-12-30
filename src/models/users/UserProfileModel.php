<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Modèle permettant de gérer les infos d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models\users;

use App\Models\BaseModel;


class UserProfileModel extends BaseModel {

    // Fonction permettant de mettre à jour la photo de profil de l'utilisateur
    public static function updatePhoto($fileName, $userId) {
        if ($userId <= 0) {
            throw new \Exception('Identifiant utilisateur manquant.');
        }
        $sql = 'SELECT photo FROM users WHERE id = ?';
        $photo = self::fetchOne($sql, [$userId]);
        if (file_exists(__DIR__ . '/../../../public/assets/users/' . $photo['photo']) && $photo['photo'] !== 'default.png') {
            unlink(__DIR__ . '/../../../public/assets/users/' . $photo['photo']);
        }
        $sql = 'UPDATE users SET photo = ? WHERE id = ?';
        return self::executeQuery($sql, [$fileName, $userId])->rowCount();
    }

    // Fonction permettant de récupérer la note moyenne de l'utilisateur
    public static function getUserAverage($id) {
        if ($id <= 0) {
            throw new \Exception('Identifiant utilisateur manquant.');
        }
        $sql = 'SELECT AVG(rate) AS average FROM reviews WHERE driver_id = ? AND validate = 1';
        return self::fetchOne($sql, [$id]);
    }

    // Fonction permettant de récupérer les avis reçus par l'utilisateur
    public static function getUserReviewsReceived($id) {
        if ($id <= 0) {
            throw new \Exception('Identifiant utilisateur manquant.');
        }
        $sql = 'SELECT commentary, rate FROM reviews WHERE driver_id = ? AND validate = 1';
        return self::fetchAll($sql, [$id]);
    }

    // Fonction permettant de récupérer les avis émis par l'utilisateur
    public static function getUserReviewsLeft($id) {
        if ($id <= 0) {
            throw new \Exception('Identifiant utilisateur manquant.');
        }
        $sql = 'SELECT * FROM reviews WHERE user_id = ?';
        return self::fetchAll($sql, [$id]);
    }
    
}
