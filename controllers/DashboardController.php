<?php
// controllers/DashboardController.php
require_once 'controllers/BaseController.php';
require_once 'models/User.php';
require_once 'models/Competence.php';

class DashboardController extends BaseController {
    private $userModel;
    private $competenceModel;

    public function __construct() {
        parent::__construct();
        $this->checkAuth();
        $this->userModel = new User();
        $this->competenceModel = new Competence();
    }

    public function index() {
        $userRole = $_SESSION['user_role'];
        
        switch ($userRole) {
            case ROLE_ADMIN:
                $this->adminDashboard();
                break;
            case ROLE_MANAGER:
                $this->managerDashboard();
                break;
            case ROLE_RH:
                $this->rhDashboard();
                break;
            default:
                $this->employeeDashboard();
                break;
        }
    }

    private function employeeDashboard() {
        $userId = $_SESSION['user_id'];
        $userCompetences = $this->competenceModel->getUserCompetences($userId);
        
        $data = [
            'competences' => $userCompetences,
            'pendingValidations' => array_filter($userCompetences, function($comp) {
                return $comp['niveau_valide'] === null && $comp['niveau_declare'] !== null;
            })
        ];
        
        $this->view('dashboard/employee', $data);
    }

    private function managerDashboard() {
        // Pour MVP, simuler une équipe
        $teamMembers = $this->userModel->getAllUsers(); // À remplacer par une vraie requête d'équipe
        
        $data = [
            'teamMembers' => array_slice($teamMembers, 0, 5), // Limiter à 5 pour l'exemple
            'pendingValidations' => []
        ];
        
        $this->view('dashboard/manager', $data);
    }

    private function adminDashboard() {
        $users = $this->userModel->getAllUsers();
        $competences = $this->competenceModel->getAllCompetences();
        
        $data = [
            'totalUsers' => count($users),
            'totalCompetences' => count($competences),
            'recentUsers' => array_slice($users, 0, 5)
        ];
        
        $this->view('dashboard/admin', $data);
    }

    private function rhDashboard() {
        $users = $this->userModel->getAllUsers();
        $competences = $this->competenceModel->getAllCompetences();
        
        $data = [
            'users' => $users,
            'competences' => $competences,
            'stats' => [
                'total' => count($users),
                'par_departement' => []
            ]
        ];
        
        $this->view('dashboard/rh', $data);
    }
}
?>
