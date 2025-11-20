<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant la recherche de covoiturages
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/sub-controllers/SearchMethodsController.php';
require_once __DIR__ . '/sub-controllers/GpsLogicsController.php';
require_once __DIR__ . '/sub-controllers/TimeLogicsController.php';


class CarpoolSearchController {
    
    public function CarpoolSearchArea() {

        $errors = [];
        $results = [];
        $suggestion = false;
        $research = false;      // Permet de savoir si une recherche est lancée

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $research = true;

            $departureCity = htmlspecialchars($_POST['departure-city']);
            $arrivalCity = htmlspecialchars($_POST['arrival-city']);
            $date = $_POST['date'];
            $radius = isset($_POST['radius']) ? intval($_POST['radius']) : 20;

            // On s'assure d'avoir tous les champs
            if (!isset($departureCity) || !isset($arrivalCity) || !isset($date)) {
                $errors[] = 'Il est nécessaire de renseigner les lieux et la date.';
            }

            // On appelle le controller gps
            $gpsLogics = new GpsLogicsController;

            // On essaye de récupérer les coordonnées des villes
            $departureCoordinates = $gpsLogics->getCoordinates($departureCity);
            if ($departureCoordinates === null) {
                $errors[] = 'Ville de départ introuvable.';
            }  
            $arrivalCoordinates = $gpsLogics->getCoordinates($arrivalCity);
            if ($arrivalCoordinates === null) {
                $errors[] = 'Ville d\'arrivée introuvable.';
            }
            
            // S'il y a eu une erreur, on arrête ...
            if (!empty($errors)) {
                require_once __DIR__ . '/../views/carpoolSearchView.php';
                return;
            }
            
            // Sinon, on ajoute les coordonnées aux tableaux
            $departure = array_merge(['city' => $departureCity], $departureCoordinates);
            $arrival = array_merge(['city' => $arrivalCity], $arrivalCoordinates);
            
            //Et on appelle la methode de recherche par coordonnées
            $searchMethods = new SearchMethodsController;
            // Et on stocke son contenu dans $carpools
            $results = $searchMethods->coordinatesSearch($departure, $arrival, $date, $radius);
            
            if (isset($results['suggestion'])) {
                $suggestion = true;
                unset($results['suggestion']);
            }
            
        }
        
        require_once __DIR__ . '/../views/carpoolSearchView.php';

    }
}
