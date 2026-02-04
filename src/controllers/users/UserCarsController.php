<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'ajout d'un véhicule
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers\users;

use App\Controllers\subControllers\TimeLogicsController;

use App\models\users\UserModel;
use App\models\users\CarsModel;

class UserCarsController {

    protected Array $errors = [];
    protected string $success = '';

    // Fonction gérant l'affichage des infos de véhicules d'un utilisateur
    public function usercarsArea() {


        // Si le formulaire est soumis
        if (isset($_POST['adding-car-btn'])) {
            // On récupère toutes les infos
            $brand = trim($_POST['brand'] ?? '');
            $model = trim($_POST['model'] ?? '');
            $color = trim($_POST['color'] ?? '');
            $energy = trim($_POST['energy'] ?? '');
            $plateNumber = trim($_POST['plate-number'] ?? '');
            $firstRegistration = trim($_POST['first-registration'] ?? '');
            $driverId = trim($_POST['driver-id'] ?? '');

            // On valide les infos
            if (empty($brand) || empty($model) || empty($color) || empty($energy) || empty($plateNumber) || empty($firstRegistration) || empty($driverId)) {
                $this->errors[] = "Tous les champs sont obligatoires.";
            }

            // On essaye de formatter la plaque d'immatriculation (au format AA-000-BB)
            if(strlen($plateNumber) > 9) {
                $this->errors[] = 'Le numéro d\'immatriculation est trop long.';
            } else {
                $plateArray = str_split($plateNumber, 1);
                if (count($plateArray) === 7) {
                    if (ctype_alpha($plateArray[0]) && ctype_alpha($plateArray[1])
                        && ctype_digit($plateArray[2]) && ctype_digit($plateArray[3]) && ctype_digit($plateArray[4])
                        && ctype_alpha($plateArray[5]) && ctype_alpha($plateArray[6])) {

                            $firstLetters = $plateArray[0] . $plateArray[1];
                            $numbers = $plateArray[2] . $plateArray[3] . $plateArray[4];
                            $lastLetters = $plateArray[5] . $plateArray[6];

                            $plateNumber = strtoupper($firstLetters) . '-' . $numbers . '-' . strtoupper($lastLetters);
                    } else {
                        $this->errors[] = 'Le format de la plaque d\'immatriculation est invalide. Merci de respecter le format AA-000-BB.';
                    }
                } elseif ($plateArray[2] === '-' && $plateArray[5] === '-' && count($plateArray) === 9) {
                    if (ctype_alpha($plateArray[0]) && ctype_alpha($plateArray[1])
                        && ctype_digit($plateArray[3]) && ctype_digit($plateArray[4]) && ctype_digit($plateArray[6])
                        && ctype_alpha($plateArray[7]) && ctype_alpha($plateArray[8])) {

                            $firstLetters = $plateArray[0] . $plateArray[1];
                            $numbers = $plateArray[3] . $plateArray[4] . $plateArray[6];
                            $lastLetters = $plateArray[7] . $plateArray[8];

                            $plateNumber = strtoupper($firstLetters) . '-' . $numbers . '-' . strtoupper($lastLetters);
                    } else {
                        $this->errors[] = 'Le format de la plaque d\'immatriculation est invalide. Merci de respecter le format AA-000-BB.';
                    }
                } else {
                    $this->errors[] = 'Le format de la plaque d\'immatriculation est invalide. Merci de respecter le format AA-000-BB.';
                }
            }

            // Si pas d'erreurs, on ajoute le véhicule
            if (empty($this->errors)) {
                $result = CarsModel::addUserCar($brand, $model, $color, $energy, $plateNumber, $firstRegistration, $driverId);
                if ($result) {
                    $this->success = "Véhicule ajouté avec succès.";
                } else {
                    $this->errors[] = "Erreur lors de l'ajout du véhicule.";
                }
            }
        }

        // On récupère les informations de l'utilisateur
        $user = UserModel::getUserById($_SESSION['user_id']);
        if ($user === false) {
            $this->errors[] = "Utilisateur non trouvé.";
        }

        // On récupère les véhicules de l'utilisateur
        $cars = CarsModel::getUserCars($user['id']);
        if ($cars === false) {
            $this->errors[] = "Erreur lors de la récupération des véhicules.";
        }

        // On formate la date de première immatriculation
        $formatting = new TimeLogicsController();
        foreach ($cars as &$car) {
            $car['first_registration'] = $formatting->dateFormatting($car['first_registration']);
        }
        unset($car); // On se débarasse de la référence 
        
        // On appelle la vue
        $errors = $this->errors;
        $success = $this->success;
        require_once ROOT_PATH . 'src/views/users/userCarsView.php';

    }
}