<?php


require_once __DIR__ . '/../src/controllers/HeaderController.php';
require_once __DIR__ . '/../src/controllers/users/UserRegistrationController.php';
require_once __DIR__ . '/../src/controllers/ConnectionController.php';
require_once __DIR__ . '/../src/controllers/users/UserSpaceController.php';

$header = new HeaderController();
$userRegistrationController = new UserRegistrationController();
$connectionController = new ConnectionController();
$userSpaceController = new UserSpaceController();
    
$uri1 = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/studiEcoride/public', '', $uri1);

session_start();

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
        else if (strpos($uri, '/inscription') === 0) { $userRegistrationController->registration(); }
        else if (strpos($uri, '/connexion') === 0) {  $connectionController->connection(); }
        else if (strpos($uri, '/mon-espace') === 0) { $userSpaceController->userInformationsArea(); }
        else { echo '<h1>404 - Page non trouvée</h1>'; }

        // Ajout du footer
        require __DIR__ . '/../src/views/footer.php';
    ?>
</body>
</html>
