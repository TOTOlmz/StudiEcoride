<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant les calculs GPS
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

class GpsLogicsController {

    // Fonction permettant de calculer la distance en km entre 2 points gps (formule de Haversine)
    // Récupérée sur un forum
    function haversineFormula ($lon1, $lat1, $lon2, $lat2) {
        $R = 6371; // Rayon de la Terre en km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $R * $c;
    }

    // Fonction permettant de récupérer les coordonnées d'une ville
    function getCoordinates($city) {
        
        // On récupère les informations de l'url
        $url = 'https://api-adresse.data.gouv.fr/search/?q=' . urlencode($city) . '&type=municipality&limit=7';

        // On cnfigure un contexte pour désactiver les warnings et gérer les erreurs HTTP
        $context = stream_context_create([
            'http' => [
                'ignore_errors' => true,
                'timeout' => 10
            ]
        ]);

        $response = @file_get_contents($url, false, $context);
        if ($response === false) {
            return null;
        }
        
        // Si on a récupéré des infos, on les décode
        $cityData = json_decode($response, true);
        // On vérifie qu'on a les données des villes
        if (!$cityData || !isset($cityData['features']) || empty($cityData['features'])) {
            return null;
        }
        
        // On récupère les coordonnées de la ville
        $lon =  (float) $cityData['features']['0']['geometry']['coordinates'][0];
        $lat = (float) $cityData['features']['0']['geometry']['coordinates'][1];
        $postalcode = (int) $cityData['features']['0']['properties']['postcode'];

        return ['lon' => $lon, 'lat' => $lat, 'postalcode' => $postalcode];
    }

}
