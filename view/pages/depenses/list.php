<?php $active = 'depenses'; $title = 'Dépenses'; ?>

<div class="content-header">
    <h1>💸 Gestion des Dépenses</h1>
    <div class="breadcrumb">
        <a href="/ElevageHome/public/?url=dashboard">Accueil</a> / Dépenses
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Liste des Dépenses</h3>
        <a href="/ElevageHome/public/?url=depenses/add" class="btn btn-primary btn-sm">➕ Ajouter</a>
    </div>
    <div class="card-body">
        <div style="overflow-x: auto;">
            <table id="depensesTable" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Espèce</th>
                        <th>Type Charge</th>
                        <th>Description</th>
                        <th>Quantité</th>
                        <th>P.U.</th>
                        <th>Montant Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($depenses)): ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 20px; color: #999;">
                                Aucune dépense enregistrée
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($depenses as $d): ?>
                            <tr>
                                <td><?php echo date('d/m/Y', strtotime($d['date_depense'])); ?></td>
                                <td><?php echo htmlspecialchars($d['code_bande']); ?></td>
                                <td><?php echo htmlspecialchars($d['nom_categorie']); ?></td>
                                <td><?php echo htmlspecialchars($d['libelle_depense']); ?></td>
                                <td><?php echo number_format($d['quantite'], 2); ?> <?php echo htmlspecialchars($d['unite_mesure'] ?? 'unité'); ?></td>
                                <td><?php echo number_format($d['prix_unitaire'], 2); ?> FC</td>
                                <td><strong><?php echo number_format($d['montant_total_charge'], 2); ?> FC</strong></td>
                                <td>
                                    <a href="/ElevageHome/public/?url=depenses/edit/<?php echo $d['id_depense']; ?>" class="btn btn-primary btn-sm">✏️</a>
                                    <a href="/ElevageHome/public/?url=depenses/delete/<?php echo $d['id_depense']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer?')">🗑️</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" style="text-align: right;">Total (page / global)</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
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
    $('#depensesTable').DataTable({
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
        footerCallback: function(row, data, start, end, display) {
            var api = this.api();
            var parseValue = function(i) {
                if (typeof i === 'string') {
                    return parseFloat(i.replace(/[^
\d\.\-]/g, '')) || 0;
                }
                return typeof i === 'number' ? i : 0;
            };
            var totalQty = api.column(4, { search: 'applied' }).data().reduce(function(a, b) {
                return a + parseValue(b);
            }, 0);
            var pageQty = api.column(4, { page: 'current' }).data().reduce(function(a, b) {
                return a + parseValue(b);
            }, 0);
            var totalAmt = api.column(6, { search: 'applied' }).data().reduce(function(a, b) {
                return a + parseValue(b);
            }, 0);
            var pageAmt = api.column(6, { page: 'current' }).data().reduce(function(a, b) {
                return a + parseValue(b);
            }, 0);
            $(api.column(4).footer()).html(pageQty.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' / ' + totalQty.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $(api.column(6).footer()).html(pageAmt.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' / ' + totalAmt.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' FC');
        },
        order: [[0, 'desc']]
    });
});
</script>
