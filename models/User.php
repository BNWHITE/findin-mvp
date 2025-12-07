<?php
// models/User.php
require_once 'models/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function register($data) {
        $sql = "INSERT INTO utilisateurs (id_utilisateur, email, prenom, nom, cree_le, id_departement) 
                VALUES (UUID(), :email, :prenom, :nom, NOW(), :id_departement)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':email' => $data['email'],
            ':prenom' => $data['prenom'],
            ':nom' => $data['nom'],
            ':id_departement' => $data['id_departement'] ?? null
        ]);
    }

    public function login($email) {
        $sql = "SELECT u.*, d.nom as departement_nom, 
                (SELECT role FROM roles_utilisateurs WHERE id_utilisateur = u.id_utilisateur LIMIT 1) as role
                FROM utilisateurs u 
                LEFT JOIN departements d ON u.id_departement = d.id_departement 
                WHERE u.email = :email";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function getAllUsers() {
        $sql = "SELECT u.*, d.nom as departement_nom,
                (SELECT role FROM roles_utilisateurs WHERE id_utilisateur = u.id_utilisateur LIMIT 1) as role
                FROM utilisateurs u
                LEFT JOIN departements d ON u.id_departement = d.id_departement
                ORDER BY u.nom, u.prenom";
        
        return $this->db->query($sql)->fetchAll();
    }

    public function getUserById($id) {
        $sql = "SELECT u.*, d.nom as departement_nom,
                (SELECT role FROM roles_utilisateurs WHERE id_utilisateur = u.id_utilisateur LIMIT 1) as role
                FROM utilisateurs u
                LEFT JOIN departements d ON u.id_departement = d.id_departement
                WHERE u.id_utilisateur = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function updateProfile($id, $data) {
        $sql = "UPDATE utilisateurs SET 
                prenom = :prenom, 
                nom = :nom, 
                id_departement = :id_departement 
                WHERE id_utilisateur = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':prenom' => $data['prenom'],
            ':nom' => $data['nom'],
            ':id_departement' => $data['id_departement'],
            ':id' => $id
        ]);
    }

    public function setUserRole($userId, $role) {
        // Vérifier si le rôle existe déjà
        $checkSql = "SELECT id FROM roles_utilisateurs WHERE id_utilisateur = :user_id";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute([':user_id' => $userId]);
        
        if ($checkStmt->fetch()) {
            $sql = "UPDATE roles_utilisateurs SET role = :role WHERE id_utilisateur = :user_id";
        } else {
            $sql = "INSERT INTO roles_utilisateurs (id_utilisateur, role) VALUES (:user_id, :role)";
        }
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':role' => $role
        ]);
    }
}
?>
