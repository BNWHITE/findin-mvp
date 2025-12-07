<?php
// router.php
session_start();
require_once 'config/database.php';

// Fonction d'autoload pour les controllers et models
spl_autoload_register(function ($class) {
    if (file_exists('controllers/' . $class . '.php')) {
        require_once 'controllers/' . $class . '.php';
    } elseif (file_exists('models/' . $class . '.php')) {
        require_once 'models/' . $class . '.php';
    }
});

// Récupérer l'URL demandée
$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?'); // Enlever les query strings

// Routes
$routes = [
    '/' => ['AuthController', 'login'],
    '/login' => ['AuthController', 'login'],
    '/register' => ['AuthController', 'register'],
    '/logout' => ['AuthController', 'logout'],
    '/forgot-password' => ['AuthController', 'forgotPassword'],
    
    '/dashboard' => ['DashboardController', 'index'],
    
    '/profile' => ['ProfileController', 'view'],
    '/profile/edit' => ['ProfileController', 'edit'],
    '/profile/competences' => ['ProfileController', 'competences'],
    
    '/search' => ['SearchController', 'index'],
    
    '/admin/users' => ['AdminController', 'users'],
    '/admin/competences' => ['AdminController', 'competences'],
    '/admin/dashboard' => ['AdminController', 'dashboard']
];

// Trouver la route correspondante
$routeFound = false;
foreach ($routes as $route => $handler) {
    if ($route === $request) {
        $controllerName = $handler[0];
        $methodName = $handler[1];
        
        $controller = new $controllerName();
        $controller->$methodName();
        
        $routeFound = true;
        break;
    }
}

// Route non trouvée
if (!$routeFound) {
    http_response_code(404);
    echo "Page non trouvée";
}
?>
