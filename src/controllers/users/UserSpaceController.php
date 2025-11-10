<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'affichage de l'espace personnel d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../../models/users/UserSpaceModel.php';

class UserSpaceController {

    // Foncion gérant l'affichage des infos utilisateur
    public function userInformationsArea() {

        if (isset($_POST['logout'])) {
            $this->logOut();
        }

        $errors = [];
        $success = '';
        $user = UserSpaceModel::getUserData($_SESSION['user_id']);
        $user['average'] = UserSpaceModel::getUserAverage($user['id']);
        $carpools = UserSpaceModel::getUserCarpools($user['id']);
        $cars = UserSpaceModel::getUserCars($user['id']);
        
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

        // Si on a un fichier uploadé, on lance la mise à jour de la photo
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploaded = $this->pictureUpdate($_FILES['photo'], $user['pseudo'], $user['id']);
            if (!$uploaded){
                $errors[] = 'Problème lors de l\'upload ( Appel de la fonction "pictureUpdate" ).';
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
            $uploadStatus = UserSpaceModel::updatePhoto($newName, $userId);
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

    // Fonction permettant la deconnexion
    private function logOut() {
        session_unset();
        session_destroy();
        header('Location: ./');
        exit;
    }
    

}