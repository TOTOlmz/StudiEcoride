<?php 
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Contrôleur gérant la page d'accueil
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

class HomeController {
    public function homeArea() {
        require_once __DIR__ . '/../views/homeView.php';
    }
}