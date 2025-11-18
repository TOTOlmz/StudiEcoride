<?php 
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'affichage des notes
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../AccessController.php';

require_once __DIR__ . '/../../models/users/UserModel.php';
require_once __DIR__ . '/../../models/users/ReviewsModel.php';

class ReviewsController {
    
    public function reviewsArea() {

        $accessChecker = new AccessController();
        $accessChecker->checkAccess('USER');

        $errors = [];

        // On récupère les informations de l'utilisateur
        $user = UserModel::getUserById($_SESSION['user_id']);
        if ($user === false) {
            $errors[] = "Utilisateur non trouvé.";
        }
        
        // On récupère les avis laissés par l'utilisateur
        $reviewsLeft = ReviewsModel::getUserReviewsLeft($user['id']);
        if ($reviewsLeft === false) {
            $errors[] = "Erreur lors de la récupération des avis laissés.";
        }

        // On récupère les avis reçus par l'utilisateur
        $reviewsReceived = ReviewsModel::getUserReviewsReceived($user['id']);
        if ($reviewsReceived === false) {
            $errors[] = "Erreur lors de la récupération des avis reçus.";
        }

        // On récupère la note moyenne de l'utilisateur
        $average = ReviewsModel::getUserAverage($user['id']);
        if ($average === false) {
            $errors[] = "Erreur lors de la récupération de la note moyenne.";
        }
        $average = substr($average, 0, 3);

        // On appelle la vue
        require_once __DIR__ . '/../../views/users/reviewsView.php';
    }

}