<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'affichage de l'entête
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

class HeaderController {
    
    public function header() {
        $connected = false;
        $staff = false;

        // On vérifie si une session est en cours
        if (isset($_SESSION['user_id'])) {
            $connected = true;
            // On vérifie si l'utilisateur est de l'entreprise
            if ($_SESSION['user_id'] !== 'USER') {
                $staff = true;
            }
        }

        // On charge la vue
        require __DIR__ . '/../views/headerView.php';
    }
}