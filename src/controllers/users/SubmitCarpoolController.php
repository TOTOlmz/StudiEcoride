<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant la soumission d'un covoiturage
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../../models/users/UserModel.php';
require_once __DIR__ . '/../../models/users/CarsModel.php';
require_once __DIR__ . '/../../models/users/CarpoolsModel.php';
require_once __DIR__ . '/../../models/users/ParticipationModel.php';

class SubmitCarpoolController {

    // Foncion gérant l'affichage des infos utilisateur
    public function userCarpoolsArea() {

        $errors = [];
        $success = '';

        $user = UserModel::getUserData($_SESSION['user_id']);
        $cars = CarsModel::getUserCars($user['id']);
        $carpools = CarpoolsModel::getUserCarpools($user['id']);
        

        // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // On récupère toutes les infos
            $date = $_POST['date'];
            $departureTime = strtotime($_POST['departure-time']);
            $departureCity = htmlspecialchars($_POST['departure-city']);
            $arrivalTime = strtotime($_POST['arrival-time']);
            $arrivalCity = htmlspecialchars($_POST['arrival-city']);
            $duration = $arrivalTime - $departureTime;
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

            if(empty($errors)) {
                
                // On appelle la fonction d'ajout de véhicule
                $departureCoordinates = $this->getCoordinates($departureCity, $errors);
                $arrivalCoordinates = $this->getCoordinates($arrivalCity, $errors);
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

            
            if(empty($errors)) {
                $submitCarpool = CarpoolsModel::addUserCarpools(
                    $date,
                    date('H:i', $departureTime),
                    $departureCity,
                    $departureCoordinates['postcode'],
                    $departureCoordinates['lon'],
                    $departureCoordinates['lat'],
                    date('H:i', $arrivalTime),
                    $arrivalCity,
                    $arrivalCoordinates['postcode'],
                    $arrivalCoordinates['lon'],
                    $arrivalCoordinates['lat'],
                    gmdate('H:i', $duration),
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
                $addDriver = ParticipationModel::addDriver($user['id'], $submitCarpool);
            }

        }

        require_once __DIR__ . '/../../views/users/submitCarpoolView.php';
    }


    // Fonction gérant l'ajout d'un véhicule
    private function getCoordinates($city, $errors) {
        
        // On récupère les informations de l'url
        $url = 'https://api-adresse.data.gouv.fr/search/?q=' . urlencode($city) . '&type=municipality&limit=7';
        $response = file_get_contents($url);

        if ($response === false) {
            $errors[] = 'Erreur lors de la récupération des coordonnées de la ville.';
            return $errors;
        }

        // Si on a récupérer des infos, on les décode
        $cityData = json_decode($response, true);
        // On récupère les coordonnées de la ville
        $lon =  (float) $cityData['features']['0']['geometry']['coordinates'][0];
        $lat = (float) $cityData['features']['0']['geometry']['coordinates'][1];
        $postcode = (float) $cityData['features']['0']['properties']['postcode'];

        return ['lon' => $lon, 'lat' => $lat, 'postcode' => $postcode];
        
    }
}
