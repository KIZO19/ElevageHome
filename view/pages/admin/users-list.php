<?php $active = 'admin'; $title = 'Tous les utilisateurs'; ?>

<div class="content-header">
    <h1>👥 Gestion des utilisateurs</h1>
    <a href="/ElevageHome/public/?url=admin/dashboard" class="btn btn-secondary">← Retour</a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo count($users); ?> utilisateur(s)</h3>
    </div>
    <div class="card-body">
        <div style="overflow-x: auto;">
            <table id="usersTable" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Statut Email</th>
                        <th>Compte</th>
                        <th>Inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <strong><?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></strong>
                            </td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span style="background: #e3f2fd; color: #1976d2; padding: 4px 8px; border-radius: 4px;">
                                    <?php echo htmlspecialchars($user['nom_role']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($user['email_confirmed']): ?>
                                    <span style="background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px;">✅ Confirmé</span>
                                <?php else: ?>
                                    <span style="background: #fff3cd; color: #856404; padding: 4px 8px; border-radius: 4px;">⏳ En attente</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($user['statut_compte'] === 'actif'): ?>
                                    <span style="background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px;">✅ Actif</span>
                                <?php else: ?>
                                    <span style="background: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px;">🔒 Suspendu</span>
                                <?php endif; ?>
                            </td>
                            <td style="font-size: 12px; color: #999;">
                                <?php echo date('d/m/Y', strtotime($user['created_at'])); ?>
                            </td>
                            <td>
                                <a href="/ElevageHome/public/?url=admin/edit/<?php echo $user['id_utilisateur']; ?>" 
                                   class="btn-sm" style="background: #007bff; color: white; padding: 4px 8px; border-radius: 4px; text-decoration: none; font-size: 11px;">
                                    ✏️ Modifier
                                </a>
                                <?php if ($user['statut_compte'] === 'actif'): ?>
                                    <a href="/ElevageHome/public/?url=admin/suspend/<?php echo $user['id_utilisateur']; ?>" 
                                       onclick="return confirm('Suspendre cet utilisateur?')"
                                       class="btn-sm" style="background: #ff9800; color: white; padding: 4px 8px; border-radius: 4px; text-decoration: none; font-size: 11px;">
                                        ⏸️ Suspendre
                                    </a>
                                <?php else: ?>
                                    <a href="/ElevageHome/public/?url=admin/activate/<?php echo $user['id_utilisateur']; ?>" 
                                       class="btn-sm" style="background: #28a745; color: white; padding: 4px 8px; border-radius: 4px; text-decoration: none; font-size: 11px;">
                                        ▶️ Activer
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.content-header h1 {
    font-size: 24px;
    color: #1f3057;
    font-weight: 600;
    margin: 0;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    cursor: pointer;
    font-size: 13px;
}

.btn-secondary:hover {
    background: #5a6268;
}

.card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-header {
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
    padding: 12px;
    text-align: left;
    font-weight: 600;
    color: #1f3057;
    border-bottom: 2px solid #e0e0e0;
}

.table td {
    padding: 12px;
    border-bottom: 1px solid #e0e0e0;
}

.table tbody tr:hover {
    background: #f8f9fa;
}

.btn-sm {
    display: inline-block;
    margin-right: 4px;
    transition: all 0.3s ease;
}

.btn-sm:hover {
    opacity: 0.8;
    transform: translateY(-2px);
}
</style>

<script>
$(document).ready(function() {
    $('#usersTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json'
        },
        pageLength: 25,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        responsive: true,
        columnDefs: [{targets: -1, orderable: false}],
        order: [[5, 'desc']]
    });
});
</script>
