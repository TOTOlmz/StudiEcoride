<?php 
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur mettant en forme un covoiturage
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../../models/SearchCarpoolModel.php';

class SearchCarpoolProcessController {

    function carpoolProcessing($carpool, $depart, $arrival, $radius) {


        // On appelle les controllers : 
        $gpsLogics = new GpsLogicsController;   // Gérant les calculs gps
        $timeLogics = new TimeLogicsController; // Controller gérant les formatages de temps

        // Variables liées au covoiturage de la BDD
        $cDLon = floatval($carpool['departure_lon']);
        $cDLat = floatval($carpool['departure_lat']);
        $cDPostal = intval($carpool['departure_postalcode']);
        $cALon = floatval($carpool['arrival_lon']);
        $cALat = floatval($carpool['arrival_lat']);
        $cAPostal = intval($carpool['arrival_postalcode']);

        // On s'asssure d'avoir les coordonnées GPS du covoiturage
        if ($cDLon !== null && $cDLat !== null && $cALon !== null && $cALat !== null) {

            $dOk = $gpsLogics->haversineFormula($depart['lon'], $depart['lat'], $cDLon, $cDLat) <= $radius; // true si la ville de départ est à moins de $radius
            $aOk = $gpsLogics->haversineFormula($arrival['lon'], $arrival['lat'], $cALon, $cALat) <= $radius; // true si la ville d'arrivée est à moins de $radius

            if ($dOk && $aOk) {

                // Si tout correspond, on met les informations en forme
                $driverRate = SearchCarpoolModel::getDriverAverage($carpool['driver_id']);
                $carpool['driver_rate'] = $driverRate !== null ? $driverRate : 'Non noté';
                $driverData = UserModel::getUserById($carpool['driver_id']);
                $carpool['driver_photo'] = $driverData['photo'];
                $carpool['driver_pseudo'] = $driverData['pseudo'];

                $carpool['date'] = $timeLogics->dateFormatting($carpool['date']);
                $carpool['show_duration'] = $timeLogics->durationFormatting($carpool['duration']);
                if (floatval($carpool['driver_rate'])) {
                    $carpool['driver_rate'] = round($carpool['driver_rate'], 1);
                }
                $carpool['departure_time'] = substr($carpool['departure_time'], 0, 5);
                $carpool['arrival_time'] = substr($carpool['arrival_time'], 0, 5);

                // Et on renvoie le covoiturage
                return $carpool;

            }
        
        // Si les coordonnées gps manquent mais que les codes postaux correspondent. On valide le trajet
        } elseif ($cDPostal !== null && $cAPostal !== null) {

            if ($cDPostal === $depart['postalcode'] && $cAPostal === $arrival['postalcode']) {
            
                // Si tout correspond, on met les informations en forme
                $driverRate = SearchCarpoolModel::getDriverAverage($carpool['driver_id']);
                $carpool['driver_rate'] = $driverRate !== null ? $driverRate : 'Non noté';
                $driverData = UserModel::getUserById($carpool['driver_id']);
                $carpool['driver_photo'] = $driverData['photo'];
                $carpool['driver_pseudo'] = $driverData['pseudo'];

                $carpool['date'] = $timeLogics->dateFormatting($carpool['date']);
                $carpool['show_duration'] = $timeLogics->durationFormatting($carpool['duration']);
                if (floatval($carpool['driver_rate'])) {
                    $carpool['driver_rate'] = round($carpool['driver_rate'], 1);
                }
                $carpool['departure_time'] = substr($carpool['departure_time'], 0, 5);
                $carpool['arrival_time'] = substr($carpool['arrival_time'], 0, 5);

                // Et on renvoie le covoiturage
                return $carpool;

            }

        }

    }

}