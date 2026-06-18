<?php $active = 'bandes'; $title = 'Modifier une Espèce'; ?>

<div class="content-header">
    <h1>✏️ Modifier une Espèce</h1>
    <div class="breadcrumb">
        <a href="/ElevageHome/public/?url=dashboard">Accueil</a> / 
        <a href="/ElevageHome/public/?url=bandes">Espèces</a> / 
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
                <label class="form-label">Code Espèce</label>
                <input type="text" value="<?php echo htmlspecialchars($bande['code_bande']); ?>" class="form-control" disabled>
                <small style="color: #999;">Non modifiable</small>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label">Espèce * </label>
                    <select name="espece_detaillee" class="form-control" required>
                        <option value="Poulet Chair" <?php echo $bande['espece_detaillee'] === 'Poulet Chair' ? 'selected' : ''; ?>>Poulet Chair</option>
                        <option value="Poule Pondeuse" <?php echo $bande['espece_detaillee'] === 'Poule Pondeuse' ? 'selected' : ''; ?>>Poule Pondeuse</option>
                        <option value="Poulet Indigène" <?php echo $bande['espece_detaillee'] === 'Poulet Indigène' ? 'selected' : ''; ?>>Poulet Indigène</option>
                        <option value="Pintade" <?php echo $bande['espece_detaillee'] === 'Pintade' ? 'selected' : ''; ?>>Pintade</option>
                        <option value="Canard" <?php echo $bande['espece_detaillee'] === 'Canard' ? 'selected' : ''; ?>>Canard</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Type Production * </label>
                    <select name="type_production" class="form-control" required>
                        <option value="chair" <?php echo $bande['type_production'] === 'chair' ? 'selected' : ''; ?>>Chair</option>
                        <option value="pondeuse" <?php echo $bande['type_production'] === 'pondeuse' ? 'selected' : ''; ?>>Pondeuse</option>
                        <option value="indigene_local" <?php echo $bande['type_production'] === 'indigene_local' ? 'selected' : ''; ?>>Indigène Local</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label">Quantité Initiale * </label>
                    <input type="number" name="quantite_initiale" class="form-control" min="1" value="<?php echo $bande['quantite_initiale']; ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Date Lancement * </label>
                    <input type="date" name="date_lancement" class="form-control" value="<?php echo $bande['date_lancement']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Observations</label>
                <textarea name="observations" class="form-control" rows="3"><?php echo htmlspecialchars($bande['observations'] ?? ''); ?></textarea>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary">✅ Mettre à jour</button>
                <a href="/ElevageHome/public/?url=bandes" class="btn btn-secondary">❌ Annuler</a>
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

    .form-control:disabled {
        background: #f8f9fa;
        cursor: not-allowed;
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
