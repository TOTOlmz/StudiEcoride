<?php


require_once __DIR__ . '/../src/controllers/HeaderController.php';
require_once __DIR__ . '/../src/controllers/users/UserRegistrationController.php';
require_once __DIR__ . '/../src/controllers/ConnectionController.php';

$header = new HeaderController();
$userRegistrationController = new UserRegistrationController();
$connectionController = new ConnectionController();
    
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
        else if ($uri == '/inscription') { $userRegistrationController->registration(); }
        else if ($uri == '/connexion') {  $connectionController->connection(); }

        // Ajout du footer
        require __DIR__ . '/../src/views/footer.php';
    ?>
</body>
</html>
