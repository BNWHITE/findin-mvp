<!-- views/auth/login.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIN - Connexion</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .login-card {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
            color: #2563eb;
            font-size: 2rem;
            font-weight: bold;
        }
        
        .login-title {
            text-align: center;
            margin-bottom: 2rem;
            color: #1f2937;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #6b7280;
        }
        
        .login-footer a {
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">FindIN</div>
            <h1 class="login-title">Connexion à votre compte</h1>
            
            <?php if (isset($data['error'])): ?>
                <div class="alert alert-error"><?= htmlspecialchars($data['error']) ?></div>
            <?php endif; ?>
            
            <form method="POST" action="/login">
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">
                    Se connecter
                </button>
            </form>
            
            <div class="login-footer">
                <p>Pas encore de compte ? <a href="/register">S'inscrire</a></p>
                <p><a href="/forgot-password">Mot de passe oublié ?</a></p>
            </div>
        </div>
    </div>
</body>
</html>
