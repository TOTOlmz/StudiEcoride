<?php 

/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Controlleur gérant l'inscription des utilisateurs
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

require_once __DIR__ . '/../../models/users/UserModel.php';

class RegistrationController {
    
    public function registration() {

        $errors = [];
        $success = '';
        // Si le formulaire n'est pas soumis
        
        // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = trim($_POST['pseudo'])  ?? '';
            $email = trim($_POST['email'])  ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm-password'] ?? '';
            
            
            if (empty($pseudo) || empty($email) || empty($password)) {
                $errors[] = 'Merci de renseigner tous les champs';
            }
            
            if ($password !== $confirmPassword) {
                $errors[] = 'Les mots de passe ne correspondent pas';
            }
            
            if (!$this->passwordCheck($password)) {
                $errors[] = 'Le mot de passe ne respecte pas les critères requis';
            }
            
            // On appelle les fonctions du modèle pour vérifier que le mail et le pseudo sont bien uniques
            if (UserModel::emailExists($email)) {
                $errors[] = 'Cet email est déjà utilisé';
            }
            
            if (UserModel::pseudoExists($pseudo)) {
                $errors[] = 'Ce pseudo est déjà utilisé';
            }
            
            // Si pas d'erreurs :
            if (empty($errors)) {
                try {
                    // On crée l'utilisateur
                    $userId = UserModel::create($pseudo, $email, $password, 20, 'USER');
                    
                    // Et on démarre la session
                    if ($userId) {
                        $user = UserModel::getUserById($userId);

                        if ($user) {
                            // Créer la session
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['user_email'] = $user['email'];
                            $_SESSION['user_role'] = $user['roles'];
                            
                            $success = 'Compte créé avec succès !';
                        } else {
                            $errors[] = 'Erreur lors de la récupération des données utilisateur';
                        }
                    } else {
                        $errors[] = 'Erreur lors de la récupération de la création de compte';
                    }                   
                    
                } catch (PDOException $e) {
                    $errors[] = 'Erreur lors de la création du compte : ' . $e->getMessage();
                }
            }

            header('Location: ./mon-espace');
        }
        
        // On charge la vue
        require __DIR__ . '/../../views/users/registrationView.php';
    }

    // Fonction permettant de vérifier la robustesse du mot de passe
    private function passwordCheck($password) {
    return strlen($password) >= 8 &&        // On vérifie la longueur minimale
    strtolower($password) !== $password &&  // La presence d'une minuscule
    strtoupper($password) !== $password &&  // La presence d'une majuscule
    preg_match('/[0-9]/', $password);       // La presence d'un chiffre
}
}