<?php $active = 'depenses'; $title = 'Modifier une Dépense'; ?>

<div class="content-header">
    <h1>✏️ Modifier une Dépense</h1>
    <div class="breadcrumb">
        <a href="/ElevageHome/public/?url=dashboard">Accueil</a> / 
        <a href="/ElevageHome/public/?url=depenses">Dépenses</a> / 
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
                    <option><?php echo htmlspecialchars($depense['code_bande']); ?></option>
                </select>
                <small style="color: #999;">Non modifiable</small>
            </div>

            <div class="form-group">
                <label class="form-label">Type de Charge * </label>
                <select name="id_type_charge" class="form-control" required>
                    <option value="1" <?php echo $depense['id_type_charge'] == 1 ? 'selected' : ''; ?>>Alimentation (Provende/Maïs)</option>
                    <option value="2" <?php echo $depense['id_type_charge'] == 2 ? 'selected' : ''; ?>>Santé & Médicaments (Vaccins)</option>
                    <option value="3" <?php echo $depense['id_type_charge'] == 3 ? 'selected' : ''; ?>>Main-d'œuvre (Aide/Ouvrier)</option>
                    <option value="4" <?php echo $depense['id_type_charge'] == 4 ? 'selected' : ''; ?>>Transport & Logistique</option>
                    <option value="5" <?php echo $depense['id_type_charge'] == 5 ? 'selected' : ''; ?>>Infrastructure & Énergie (Chauffage/Braises)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Description * </label>
                <input type="text" name="libelle_depense" class="form-control" value="<?php echo htmlspecialchars($depense['libelle_depense']); ?>" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label">Quantité * </label>
                    <input type="number" name="quantite" step="0.01" min="0" class="form-control" value="<?php echo $depense['quantite']; ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Unité Mesure * </label>
                    <select name="unite_mesure" class="form-control" required>
                        <option value="kg" <?php echo $depense['unite_mesure'] === 'kg' ? 'selected' : ''; ?>>Kilogramme (kg)</option>
                        <option value="litre" <?php echo $depense['unite_mesure'] === 'litre' ? 'selected' : ''; ?>>Litre (L)</option>
                        <option value="piece" <?php echo $depense['unite_mesure'] === 'piece' ? 'selected' : ''; ?>>Pièce</option>
                        <option value="sac" <?php echo $depense['unite_mesure'] === 'sac' ? 'selected' : ''; ?>>Sac</option>
                        <option value="carton" <?php echo $depense['unite_mesure'] === 'carton' ? 'selected' : ''; ?>>Carton</option>
                        <option value="forfait" <?php echo $depense['unite_mesure'] === 'forfait' ? 'selected' : ''; ?>>Forfait</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label">Prix Unitaire (FC) * </label>
                    <input type="number" name="prix_unitaire" step="0.01" min="0" class="form-control" value="<?php echo $depense['prix_unitaire']; ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Date Dépense * </label>
                    <input type="date" name="date_depense" class="form-control" value="<?php echo $depense['date_depense']; ?>" required>
                </div>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary">✅ Mettre à jour</button>
                <a href="/ElevageHome/public/?url=depenses" class="btn btn-secondary">❌ Annuler</a>
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
