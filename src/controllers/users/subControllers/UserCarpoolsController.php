<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant les covoiturages d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers\users\subControllers;

use App\Controllers\BaseController;
use App\models\users\UserCarpoolsModel;

class UserCarpoolsController extends BaseController {

    
    protected Array $errors = [];
    protected string $success = '';

    // Fonction permettant de mettre à jour le statut d'un covoiturage
    public function updateCarpoolStatus($carpoolId, $CarpoolStatus) {

        if (!isset($carpoolId) || !isset($CarpoolStatus)) {
            return false;
        }
        $updateStatus = UserCarpoolsModel::updateCarpoolStatus($carpoolId, $CarpoolStatus);
        return $updateStatus;
    }

    // Fonction permettant de mettre à jour les participants à un covoiturage
    public function leaveCarpool($userId, $carpoolId) {

        $this->errors = [];
        $this->success = '';
        
        // On appelle le modèle pour récupérer les covoiturages de l'utilisateur
        $carpools = UserCarpoolsModel::getCarpoolsByUserId($userId);

        if (empty($carpools)) {
            $this->errors[] = 'Covoiturages introuvable.';
            return ['errors' => $this->errors];
        }
        // On identifie le covoiturage concerné
        $carpool = [];
        foreach ($carpools as $c) {
            if ($c['id'] == $carpoolId) {
                $carpool = $c;
                break;
            }
        }
        if (empty($carpool)) {
            $this->errors[] = 'Covoiturage introuvable.';
            return ['errors' => $this->errors];
        }

        // On vérifie si l'utilisateur est conducteur
        $isDriver = $carpool['driver_id'] === $userId;

        // Si la personne annulant est le conducteur
        if ($isDriver) {

            // On récupère tous les passagers
            $passengers = UserCarpoolsModel::getPassengers($carpoolId);

            
            // On crédite et informe chaque passager ... 
            if (count($passengers) > 0) {
                foreach ($passengers as $p) {
                    
                    $adjustCredits = UserCarpoolsModel::adjustPassengerCredits($p['user_id'], $p['pending_credits']);
                    $leaveCarpool = UserCarpoolsModel::leaveCarpool($p['user_id'], $carpoolId);
                    if (!$adjustCredits || !$leaveCarpool) {
                        $this->errors[] = 'Erreur lors du traitement d\'un passager.';
                    }
                    $email = UserCarpoolsModel::getPassengerEmail($p['user_id']);

                    if (!empty($email)) {
                        $to = $email;
                        $subject = 'Annulation du covoiturage';
                        $content = 'Bonjour,<br>Le conducteur a annulé le covoiturage auquel vous participiez. Vos crédits ont été remboursés.';
                        $send = $this->sendEmailToUser($to, $subject, $content);

                        if (!$send) {
                            $this->errors[] = 'Erreur lors de l\'envoi de l\'email à un passager.';
                        }
                    }
                    
                }
            }
            // ...Avant de supprimer le covoiturage
            UserCarpoolsModel::leaveCarpool($userId, $carpoolId);
            UserCarpoolsModel::deleteCarpool($carpoolId);
            if (empty($this->errors)) {
                return ['success' => $this->success];
            } else {
                return ['errors' => $this->errors];
            }
            
        } else {
            // Si la personne annulant est un passager
            $passenger = UserCarpoolsModel::getPassenger($userId, $carpoolId); // On récupère les infos du passager

            $adjustCredits = UserCarpoolsModel::adjustPassengerCredits($userId, $passenger['pending_credits']); // On rembourse les crédits en attente
            $leaveCarpool = UserCarpoolsModel::leaveCarpool($userId, $carpoolId); // On le fait sortir du covoiturage
            $updateSeats = UserCarpoolsModel::updateCarpoolSeats($carpoolId, 1); // On réajuste le nombre de sièges disponibles
            
            if ($adjustCredits && $leaveCarpool && $updateSeats) {
                return ['success' => $this->success];
            } else {
                return ['errors' => $this->errors];
            }
            
        }
    }
}


