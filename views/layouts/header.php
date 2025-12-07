<!-- views/layouts/header.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIN - Gestion des Compétences</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="header">
        <a href="/dashboard" class="logo">FindIN</a>
        
        <nav class="nav-menu">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/dashboard" class="nav-link <?= $_SERVER['REQUEST_URI'] == '/dashboard' ? 'active' : '' ?>">
                    Tableau de bord
                </a>
                
                <a href="/search" class="nav-link <?= $_SERVER['REQUEST_URI'] == '/search' ? 'active' : '' ?>">
                    Recherche
                </a>
                
                <a href="/profile" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/profile') === 0 ? 'active' : '' ?>">
                    Mon profil
                </a>
                
                <?php if ($_SESSION['user_role'] == 'admin'): ?>
                    <a href="/admin/dashboard" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin') === 0 ? 'active' : '' ?>">
                        Administration
                    </a>
                <?php endif; ?>
                
                <div class="user-info">
                    <span><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                    <span class="role-badge"><?= htmlspecialchars($_SESSION['user_role']) ?></span>
                    <a href="/logout" class="btn btn-danger btn-sm">Déconnexion</a>
                </div>
            <?php else: ?>
                <a href="/login" class="nav-link">Connexion</a>
                <a href="/register" class="nav-link">Inscription</a>
            <?php endif; ?>
        </nav>
    </header>
    
    <main class="container">
