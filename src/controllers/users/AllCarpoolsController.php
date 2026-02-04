<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant le listing des covoiturages
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers\users;

use App\models\users\UserModel;
use App\models\users\CarpoolsModel;
use App\models\users\ReviewsModel;

class AllCarpoolsController {

    
    protected Array $errors = [];
    protected string $success = '';

    function allCarpoolsArea() {
        


        $user = UserModel::getUserById($_SESSION['user_id']);
        $reviewsLeft = ReviewsModel::getUserReviewsLeft($user['id']);
        $carpools = CarpoolsModel::getUserCarpools($user['id']);


         // On récupère les covoiturages actifs de l'utilisateur
        $activeCarpools = [];
        $historyCarpools = [];
        foreach ($carpools as $c) {
            if (strtolower($c['status']) !== 'terminé' && strtolower($c['status']) !== 'a valider') {
                $activeCarpools[] = $c;
            } else {
                $historyCarpools[] = $c;
            }
        }


        // Traitement du formulaire d'avis
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['leave-review'])) {
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

        $errors = $this->errors;
        $success = $this->success;
        include ROOT_PATH . 'src/views/users/carpoolsView.php';
    }

}