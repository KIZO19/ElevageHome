<?php $active = 'clients'; $title = 'Modifier un Client'; ?>

<div class="content-header">
    <h1>✏️ Modifier un Client</h1>
    <div class="breadcrumb">
        <a href="/ElevageHome/public/?url=dashboard">Accueil</a> / 
        <a href="/ElevageHome/public/?url=clients">Clients</a> / 
        Modifier
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulaire de modification</h3>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div style="padding: 12px 15px; background: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
                ⚠️ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" style="max-width: 600px;">
            <div class="form-group">
                <label class="form-label">Nom Complet * </label>
                <input type="text" name="nom_complet" class="form-control" value="<?php echo htmlspecialchars($client['nom_complet']); ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Téléphone * </label>
                <input type="tel" name="telephone" class="form-control" value="<?php echo htmlspecialchars($client['telephone']); ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Adresse (Goma)</label>
                <input type="text" name="adresse_goma" class="form-control" value="<?php echo htmlspecialchars($client['adresse_goma'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Type de Client</label>
                <select name="type_client" class="form-control">
                    <option value="particulier" <?php echo $client['type_client'] === 'particulier' ? 'selected' : ''; ?>>Particulier</option>
                    <option value="grossiste" <?php echo $client['type_client'] === 'grossiste' ? 'selected' : ''; ?>>Grossiste</option>
                    <option value="restaurant_hotel" <?php echo $client['type_client'] === 'restaurant_hotel' ? 'selected' : ''; ?>>Restaurant/Hôtel</option>
                </select>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary">✅ Mettre à jour</button>
                <a href="/ElevageHome/public/?url=clients" class="btn btn-secondary">❌ Annuler</a>
            </div>
        </form>
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
        color: #1f3057;
        font-size: 13px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        font-size: 13px;
        font-family: inherit;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        font-size: 13px;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0056b3;
    }

    .btn-secondary {
        background: #e9ecef;
        color: #495057;
    }

    .btn-secondary:hover {
        background: #dee2e6;
    }
</style>
