<?php
// Récupérer les infos de .env.local et les utiliser pour se connecter à la bdd
$dbElements = [];

// D'abord, charger depuis .env.local
$path = __DIR__ . '/../../.env.local';
if(is_file($path) !== false){
    $file = file($path, FILE_SKIP_EMPTY_LINES && FILE_IGNORE_NEW_LINES);

    foreach($file as $line){
        if(strpos($line, '#') !== false){
            continue;
        }
        
        if(strpos($line, '=') !== false){
            $parts = explode('=', $line, 2);
            $key = trim($parts[0]);
            $value = trim($parts[1]);
            $dbElements[$key] = $value;
        }
    }
}

// Ensuite, les variables d'environnement écrasent les valeurs de .env.local (pour Docker)
$envVars = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'DB_CHARSET', 'DB_PORT'];
foreach($envVars as $var){
    $envValue = getenv($var);
    if($envValue !== false){
        $dbElements[$var] = $envValue;
    }
}

return $dbElements;
?>