<?php $active = 'admin'; $title = 'Éditer utilisateur'; ?>

<div class="content-header">
    <h1>✏️ Éditer l'utilisateur</h1>
    <a href="/ElevageHome/public/?url=admin/users" class="btn btn-secondary">← Retour</a>
</div>

<div style="max-width: 600px;">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></h3>
        </div>
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                    ❌ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Prénom *</label>
                    <input type="text" name="prenom" class="form-control" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nom *</label>
                    <input type="text" name="nom" class="form-control" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" placeholder="Laisser vide pour conserver le mot de passe actuel">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Rôle *</label>
                    <select name="id_role" class="form-control" required>
                        <option value="">-- Sélectionner un rôle --</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?php echo $role['id_role']; ?>" <?php echo ($user['id_role'] == $role['id_role']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($role['nom_role']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Exploitation</label>
                    <select name="id_exploitation" class="form-control">
                        <option value="">-- Aucune exploitation --</option>
                        <?php foreach ($exploitations as $exp): ?>
                            <option value="<?php echo $exp['id_exploitation']; ?>" <?php echo ($user['id_exploitation'] == $exp['id_exploitation']) ? 'selected' : ''; ?> >
                                <?php echo htmlspecialchars($exp['nom_responsable'] . ' - ' . $exp['quartier_goma']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Statut du compte *</label>
                    <select name="statut_compte" class="form-control" required>
                        <option value="actif" <?php echo ($user['statut_compte'] === 'actif') ? 'selected' : ''; ?>>Actif</option>
                        <option value="suspendu" <?php echo ($user['statut_compte'] === 'suspendu') ? 'selected' : ''; ?>>Suspendu</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email confirmé</label>
                    <div style="padding: 10px; background: #f8f9fa; border-radius: 4px;">
                        <?php if ($user['email_confirmed'] ?? false): ?>
                            <span style="background: #d4edda; color: #155724; padding: 6px 12px; border-radius: 4px;">✅ Oui</span>
                        <?php else: ?>
                            <span style="background: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 4px;">⏳ En attente</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div style="display: flex; gap: 10px; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary">✅ Mettre à jour</button>
                    <a href="/ElevageHome/public/?url=admin/users" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
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

.form-control:disabled {
    background: #f8f9fa;
    color: #666;
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
</style>
