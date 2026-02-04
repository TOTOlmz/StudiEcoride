<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'historique des covoiturages
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers\users;


use App\Controllers\users\subControllers\ValidateCarpoolController;
use App\Controllers\users\subControllers\ReportCarpoolController;
use App\models\users\UserModel;
use App\models\users\ReviewsModel;
use App\models\users\UserCarpoolsModel;

class CarpoolsHistoryController {

    
    protected Array $errors = [];
    protected string $success = '';
    
    public function carpoolsHistoryArea() {



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
                $this->success = 'Avis envoyé !';
            } else {
                $this->errors[] = 'Erreur lors de l\'envoi de l\'avis.';
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
                $this->success = $result['success'];
            } elseif ($result && isset($result['errors'])) {
                $this->errors = array_merge($this->errors, $result['this->errors']);
            }
        }

        // Si un signalement est fait (confirmation d'insatisfaction)
        // On appelle la fonction d'envoi de signalement
        if (isset($_POST['report']) && isset($_POST['subject']) && isset($_POST['description'])) {
            $reportsCarpoolController = new ReportCarpoolController();
            $result = $reportsCarpoolController->sendReport($_POST);      
            
            // Gestion du résultat
            if ($result && isset($result['success'])) {
                $this->success = $result['success'];
            } elseif ($result && isset($result['errors'])) {
                $this->errors = array_merge($this->errors, $result['errors']);
            } else {
                $this->errors[] = 'Erreur lors de l\'envoi du signalement.';
            }
        }

        // On récupère les avis
        $reviewsLeft = ReviewsModel::getUserReviewsLeft($user['id']);
        $reviewsReceived = ReviewsModel::getUserReviewsReceived($user['id']);

        $errors = $this->errors;
        $success = $this->success;
        include ROOT_PATH . 'src/views/users/carpoolsHistoryView.php';
    }
}
