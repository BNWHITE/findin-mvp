<?php
// config/database.php

// Pour macOS avec MAMP
// define('DB_HOST', 'localhost:8889');
// define('DB_USER', 'root');
// define('DB_PASS', 'root');

// Pour macOS avec Homebrew
define('DB_HOST', 'localhost');
define('DB_NAME', 'gestion_competences');
define('DB_USER', 'root');
define('DB_PASS', ''); // Mot de passe vide pour développement
define('DB_CHARSET', 'utf8mb4');

// Rôles utilisateurs
define('ROLE_EMPLOYEE', 'employe');
define('ROLE_MANAGER', 'manager');
define('ROLE_RH', 'rh');
define('ROLE_ADMIN', 'admin');

// Configuration de l'application
define('APP_NAME', 'FindIN');
define('APP_URL', 'http://localhost:8000');
define('DEBUG_MODE', true);

// Fonction de débogage
function debug($data) {
    if (DEBUG_MODE) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}
?>
