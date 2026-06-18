<?php $active = 'admin'; $title = 'Utilisateurs en attente'; ?>

<div class="content-header">
    <h1>📋 Utilisateurs en attente de confirmation</h1>
    <a href="/ElevageHome/public/?url=admin/dashboard" class="btn btn-secondary">← Retour</a>
</div>

<?php if (empty($users)): ?>
    <div class="card">
        <div class="card-body" style="text-align: center; padding: 60px 20px;">
            <p style="font-size: 18px; color: #999;">✅ Aucun utilisateur en attente!</p>
        </div>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo count($users); ?> utilisateur(s) en attente</h3>
        </div>
        <div class="card-body">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8f9fa;">
                            <th style="padding: 12px; text-align: left; font-weight: 600; border-bottom: 2px solid #ddd;">Nom</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; border-bottom: 2px solid #ddd;">Email</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; border-bottom: 2px solid #ddd;">Rôle</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; border-bottom: 2px solid #ddd;">Inscription</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; border-bottom: 2px solid #ddd;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 12px;">
                                    <strong><?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></strong>
                                </td>
                                <td style="padding: 12px;"><?php echo htmlspecialchars($user['email']); ?></td>
                                <td style="padding: 12px;">
                                    <span style="background: #e3f2fd; color: #1976d2; padding: 4px 8px; border-radius: 4px;">
                                        <?php echo htmlspecialchars($user['nom_role']); ?>
                                    </span>
                                </td>
                                <td style="padding: 12px; font-size: 12px; color: #999;">
                                    <?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?>
                                </td>
                                <td style="padding: 12px;">
                                    <a href="/ElevageHome/public/?url=admin/approve/<?php echo $user['id_utilisateur']; ?>" 
                                       class="btn btn-sm" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px;">
                                        ✅ Approuver
                                    </a>
                                    <a href="/ElevageHome/public/?url=admin/reject/<?php echo $user['id_utilisateur']; ?>" 
                                       class="btn btn-sm" style="background: #dc3545; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; margin-left: 5px;">
                                        ❌ Rejeter
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

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

.btn-sm {
    display: inline-block;
    transition: all 0.3s ease;
}

.btn-sm:hover {
    opacity: 0.8;
    transform: translateY(-2px);
}
</style>
