<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur principal.
    Vérifie les accès,
    Gère les déconnexions
    Assure l'envoi d'Emails
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers;

use App\Models\users\UserModel;
// Import des classes Symfony Mailer
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Exception;

class BaseController {

    // Fonction vérifiant l'accès à l'espace utilisateur
    public function checkAccess($role) {
        if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== $role){
            header('Location: ./connexion');
            exit();
        } else {
            $this->checkSuspension($_SESSION['user_id']);
        }
    }

    // Fonction vérifiant l'état du compte utilisateur (suspendu ou pas)
    private function checkSuspension($userId) {
        $user = UserModel::getUserById($userId);
        if ($user && intval($user['is_suspended']) === 1) {
            session_unset();
            session_destroy();
            header('Location: ./suspendu');
            exit();
        }
    }
    
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