<?php 

/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'inscription des utilisateurs
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Controllers\users;

use App\models\users\UserModel;
use PDOException;

class RegistrationController {
    

    protected array $errors = [];
    protected string $success = '';


    public function registration() {
        
        // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = trim($_POST['pseudo'])  ?? '';
            $email = trim($_POST['email'])  ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm-password'] ?? '';
            
            
            if (empty($pseudo) || empty($email) || empty($password)) {
                $this->errors[] = 'Merci de renseigner tous les champs';
            }
            
            if ($password !== $confirmPassword) {
                $this->errors[] = 'Les mots de passe ne correspondent pas';
            }
            
            if (!$this->passwordCheck($password)) {
                $this->errors[] = 'Le mot de passe ne respecte pas les critères requis';
            }
            
            // On appelle les fonctions du modèle pour vérifier que le mail et le pseudo sont bien uniques
            if (UserModel::emailExists($email)) {
                $this->errors[] = 'Cet email est déjà utilisé';
            }
            
            if (UserModel::pseudoExists($pseudo)) {
                $this->errors[] = 'Ce pseudo est déjà utilisé';
            }
            
            // Si pas d'erreurs :
            if (empty($this->errors)) {
                try {
                    // On crée l'utilisateur
                    $userId = UserModel::create($pseudo, $email, $password, 20, 'USER');
                    
                    // Et on démarre la session
                    if ($userId) {
                        $user = UserModel::getUserById($userId);

                        if ($user) {
                            // Création de la session
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['user_email'] = $user['email'];
                            $_SESSION['user_role'] = $user['roles'];
                            
                            $this->success = 'Compte créé avec succès !';
                        } else {
                            $this->errors[] = 'Erreur lors de la récupération des données utilisateur';
                        }
                    } else {
                        $this->errors[] = 'Erreur lors de la récupération de la création de compte';
                    }                   
                    
                } catch (PDOException $e) {
                    $this->errors[] = 'Erreur lors de la création du compte : ' . $e->getMessage();
                }
            }

            header('Location: ./mon-espace');
        }
    }

    public function displayView() {
        $errors = $this->errors;
        $success = $this->success;
        require_once ROOT_PATH . '/src/Views/users/registrationView.php';
    }


    // Fonction permettant de vérifier la robustesse du mot de passe
    private function passwordCheck($password) {
        return strlen($password) >= 8 &&        // On vérifie la longueur minimale
        strtolower($password) !== $password &&  // La presence d'une minuscule
        strtoupper($password) !== $password &&  // La presence d'une majuscule
        preg_match('/[0-9]/', $password);       // La presence d'un chiffre
    }
}