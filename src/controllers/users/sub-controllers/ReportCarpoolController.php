<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant le les covoiturages
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../../../models/users/UserValidationModel.php';
require_once __DIR__ . '/../../../models/users/UserCarpoolsModel.php';
require_once __DIR__ . '/../../../models/users/UserModel.php';
require_once __DIR__ . '/../../../models/ReportsModel.php';

class ReportCarpoolController {

    function sendReport($element) {
        $errors = [];
        $success = '';

        $u = [
            'id' => intval($element['user-id']),
            'email' => htmlspecialchars($element['user-email']),
            'pseudo' => htmlspecialchars($element['user-pseudo'])];
        $d = [
            'id' => intval($element['driver-id']),
            'email' => htmlspecialchars($element['driver-email']),
            'pseudo' => htmlspecialchars($element['driver-pseudo'])];
        $c = [
            'id' => intval($element['carpool-id']),
            'date' => htmlspecialchars($element['date']),
            'departure_city' => htmlspecialchars($element['departure-city']),
            'departure_time' => htmlspecialchars($element['departure-time']),
            'arrival_city' => htmlspecialchars($element['arrival-city']),
            'arrival_time' => htmlspecialchars($element['arrival-time'])];
        $r = ['subject' => htmlspecialchars($element['subject']),
                'description' => htmlspecialchars($element['description'])];

        // On met à jour la confirmation d'utilisateur
        $confirmationUpdate = UserValidationModel::confirmationUpdate($u['id'], $c['id']);
        if (!$confirmationUpdate) {
            $errors[] = 'Erreur lors de la mise à jour de la confirmation.';
        }

        $reportAdded = ReportsModel::addReport(
            $u['id'], $u['pseudo'], $u['email'],
            $d['id'], $d['pseudo'], $d['email'],
            $c['id'], $c['date'], $c['departure_city'], $c['departure_time'], $c['arrival_city'], $c['arrival_time'],
            $r['subject'], $r['description']);

        if ($reportAdded == 0) {
            $errors[] = 'Erreur lors de l\'envoi du signalement.';
        } else {
            $success = 'Votre signalement a bien été envoyé. Nous reviendrons vers vous rapidement.';
        }

        // Retourner le résultat
        if (!empty($errors)) {
            return ['errors' => $errors];
        } else {
            return ['success' => $success];
        }
    }

}









