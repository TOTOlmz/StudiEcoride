<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'affichage de l'espace personnel d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers\users;

use App\Controllers\BaseController;
use App\Controllers\users\subControllers\ProfileController;
use App\Controllers\users\subControllers\UserCarpoolsController;
use App\Controllers\users\subControllers\ValidateCarpoolController;
use App\Controllers\users\subControllers\ReportCarpoolController;
use App\Models\users\UserModel;
use App\Models\users\CarsModel;
use App\Models\users\ReviewsModel;
use App\Models\users\UserCarpoolsModel;


class UserSpaceController extends BaseController{
    
    protected Array $errors = [];
    protected string $success = '';

    // Foncion gérant l'affichage des infos utilisateur
    public function userSpaceArea() {




        // Appel de la fonction de déconnexion
        if (isset($_POST['logout'])) {
            $this->logout();
        }

        // Appel de la fonction de mise à jour de la photo de profil
        if (isset($_FILES['photo'])) {
            $profileController = new ProfileController();
            $profileController->updatePhoto($_FILES['photo'], $_SESSION['user_id']);
        }

        // Si le bouton démarrer / Terminer est cliqué,
        // Appel de la fonction d'édition du statut d'un covoiturage
        if (isset($_POST['update-carpool']) && isset($_POST['carpool-id'])) {
            
            $carpoolsController = new UserCarpoolsController();

            // S'il n'y a pas de passagers, on met directement le covoiturage à "Terminé"
            if (isset($_POST['passengers']) && intval($_POST['passengers']) === 0) {
                $carpoolsController->updateCarpoolStatus(intval($_POST['carpool-id']), 'Terminé');
                return;
            } else {
                $carpoolsController->updateCarpoolStatus(intval($_POST['carpool-id']), htmlspecialchars($_POST['carpool-status']));
            }
        }

        // Si le bouton annuler est cliqué, on vérifie qui est le conducteur 
        // avant d'appeler la fonction d'édition du statut d'un covoiturage
        if (isset($_POST['leave-carpool']) && isset($_POST['carpool-id'])) {
            $leaveCarpoolController = new UserCarpoolsController();
            $results = $leaveCarpoolController->leaveCarpool(intval($_SESSION['user_id']), intval($_POST['carpool-id']));
            if (isset($results['errors'])) {
                $this->errors = array_merge($this->errors, $results['errors']);
            } else {
                $this->success = 'Covoiturage annulé avec succès';
            }
        }

        // Si le bouton confirmer est cliqué
        // On appelle la fonction de confirmation de fin de covoiturage
        if ((isset($_POST['validate-carpool-0']) || isset($_POST['validate-carpool-1'])) && isset($_POST['carpool-id']) && isset($_POST['user-id'])) {
            $isSatisfied = isset($_POST['validate-carpool-1']) ? 1 : 0;
            $validateCarpoolController = new ValidateCarpoolController();
            $validateCarpoolController->confirmCarpoolEnd($_POST['user-id'], $_POST['carpool-id'], $_POST['driver-id'], $isSatisfied);  
            if (isset($result['errors'])) {
                $this->errors = array_merge($this->errors, $result['errors']);
            } elseif (isset($result['success'])) {
                $this->success = $result['success'];
            }           
        }

        // Si un signalement est fait (confirmation d'insatisfaction)
        // On appelle la fonction d'envoi de signalement
        if (isset($_POST['report']) && isset($_POST['subject']) && isset($_POST['description'])) {
            $reportsCarpoolController = new ReportCarpoolController();
            $result = $reportsCarpoolController->sendReport($_POST);  
            if (isset($result['errors'])) {
                $this->errors = array_merge($this->errors, $result['errors']);
            } elseif (isset($result['success'])) {
                $this->success = $result['success'];
            }           
        }

        // Gestion de la suppression de véhicule
        if (isset($_POST['delete-car'])) {
            $carId = intval($_POST['car-id']);
            $deleteCar = CarsModel::deleteCar($carId);
            if ($deleteCar) {
                $this->success = 'Véhicule supprimé avec succès';
            } else {
                $this->errors[] = 'Erreur lors de la suppression du véhicule';
            } 
        }

        
        $user = UserModel::getUserById($_SESSION['user_id']);
        $user['avg'] = ReviewsModel::getUserAverage($user['id']);
        $carpools = UserCarpoolsModel::getCarpoolsByUserId($user['id']);
        $cars = CarsModel::getUserCars($user['id']);

        // On vérifie que l'on a bien récupérer les informations de l'utilisateur
        if (empty($user)) {
            $this->errors[] = 'Erreur lors de la récupération des informations utilisateur';
        }

        // On récupère les covoiturages actifs de l'utilisateur
        $activeCarpools = [];
        $historyCarpools = [];
        foreach ($carpools as $c) {
            if (strtolower($c['status']) !== 'terminé' && intval($c['user_confirmed']) === 0) {
                $activeCarpools[] = $c;
            } else {
                $historyCarpools[] = $c;
            }
        }

        // On s'assure qu'il y a au moins un avis pour faire la moyenne (et pour l'affichage)
        $averageRate = $user['avg'] !== null ? round($user['avg'], 2): null;

        $errors = $this->errors;
        $success = $this->success;
        require_once ROOT_PATH . '/src/Views/users/userSpaceView.php';
    }

}
?>
