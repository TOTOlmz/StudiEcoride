<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant la confirmation d'inscription
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../AccessController.php';

require_once __DIR__ . '/../../models/users/UserModel.php';
require_once __DIR__ . '/../../models/CarpoolDetailsModel.php';
require_once __DIR__ . '/../../models/users/UserBookingModel.php';

class BookConfirmationController {
    
    public function bookConfirmationArea() {

        $errors = [];
        $success = false;

        $accessChecker = new AccessController();
        $accessChecker->checkAccess('USER');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            require_once __DIR__ . '/../../views/users/participationConfirmationView.php';
            exit;
        }
        // On récupère l'id du covoiturage qui est passé en paramètre de l'URL
        $urlQuery = $_SERVER['QUERY_STRING'];
        $carpoolId = str_replace('c=', '', $urlQuery);
        if ($carpoolId == '') {
            $errors[] = 'Aucun covoiturage trouvé dans l\'url.';
        }

        // On récupère les valeurs du formulaire
        $seats = intval($_POST['seats']);
        $price = floatval($_POST['price']);
        $userId = intval($_POST['user-id']);
        $carpoolId = intval($carpoolId);
        $cost = $price * $seats;

        // On vérifie que toutes les valeurs sont renseignées
        if ($seats === 0 || $price === 0 || $userId === 0 || $carpoolId === 0) {
            $errors[] = 'Toutes les informations doivent être renseignées.';
        }

        $carpool = CarpoolDetailsModel::getCarpoolById($carpoolId);
        if (!$carpool) {
            $errors[] = 'Covoiturage introuvable.';
        }

        // On vérifie que le prix et le nombre de sièges n'ont pas changé pendant la soumission du formulaire
        if ($carpool['available_seats'] < $seats) {
            $errors[] = 'Le nombre de sièges disponibles a changé. Veuillez vérifier à nouveau.';
        }
        if ($carpool['price'] != $price) {
            $errors[] = 'Le prix du covoiturage a changé. Veuillez vérifier à nouveau.';
        }

        $user = UserModel::getUserById($userId);
        if (!$user) {
            $errors[] = 'Utilisateur introuvable.';
        }
        if ($cost > $user['credits']) {
            $errors[] = 'Crédits insuffisants pour confirmer la participation.';
        }

        // Si tout est bon, on enregistre la participation
        if (empty($errors)) {

            
            // On met à jour les crédits de l'utilisateur
            $userCreditsUpdated = UserBookingModel::adjustCredits($userId, -$cost);

            // On met à jour le nombre de sièges disponibles
            $carpoolSeatsUpdated = UserBookingModel::updateCarpoolSeats($carpoolId, -$seats);

            // On lie l'utilisateur au covoiturage et stocke les credits dans pending_credits
            $participation = 0;
            for ($participation; $participation < $seats; $participation++) {
                UserBookingModel::addPassenger($userId, $carpoolId, $price);
            }

            if ($userCreditsUpdated && $carpoolSeatsUpdated && $participation == $seats) {
                $success = true;
            } else {
                $errors[] = 'Une erreur est survenue lors de la confirmation de votre participation. Veuillez réessayer.';
            }
        }
        require_once __DIR__ . '/../../views/users/bookingConfirmationView.php';
    }
}