<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant la page de contact
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers;


class ContactController extends BaseController {
    
    protected array $errors = [];
    protected string $success = '';

    public function contact() {
    
        if (isset($_POST['contact-form'])) {
            
            $from = $_POST['email'];
            $name = $_POST['name'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];

            if (!$from && !$name && !$subject && !$message) {
                $this->errors[] = "Tous les champs doivent être remplis.";
            }

            if (!empty($from)) { 
                $send = $this->sendEmailFromForm($from, $name, $subject, $message); 
                if ($send) {
                    $this->success = "Email envoyé avec succès.";
                } else {
                    $this->errors[] = "Erreur lors de l'envoi de l'email.";
                }
            }        
        }

        $errors = $this->errors;
        $success = $this->success;
        require_once ROOT_PATH . 'src/Views/contactView.php';

    }
}