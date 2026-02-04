<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant le les signalements de covoiturages
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers\users\subControllers;

use App\Models\users\UserValidationModel;
use App\Models\ReportsModel;

class ReportCarpoolController {

    
    protected Array $errors = [];
    protected string $success = '';

    function sendReport($element) {
        $this->errors = [];
        $this->success = '';

        // Valeurs liées au signalant
        $u = [
            'id' => intval($element['user-id']),
            'email' => htmlspecialchars($element['user-email']),
            'pseudo' => htmlspecialchars($element['user-pseudo'])];
        // Valeurs liées au conducteur
        $d = [
            'id' => intval($element['driver-id']),
            'email' => htmlspecialchars($element['driver-email']),
            'pseudo' => htmlspecialchars($element['driver-pseudo'])];
        // Valeurs liées au covoiturage
        $c = [
            'id' => intval($element['carpool-id']),
            'date' => htmlspecialchars($element['date']),
            'departure_city' => htmlspecialchars($element['departure-city']),
            'departure_time' => htmlspecialchars($element['departure-time']),
            'arrival_city' => htmlspecialchars($element['arrival-city']),
            'arrival_time' => htmlspecialchars($element['arrival-time'])];
        // Valeurs liées au signalement
        $r = ['subject' => htmlspecialchars($element['subject']),
                'description' => htmlspecialchars($element['description'])];

        // On met à jour la confirmation d'utilisateur
        $confirmationUpdate = UserValidationModel::confirmationUpdate($u['id'], $c['id']);
        if (!$confirmationUpdate) {
            $this->errors[] = 'Erreur lors de la mise à jour de la confirmation.';
        }

        $reportAdded = ReportsModel::addReport(
            $u['id'], $u['pseudo'], $u['email'],
            $d['id'], $d['pseudo'], $d['email'],
            $c['id'], $c['date'], $c['departure_city'], $c['departure_time'], $c['arrival_city'], $c['arrival_time'],
            $r['subject'], $r['description']);

        if ($reportAdded == 0) {
            $this->errors[] = 'Erreur lors de l\'envoi du signalement.';
        } else {
            $this->success = 'Votre signalement a bien été envoyé. Nous reviendrons vers vous rapidement.';
        }

        // Retourner le résultat
        if (!empty($this->errors)) {
            return ['errors' => $this->errors];
        } else {
            return ['success' => $this->success];
        }
    }

}









