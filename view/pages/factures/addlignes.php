<?php $active = 'factures'; $title = 'Ajouter Lignes Facture'; ?>

<div class="content-header">
    <h1>➕ Ajouter Produits à la Facture</h1>
    <div class="breadcrumb">
        <a href="/ElevageHome/public/?url=dashboard">Accueil</a> / 
        <a href="/ElevageHome/public/?url=factures">Factures</a> / 
        Ajouter Produits
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Facture <?php echo htmlspecialchars($facture['numero_facture']); ?> - <?php echo htmlspecialchars($facture['nom_complet']); ?></h3>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div style="padding: 12px 15px; background: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
                ⚠️ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" style="margin-bottom: 30px;">
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 15px; align-items: flex-end; margin-bottom: 20px;">
                <div class="form-group" style="margin: 0;">
                    <label class="form-label">Produit * </label>
                    <select name="produit_vendu" class="form-control" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="oeufs">🥚 Œufs</option>
                        <option value="poussins">🐥 Poussins</option>
                        <option value="poules">🐔 Poules</option>
                        <option value="fumier">♻️ Fumier</option>
                        <option value="autres">📦 Autres</option>
                    </select>
                </div>

                <div class="form-group" style="margin: 0;">
                    <label class="form-label">Quantité * </label>
                    <input type="number" name="quantite" class="form-control" placeholder="0" step="0.01" required>
                </div>

                <div class="form-group" style="margin: 0;">
                    <label class="form-label">P.U. (FC) * </label>
                    <input type="number" name="prix_unitaire_vente" class="form-control" placeholder="0" step="0.01" required>
                </div>

                <div class="form-group" style="margin: 0;">
                    <label class="form-label">Espèce</label>
                    <select name="id_bande" class="form-control">
                        <option value="">-- Aucune --</option>
                        <?php foreach ($bandes as $b): ?>
                            <option value="<?php echo $b['id_bande']; ?>">
                                <?php echo htmlspecialchars($b['code_bande']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" name="action" value="add_ligne" class="btn btn-primary" style="padding: 10px 20px;">
                    ➕ Ajouter
                </button>
            </div>
        </form>

        <!-- Tableau des lignes ajoutées -->
        <div style="margin-bottom: 30px;">
            <h4 style="margin: 0 0 15px 0; color: #1f3057; font-size: 14px; font-weight: 600;">📋 Lignes de la Facture</h4>
            
            <?php if (empty($lignes)): ?>
                <div style="padding: 30px; text-align: center; background: #f8f9fa; border-radius: 4px; color: #999;">
                    Aucune ligne ajoutée. Commencez par ajouter un produit.
                </div>
            <?php else: ?>
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background: #f8f9fa;">
                            <th style="padding: 10px; text-align: left; border-bottom: 2px solid #e0e0e0; font-weight: 600;">Produit</th>
                            <th style="padding: 10px; text-align: center; border-bottom: 2px solid #e0e0e0; font-weight: 600;">Quantité</th>
                            <th style="padding: 10px; text-align: center; border-bottom: 2px solid #e0e0e0; font-weight: 600;">P.U. (FC)</th>
                            <th style="padding: 10px; text-align: right; border-bottom: 2px solid #e0e0e0; font-weight: 600;">Montant (FC)</th>
                            <th style="padding: 10px; text-align: center; border-bottom: 2px solid #e0e0e0; font-weight: 600;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($lignes as $l): 
                            $montant = round($l['quantite'] * $l['prix_unitaire_vente'], 2);
                            $total += $montant;
                        ?>
                            <tr style="border-bottom: 1px solid #e0e0e0;">
                                <td style="padding: 10px;">
                                    <?php echo ucfirst(str_replace('_', ' ', $l['produit_vendu'])); ?>
                                    <?php if ($l['code_bande']): ?><br><small style="color: #999;"><?php echo htmlspecialchars($l['code_bande']); ?></small><?php endif; ?>
                                </td>
                                <td style="padding: 10px; text-align: center;">
                                    <?php echo number_format($l['quantite'], 2); ?>
                                </td>
                                <td style="padding: 10px; text-align: center;">
                                    <?php echo number_format($l['prix_unitaire_vente'], 2); ?>
                                </td>
                                <td style="padding: 10px; text-align: right; font-weight: 600;">
                                    <?php echo number_format($l['montant_ligne'], 2); ?>
                                </td>
                                <td style="padding: 10px; text-align: center;">
                                    <a href="/ElevageHome/public/?url=factures/deleteligne/<?php echo $l['id_ligne']; ?>/<?php echo $facture['id_facture']; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Supprimer cette ligne?')"
                                       style="background: #dc3545; color: white; padding: 4px 8px; border: none; border-radius: 4px; cursor: pointer; font-size: 11px; text-decoration: none; display: inline-block;">
                                        🗑️
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="background: #f8f9fa; font-weight: 600;">
                            <td colspan="3" style="padding: 12px 10px; text-align: right;">TOTAL:</td>
                            <td style="padding: 12px 10px; text-align: right; color: #28a745; font-size: 15px;">
                                <?php echo number_format($total, 2); ?> FC
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            <?php endif; ?>
        </div>

        <!-- Actions -->
        <div style="display: flex; gap: 10px; justify-content: flex-end;">
            <?php if (!empty($lignes)): ?>
                <form method="POST" style="display: inline;">
                    <button type="submit" name="action" value="finish" class="btn btn-success" style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                        ✅ Terminer
                    </button>
                </form>
            <?php endif; ?>
            <a href="/ElevageHome/public/?url=factures" class="btn btn-secondary" style="padding: 10px 20px; background: #e9ecef; color: #495057; text-decoration: none; border-radius: 4px; font-weight: 600;">
                ❌ Annuler
            </a>
        </div>
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
        padding: 8px 16px;
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

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #218838;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 11px;
    }

    @media (max-width: 768px) {
        [style*="grid-template-columns: 2fr 1fr 1fr 1fr auto"] {
            grid-template-columns: 1fr !important;
        }

        [style*="display: grid"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
