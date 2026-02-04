<?php 
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Contrôleur gérant la page d'accueil
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

class HomeController {
    public function homeArea() {
        require_once ROOT_PATH . 'src/Views/homeView.php';
    }
}