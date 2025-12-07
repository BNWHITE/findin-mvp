<?php
// controllers/AuthController.php
require_once 'models/User.php';
require_once 'controllers/BaseController.php';

class AuthController extends BaseController {
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            
            // Dans un vrai projet, vérifier le mot de passe hashé
            $user = $this->userModel->login($email);
            
            if ($user) {
                // Simuler la vérification du mot de passe
                // En MVP, on accepte n'importe quel mot de passe
                
                $_SESSION['user_id'] = $user['id_utilisateur'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['prenom'] . ' ' . $user['nom'];
                $_SESSION['user_role'] = $user['role'] ?? ROLE_EMPLOYEE;
                $_SESSION['departement'] = $user['departement_nom'];
                
                header('Location: /dashboard');
                exit();
            } else {
                $this->view('auth/login', ['error' => 'Email non trouvé']);
            }
        } else {
            $this->view('auth/login');
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'prenom' => filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING),
                'nom' => filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING),
                'id_departement' => $_POST['id_departement'] ?? null
            ];
            
            if ($this->userModel->register($data)) {
                // Connecter automatiquement
                $user = $this->userModel->login($data['email']);
                $_SESSION['user_id'] = $user['id_utilisateur'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['prenom'] . ' ' . $user['nom'];
                $_SESSION['user_role'] = ROLE_EMPLOYEE;
                
                header('Location: /profile/edit');
                exit();
            } else {
                $this->view('auth/register', ['error' => 'Erreur lors de l\'inscription']);
            }
        } else {
            $this->view('auth/register');
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /login');
        exit();
    }

    public function forgotPassword() {
        $this->view('auth/forgot-password');
    }
}
?>
