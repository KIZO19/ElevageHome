// Dashboard JavaScript

document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard chargé avec succès');
    
    // Animations pour les cartes de statistiques
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Animations pour les barres de progression
    const statBars = document.querySelectorAll('.stat-bar-fill');
    statBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.transition = 'width 1s ease';
            bar.style.width = width;
        }, 300);
    });

    // Interaction sur le tableau
    const tableRows = document.querySelectorAll('.bookings-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('hover', function() {
            this.style.backgroundColor = '#f0f0f0';
        });
    });

    // Format de devise pour les revenus
    console.log('Dashboard prêt pour les interactions');
});

// Fonction pour rafraîchir les données du dashboard
function refreshDashboard() {
    console.log('Rafraîchissement du dashboard...');
    location.reload();
}

// Fonction pour exporter les données
function exportData() {
    console.log('Export des données en cours...');
    alert('Export des données - Fonctionnalité à venir');
}

// Fonction pour afficher les détails d'une réservation
function showBookingDetails(bookingId) {
    console.log('Affichage des détails de la réservation:', bookingId);
    alert('Détails de la réservation #' + bookingId + ' - Fonctionnalité à venir');
}
