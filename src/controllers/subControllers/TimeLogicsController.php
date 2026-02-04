<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant les formats de temps
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers\subControllers;

use DateTime;

class TimeLogicsController {

    // Fonction permettant de formater la date en français
    function dateFormatting($date) {
        if (!$date) {
            return 'Date non renseignée';
        }
        $dateObj = DateTime::createFromFormat('Y-m-d', $date);
        $monthFr = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
        $dateFr = $dateObj ? $dateObj->format('d') . ' ' . $monthFr[intval($dateObj->format('n')) - 1] . ' ' . $dateObj->format('Y') : htmlspecialchars($date);
        return $dateFr;
    }

    // fonction permettant de formater une durée en Xh YYmin
    function durationFormatting($duration) {
        $h = floor($duration / 60);
        $m = $duration % 60;
        $newDuration = $h . 'h ' . $m . 'min';

        return $newDuration;
    }
}