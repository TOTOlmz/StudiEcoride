<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant la connexion d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers;

use App\Models\ConnectionModel;



class ContactController extends BaseController {
    
    public function contact() {
    
        $errors = [];
        $success = '';
        
        if (isset($_POST['contact-form'])) {
            
            $from = $_POST['email'];
            $name = $_POST['name'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];

            if (!$from && !$name && !$subject && !$message) {
                $errors[] = "Tous les champs doivent être remplis.";
            }

            if (!empty($from)) { 
                $send = $this->sendEmailFromForm($from, $name, $subject, $message); 
                if ($send) {
                    $success = "Email envoyé avec succès.";
                } else {
                    $errors[] = "Erreur lors de l'envoi de l'email.";
                }
            }        
        }

        require_once __DIR__ . '/../views/contactView.php';

    }
}