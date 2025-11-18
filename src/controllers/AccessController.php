<?php 
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controller gérant les accès aux pages
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../models/users/UserModel.php';


class AccessController {


    // Fonction vérifiant l'accès à l'espace utilisateur
    public function checkAccess($role) {
        if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== $role){
            header('Location: ./connexion');
            exit();
        } else {
            $this->checkSuspension($_SESSION['user_id']);
        }
    }

    // Fonction vérifiant l'état du compte utilisateur (suspendu ou pas)
    private function checkSuspension($userId) {
        $user = UserModel::getUserById($userId);
        if ($user && intval($user['is_suspended']) === 1) {
            session_unset();
            session_destroy();
            header('Location: ./suspendu');
            exit();
        }
    }
}