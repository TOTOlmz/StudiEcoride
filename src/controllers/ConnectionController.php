<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant la connexion d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers;

use App\Models\ConnectionModel;

class ConnectionController {
    
    protected array $errors = [];
    protected string $success = '';

    
    public function connection() {
        
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $email = $_POST['email'];
            $password = $_POST['password'];


            if (!$email || !$password) {
                $this->errors[] = 'Merci de renseigner tous les champs';
            }
            
            
            // Si pas d'erreurs, on connecte l'utilisateur
            if (empty($this->errors)) {
                
                $user = ConnectionModel::connection($email, $password);
                if (empty($user)) {  // Si user n'est pas trouvé :
                    $this->errors[] = 'Ces identifiants ne correspondent à aucun compte';
                }

                if (empty($this->errors)) {
                    // On démarre la session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['roles'];
    
                    // On gère la redirection
                    if ($user['roles'] === 'ADMIN') {
                        header ('Location: ./espace-admin');
                    }  elseif ($user['roles'] === 'STAFF') {
                        header ('Location: ./espace-staff');
                    } else {
                        header ('Location: ./mon-espace');
                    }
                    $this->success = 'connexion réussie';
                    return $this->success;
                }
            }
        }
        
    }


    public function displayView() {
        $errors = $this->errors;
        $success = $this->success;
        require_once ROOT_PATH . '/src/Views/connectionView.php';
    }

}