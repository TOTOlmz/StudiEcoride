<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'affichage de l'espace personnel d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../../models/users/UserModel.php';
require_once __DIR__ . '/../../models/users/CarsModel.php';
require_once __DIR__ . '/../../models/users/CarpoolsModel.php';
require_once __DIR__ . '/../../models/users/ParticipationModel.php';
require_once __DIR__ . '/../../models/users/ReviewsModel.php';

class UserSpaceController {

    // Foncion gérant l'affichage des infos utilisateur
    public function userSpaceArea() {

        $errors = [];
        $success = '';
        $user = UserModel::getUserData($_SESSION['user_id']);
        $user['average'] = ReviewsModel::getUserAverage($user['id']);
        $carpools = CarpoolsModel::getUserCarpools($user['id']);
        $cars = CarsModel::getUserCars($user['id']);

        // Appel de la fonction de déconnexion
        if (isset($_POST['logout'])) {
            $this->logOut();
        }

        // Si on a un fichier uploadé, on lance la mise à jour de la photo
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploaded = $this->pictureUpdate($_FILES['photo'], $user['pseudo'], $user['id']);
            if (!$uploaded){
                $errors[] = 'Problème lors de l\'upload ( Appel de la fonction "pictureUpdate" ).';
            }
        }

        // Si le bouton démarrer / Terminer est cliqué,
        // on appelle la fonction d'édition du statut d'un covoiturage
        if (isset($_POST['update-carpool']) && isset($_POST['carpool_id'])) {
            $this->updateCarpoolStatus(intval($_POST['carpool_id']), htmlspecialchars($_POST['carpool-status']));
        }

        // Si le bouton annuler est cliqué, on vérifie qui est le conducteur 
        // avant d'appeler la fonction d'édition du statut d'un covoiturage
        if (isset($_POST['leave-carpool']) && isset($_POST['carpool_id'])) {
            $carpoolId = intval($_POST['carpool_id']);
            $carpoolDriver = 0;
            $this->leaveCarpool($user, $carpools, $carpoolId);
            
        }
        
        
        // On s'assure qu'il y a au moins un avis pour faire la moyenne (et pour l'affichage)
        if ($user['average']['nbReviews'] > 0) {
            $averageRate = round($user['average']['average'], 2);
        } else {
            $averageRate = NULL;
        }

        // On vérifie que l'on a bien récupérer les informations de l'utilisateur
        if (empty($user)) {
            $errors[] = 'Erreur lors de la récupération des informations utilisateur';
        }


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

        // Si pas d'erreurs, on affiche la vue
        require_once __DIR__ . '/../../views/users/userSpaceView.php';
    }




    // Fonction gérant la mise à jour de la photo de profil
    private function pictureUpdate($file, $userPseudo, $userId) {
        $uploadDir = '../src/assets/images/users/';
        $tmpName = $file['tmp_name']; // évite le problème de mise en cache
        $fileName = basename($file['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $updateSuccess = false;
        // On vérifie que c’est bien une image
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($fileExt, $allowed)) {
            return('Format de fichier non autorisé.');
        }

        // On renomme le fichier et le chemin de stockage
        $newName = $userPseudo . '.' . $fileExt;
        $destination = $uploadDir . $newName;

        // Si le dépot du fichier dans le dossier à marché
        if (move_uploaded_file($tmpName, $destination)) {

            // On met à jour la BDD
            $uploadStatus = UserModel::updatePhoto($newName, $userId);
            if ($uploadStatus) {
                echo 'Erreur lors de la mise à jour en base de données.';
            } else {
                $updateSuccess = true;
            }

        } else {
            echo 'Erreur lors du dépôt du fichier.';
            $updateSuccess = false;
        }

        return $updateSuccess;

    }


    // Fonction permettant de mettre à jour le statut d'un covoiturage
    private function updateCarpoolStatus($carpoolId, $CarpoolStatus) {
        $updateStatus = CarpoolsModel::updateCarpoolStatus($carpoolId, $CarpoolStatus);
        return $updateStatus;
    }

    // Fonction permettant de mettre à jour les participants à un covoiturage
    private function leaveCarpool($user, $carpools, $carpoolId) {

        $carpoolDriver = 0;
        // On cherche le conducteur du covoiturage
        foreach ($carpools as $c) {
            if ($c['id'] == $carpoolId) {
                $carpoolDriver = $c['driver_id'];
            }
        }
        // On récupère tous les passagers
        $passengers = ParticipationModel::listPassengers($carpoolId);

        // Si la personne annulant est le conducteur
        if ($carpoolDriver == $user['id']) {
            
            // On crédite et informe chaque passager ... (!A FAIRE!) Gestion email
            foreach ($passengers as $p) {
                UserModel::adjustCredits($p['user_id'], $p['pending_credits']);
                ParticipationModel::leaveCarpool($p['user_id'], $carpoolId);
                /*
                if (!empty($user['email'])) {
                    $to = $user['email'];
                    $subject = "Annulation du covoiturage";
                    $content = "Bonjour,<br>Le conducteur a annulé le covoiturage auquel vous participiez. Vos crédits ont été remboursés.";
                    sendEmailToUser($to, $subject, $content);
                }
                */
            }
            // ...Avant de supprimer le covoiturage
            CarpoolsModel::deleteCarpool($carpoolId);

        } else {
            // Si la personne annulant est un passager
            foreach ($passengers as $p) {
                if($p['user_id'] === $user['id']) {

                    UserModel::adjustCredits($user['id'], $p['pending_credits']); // On réajuste les crédits
                    CarpoolsModel::updateCarpoolSeats($carpoolId, -1); // On réajuste le nombre de sièges disponibles
                    ParticipationModel::leaveCarpool($user['id'], $carpoolId);

                }
            }
        }
    }

    /*
    function sendEmailToUser($to, $subject, $message, $from = 'ecoride-studi@proton.me') {
        // Headers pour HTML et encodage
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: EcoRide <{$from}>\r\n";
        $headers .= "Reply-To: {$from}\r\n";

        // Envoi de l'email
        return mail($to, $subject, $message, $headers);
    }
    */
    
    // Fonction permettant la deconnexion
    private function logOut() {
        session_unset();
        session_destroy();
        header('Location: ./');
        exit;
    }
    

}