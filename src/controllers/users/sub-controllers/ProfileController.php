<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant le profil utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../../../models/users/UserProfileModel.php';
require_once __DIR__ . '/../../../models/users/UserModel.php';

class ProfileController {


    // Foncion permettant la déconnexion
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ./');
        exit;
    }

    // Foncion mettant la photo de profil à jour dans la bdd
    public function updatePhoto($file, $userId) {
        $errors = [];

        // Si on a un fichier uploadé, on lance la mise à jour de la photo
        if ($file['error'] === UPLOAD_ERR_OK) {

            // On récupère le pseeudo de l'utilisateur
            $user = UserModel::getUserById($userId);
            $userPseudo = $user['pseudo'];

            $uploadDir = '../src/assets/images/users/';     // On définit le dossier de destination
            $tmpName = $file['tmp_name'];                   // évite le problème de mise en cache
            $fileName = basename($file['name']);            // On récupère le nom du fichier, puis l'extension
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $success = false;

            // On vérifie que c’est bien une image
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($fileExt, $allowed)) {
                $errors[] = 'Format de fichier non autorisé.';
            }

            // On renomme le fichier et le chemin de stockage
            $newName = $userPseudo . '.' . $fileExt;
            $destination = $uploadDir . $newName;

            // On essaye de déposer le fichier dans le dossier
            $photoUpload = move_uploaded_file($tmpName, $destination);

            // Si ca réussit :
            if ($photoUpload) {

                // On met à jour la BDD
                $updateStatus = UserProfileModel::updatePhoto($newName, $userId);
                if ($updateStatus) {
                    $success = true;
                } else {
                    $errors[] = 'Erreur lors de la mise à jour en base de données.';
                }

            } else {
                $errors[] = 'Erreur lors du dépôt du fichier.';
                $success = false;
            }

            return ['errors' => $errors, 'success' => $success];

        }

    }


    public function getUserData($userId) {
        // Logique de mise à jour du profil
        $errors = [];
        $success = true;
        
        $user = UserModel::getUserById($userId);
        $user['average'] = UserProfileModel::getUserAverage($userId);
        
        // Validation des données
        if (empty($user)) {
            $errors[] = 'Echec lors de la récupération des infos.';
        }
        
        return $user;
    }

}