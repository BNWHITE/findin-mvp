<?php
// models/Database.php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
            
            // Test de connexion
            $this->connection->query("SELECT 1");
            
        } catch (PDOException $e) {
            // Afficher un message d'erreur clair
            $error_msg = "Erreur de connexion à la base de données:<br>";
            $error_msg .= "Message: " . $e->getMessage() . "<br>";
            $error_msg .= "Host: " . DB_HOST . "<br>";
            $error_msg .= "Base: " . DB_NAME . "<br>";
            $error_msg .= "User: " . DB_USER . "<br>";
            
            if (DEBUG_MODE) {
                die($error_msg);
            } else {
                die("Erreur de connexion à la base de données. Veuillez contacter l'administrateur.");
            }
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }

    public static function query($sql, $params = []) {
        try {
            $db = self::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            if (DEBUG_MODE) {
                die("Erreur SQL: " . $e->getMessage() . "<br>Requête: " . $sql);
            } else {
                die("Une erreur est survenue lors de l'exécution de la requête.");
            }
        }
    }
}
?>
