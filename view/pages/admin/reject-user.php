<?php $active = 'admin'; $title = 'Rejeter utilisateur'; ?>

<div class="content-header">
    <h1>❌ Rejeter la demande</h1>
</div>

<div style="max-width: 500px;">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Rejeter <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></h3>
        </div>
        <div class="card-body">
            <p style="margin-bottom: 20px; color: #666;">
                Vous êtes sur le point de rejeter la demande de <strong><?php echo htmlspecialchars($user['email']); ?></strong>
            </p>
            <p style="margin-bottom: 20px; color: #666;">
                L'utilisateur recevra une notification par email expliquant le rejet.
            </p>
            
            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Motif du rejet (optionnel)</label>
                    <textarea name="reason" class="form-control" rows="4" placeholder="Expliquez pourquoi vous rejetez cette demande..."></textarea>
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-danger">❌ Confirmer le rejet</button>
                    <a href="/ElevageHome/public/?url=admin/pending" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.content-header {
    margin-bottom: 30px;
}

.content-header h1 {
    font-size: 24px;
    color: #1f3057;
    font-weight: 600;
    margin: 0;
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

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}
</style>
