<?php


session_start();

// Inclusion et déclaration des contrôleurs
    // Header
require_once __DIR__ . '/../src/controllers/HeaderController.php';
$header = new HeaderController();

    // Connexion
require_once __DIR__ . '/../src/controllers/ConnectionController.php';
$connectionController = new ConnectionController();

    // Utilisateurs
require_once __DIR__ . '/../src/controllers/users/RegistrationController.php';
$registrationController = new RegistrationController();

require_once __DIR__ . '/../src/controllers/users/UserSpaceController.php';
$userSpaceController = new UserSpaceController();

require_once __DIR__ . '/../src/controllers/users/CarsController.php';
$carsController = new CarsController();

require_once __DIR__ . '/../src/controllers/users/SubmitCarpoolController.php';
$submitCarpoolController = new SubmitCarpoolController();

require_once __DIR__ . '/../src/controllers/users/SearchCarpoolsController.php';
$searchCarpoolsController = new SearchCarpoolsController();

require_once __DIR__ . '/../src/controllers/users/AllCarpoolsController.php';
$allCarpoolsController = new AllCarpoolsController();


    
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = '/studiecoride/public/';

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
    <?php
        $header->header();

        if ($uri == '/') { echo ''; }
        else if (strpos($uri, '/inscription') === 0) { $registrationController->registration(); }
        else if (strpos($uri, '/connexion') === 0) {  $connectionController->connection(); }
        else if (strpos($uri, '/mon-espace') === 0) { $userSpaceController->userSpaceArea(); }
        else if (strpos($uri, '/ajouter-un-vehicule') === 0) { $carsController->userCarsArea(); }
        else if (strpos($uri, '/proposer-un-covoiturage') === 0) { $submitCarpoolController->userCarpoolsArea(); }
        else if (strpos($uri, '/chercher-un-covoiturage') === 0) { $searchCarpoolsController->searchCarpoolsArea(); } // A FAIRE
        else if (strpos($uri, '/historique-des-covoiturages') === 0) { $allCarpoolsController->allCarpoolsArea(); } // A FAIRE

        // else if (strpos($uri, '/proposer-un-covoiturage') === 0) { $userSpaceController->userCarpoolsArea(); }
        else { echo '<h1>404 - Page non trouvée</h1>'; }

        // Ajout du footer
        // require __DIR__ . '/../src/views/footer.php';
    ?>
</body>
</html>
