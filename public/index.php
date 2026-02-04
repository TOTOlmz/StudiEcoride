<?php

declare(strict_types=1);
define('ROOT_PATH', __DIR__ . '/../');

require_once ROOT_PATH . '/vendor/autoload.php';
require_once ROOT_PATH . 'src/config/variables.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Initialiser le PDO (charge automatiquement variables.php)
\App\Models\BaseModel::initializePdo();

// Import des contrôleurs avec namespaces

use App\Controllers\BaseController;
use App\Controllers\HeaderController;
use App\Controllers\ContactController;
use App\Controllers\ConnectionController;
use App\Controllers\CarpoolSearchController;
use App\Controllers\CarpoolDetailsController;
use App\Controllers\users\RegistrationController;
use App\Controllers\users\UserSpaceController;
use App\Controllers\users\UserCarsController;
use App\Controllers\users\UserCarpoolController;
use App\Controllers\users\BookConfirmationController;
use App\Controllers\users\CarpoolsHistoryController;
use App\Controllers\users\ReviewsController;
use App\Controllers\staff\StaffSpaceController;
use App\Controllers\staff\AdminSpaceController;


// Instanciation des contrôleurs
$header = new HeaderController();

$baseController = new BaseController();
$contactController = new ContactController();
$registrationController = new RegistrationController();
$connectionController = new ConnectionController();
$userSpaceController = new UserSpaceController();
$userCarsController = new UserCarsController();
$userCarpoolController = new UserCarpoolController();
$carpoolSearchController = new CarpoolSearchController();
$carpoolDetailsController = new CarpoolDetailsController();
$bookConfirmationController = new BookConfirmationController();
$carpoolsHistoryController = new CarpoolsHistoryController();
$reviewsController = new ReviewsController();
$staffSpaceController = new StaffSpaceController();
$adminSpaceController = new AdminSpaceController();


    
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = '/ecoride/public/';

if (stripos($path, $base) === 0) {
    $uri = substr($path, strlen($base));
} else {
    $uri = $path;
}

$uri = '/'.ltrim($uri, '/'); // garantit un slash initial

// On gère la réécriture d'url avant de charger le contenu de la page
if (strpos($uri, '/connexion') === 0) { 
    $connectionController->connection();
} else if (strpos($uri, '/inscription') === 0) {
    $registrationController->registration();
} else if (strpos($uri, '/mon-espace') === 0 
        || strpos($uri, '/mes-avis') === 0
        || strpos($uri, '/ajouter-un-vehicule') === 0
        || strpos($uri, '/proposer-un-covoiturage') === 0
        || strpos($uri, '/confirmation-de-reservation') === 0
        || strpos($uri, '/historique-des-covoiturages') === 0
        ) {
    $baseController->checkAccess('USER');
} else if (strpos($uri, '/espace-staff') === 0 
        ) {
    $baseController->checkAccess('STAFF');
} else if (strpos($uri, '/espace-admin') === 0 
        ) {
    $baseController->checkAccess('ADMIN');
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/mainStyle.css">
    <link rel="stylesheet" href="assets/styles/headerStyle.css">
    <link rel="stylesheet" href="assets/styles/homeStyle.css">
    <link rel="stylesheet" href="assets/styles/carpoolStyle.css">
    <link rel="stylesheet" href="assets/styles/userProfileStyle.css">
    <link rel="stylesheet" href="assets/styles/responsiveStyle.css">
    <title>Ecoride</title>
</head>
<body>
    <?php 
        // appel du header
        $header->header(); 
    ?>

    <div class="main">
        <?php
            // On appelle la vue en fonction de l'URI (les réécritures ont déjà été appellées)
            if ($uri == '/') { include ROOT_PATH . '/src/views/homeView.php'; }
            else if (strpos($uri, '/nous-contacter') === 0) { $contactController->contact(); }
            else if (strpos($uri, '/legal') === 0) { include ROOT_PATH . '/src/views/legalView.php'; }
            else if (strpos($uri, '/inscription') === 0) { $registrationController->displayView(); }
            else if (strpos($uri, '/connexion') === 0) {  $connectionController->displayView(); }
            else if (strpos($uri, '/mon-espace') === 0) { $userSpaceController->userSpaceArea(); }
            else if (strpos($uri, '/mes-avis') === 0) { $reviewsController->reviewsArea(); }
            else if (strpos($uri, '/ajouter-un-vehicule') === 0) { $userCarsController->userCarsArea(); }
            else if (strpos($uri, '/proposer-un-covoiturage') === 0) { $userCarpoolController->userCarpoolArea(); }
            else if (strpos($uri, '/chercher-un-covoiturage') === 0) { $carpoolSearchController->carpoolSearchArea(); } 
            else if (strpos($uri, '/details-du-covoiturage') === 0) { $carpoolDetailsController->carpoolDetailsArea(); }
            else if (strpos($uri, '/confirmation-de-reservation') === 0) { $bookConfirmationController->bookConfirmationArea(); }
            else if (strpos($uri, '/historique-des-covoiturages') === 0) { $carpoolsHistoryController->CarpoolsHistoryArea(); }
            else if (strpos($uri, '/espace-staff') === 0) { $staffSpaceController->staffSpaceArea(); }
            else if (strpos($uri, '/espace-admin') === 0) { $adminSpaceController->adminSpaceArea(); }
            else if (strpos($uri, '/suspendu') === 0) { include ROOT_PATH . '/src/views/suspendedView.php'; }

            else { include ROOT_PATH . '/src/views/lostView.php'; } // Dans tous les autres cas, page 404
        ?>
    </div>
    <?php
        // Ajout du footer
        require ROOT_PATH . 'src/views/footerView.php';
    ?>
</body>
</html>
