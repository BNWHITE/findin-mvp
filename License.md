## 15. Fichier de déploiement rapide (deploy.sh)

```bash
#!/bin/bash
# deploy.sh

echo "📦 Déploiement de FindIN MVP..."

# Vérifier les prérequis
command -v php >/dev/null 2>&1 || { echo "❌ PHP n'est pas installé"; exit 1; }
command -v mysql >/dev/null 2>&1 || { echo "❌ MySQL n'est pas installé"; exit 1; }

# Créer la structure de dossiers
mkdir -p assets/{css,js,images}
mkdir -p config controllers models views/{layouts,auth,dashboard,profile,search,admin}

echo "✅ Structure de dossiers créée"

# Copier les fichiers (à faire manuellement ou avec git)

echo "🚀 Installation terminée !"
echo "📖 Consultez README.md pour les prochaines étapes"
