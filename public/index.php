<?php


session_start();

// Inclusion et déclaration des contrôleurs
    // Header
require_once __DIR__ . '/../src/controllers/HeaderController.php';
$header = new HeaderController();

    // Contact
require_once __DIR__ . '/../src/controllers/ContactController.php';
$contactController = new ContactController();

    // Inscription
require_once __DIR__ . '/../src/controllers/users/RegistrationController.php';
$registrationController = new RegistrationController();

    // Connexion
require_once __DIR__ . '/../src/controllers/ConnectionController.php';
$connectionController = new ConnectionController();

    // Espace utilisateur
require_once __DIR__ . '/../src/controllers/users/UserSpaceController.php';
$userSpaceController = new UserSpaceController();

    // Ajout d'un véhicule
require_once __DIR__ . '/../src/controllers/users/UserCarsController.php';
$userCarsController = new UserCarsController();

    // Ajout d'un covoiturage
require_once __DIR__ . '/../src/controllers/users/UserCarpoolController.php';
$userCarpoolController = new UserCarpoolController();

    // Recherche de covoiturage
require_once __DIR__ . '/../src/controllers/CarpoolSearchController.php';
$carpoolSearchController = new CarpoolSearchController();

    // Détails d'un covoiturage
require_once __DIR__ . '/../src/controllers/CarpoolDetailsController.php';
$carpoolDetailsController = new CarpoolDetailsController();

    // Confirmation de réservation
require_once __DIR__ . '/../src/controllers/users/BookConfirmationController.php';
$bookConfirmationController = new BookConfirmationController();

    // Historique des covoiturages
require_once __DIR__ . '/../src/controllers/users/CarpoolsHistoryController.php';
$carpoolsHistoryController = new CarpoolsHistoryController();

    // Liste des avis utilisateur
require_once __DIR__ . '/../src/controllers/users/ReviewsController.php';
$reviewsController = new ReviewsController();

    // Espace staff
require_once __DIR__ . '/../src/controllers/staff/StaffSpaceController.php';
$staffSpaceController = new StaffSpaceController();

    // Espace admin
require_once __DIR__ . '/../src/controllers/staff/AdminSpaceController.php';
$adminSpaceController = new AdminSpaceController();


    
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = '/ecoride/public/';

if (stripos($path, $base) === 0) {
    $uri = substr($path, strlen($base));
} else {
    $uri = $path;
}
$uri = '/'.ltrim($uri, '/'); // garantit un slash initial

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Ecoride</title>
</head>
<body>
    <?php $header->header(); ?>

    <div class="main">
        <?php
            if ($uri == '/') { include __DIR__ . '/../src/views/homeView.php'; }
            else if (strpos($uri, '/nous-contacter') === 0) { $contactController->contact(); }
            else if (strpos($uri, '/legal') === 0) { include __DIR__ . '/../src/views/legalView.php'; }
            else if (strpos($uri, '/inscription') === 0) { $registrationController->registration(); }
            else if (strpos($uri, '/connexion') === 0) {  $connectionController->connection(); }
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
            else if (strpos($uri, '/suspendu') === 0) { echo '<h1 style="margin:15px;">Votre compte est suspendu, vous ne pouvez plus l\'utiliser pour l\'instant</h1>'; }
            
            else { echo '<h1 style="margin:15px;">404 - Page non trouvée</h1>'; }
        ?>
    </div>
    <?php
        // Ajout du footer
        require __DIR__ . '/../src/views/footerView.php';
    ?>
</body>
</html>
