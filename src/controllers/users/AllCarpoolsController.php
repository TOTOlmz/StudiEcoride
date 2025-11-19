<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'affichage de l'espace personnel d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../../models/users/UserModel.php';
require_once __DIR__ . '/../../models/users/CarsModel.php';
require_once __DIR__ . '/../../models/users/CarpoolsModel.php';
require_once __DIR__ . '/../../models/users/ParticipationModel.php';
require_once __DIR__ . '/../../models/users/ReviewsModel.php';

class AllCarpoolsController {

    function allCarpoolsArea() {
        


        $user = UserModel::getUserData($_SESSION['user_id']);
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
                echo '<p style="color:green;">Avis envoyé !</p>';
            } else {
                echo '<p style="color:red;">Erreur lors de l\'envoi de l\'avis.</p>';
            }
        }

        include __DIR__ . '/../../views/users/carpoolsView.php';
    }

}