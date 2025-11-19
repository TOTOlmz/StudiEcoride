<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'ajout d'un véhicule
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../../models/users/UserModel.php';
require_once __DIR__ . '/../../models/users/CarsModel.php';

class CarsController {

    // Foncion gérant l'affichage des infos utilisateur
    public function userCarsArea() {

        $errors = [];
        $success = '';

        $user = UserModel::getUserData($_SESSION['user_id']);
        $cars = CarsModel::getUserCars($user['id']);

        // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // On crécupère toutes les infos
            $brand = trim($_POST['brand'] ?? '');
            $model = trim($_POST['model'] ?? '');
            $color = trim($_POST['color'] ?? '');
            $energy = trim($_POST['energy'] ?? '');
            $plateNumber = trim($_POST['plate-number'] ?? '');
            $firstRegistration = trim($_POST['first-registration'] ?? '');
            $driverId = trim($_POST['driver-id'] ?? '');

            // On essaye de formation la plaque d'immatriculation au format AA-000-BB
            if(strlen($plateNumber) > 9) {
                $errors[] = 'Le numéro d\'immatriculation est trop long.';
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
                        $errors[] = 'Le format de la plaque d\'immatriculation est invalide.';
                    }
                }
            }

            if(empty($errors)) {

                // On appelle la fonction d'ajout de véhicule
                $newCar = $this->addCar($brand, $model, $color, $energy, $plateNumber, $firstRegistration, $driverId, $errors);
                if ($newCar) {
                    $success = 'Véhicule ajouté avec succès.';
                } else {
                    $errors[] = 'Erreur lors de l\'ajout du véhicule.';
                    var_dump($newCar);
                }
            }
        }

        require_once __DIR__ . '/../../views/users/carsView.php';
    }


    // Fonction gérant l'ajout d'un véhicule
    private function addCar($brand, $model, $color, $energy, $plateNumber, $firstRegistration, $driverId, $errors) {
        
        $addCar = false;

        // On vérifie qu'aucun champ n'est vide :
        if (empty($brand) || empty($model) || empty($color) || empty($energy) || empty($plateNumber) || empty($firstRegistration) || empty($driverId)) {
            $errors[] = 'Tous les champs doivent être renseignés.';
        }

        // On vérifie que l'id du conducteur est correct 
        if ($driverId !== $_SESSION['user_id']) {
            $errors[] = 'L\'id du conducteur ne correspond pas au compte.'; 
        }

        // On vérifie que le type de moteur correspond aux options de la liste
        if (strtolower($energy) !== 'essence' && strtolower($energy) !== 'diesel' && strtolower($energy) !== 'hybride' && strtolower($energy) !== 'electrique') {
            $errors[] = 'Le type de moteur sélectionné est invalide.';
        }

        // S'il n'y a pas d'erreurs, on ajoute le véhicule
        if (empty($errrors)) {
            $addCar = CarsModel::addUserCar($brand, $model, $color, $energy, $plateNumber, $firstRegistration, $driverId);
        }
        return $addCar && $errors;
    }
}
