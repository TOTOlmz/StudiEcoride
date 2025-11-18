<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'affichage de l'espace employé
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../AccessController.php';
require_once __DIR__ . '/../users/sub-controllers/ProfileController.php';
require_once __DIR__ . '/../../models/users/ReviewsModel.php';
require_once __DIR__ . '/../../models/ReportsModel.php';
require_once __DIR__ . '/../sub-controllers/TimeLogicsController.php';

class StaffSpaceController {

    // Foncion gérant l'affichage des infos utilisateur
    public function staffSpaceArea() {

        $errors = [];
        $success = '';

        // On vérifie les autorisations
        $accessChecker = new AccessController();
        $accessChecker->checkAccess('STAFF');

        // Appel de la fonction de déconnexion
        if (isset($_POST['logout'])) {
            $profileController = new ProfileController();
            return $profileController->logout();
        }

        // Validation des avis
        if(isset($_POST['validate-review']) && isset($_POST['review-id'])){
                $result = ReviewsModel::validateReview($_POST['review-id']);
                if($result){
                    $success = "L'avis a été validé avec succès.";
                } else {
                    $errors[] = "Une erreur est survenue lors de la validation de l'avis.";
                }
        }

        // refus des avis
        if(isset($_POST['reject-review']) && isset($_POST['review-id'])){
                $result = ReviewsModel::deleteReview($_POST['review-id']);
                if($result){
                    $success = "L'avis a été supprimé avec succès.";
                } else {
                    $errors[] = "Une erreur est survenue lors de la suppression de l'avis.";
                }
        }

        // Ouvrir un signalement
        if(isset($_POST['open-report']) && isset($_POST['report-id'])){
                $result = ReportsModel::openReport($_POST['report-id']);
                if($result){
                    $success = "Le signalement a été consulté avec succès.";
                } else {
                    $errors[] = "Une erreur est survenue lors de la l'activation de la consultation.";
                }
        }

        // Fermer un signalement
        if(isset($_POST['close-report']) && isset($_POST['report-id'])){
                $result = ReportsModel::closeReport($_POST['report-id']);
                if($result){
                    $success = "Le signalement a été refermé avec succès.";
                } else {
                    $errors[] = "Une erreur est survenue lors de la fermeture du signalement.";
                }
        }

        $pendingReviews = ReviewsModel::getPendingReviews();
        $pendingReports = ReportsModel::getPendingReports();
        $currentReports = ReportsModel::getCurrentReports();
        $closedReports = ReportsModel::getClosedReports();

        // Appel de la fonction de traitement de la date
        $timeLogicsController = new TimeLogicsController();

        for($i = 0; $i < count($pendingReports); $i++){
            $pendingReports[$i]['date-fr'] = $timeLogicsController->dateFormatting($pendingReports[$i]['date']);
            $pendingReports[$i]['departure_time'] = substr($pendingReports[$i]['departure_time'], 0, 5);
            $pendingReports[$i]['arrival_time'] = substr($pendingReports[$i]['arrival_time'], 0, 5);
        }
        for($i = 0; $i < count($currentReports); $i++){
            $currentReports[$i]['date-fr'] = $timeLogicsController->dateFormatting($currentReports[$i]['date']);
            $currentReports[$i]['departure_time'] = substr($currentReports[$i]['departure_time'], 0, 5);
            $currentReports[$i]['arrival_time'] = substr($currentReports[$i]['arrival_time'], 0, 5);
        }

        require_once __DIR__ . '/../../views/staff/staffSpaceView.php';

    }

}