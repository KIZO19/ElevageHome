<?php $active = 'mortalite'; $title = 'Modifier une Mortalité'; ?>

<div class="content-header">
    <h1>✏️ Modifier une Mortalité</h1>
    <div class="breadcrumb">
        <a href="/ElevageHome/public/?url=dashboard">Accueil</a> / 
        <a href="/ElevageHome/public/?url=mortalite">Mortalité</a> / 
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
                <label class="form-label">Espèce</label>
                <select disabled class="form-control">
                    <option><?php echo htmlspecialchars($mortalite['code_bande']); ?></option>
                </select>
                <small style="color: #999;">Non modifiable</small>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label">Nombre de Morts * </label>
                    <input type="number" name="nbre_sujets_morts" min="1" class="form-control" value="<?php echo $mortalite['nbre_sujets_morts']; ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Date de la Perte * </label>
                    <input type="date" name="date_perte" class="form-control" value="<?php echo $mortalite['date_perte']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Cause Probable</label>
                <select name="cause_probable" class="form-control">
                    <option value="">-- Sélectionner une cause --</option>
                    <option value="maladie" <?php echo $mortalite['cause_probable'] === 'maladie' ? 'selected' : ''; ?>>Maladie</option>
                    <option value="predateur" <?php echo $mortalite['cause_probable'] === 'predateur' ? 'selected' : ''; ?>>Prédateur</option>
                    <option value="malnutrition" <?php echo $mortalite['cause_probable'] === 'malnutrition' ? 'selected' : ''; ?>>Malnutrition</option>
                    <option value="accident" <?php echo $mortalite['cause_probable'] === 'accident' ? 'selected' : ''; ?>>Accident</option>
                    <option value="age" <?php echo $mortalite['cause_probable'] === 'age' ? 'selected' : ''; ?>>Vieillesse</option>
                    <option value="cannibalisme" <?php echo $mortalite['cause_probable'] === 'cannibalisme' ? 'selected' : ''; ?>>Cannibalisme</option>
                    <option value="autre" <?php echo $mortalite['cause_probable'] === 'autre' ? 'selected' : ''; ?>>Autre</option>
                </select>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary">✅ Mettre à jour</button>
                <a href="/ElevageHome/public/?url=mortalite" class="btn btn-secondary">❌ Annuler</a>
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
