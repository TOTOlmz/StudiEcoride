<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant le profil utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers\users\subControllers;

use App\Controllers\BaseController;
use App\models\users\UserProfileModel;
use App\models\users\UserModel;

class ProfileController extends BaseController {

    protected Array $errors = [];
    protected bool $success = false;


    // Foncion mettant la photo de profil à jour dans la bdd
    public function updatePhoto($file, $userId) {
        

        // Si on a un fichier uploadé, on lance la mise à jour de la photo
        if ($file['error'] === UPLOAD_ERR_OK) {

            // On récupère le pseudo de l'utilisateur
            $user = UserModel::getUserById($userId);
            $userPseudo = $user['pseudo'];

            $uploadDir = './assets/images/users/';     // On définit le dossier de destination
            $tmpName = $file['tmp_name'];                   // évite le problème de mise en cache
            $fileName = basename($file['name']);            // On récupère le nom du fichier, puis l'extension
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $this->success = false;

            // On vérifie que c’est bien une image
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($fileExt, $allowed)) {
                $this->errors[] = 'Format de fichier non autorisé.';
            }

            // On renomme le fichier et le chemin de stockage
            $newName = strtolower($userPseudo . '.' . $fileExt);
            $destination = $uploadDir . $newName;

            // On essaye de déposer le fichier dans le dossier
            $photoUpload = move_uploaded_file($tmpName, $destination);

            // Si ca réussit :
            if ($photoUpload) {

                // On met à jour la BDD
                $updateStatus = UserProfileModel::updatePhoto($newName, $userId);
                if ($updateStatus) {
                    $this->success = true;
                } else {
                    $this->errors[] = 'Erreur lors de la mise à jour en base de données.';
                }

            } else {
                $this->errors[] = 'Erreur lors du dépôt du fichier.';
                $this->success = false;
            }

            return ['errors' => $this->errors, 'success' => $this->success];

        }

    }


    public function getUserData($userId) {
        // Logique de mise à jour du profil
        
        $user = UserModel::getUserById($userId);
        $user['average'] = UserProfileModel::getUserAverage($userId);
        
        // Validation des données
        if (empty($user)) {
            $this->errors[] = 'Echec lors de la récupération des infos.';
        }
        if (empty($this->errors)) {
            $this->success = true;
        }
        
        return $user;
    }

}