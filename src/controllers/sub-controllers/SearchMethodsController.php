<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant le re retour des carpools trouvés
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../../models/SearchCarpoolModel.php';
require_once __DIR__ . '/SearchCarpoolProcessController.php';

class SearchMethodsController {


    // Foncion permettant la déconnexion
    public function coordinatesSearch($depart, $arrival, $date, $radius) {

        $results = [];          // Tableau qui stockera les covoiturages correspondants
        $suggestion = false;   // variable qui permet de retourner que le 1er covoiturage le plus proche (triés par dates)




        $carpools = SearchCarpoolModel::getCarpoolsByDate($date);
        // On commence par décomposer nos tableaux en différentes variables
        $rDLon = $depart['lon'];
        $rDLat = $depart['lat'];
        $rDPostal = $depart['postalcode'];
        $rALon = $arrival['lon'];
        $rALat = $arrival['lat'];
        $rAPostal = $arrival['postalcode'];

        // On initialise la logic de sélection et lise en forme des covoiturages
        $carpoolLogic = new SearchCarpoolProcessController; 

        if (count($carpools) > 0) {     // S'il y a au moins 1 carpool, on parcourt le tableau
            foreach($carpools as $c) {

                // On vérifie le statut et le nombre de places
                if (htmlspecialchars($c['status']) !== 'Planifié') { continue; }
                if (intval($c['available_seats']) === 0) { continue; }

                $processingResult = $carpoolLogic->carpoolProcessing($c, $depart, $arrival, $radius);
                if (is_array($processingResult) && count($processingResult) > 0) {
                    $results[] = $processingResult;
                }

            }
        }   // S'il n'y a aucun covoiturage pour la date :
        if (count($results) === 0) {
            // On récupère tous les covoiturages planifiés
            $allCarpools = SearchCarpoolModel::getCarpoolsByStatus('Planifié');

            foreach($allCarpools as $c) {

                // On vérifie le statut et le nombre de places
                if (htmlspecialchars($c['status']) !== 'Planifié') { continue; }
                if (intval($c['available_seats']) === 0) { continue; }

                if (count($results) === 0 && !$suggestion){  // Tant qu'on a pas de covoiturage dans le tableau, on cherche
                    $processingResult = $carpoolLogic->carpoolProcessing($c, $depart, $arrival, $radius);
                    if ($processingResult) {
                        $results[] = $processingResult;
                        $suggestion = true;
                        $results['suggestion'] = 1;
                    } 
                }
            }
        }
        return $results;

    }

}