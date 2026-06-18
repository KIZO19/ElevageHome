<?php $active = 'factures'; $title = 'Créer une Facture'; ?>

<div class="content-header">
    <h1>➕ Créer une Facture</h1>
    <div class="breadcrumb">
        <a href="/ElevageHome/public/?url=dashboard">Accueil</a> / 
        <a href="/ElevageHome/public/?url=factures">Factures</a> / 
        Créer
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulaire de création</h3>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div style="padding: 12px 15px; background: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
                ⚠️ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" style="max-width: 600px;">
            <div class="form-group">
                <label class="form-label">Client * </label>
                <select name="id_client" class="form-control" required>
                    <option value="">-- Sélectionner un client --</option>
                    <?php foreach ($clients as $c): ?>
                        <option value="<?php echo $c['id_client']; ?>">
                            <?php echo htmlspecialchars($c['nom_complet']); ?> (<?php echo htmlspecialchars($c['telephone']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label">Date Facturation * </label>
                    <input type="date" name="date_facturation" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Statut Paiement</label>
                    <select name="statut_paiement" class="form-control">
                        <option value="non_paye">Non Payé</option>
                        <option value="avance">Avance</option>
                        <option value="paye">Payé</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Mode Paiement</label>
                <select name="mode_paiement" class="form-control">
                    <option value="cash">💵 Cash</option>
                    <option value="mobile_money">📱 Mobile Money</option>
                    <option value="credit">🏦 Crédit</option>
                </select>
            </div>

            <div style="margin-top: 30px; padding: 15px; background: #e7f3ff; border-radius: 4px; border-left: 4px solid #007bff;">
                <strong>ℹ️ Note:</strong> Après création, vous pourrez ajouter des lignes de produits à la facture.
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary">✅ Créer Facture</button>
                <a href="/ElevageHome/public/?url=factures" class="btn btn-secondary">❌ Annuler</a>
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
