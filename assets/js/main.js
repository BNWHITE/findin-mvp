// assets/js/main.js

// Fonctions utilitaires
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des messages flash
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // Validation de formulaire
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#ef4444';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Veuillez remplir tous les champs obligatoires.');
            }
        });
    });

    // Recherche en temps réel (optionnel)
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            // Implémentation future de la recherche en temps réel
        });
    }

    // Menu mobile
    const menuToggle = document.querySelector('.menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            document.querySelector('.nav-menu').classList.toggle('show');
        });
    }
});

// Fonction pour afficher/masquer les filtres de recherche
function toggleFilters() {
    const filters = document.getElementById('search-filters');
    if (filters) {
        filters.style.display = filters.style.display === 'none' ? 'block' : 'none';
    }
}

// Fonction pour confirmer les actions importantes
function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Gestion des niveaux de compétence
function updateLevelDisplay(element) {
    const level = element.value;
    const display = element.nextElementSibling;
    if (display && display.classList.contains('level-display')) {
        display.textContent = `Niveau ${level}`;
        display.className = `level-display level-${level}`;
    }
}
