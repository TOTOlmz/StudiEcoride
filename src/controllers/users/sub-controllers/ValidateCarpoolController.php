<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant le les covoiturages
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../../../models/users/UserValidationModel.php';
require_once __DIR__ . '/../../../models/CarpoolDetailsModel.php';
require_once __DIR__ . '/../../../models/users/UserModel.php';
require_once __DIR__ . '/../../../models/ReportsModel.php';

class ValidateCarpoolController {

    // Fonction permettant de confirmer la fin d'un covoiturage
    function confirmCarpoolEnd($userId, $carpoolId, $driverId, $isSatisfied) {
        $errors = [];

        // Si l'utilisateur est satisfait
        if ($isSatisfied === 1) {

            // On met à jour la confirmation de l'utilisateur
            $confirmationUpdate = UserValidationModel::confirmationUpdate($userId, $carpoolId);
            if (!$confirmationUpdate) {
                $errors[] = 'Erreur lors de la mise à jour de la confirmation.';
            }

            // On met à jour la satisfaction de l'utilisateur
            $satisfactionUpdate = UserValidationModel::satisfactionUpdate($userId, $carpoolId);
            if (!$satisfactionUpdate) {
                $errors[] = 'Erreur lors de la mise à jour de la satisfaction.';
            }

            // On récupère les crédits en attente
            $pendingCredits = UserValidationModel::getPendingCredits($userId, $carpoolId);
            if (!$pendingCredits) {
                $errors[] = 'Erreur lors de la récupération des crédits.';
            }

            // On vérifie si la commission de la plateforme a déjà été prise
            $commissionValue = UserValidationModel::returnCarpoolCommission($carpoolId);
            if (!$commissionValue) {
                $errors[] = 'Erreur lors de la récupération de la commission.';
            }

            // On vide les crédits en attente de l'utilisateur
            $updateUserPendingCredits = UserValidationModel::deletePendingCredits($userId, $carpoolId, $pendingCredits);
            if (!$updateUserPendingCredits) {
                $errors[] = 'Erreur lors de la suppression des credits en attente.';
            }

            // On ajoute les crédits au conducteur, en retirant la commission si nécessaire
            if ($commissionValue === 0) {

                $getCommission = UserValidationModel::adjustCredits(1, 2);  // On donne eux crédits de comission à l'admin
                if (!$getCommission) {
                    $errors[] = 'Erreur lors de la récupération de la commission.';
                }

                $pendingCredits = $pendingCredits - 2;
                $updateCommission = UserValidationModel::updateCarpoolCommission($carpoolId);
                if (!$updateCommission) {
                    $errors[] = 'Erreur lors de la mise à jour de la commission.';
                }
            }

            $updateDriverCredits = UserValidationModel::adjustCredits($driverId, intval($pendingCredits));
            if (!$updateDriverCredits) {
                $errors[] = 'Erreur lors de l\'ajout des crédits au conducteur.';
            }

            if (empty($errors)) {
                $reviewForm = true;
                return ['success' => 'Votre confirmation a bien été prise en compte.', 'reviewForm' => $reviewForm];
            }

            $everyoneSatisfied = UserValidationModel::everyoneSatisfied($carpoolId);
            if ($everyoneSatisfied === 0) {
                UserCarpoolsModel::updateCarpoolStatus($carpoolId, 'Terminé');
            }
        } else {
            // Si l'utilisateur n'est pas satisfait :
            if (empty($errors)) {
                // On invite l'utilisateur à laisser un signalement qui sera traité par un employé
                $c = CarpoolDetailsModel::getCarpoolById($carpoolId);
                $u = UserModel::getUserById($userId);
                $d = UserModel::getUserById($driverId);

                $reportForm = true;
                require_once __DIR__ . '/../../../views/users/components/reportScreen.php';
                return ['success' => 'Votre signalement a bien été envoyé. Nous reviendrons vers vous rapidement.'];
            }
        }

        // Retourner les erreurs s'il y en a
        if (!empty($errors)) {
            return ['errors' => $errors];
        }

        return false;
    }
}
