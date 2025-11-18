<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'affichage de l'espace personnel d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../models/CarpoolDetailsModel.php';
require_once __DIR__ . '/../models/users/UserModel.php';
require_once __DIR__ . '/../models/users/UserProfileModel.php';
require_once __DIR__ . '/sub-controllers/TimeLogicsController.php';

class CarpoolDetailsController {

    function carpoolDetailsArea() {
        
        $errors = [];
        if (isset($_SESSION['user_id'])){
            $user = UserModel::getUserById($_SESSION['user_id']);
        } else {
            $user['credits'] = 0;
        }

        // On récupère l'id du covoiturage qui est passé en paramètre de l'URL
        $urlQuery = $_SERVER['QUERY_STRING'];
        $carpoolId = str_replace('c=', '', $urlQuery);
        if ($carpoolId == '') {
            $errors[] = 'Aucun covoiturage trouvé dans l\'url.';
        }

        // On récupère les infos du covoiturage
        $carpool = CarpoolDetailsModel::getCarpoolById($carpoolId);
        if (!$carpool) {
            $errors[] = 'Covoiturage introuvable.';
        }

        // On récupère les infos du conducteur
        $driver = UserModel::getUserById($carpool['driver_id']);
        if (!$driver) {
            $errors[] = 'Conducteur introuvable.';
        }
        
        // On récupère les infos de la voiture
        $car = CarsModel::getCarById($carpool['car_id']);
        if (!$car) {
            $errors[] = 'Voiture introuvable.';
        }

        // On récupère la note moyenne du conducteur
        $driver['avg'] = UserProfileModel::getUserAverage($carpool['driver_id']);

        if (!intval($driver['avg'])) {
             $driver['avg'] = 'Non noté';
        } else {
            $driver['avg'] = round(intval($driver['avg']), 1);
        }

        // On récupère les commentaires sur le conducteur
        $driverComments = UserProfileModel::getUserReviewsReceived($carpool['driver_id']);
        if ($driverComments === false) {
            $errors[] = 'Impossible de récupérer les commentaires du conducteur.';
        }

        $timeLogics = new TimeLogicsController;
        // On formate la date et la durée du trajet
        $carpool['date'] = $timeLogics->dateFormatting($carpool['date']);
        $carpool['duration'] = $timeLogics->durationFormatting($carpool['duration']);

        require_once __DIR__ . '/../views/carpoolDetailsView.php';

    }

    
}