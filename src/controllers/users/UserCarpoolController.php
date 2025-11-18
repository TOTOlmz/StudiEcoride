<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'ajout d'un covoiturage
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../AccessController.php';

require_once __DIR__ . '/../sub-controllers/GpsLogicsController.php';

require_once __DIR__ . '/../../models/users/UserModel.php';
require_once __DIR__ . '/../../models/users/CarsModel.php'; 
require_once __DIR__ . '/../../models/users/UserCarpoolsModel.php';
require_once __DIR__ . '/../../models/users/SubmitCarpoolModel.php';

class UserCarpoolController {

    // Foncion gérant l'affichage des infos utilisateur
    public function usercarpoolArea() {

        $accessChecker = new AccessController();
        $accessChecker->checkAccess('USER');

        $errors = [];
        $success = '';

        $user = UserModel::getUserById($_SESSION['user_id']);
        $cars = CarsModel::getUserCars($user['id']);

        // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // On récupère toutes les infos
            $date = $_POST['date'];
            $departureTime = strtotime($_POST['departure-time']);
            $departureCity = htmlspecialchars($_POST['departure-city']);
            $arrivalTime = strtotime($_POST['arrival-time']);
            $arrivalCity = htmlspecialchars($_POST['arrival-city']);
            $status = 'Planifié';
            $seats = intval($_POST['nb-seats']);
            $availableSeats = intval($_POST['nb-seats']);
            $price = floatval($_POST['price']);
            $driverId = $_SESSION['user_id'];
            $carId = intval($_POST['car-id']);
            $isEcological = 0;
            $smoke = isset($_POST['smoke']) ? 1 : 0;
            $animals = isset($_POST['animals']) ? 1 : 0;
            $preferences = htmlspecialchars($_POST['preferences'] ?? '');
            $commission = 0;

            $tomorrow = date("Y-m-d", strtotime("+1 day"));
            if ($date < $tomorrow) {
                $errors[] = 'On ne peut pas soumettre de covoiturage pour le lendemain.';
            }

            // On évite les durées négatives
            if ($departureTime >= $arrivalTime) {
                $arrivalTime = strtotime('+1 day', $arrivalTime);
            }
            
            $duration = ($arrivalTime - $departureTime) / 60;
            

            // On vérifie que l'utilisateur a bien des véhicules enregistrés
            if (count($cars) === 0) {
                $errors[] = 'Vous ne pouvez pas soumettre de covoiturage sans avoir renseigné de véhicule.';
            } else {
                // On récupère son véhicule
                $car = CarsModel::getOneCar($driverId, $carId);

                // On s'assure que le véhicule appartient à l'utilisateur
                if (!$car) {
                    $errors[] = 'Le véhicule ne vous est pas rattaché.';
                }

                // On configure $isEcological si le moteur est électrique
                if (strtolower($car['energy']) == 'electrique') {
                    $isEcological = 1;
                }
            }
        
            // Si pas d'erreurs, on continue
            if(empty($errors)) {
                
                $gpsLogics = new GpsLogicsController();
                // On appelle la fonction d'ajout de véhicule
                $departureCoordinates = $gpsLogics->getCoordinates($departureCity);
                $arrivalCoordinates = $gpsLogics->getCoordinates($arrivalCity);
                if (count($departureCoordinates) === 0 || count($arrivalCoordinates) === 0) {
                    if (count($departureCoordinates) === 0 && count($arrivalCoordinates) === 0) {
                        $errors[] = 'Erreur de récupération des coordonnées des villes.';
                    } elseif (count($departureCoordinates) === 0) {
                        $errors[] = 'Erreur de récupération des coordonnées de la ville de départ.';
                    } else {
                        $errors[] = 'Erreur de récupération des coordonnées de la ville d\'arrivée.';
                    }
                }
            }

            // Si pas d'erreurs, on crée le covoiturage
            if(empty($errors)) {
                $submitCarpool = SubmitCarpoolModel::addCarpool(
                    $date,
                    date('H:i', $departureTime),
                    $departureCity,
                    $departureCoordinates['postalcode'],
                    $departureCoordinates['lon'],
                    $departureCoordinates['lat'],
                    date('H:i', $arrivalTime),
                    $arrivalCity,
                    $arrivalCoordinates['postalcode'],
                    $arrivalCoordinates['lon'],
                    $arrivalCoordinates['lat'],
                    $duration,
                    $status,
                    $seats,
                    $availableSeats,
                    $price,
                    $driverId,
                    $carId,
                    $isEcological,
                    $smoke,
                    $animals,
                    $preferences
                );
                
                if ($submitCarpool) {
                    $success = 'Covoiturage soumis avec succès !';
                } else {
                    $errors[] = 'Erreur lors de la soumission du covoiturage.';
                }
            }

            if(empty($errors)) {
                $addDriver = SubmitCarpoolModel::addDriver($user['id'], $submitCarpool);
            }

        }

        // On récupère les covoiturages
        $carpools = UserCarpoolsModel::getCarpoolsByUserId($user['id']);

        require_once __DIR__ . '/../../views/users/submitCarpoolView.php';
    }
}