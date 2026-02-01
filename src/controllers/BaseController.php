<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant le profil utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers;

// Import des classes Symfony Mailer
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Exception;

class BaseController {

    
    // Foncion permettant la déconnexion
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ./');
        exit;
    }

    public function sendEmailFromForm($from, $name, $subject, $content) {
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

    public function sendEmailToUser($to, $subject, $content) {
        try {
            // Configuration SMTP Gmail
            $dsn = 'smtp://ecoride.studi.to@gmail.com:anovznbiwqvexgih@smtp.gmail.com:587?encryption=tls';
            $transport = Transport::fromDsn($dsn);
            $mailer = new Mailer($transport);

            // Création et envoi de l'email
            $email = (new Email())
                ->from('ecoride.studi.to@gmail.com')
                ->to($to)
                ->subject($subject)
                ->html($content);

            $mailer->send($email);
            return true;
            
        } catch (Exception $e) {
            error_log('Erreur email : ' . $e->getMessage());
            return false;
        }
    }

}