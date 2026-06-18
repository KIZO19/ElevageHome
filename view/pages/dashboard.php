<?php
$active = 'dashboard';
$title = 'Tableau de bord';
?>

<div class="content-header">
    <h1>📊 Tableau de bord</h1>
    <div class="breadcrumb">
        <a href="/ElevageHome/public/?url=dashboard">Accueil</a> / Tableau de bord
    </div>
</div>

<!-- FILTRE DE DATES -->
<div class="card" style="margin-bottom: 20px;">
    <div class="card-header">
        <h3 class="card-title">📅 Filtre par Période</h3>
    </div>
    <div class="card-body">
        <form method="GET" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
            <input type="hidden" name="url" value="dashboard">
            
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #1f3057; font-size: 13px;">
                    📅 Date Début
                </label>
                <input type="date" name="date_debut" class="form-control" value="<?php echo htmlspecialchars($date_debut); ?>" required style="width: 100%; padding: 10px; border: 1px solid #e0e0e0; border-radius: 4px;">
            </div>
            
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #1f3057; font-size: 13px;">
                    📅 Date Fin
                </label>
                <input type="date" name="date_fin" class="form-control" value="<?php echo htmlspecialchars($date_fin); ?>" required style="width: 100%; padding: 10px; border: 1px solid #e0e0e0; border-radius: 4px;">
            </div>
            
            <button type="submit" class="btn btn-primary" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                🔍 Filtrer
            </button>
            
            <a href="/ElevageHome/public/?url=dashboard" class="btn btn-secondary" style="padding: 10px 20px; background: #e9ecef; color: #495057; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block;">
                ↺ Réinitialiser
            </a>
        </form>
        
        <div style="margin-top: 15px; padding: 10px; background: #e7f3ff; border-left: 4px solid #007bff; border-radius: 4px; color: #004085;">
            <strong>Période sélectionnée:</strong> <?php echo date('d/m/Y', strtotime($date_debut)); ?> → <?php echo date('d/m/Y', strtotime($date_fin)); ?>
            (<?php 
                $interval = date_diff(date_create($date_debut), date_create($date_fin));
                echo $interval->days + 1;
            ?> jours)
        </div>
    </div>
</div>

<!-- STATS CARDS -->
<div class="row">
    <!-- Total Espèces -->
    <div class="info-box blue">
        <div class="info-box-icon">
            <i class="fas fa-layer-group"></i>
        </div>
        <span class="info-box-number"><?php echo count($bandes); ?></span>
        <span class="info-box-text">Espèces Actives</span>
        <div class="info-box-more">
            <a href="/ElevageHome/public/?url=bandes">Plus d'infos →</a>
        </div>
    </div>

    <!-- Total Dépenses -->
    <div class="info-box green">
        <div class="info-box-icon">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <span class="info-box-number">
            <?php 
            $totalDepenses = 0;
            foreach ($depenses as $d) {
                $totalDepenses += $d['montant_total_charge'] ?? 0;
            }
            echo number_format($totalDepenses, 0) . ' FC';
            ?>
        </span>
        <span class="info-box-text">Dépenses Totales</span>
        <div class="info-box-more">
            <a href="/ElevageHome/public/?url=depenses">Plus d'infos →</a>
        </div>
    </div>

    <!-- Total Ventes -->
    <div class="info-box yellow">
        <div class="info-box-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <span class="info-box-number">
            <?php 
            $totalVentes = 0;
            foreach ($ventes as $v) {
                $totalVentes += $v['montant_total_recette'] ?? 0;
            }
            echo number_format($totalVentes, 0) . ' FC';
            ?>
        </span>
        <span class="info-box-text">Recettes Totales</span>
        <div class="info-box-more">
            <a href="/ElevageHome/public/?url=ventes">Plus d'infos →</a>
        </div>
    </div>

    <!-- Stock Disponible -->
    <div class="info-box purple">
        <div class="info-box-icon">
            <i class="fas fa-boxes"></i>
        </div>
        <span class="info-box-number"><?php echo number_format($totalDisponible, 0); ?> </span>
        <span class="info-box-text">Stock Disponible</span>
        <div class="info-box-more">
            <a href="/ElevageHome/public/?url=bandes">Plus d'infos →</a>
        </div>
    </div>

    <!-- Total Mortalité -->
    <div class="info-box red">
        <div class="info-box-icon">
            <i class="fas fa-heartbeat"></i>
        </div>
        <span class="info-box-number"><?php echo count($mortalites); ?></span>
        <span class="info-box-text">Cas de Mortalité</span>
        <div class="info-box-more">
            <a href="/ElevageHome/public/?url=mortalite">Plus d'infos →</a>
        </div>
    </div>
</div>

<!-- GRAPHIQUES ROW 1 -->
<div class="row">
    <!-- Dépenses par Espèce -->
    <div class="card chart-card">
        <div class="card-header">
            <h3 class="card-title"> Dépenses par Espèce</h3>
        </div>
        <div class="card-body">
            <div style="position: relative; height: 300px;">
                <canvas id="depensesBandeChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Ventes par Produit -->
    <div class="card chart-card">
        <div class="card-header">
            <h3 class="card-title">🛒 Ventes par Produit</h3>
        </div>
        <div class="card-body">
            <div style="position: relative; height: 300px;">
                <canvas id="ventesProduitChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- GRAPHIQUES ROW 2 -->
<div class="row">
    <!-- Évolution Mensuelle -->
    <div class="card chart-card" style="grid-column: span 2;">
        <div class="card-header">
            <h3 class="card-title">📈 Évolution Mensuelle (Dépenses vs Recettes)</h3>
        </div>
        <div class="card-body">
            <div style="position: relative; height: 300px;">
                <canvas id="evolutionChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- GRAPHIQUES ROW 3 -->
<div class="row">
    <!-- Causes de Mortalité -->
    <?php if (!empty($mortalites)): ?>
    <div class="card chart-card">
        <div class="card-header">
            <h3 class="card-title">🔴 Causes de Mortalité</h3>
        </div>
        <div class="card-body">
            <div style="position: relative; height: 300px;">
                <canvas id="mortaliteChart"></canvas>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Répartition des Espèces -->
    <div class="card chart-card">
        <div class="card-header">
            <h3 class="card-title">🐔 Répartition des Espèces</h3>
        </div>
        <div class="card-body">
            <div style="position: relative; height: 300px;">
                <canvas id="bandesChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- RECENT DEPENSES -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">💸 Dépenses Récentes</h3>
        <a href="/ElevageHome/public/?url=depenses" class="btn btn-primary btn-sm">Voir tout</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Espèce</th>
                    <th>Description</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($depenses, 0, 5) as $d): ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($d['date_depense'])); ?></td>
                    <td><?php echo htmlspecialchars($d['code_bande']); ?></td>
                    <td><?php echo htmlspecialchars($d['libelle_depense']); ?></td>
                    <td><strong><?php echo number_format($d['montant_total_charge'], 2); ?> FC</strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- RECENT VENTES -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">🛒 Ventes Récentes</h3>
        <a href="/ElevageHome/public/?url=ventes" class="btn btn-primary btn-sm">Voir tout</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Espèce</th>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($ventes, 0, 5) as $v): ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($v['date_vente'])); ?></td>
                    <td><?php echo htmlspecialchars($v['code_bande']); ?></td>
                    <td><?php echo ucfirst(str_replace('_', ' ', $v['produit_vendu'])); ?></td>
                    <td><?php echo number_format($v['quantite_vendue'], 2); ?></td>
                    <td><strong><?php echo number_format($v['montant_total_recette'], 2); ?> FC</strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- SUMMARY -->
<div class="row">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📈 Résumé Financier</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div style="padding: 15px; background: #f8f9fa; border-radius: 4px;">
                    <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">Total Dépenses</div>
                    <div style="font-size: 20px; font-weight: 700; color: #dc3545;">
                        <?php echo number_format($totalDepenses, 2); ?> FC
                    </div>
                </div>
                <div style="padding: 15px; background: #f8f9fa; border-radius: 4px;">
                    <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">Total Recettes</div>
                    <div style="font-size: 20px; font-weight: 700; color: #28a745;">
                        <?php echo number_format($totalVentes, 2); ?> FC
                    </div>
                </div>
                <div style="padding: 15px; background: #f8f9fa; border-radius: 4px;">
                    <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">Bénéfice Net</div>
                    <div style="font-size: 20px; font-weight: 700; color: #007bff;">
                        <?php echo number_format($totalVentes - $totalDepenses, 2); ?> FC
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
    }

    .content-header h1 {
        font-size: 28px;
        color: #1f3057;
        font-weight: 600;
        margin: 0 0 5px 0;
    }

    .breadcrumb {
        display: flex;
        gap: 5px;
        font-size: 12px;
        color: #6c757d;
    }

    .breadcrumb a {
        color: #007bff;
        text-decoration: none;
    }

    .row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .chart-card {
        grid-column: auto;
    }

    @media (max-width: 1024px) {
        .row {
            grid-template-columns: 1fr;
        }

        .chart-card {
            grid-column: auto !important;
        }
    }

    canvas {
        max-height: 300px !important;
    }
</style>

<script>
    // Configuration Chart.js
    Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
    Chart.defaults.color = '#6c757d';

    // Données depuis PHP
    const depensesData = <?php echo json_encode($depenses); ?>;
    const ventesData = <?php echo json_encode($ventes); ?>;
    const mortalitesData = <?php echo json_encode($mortalites); ?>;
    const especesData = <?php echo json_encode($bandes); ?>;

    // 1. DÉPENSES PAR ESPÈCE
    const depensesBandeCtx = document.getElementById('depensesBandeChart');
    if (depensesBandeCtx) {
        const depensesByEspece = {};
        depensesData.forEach(d => {
            const espece = d.code_bande || 'Inconnue';
            depensesByEspece[espece] = (depensesByEspece[espece] || 0) + parseFloat(d.montant_total_charge || 0);
        });

        new Chart(depensesBandeCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(depensesByEspece),
                datasets: [{
                    label: 'Dépenses (FC)',
                    data: Object.values(depensesByEspece),
                    backgroundColor: '#dc3545',
                    borderColor: '#c82333',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // 2. VENTES PAR PRODUIT
    const ventesProduitCtx = document.getElementById('ventesProduitChart');
    if (ventesProduitCtx) {
        const ventesByProduit = {};
        ventesData.forEach(v => {
            const produit = v.produit_vendu || 'Inconnue';
            ventesByProduit[produit] = (ventesByProduit[produit] || 0) + parseFloat(v.montant_total_recette || 0);
        });

        const colors = ['#28a745', '#17a2b8', '#ffc107', '#fd7e14', '#6f42c1'];
        new Chart(ventesProduitCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(ventesByProduit),
                datasets: [{
                    data: Object.values(ventesByProduit),
                    backgroundColor: colors,
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    // 3. ÉVOLUTION MENSUELLE
    const evolutionCtx = document.getElementById('evolutionChart');
    if (evolutionCtx) {
        const monthlyData = {};
        const currentYear = new Date().getFullYear();

        depensesData.forEach(d => {
            const date = new Date(d.date_depense);
            if (date.getFullYear() === currentYear) {
                const month = date.toLocaleString('fr-FR', { month: 'short' });
                if (!monthlyData[month]) monthlyData[month] = { depenses: 0, ventes: 0 };
                monthlyData[month].depenses += parseFloat(d.montant_total_charge || 0);
            }
        });

        ventesData.forEach(v => {
            const date = new Date(v.date_vente);
            if (date.getFullYear() === currentYear) {
                const month = date.toLocaleString('fr-FR', { month: 'short' });
                if (!monthlyData[month]) monthlyData[month] = { depenses: 0, ventes: 0 };
                monthlyData[month].ventes += parseFloat(v.montant_total_recette || 0);
            }
        });

        const months = Object.keys(monthlyData);
        const depensesValues = months.map(m => monthlyData[m].depenses);
        const ventesValues = months.map(m => monthlyData[m].ventes);

        new Chart(evolutionCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Dépenses',
                        data: depensesValues,
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Recettes',
                        data: ventesValues,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // 4. CAUSES DE MORTALITÉ
    const mortaliteCtx = document.getElementById('mortaliteChart');
    if (mortaliteCtx && mortalitesData.length > 0) {
        const mortalityByReason = {};
        mortalitesData.forEach(m => {
            const cause = m.cause_probable || 'Inconnue';
            mortalityByReason[cause] = (mortalityByReason[cause] || 0) + parseFloat(m.nbre_sujets_morts || 0);
        });

        new Chart(mortaliteCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(mortalityByReason),
                datasets: [{
                    label: 'Nombre de sujets',
                    data: Object.values(mortalityByReason),
                    backgroundColor: '#fd7e14',
                    borderColor: '#f5640f',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true }
                },
                scales: {
                    x: { beginAtZero: true }
                }
            }
        });
    }

    // 5. RÉPARTITION DES ESPÈCES
    const especesCtx = document.getElementById('bandesChart');
    if (especesCtx && especesData.length > 0) {
        const colors = ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8'];
        new Chart(especesCtx, {
            type: 'pie',
            data: {
                labels: especesData.map(e => e.code_bande),
                datasets: [{
                    data: especesData.map(e => 1),
                    backgroundColor: colors.slice(0, especesData.length),
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Espèce active';
                            }
                        }
                    }
                }
            }
        });
    }
</script>
