<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant la soumission d'un covoiturage
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers\users;

use App\Models\users\UserModel;
use App\Models\users\CarsModel;
use App\Models\users\CarpoolsModel;
use App\Models\users\ParticipationModel;


class SubmitCarpoolController {

    protected Array $errors = [];
    protected string $success = '';

    // Fonction gérant l'ajout d'un covoiturage
    public function userCarpoolsArea() {


        $user = UserModel::getUserById($_SESSION['user_id']);
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
                $this->errors[] = 'Vous ne pouvez pas soumettre de covoiturage sans avoir renseigné de véhicule.';
            } else {
                // On récupère son véhicule
                $car = CarsModel::getOneCar($driverId, $carId);

                // On s'assure que le véhicule appartient à l'utilisateur
                if (!$car) {
                    $this->errors[] = 'Le véhicule ne vous est pas rattaché.';
                }

                // On configure $isEcological si le moteur est électrique
                if (strtolower($car['energy']) == 'electrique') {
                    $isEcological = 1;
                }
            }

            if(empty($this->errors)) {
                
                // On appelle la fonction d'ajout de véhicule
                $departureCoordinates = $this->getCoordinates($departureCity);
                $arrivalCoordinates = $this->getCoordinates($arrivalCity);
                if (count($departureCoordinates) === 0 || count($arrivalCoordinates) === 0) {
                    if (count($departureCoordinates) === 0 && count($arrivalCoordinates) === 0) {
                        $this->errors[] = 'Erreur de récupération des coordonnées des villes.';
                    } elseif (count($departureCoordinates) === 0) {
                        $this->errors[] = 'Erreur de récupération des coordonnées de la ville de départ.';
                    } else {
                        $this->errors[] = 'Erreur de récupération des coordonnées de la ville d\'arrivée.';
                    }
                }
            }

            
            if(empty($this->errors)) {
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
                    $this->success = 'Covoiturage soumis avec succès !';
                } else {
                    $this->errors[] = 'Erreur lors de la soumission du covoiturage.';
                }
            }

            if(empty($this->errors)) {
                $addDriver = ParticipationModel::addDriver($user['id'], $submitCarpool);
            }

        }

        $errors = $this->errors;
        $success = $this->success;
        require_once ROOT_PATH . 'src/views/users/submitCarpoolView.php';
    }


    // Fonction gérant l'ajout d'un véhicule
    private function getCoordinates($city) {
        
        // On récupère les informations de l'url
        $url = 'https://api-adresse.data.gouv.fr/search/?q=' . urlencode($city) . '&type=municipality&limit=7';
        $response = file_get_contents($url);

        if ($response === false) {
            $this->errors[] = 'Erreur lors de la récupération des coordonnées de la ville.';
            return $this->errors;
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
