<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant la connexion d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

// Inclusion de l'autoloader Composer
require_once __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . '/../models/ConnectionModel.php';

// Import des classes Symfony Mailer
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

class ContactController {
    
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

    private function sendEmailFromForm($from, $name, $subject, $content) {
        try {
            // Configuration SMTP Gmail avec le bon format DSN
            $dsn = 'smtp://ecoride.studi.to@gmail.com:anovznbiwqvexgih@smtp.gmail.com:587?encryption=tls';
            $transport = Transport::fromDsn($dsn);
            $mailer = new Mailer($transport);

            $content = "<h1>Formulaire de contact Ecoride</h1>
            <h2>De : " . htmlspecialchars($name) . ". Email : " . htmlspecialchars($from) . "</h2><br><br>" . nl2br(htmlspecialchars($content));

            // Création et envoi de l'email
            $email = (new Email())
                ->from('ecoride.studi.to@gmail.com')
                ->to('ecoride.studi.to@gmail.com')
                ->replyTo($from) // Permet de répondre directement à l'expéditeur
                ->subject($subject)
                ->html($content);

            $mailer->send($email);
            return true;
            
        } catch (Exception $e) {
            error_log("Erreur email : " . $e->getMessage());
            return false;
        }
    }
}