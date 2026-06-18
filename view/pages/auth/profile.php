<?php $active = 'auth'; $title = 'Mon Profil'; ?>

<div class="content-header">
    <h1>👤 Mon Profil</h1>
</div>

<div style="max-width: 600px;">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mes Informations</h3>
        </div>
        <div class="card-body">
            <?php if (isset($success)): ?>
                <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                    ✅ <?php echo htmlspecialchars($success); ?>
                </div>
            <?php elseif (isset($error)): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                    ❌ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email (non modifiable)</label>
                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Rôle</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['nom_role']); ?>" disabled>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Inscrit depuis</label>
                    <input type="text" class="form-control" value="<?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?>" disabled>
                </div>
                
                <button type="submit" class="btn btn-primary">✅ Mettre à jour</button>
            </form>
        </div>
    </div>
    
    <div class="card" style="margin-top: 20px;">
        <div class="card-header">
            <h3 class="card-title">Sécurité</h3>
        </div>
        <div class="card-body">
            <a href="/ElevageHome/public/?url=auth/forgot-password" class="btn btn-secondary">🔐 Changer mon mot de passe</a>
            <a href="/ElevageHome/public/?url=auth/logout" class="btn btn-danger" style="margin-left: 10px;">🚪 Se déconnecter</a>
        </div>
    </div>
</div>

<style>
.content-header {
    margin-bottom: 30px;
}

.content-header h1 {
    font-size: 28px;
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
    margin-bottom: 15px;
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

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-primary:hover {
    background: #0056b3;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
}
</style>
