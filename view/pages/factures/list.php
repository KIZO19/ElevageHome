<?php $active = 'factures'; $title = 'Facturation'; ?>

<div class="content-header">
    <h1>💰 Gestion des Factures</h1>
    <div class="breadcrumb">
        <a href="/ElevageHome/public/?url=dashboard">Accueil</a> / Factures
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Liste des Factures</h3>
        <a href="/ElevageHome/public/?url=factures/add" class="btn btn-primary btn-sm">➕ Nouvelle Facture</a>
    </div>
    <div class="card-body">
        <div style="overflow-x: auto;">
            <table id="facturesTable" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Téléphone</th>
                        <th>Montant</th>
                        <th>Statut Paiement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($factures)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px; color: #999;">
                                Aucune facture enregistrée
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($factures as $f): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($f['numero_facture']); ?></strong></td>
                                <td><?php echo date('d/m/Y', strtotime($f['date_facturation'])); ?></td>
                                <td><?php echo htmlspecialchars($f['nom_complet']); ?></td>
                                <td><?php echo htmlspecialchars($f['telephone']); ?></td>
                                <td><strong><?php echo number_format($f['montant_total_facture'], 2); ?> FC</strong></td>
                                <td>
                                    <?php 
                                    $badges = [
                                        'paye' => ['bg' => '#28a745', 'text' => 'Payé'],
                                        'avance' => ['bg' => '#ffc107', 'text' => 'Avance'],
                                        'non_paye' => ['bg' => '#dc3545', 'text' => 'Non Payé']
                                    ];
                                    $statut = $f['statut_paiement'];
                                    $badge = $badges[$statut] ?? ['bg' => '#6c757d', 'text' => $statut];
                                    ?>
                                    <span style="background: <?php echo $badge['bg']; ?>; color: white; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                                        <?php echo $badge['text']; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/ElevageHome/public/?url=factures/view/<?php echo $f['id_facture']; ?>" class="btn btn-info btn-sm">👁️</a>
                                    <a href="/ElevageHome/public/?url=factures/edit/<?php echo $f['id_facture']; ?>" class="btn btn-primary btn-sm">✏️</a>
                                    <a href="/ElevageHome/public/?url=factures/delete/<?php echo $f['id_facture']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer?')">🗑️</a>
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

    .btn-info {
        background: #17a2b8;
        color: white;
    }

    .btn-info:hover {
        background: #138496;
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
    $('#facturesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json'
        },
        pageLength: 25,
        dom: 'Bfrtip',
        buttons: [
            'copy', 
            {
                extend: 'csv',
                text: 'CSV'
            },
            {
                extend: 'excel',
                text: 'Excel'
            },
            {
                extend: 'pdf',
                text: 'PDF'
            },
            'print'
        ],
        responsive: true,
        columnDefs: [
            {
                targets: -1,
                orderable: false
            }
        ],
        order: [[1, 'desc']]
    });
});
</script>
