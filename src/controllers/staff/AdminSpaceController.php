<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'affichage de l'espace administrateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

namespace App\Controllers\staff;

use App\Controllers\BaseController;
use App\Controllers\users\subControllers\ProfileController;
use App\Models\users\UserModel;
use App\Models\staff\StaffModel;


class AdminSpaceController extends BaseController {

    protected Array $errors = [];
    protected string $success = '';

    // Fonction gérant l'affichage des infos admin
    public function adminSpaceArea() {

        $this->errors = [];
        $this->success = '';


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
                $this->errors[] = "certains champs sont vides.";
            }

            // On valide les champs
            if(UserModel::pseudoExists($pseudo)){
                $this->errors[] = "Le pseudo est déjà utilisé.";
            }
            if(UserModel::emailExists($email)){
                $this->errors[] = "L'email est déjà utilisé.";
            }
            if($password !== $confirmPassword){
                $this->errors[] = "Les mots de passe ne correspondent pas.";
            }
            if(empty($this->errors)){
                // S'il n'y a pas d'erreur, on crée le compte
                $newUserId = UserModel::create($pseudo, $email, $password, 0, 'STAFF');
                if($newUserId){
                    $success = "Le compte employé a été créé avec succès.";
                } else {
                    $this->errors[] = "Une erreur est survenue lors de la création du compte.";
                }
            }
        }

        // Si le formulaire de suspension/réactivation de compte est soumis
        if(isset($_POST['suspend-account'])){

            $accountId = intval($_POST['user-id']);
            if (!isset($accountId) || $accountId <= 1) {    // On interdit la suspension du compte admin
                $this->errors[] = "ID de compte invalide.";
            }

            $account = UserModel::getUserById($accountId);
            if (!$account) {
                $this->errors[] = "Compte introuvable.";
            }

            if (empty($this->errors)) {
                if ($account['is_suspended'] === 1) {
                    $action = StaffModel::reactivateAccount($accountId);
                    if ($action) {
                        $success = "Le compte a été réactivé avec succès.";
                    } else {
                        $this->errors[] = "Une erreur est survenue lors de la suspension du compte.";
                    }
                } else {
                    $action = StaffModel::suspendAccount($accountId);
                    if ($action) {
                        $success = "Le compte a été suspendu avec succès.";
                    } else {
                        $this->errors[] = "Une erreur est survenue lors de la suspension du compte.";
                    }
                }
            }

        }

        // On compte le nombre de covoiturage avec la commision récupérée
        $totalCredits = StaffModel::getFullCommission();
        if (!$totalCredits) {
            $this->errors[] = "Erreur lors de la récupération des crédits totaux.";
        } else {
            $totalCredits = $totalCredits * 2; // Chaque covoiturage rapporte 2 crédits à la plateforme
        }

        // On récupère les données pour les graphiques
        $carpoolsData = StaffModel::getCarpoolCountPerDay();
        if (!$carpoolsData) {
            $this->errors[] = "Erreur lors de la récupération des données des covoiturages.";
        }
        // On récupère les crédits gagnés par jour
        $creditsData = StaffModel::getCreditsPerDay();
        if (!$creditsData) {
            $this->errors[] = "Erreur lors de la récupération des données des crédits.";
        }


        // On simplifie les variables pour leur intégration dans la vue
        $errors = $this->errors;
        $success = $this->success;
        require_once ROOT_PATH . '/src/Views/staff/adminSpaceView.php';
    }
}