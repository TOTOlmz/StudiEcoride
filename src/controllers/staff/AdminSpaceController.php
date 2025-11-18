<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'affichage de l'espace administrateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../AccessController.php';
require_once __DIR__ . '/../users/sub-controllers/ProfileController.php';
require_once __DIR__ . '/../../models/users/UserModel.php';
require_once __DIR__ . '/../../models/staff/StaffModel.php';

class AdminSpaceController {

    // Foncion gérant l'affichage des infos utilisateur
    public function adminSpaceArea() {

        $errors = [];
        $success = '';

        $accessChecker = new AccessController();
        $accessChecker->checkAccess('ADMIN');


        // Appel de la fonction de déconnexion
        if (isset($_POST['logout'])) {
            $profileController = new ProfileController();
            return $profileController->logout();
        }


        // Si le formulaire de création de compte est soumis
        if(isset($_POST['account-creation'])){
            $pseudo = trim($_POST['pseudo']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm-password'];

            if (!isset($pseudo) || !isset($pseudo) || !isset($email) || !isset($password) || !isset($confirmPassword)) {
                $errors[] = "certains champs sont vides.";
            }

            // On valide les champs
            if(UserModel::pseudoExists($pseudo)){
                $errors[] = "Le pseudo est déjà utilisé.";
            }
            if(UserModel::emailExists($email)){
                $errors[] = "L'email est déjà utilisé.";
            }
            if($password !== $confirmPassword){
                $errors[] = "Les mots de passe ne correspondent pas.";
            }
            if(empty($errors)){
                // S'il n'y a pas d'erreur, on crée le compte
                $newUserId = UserModel::create($pseudo, $email, $password, 0, 'STAFF');
                if($newUserId){
                    $success = "Le compte employé a été créé avec succès.";
                } else {
                    $errors[] = "Une erreur est survenue lors de la création du compte.";
                }
            }
        }

        // Si le formulaire de suspension/réactivation de compte est soumis
        if(isset($_POST['suspend-account'])){

            $accountId = intval($_POST['user-id']);
            if (!isset($accountId) || $accountId <= 1) {    // On interdit la suspension du compte admin
                $errors[] = "ID de compte invalide.";
            }

            $account = UserModel::getUserById($accountId);
            if (!$account) {
                $errors[] = "Compte introuvable.";
            }

            if (empty($errors)) {
                if ($account['is_suspended'] === 1) {
                    $action = StaffModel::reactivateAccount($accountId);
                    if ($action) {
                        $success = "Le compte a été réactivé avec succès.";
                    } else {
                        $errors[] = "Une erreur est survenue lors de la suspension du compte.";
                    }
                } else {
                    $action = StaffModel::suspendAccount($accountId);
                    if ($action) {
                        $success = "Le compte a été suspendu avec succès.";
                    } else {
                        $errors[] = "Une erreur est survenue lors de la suspension du compte.";
                    }
                }
            }

        }

        // On compte le nombre de covoiturage avec la commision récupérée
        $totalCredits = StaffModel::getFullCommission();
        if (!$totalCredits) {
            $errors[] = "Erreur lors de la récupération des crédits totaux.";
        } else {
            $totalCredits = $totalCredits * 2; // Chaque covoiturage rapporte 2 crédits à la plateforme
        }

        // On récupère les données pour les graphiques
        $carpoolsData = StaffModel::getCarpoolCountPerDay();
        if (!$carpoolsData) {
            $errors[] = "Erreur lors de la récupération des données des covoiturages.";
        }
        // On récupère les crédits gagnés par jour
        $creditsData = StaffModel::getCreditsPerDay();
        if (!$creditsData) {
            $errors[] = "Erreur lors de la récupération des données des crédits.";
        }

        require_once __DIR__ . '/../../views/staff/adminSpaceView.php';
    }
}