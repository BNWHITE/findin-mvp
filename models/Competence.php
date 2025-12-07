<?php
// models/Competence.php
require_once 'models/Database.php';

class Competence {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllCompetences() {
        $sql = "SELECT c.*, cc.nom as categorie_nom 
                FROM competences c
                LEFT JOIN categories_competences cc ON c.id_categorie = cc.id_categorie
                ORDER BY cc.nom, c.nom";
        
        return $this->db->query($sql)->fetchAll();
    }

    public function getUserCompetences($userId) {
        $sql = "SELECT cu.*, c.nom as competence_nom, c.type_competence, cc.nom as categorie_nom
                FROM competences_utilisateurs cu
                JOIN competences c ON cu.id_competence = c.id_competence
                LEFT JOIN categories_competences cc ON c.id_categorie = cc.id_categorie
                WHERE cu.id_utilisateur = :user_id
                ORDER BY cc.nom, c.nom";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function addUserCompetence($userId, $competenceId, $niveauDeclare) {
        $sql = "INSERT INTO competences_utilisateurs 
                (id_comp_utilisateur, id_utilisateur, id_competence, niveau_declare, date_validation) 
                VALUES (UUID(), :user_id, :competence_id, :niveau, NOW())";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':competence_id' => $competenceId,
            ':niveau' => $niveauDeclare
        ]);
    }

    public function updateCompetenceValidation($compUserId, $niveauValide, $managerId) {
        $sql = "UPDATE competences_utilisateurs SET 
                niveau_valide = :niveau_valide,
                id_manager_validateur = :manager_id,
                date_validation = NOW()
                WHERE id_comp_utilisateur = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':niveau_valide' => $niveauValide,
            ':manager_id' => $managerId,
            ':id' => $compUserId
        ]);
    }

    public function searchByCompetence($searchTerm, $filters = []) {
        $sql = "SELECT DISTINCT u.id_utilisateur, u.prenom, u.nom, u.email, 
                d.nom as departement_nom,
                c.nom as competence_nom,
                cu.niveau_valide as niveau
                FROM utilisateurs u
                JOIN competences_utilisateurs cu ON u.id_utilisateur = cu.id_utilisateur
                JOIN competences c ON cu.id_competence = c.id_competence
                LEFT JOIN departements d ON u.id_departement = d.id_departement
                WHERE c.nom LIKE :search 
                OR u.prenom LIKE :search 
                OR u.nom LIKE :search";
        
        // Ajouter des filtres
        if (!empty($filters['departement'])) {
            $sql .= " AND d.id_departement = :departement";
        }
        
        if (!empty($filters['niveau_min'])) {
            $sql .= " AND cu.niveau_valide >= :niveau_min";
        }
        
        $stmt = $this->db->prepare($sql);
        
        $params = [':search' => '%' . $searchTerm . '%'];
        
        if (!empty($filters['departement'])) {
            $params[':departement'] = $filters['departement'];
        }
        
        if (!empty($filters['niveau_min'])) {
            $params[':niveau_min'] = $filters['niveau_min'];
        }
        
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>
