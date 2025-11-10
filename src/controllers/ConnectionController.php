<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant la connexion d'un utilisateur
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../models/ConnectionModel.php';

class ConnectionController {
    
    public function connection() {
        $errors = [];
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $email = $_POST['email']  ?? '';
            $password = $_POST['password'] ?? '';


            if (empty($email) || empty($password)) {
                $errors[] = 'Merci de renseigner tous les champs';
            }
            
            
            // Si pas d'erreurs, on connecte l'utilisateur
            if (empty($errors)) {
                try {
                    $user = ConnectionModel::connection($email, $password);
                    if (!$user) {  // ✅ Plus simple !
                        $errors[] = 'Ces identifiants ne correspondent à aucun compte';
                    }

                    
                    // On démarre la session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['roles'];
                    
                    $success = 'Connexion réussie';
                    
                } catch (PDOException $e) {
                    $errors[] = 'Erreur lors de la connexion';
                }
            }
        }

        // On charge la vue
        require __DIR__ . '/../views/connectionView.php';
        
    }

}