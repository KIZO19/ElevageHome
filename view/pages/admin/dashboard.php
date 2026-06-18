<?php $active = 'admin'; $title = 'Gestion des Utilisateurs'; ?>

<div class="content-header">
    <h1>⚙️ Gestion des Utilisateurs</h1>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="stat-card">
        <div class="stat-number"><?php echo $total; ?></div>
        <div class="stat-label">Total d'utilisateurs</div>
    </div>
    <div class="stat-card">
        <div class="stat-number" style="color: #ff9800;"><?php echo $pending; ?></div>
        <div class="stat-label">En attente de confirmation</div>
    </div>
    <div class="stat-card">
        <div class="stat-number" style="color: #28a745;"><?php echo $confirmed; ?></div>
        <div class="stat-label">Confirmés</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
    <a href="/ElevageHome/public/?url=admin/pending" class="card-link">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">📋 Comptes en attente</h3>
            </div>
            <div class="card-body">
                <p style="margin: 0; color: #666;">Approuver ou rejeter les nouvelles demandes</p>
                <p style="margin-top: 10px; font-size: 24px; font-weight: bold; color: #ff9800;">
                    <?php echo $pending; ?>
                </p>
            </div>
        </div>
    </a>
    
    <a href="/ElevageHome/public/?url=admin/users" class="card-link">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">👥 Tous les utilisateurs</h3>
            </div>
            <div class="card-body">
                <p style="margin: 0; color: #666;">Gérer les rôles et permissions</p>
                <p style="margin-top: 10px; font-size: 24px; font-weight: bold; color: #007bff;">
                    <?php echo $total; ?>
                </p>
            </div>
        </div>
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">📅 Utilisateurs récents</h3>
    </div>
    <div class="card-body">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th style="padding: 12px; text-align: left; font-weight: 600; border-bottom: 2px solid #ddd;">Nom</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; border-bottom: 2px solid #ddd;">Email</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; border-bottom: 2px solid #ddd;">Rôle</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; border-bottom: 2px solid #ddd;">Statut</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; border-bottom: 2px solid #ddd;">Inscription</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent as $user): ?>
                        <tr style="border-bottom: 1px solid #eee; hover: {background: #f8f9fa;}">
                            <td style="padding: 12px;"><?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></td>
                            <td style="padding: 12px;"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td style="padding: 12px;">
                                <span style="background: #e3f2fd; color: #1976d2; padding: 4px 8px; border-radius: 4px;">
                                    <?php echo htmlspecialchars($user['nom_role']); ?>
                                </span>
                            </td>
                            <td style="padding: 12px;">
                                <?php if ($user['email_confirmed']): ?>
                                    <span style="background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px;">✅ Confirmé</span>
                                <?php else: ?>
                                    <span style="background: #fff3cd; color: #856404; padding: 4px 8px; border-radius: 4px;">⏳ En attente</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 12px; font-size: 12px; color: #999;">
                                <?php echo date('d/m/Y', strtotime($user['created_at'])); ?>
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
    font-size: 28px;
    color: #1f3057;
    font-weight: 600;
    margin: 0;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.stat-number {
    font-size: 32px;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 10px;
}

.stat-label {
    font-size: 14px;
    color: #666;
}

.card-link {
    text-decoration: none;
    color: inherit;
}

.card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-link .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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
</style>
