<?php
// Fichier permettant de récupérer les infos de .env.local et de les utiliser pour se connecter à la bdd
$path = __DIR__ . '/../../.env.local';
$file = '';
$dbElements = [];
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
    return $dbElements;
}

?>