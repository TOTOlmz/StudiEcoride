<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'historique des covoiturages
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers\users;

use App\Controllers\AccessController;

use App\Controllers\users\subControllers\ValidateCarpoolController;
use App\Controllers\users\subControllers\ReportCarpoolController;
use App\models\users\UserModel;
use App\models\users\ReviewsModel;
use App\models\users\UserCarpoolsModel;

class CarpoolsHistoryController {
    
    public function carpoolsHistoryArea() {


        $errors = [];
        $success = '';

        $accessChecker = new AccessController();
        $accessChecker->checkAccess('USER');


        $user = UserModel::getUserById($_SESSION['user_id']);
        $carpools = UserCarpoolsModel::getCarpoolsByUserId($user['id']);


         // On récupère les covoiturages actifs de l'utilisateur
        $activeCarpools = [];
        $historyCarpools = [];
        foreach ($carpools as $carpool) {
            if (strtolower($carpool['status']) !== 'terminé' && strtolower($carpool['status']) !== 'a valider') {
                $activeCarpools[] = $carpool;
            } else {
                $historyCarpools[] = $carpool;
            }
        }


        // Traitement du formulaire d'avis
        if (isset($_POST['leave-review'])) {
            $carpoolId = intval($_POST['carpool_id']);
            $driverId = intval($_POST['driver_id']);
            $rate = intval($_POST['rate']);
            $commentary = isset($_POST['commentary']) ? trim($_POST['commentary']) : '';

            // Appel de la fonction pour ajouter l'avis
            $result = ReviewsModel::addReview($user['id'], $carpoolId, $driverId, $rate, $commentary);
            if ($result) {
                $success = 'Avis envoyé !';
            } else {
                $errors[] = 'Erreur lors de l\'envoi de l\'avis.';
            }
        }

        // Si le bouton confirmer est cliqué
        // On appelle la fonction de confirmation de fin de covoiturage
        if ((isset($_POST['validate-carpool-0']) || isset($_POST['validate-carpool-1'])) && isset($_POST['carpool-id']) && isset($_POST['user-id'])) {
            $isSatisfied = isset($_POST['validate-carpool-1']) ? 1 : 0;
            $validateCarpoolController = new ValidateCarpoolController();
            $result = $validateCarpoolController->confirmCarpoolEnd($_POST['user-id'], $_POST['carpool-id'], $_POST['driver-id'], $isSatisfied);   
            
            // Gestion du résultat
            if ($result && isset($result['success'])) {
                $success = $result['success'];
            } elseif ($result && isset($result['errors'])) {
                $errors = array_merge($errors, $result['errors']);
            }
        }

        // Si un signalement est fait (confirmation d'insatisfaction)
        // On appelle la fonction d'envoi de signalement
        if (isset($_POST['report']) && isset($_POST['subject']) && isset($_POST['description'])) {
            $reportsCarpoolController = new ReportCarpoolController();
            $result = $reportsCarpoolController->sendReport($_POST);      
            
            // Gestion du résultat
            if ($result && isset($result['success'])) {
                $success = $result['success'];
            } elseif ($result && isset($result['errors'])) {
                $errors = array_merge($errors, $result['errors']);
            } else {
                $errors[] = 'Erreur lors de l\'envoi du signalement.';
            }
        }

        // On récupère les avis
        $reviewsLeft = ReviewsModel::getUserReviewsLeft($user['id']);
        $reviewsReceived = ReviewsModel::getUserReviewsReceived($user['id']);

        include __DIR__ . '/../../views/users/carpoolsHistoryView.php';
    }
}
