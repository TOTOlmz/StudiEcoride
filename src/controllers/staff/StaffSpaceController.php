<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'affichage de l'espace employé
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers\staff;

use App\Controllers\AccessController;
use App\Controllers\users\subControllers\ProfileController;
use App\models\users\ReviewsModel;
use App\models\ReportsModel;
use App\Controllers\subControllers\TimeLogicsController;

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
                $result = ReviewsModel::rejectReview($_POST['review-id']);
                if($result){
                    $success = "L'avis a été refusé avec succès.";
                } else {
                    $errors[] = "Une erreur est survenue lors du refus de l'avis.";
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

        require_once ROOT_PATH . '/src/views/staff/staffSpaceView.php';

    }

}