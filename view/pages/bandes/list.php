<?php $active = 'bandes'; $title = 'Espèces'; ?>

<div class="content-header">
    <h1>🐔 Gestion des Espèces</h1>
    <div class="breadcrumb">
        <a href="/ElevageHome/public/?url=dashboard">Accueil</a> / Espèces
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Liste des Espèces</h3>
        <a href="/ElevageHome/public/?url=bandes/add" class="btn btn-primary btn-sm">➕ Ajouter une Espèce</a>
    </div>
    <div class="card-body">
        <div style="overflow-x: auto;">
            <table id="bandesTable" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Espèce</th>
                        <th>Type</th>
                        <th>Quantité</th>
                        <th>Lancement</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($bandes)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px; color: #999;">
                                Aucune espèce enregistrée
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($bandes as $b): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($b['code_bande']); ?></strong></td>
                                <td><?php echo htmlspecialchars($b['espece_detaillee']); ?></td>
                                <td>
                                    <span style="display: inline-block; padding: 4px 8px; border-radius: 3px; font-size: 12px; font-weight: 600;
                                        <?php 
                                            echo match($b['type_production']) {
                                                'chair' => 'background: #f8d7da; color: #721c24;',
                                                'pondeuse' => 'background: #d1ecf1; color: #0c5460;',
                                                'indigene_local' => 'background: #fff3cd; color: #856404;',
                                                default => 'background: #e2e3e5; color: #383d41;'
                                            };
                                        ?>">
                                        <?php echo ucfirst(str_replace('_', ' ', $b['type_production'])); ?>
                                    </span>
                                </td>
                                <td><?php echo number_format($b['quantite_initiale']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($b['date_lancement'])); ?></td>
                                <td>
                                    <span style="display: inline-block; padding: 4px 8px; border-radius: 3px; font-size: 12px; font-weight: 600;
                                        <?php 
                                            echo match($b['statut_lot']) {
                                                'actif' => 'background: #d4edda; color: #155724;',
                                                'cloture' => 'background: #e2e3e5; color: #383d41;',
                                                default => 'background: #e2e3e5; color: #383d41;'
                                            };
                                        ?>">
                                        <?php echo ucfirst($b['statut_lot']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/ElevageHome/public/?url=bandes/edit/<?php echo $b['id_bande']; ?>" class="btn btn-primary btn-sm">✏️</a>
                                    <a href="/ElevageHome/public/?url=bandes/delete/<?php echo $b['id_bande']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Clôturer cette espèce?')">🗑️</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
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

    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
    }

    .card-title {
        margin: 0;
        font-size: 16px;
        color: #1f3057;
        font-weight: 600;
    }

    .card-body {
        padding: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .table thead {
        background: #f8f9fa;
    }

    .table th {
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: #1f3057;
        border-bottom: 2px solid #e0e0e0;
    }

    .table td {
        padding: 12px 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    .btn {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-size: 12px;
        transition: all 0.3s ease;
        margin: 0 2px;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0056b3;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 11px;
    }

    /* DataTables overrides */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 6px 10px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 4px;
        margin: 2px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #007bff;
    }

    @media (max-width: 768px) {
        .table {
            font-size: 11px;
        }

        .table th, .table td {
            padding: 8px 10px;
        }

        .btn {
            padding: 4px 8px;
            font-size: 10px;
        }
    }
</style>

<script>
$(document).ready(function() {
    initFullDataTable('#bandesTable', {
        order: [[0, 'asc']]
    });
});
</script>
