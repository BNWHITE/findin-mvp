<!-- views/auth/register.php -->
<?php include 'views/layouts/header.php'; ?>

<div class="login-container">
    <div class="login-card">
        <div class="login-logo">FindIN</div>
        <h1 class="login-title">Créer un compte</h1>
        
        <?php if (isset($data['error'])): ?>
            <div class="alert alert-error"><?= htmlspecialchars($data['error']) ?></div>
        <?php endif; ?>
        
        <form method="POST" action="/register">
            <div class="form-group">
                <label class="form-label" for="prenom">Prénom *</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="nom">Nom *</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="email">Email *</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="id_departement">Département</label>
                <select class="form-control" id="id_departement" name="id_departement">
                    <option value="">Sélectionnez un département</option>
                    <?php 
                    // Dans un vrai projet, charger depuis la base de données
                    $departements = [
                        'Direction',
                        'Ressources Humaines',
                        'Développement',
                        'Marketing',
                        'Commercial'
                    ];
                    foreach ($departements as $dept): 
                    ?>
                        <option value="<?= htmlspecialchars($dept) ?>">
                            <?= htmlspecialchars($dept) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="password">Mot de passe *</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="confirm_password">Confirmer le mot de passe *</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">
                Créer mon compte
            </button>
        </form>
        
        <div class="login-footer">
            <p>Déjà un compte ? <a href="/login">Se connecter</a></p>
        </div>
    </div>
</div>

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
        max-width: 450px;
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
</style>

<?php include 'views/layouts/footer.php'; ?>
