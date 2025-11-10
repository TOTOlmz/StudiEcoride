<?php

require_once __DIR__ . '/db.php';

$pdo = new PDO('mysql:host=' . $dbElements['DB_HOST'] . ';dbname=' . $dbElements['DB_NAME'] . ';charset=utf8', $dbElements['DB_USER'], $dbElements['DB_PASS']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>