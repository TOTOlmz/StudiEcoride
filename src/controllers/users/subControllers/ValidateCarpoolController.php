<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant la validation des covoiturages
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers\users\subControllers;

use App\Models\users\UserValidationModel;
use App\Models\CarpoolDetailsModel;
use App\Models\users\UserModel;
use App\Models\users\UserCarpoolsModel;

class ValidateCarpoolController {

    
    protected Array $errors = [];
    protected string $success = '';

    // Fonction permettant de confirmer la fin d'un covoiturage
    function confirmCarpoolEnd($userId, $carpoolId, $driverId, $isSatisfied) {
        $this->errors = [];

        // Si l'utilisateur est satisfait
        if ($isSatisfied === 1) {

            // On met à jour la confirmation de l'utilisateur
            $confirmationUpdate = UserValidationModel::confirmationUpdate($userId, $carpoolId);
            if (!$confirmationUpdate) {
                $this->errors[] = 'Erreur lors de la mise à jour de la confirmation.';
            }

            // On met à jour la satisfaction de l'utilisateur
            $satisfactionUpdate = UserValidationModel::satisfactionUpdate($userId, $carpoolId);
            if (!$satisfactionUpdate) {
                $this->errors[] = 'Erreur lors de la mise à jour de la satisfaction.';
            }

            // On récupère les crédits en attente
            $pendingCredits = UserValidationModel::getPendingCredits($userId, $carpoolId);
            if (!$pendingCredits) {
                $this->errors[] = 'Erreur lors de la récupération des crédits.';
            }

            // On vérifie si la commission de la plateforme a déjà été prise
            $commissionValue = UserValidationModel::returnCarpoolCommission($carpoolId);
            if (!$commissionValue) {
                $this->errors[] = 'Erreur lors de la récupération de la commission.';
            }

            // On vide les crédits en attente de l'utilisateur
            $updateUserPendingCredits = UserValidationModel::deletePendingCredits($userId, $carpoolId, $pendingCredits);
            if (!$updateUserPendingCredits) {
                $this->errors[] = 'Erreur lors de la suppression des credits en attente.';
            }

            // On ajoute les crédits au conducteur, en retirant la commission si nécessaire
            if ($commissionValue === 0) {

                $getCommission = UserValidationModel::adjustCredits(1, 2);  // On donne deux crédits de commission à l'admin
                if (!$getCommission) {
                    $this->errors[] = 'Erreur lors de la récupération de la commission.';
                }

                $pendingCredits = $pendingCredits - 2;
                $updateCommission = UserValidationModel::updateCarpoolCommission($carpoolId);
                if (!$updateCommission) {
                    $this->errors[] = 'Erreur lors de la mise à jour de la commission.';
                }
            }

            $updateDriverCredits = UserValidationModel::adjustCredits($driverId, intval($pendingCredits));
            if (!$updateDriverCredits) {
                $this->errors[] = 'Erreur lors de l\'ajout des crédits au conducteur.';
            }

            if (empty($this->errors)) {
                $reviewForm = true;
                $this->success = 'Votre confirmation a bien été prise en compte.';
                return ['success' => $this->success, 'reviewForm' => $reviewForm];
            }

            $everyoneSatisfied = UserValidationModel::everyoneSatisfied($carpoolId);
            if ($everyoneSatisfied === 0) {
                UserCarpoolsModel::updateCarpoolStatus($carpoolId, 'Terminé');
            }
        } else {
            // Si l'utilisateur n'est pas satisfait :
            if (empty($this->errors)) {
                // On invite l'utilisateur à laisser un signalement qui sera traité par un employé
                $c = CarpoolDetailsModel::getCarpoolById($carpoolId);
                $u = UserModel::getUserById($userId);
                $d = UserModel::getUserById($driverId);

                $reportForm = true;
                require_once ROOT_PATH . 'src/Views/users/components/reportScreen.php';
                $this->success = 'Votre signalement a bien été envoyé. Nous reviendrons vers vous rapidement.';
                return ['success' => $this->success];
            }
        }

        // Retourner les erreurs s'il y en a
        if (!empty($this->errors)) {
            return ['errors' => $this->errors];
        }

        return false;
    }
}
