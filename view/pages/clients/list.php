<?php $active = 'clients'; $title = 'Gestion des Clients'; ?>

<div class="content-header">
    <h1>👥 Gestion des Clients</h1>
    <div class="breadcrumb">
        <a href="/ElevageHome/public/?url=dashboard">Accueil</a> / Clients
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Liste des Clients</h3>
        <a href="/ElevageHome/public/?url=clients/add" class="btn btn-primary btn-sm">➕ Ajouter</a>
    </div>
    <div class="card-body">
        <div style="overflow-x: auto;">
            <table id="clientsTable" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th>Type Client</th>
                        <th>Dette</th>
                        <th>Date Création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($clients)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px; color: #999;">
                                Aucun client enregistré
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($clients as $c): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($c['nom_complet']); ?></strong></td>
                                <td><?php echo htmlspecialchars($c['telephone']); ?></td>
                                <td><?php echo htmlspecialchars($c['adresse_goma'] ?? '-'); ?></td>
                                <td>
                                    <?php 
                                    $badges = [
                                        'particulier' => ['bg' => '#007bff', 'text' => 'Particulier'],
                                        'grossiste' => ['bg' => '#28a745', 'text' => 'Grossiste'],
                                        'restaurant_hotel' => ['bg' => '#ff6b6b', 'text' => 'Restaurant/Hôtel']
                                    ];
                                    $type = $c['type_client'];
                                    $badge = $badges[$type] ?? ['bg' => '#6c757d', 'text' => $type];
                                    ?>
                                    <span style="background: <?php echo $badge['bg']; ?>; color: white; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                                        <?php echo $badge['text']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($c['total_dette']) && $c['total_dette'] > 0): ?>
                                        <span style="background: #f8d7da; color: #721c24; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; display: inline-block;">
                                            <?php echo number_format($c['total_dette'], 2); ?> FC
                                        </span>
                                    <?php else: ?>
                                        <span style="background: #d4edda; color: #155724; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; display: inline-block;">
                                            0,00 FC
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($c['created_at'])); ?></td>
                                <td>
                                    <a href="/ElevageHome/public/?url=clients/edit/<?php echo $c['id_client']; ?>" class="btn btn-primary btn-sm">✏️</a>
                                    <a href="/ElevageHome/public/?url=clients/delete/<?php echo $c['id_client']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce client?')">🗑️</a>
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
    initFullDataTable('#clientsTable', {
        order: [[0, 'asc']]
    });
});
</script>
