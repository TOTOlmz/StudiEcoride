<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'affichage des détails d'un covoiturage
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers;

use App\Models\CarpoolDetailsModel;
use App\Models\users\UserModel;
use App\Models\users\CarsModel;
use App\Models\users\UserProfileModel;
use App\Controllers\subControllers\TimeLogicsController;

class CarpoolDetailsController {
    
    protected Array $errors = [];
    protected string $success = '';

    function carpoolDetailsArea() {
        
        $this->errors = [];
        if (isset($_SESSION['user_id'])){
            $user = UserModel::getUserById($_SESSION['user_id']);
        } else {
            $user['credits'] = 0;
        }

        // On récupère l'id du covoiturage qui est passé en paramètre de l'URL
        $urlQuery = $_SERVER['QUERY_STRING'];
        $carpoolId = str_replace('c=', '', $urlQuery);
        if ($carpoolId == '') {
            $this->errors[] = 'Aucun covoiturage trouvé dans l\'url.';
        }

        // On récupère les infos du covoiturage
        $carpool = CarpoolDetailsModel::getCarpoolById($carpoolId);
        if (!$carpool) {
            $this->errors[] = 'Covoiturage introuvable.';
        }

        // On récupère les infos du conducteur
        $driver = UserModel::getUserById($carpool['driver_id']);
        if (!$driver) {
            $this->errors[] = 'Conducteur introuvable.';
        }
        
        // On récupère les infos de la voiture
        $car = CarsModel::getCarById($carpool['car_id']);
        if (!$car) {
            $this->errors[] = 'Voiture introuvable.';
        }

        // On récupère la note moyenne du conducteur
        $driver['avg'] = UserProfileModel::getUserAverage($carpool['driver_id']);

        if (!intval($driver['avg'])) {
            $driver['avg'] = null;
        } else {
            $driver['avg'] = round(intval($driver['avg']), 1);
        }
        echo $driver['avg'];

        // On récupère les commentaires sur le conducteur
        $driverComments = UserProfileModel::getUserReviewsReceived($carpool['driver_id']);
        if ($driverComments === false) {
            $this->errors[] = 'Impossible de récupérer les commentaires du conducteur.';
        }

        $timeLogics = new TimeLogicsController;
        // On formate la date et la durée du trajet
        $carpool['date'] = $timeLogics->dateFormatting($carpool['date']);
        $carpool['duration'] = $timeLogics->durationFormatting($carpool['duration']);

        $errors = $this->errors;
        require_once ROOT_PATH . 'src/views/carpoolDetailsView.php';

    }

    
}