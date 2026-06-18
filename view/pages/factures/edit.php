<?php $active = 'factures'; $title = 'Modifier Facture'; ?>

<div class="content-header">
    <h1>✏️ Modifier Facture</h1>
    <div class="breadcrumb">
        <a href="/ElevageHome/public/?url=dashboard">Accueil</a> / 
        <a href="/ElevageHome/public/?url=factures">Factures</a> / 
        Modifier
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
    <!-- FORMULAIRE MODIFICATION -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Facture <?php echo htmlspecialchars($facture['numero_facture']); ?></h3>
        </div>
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div style="padding: 12px 15px; background: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
                    ⚠️ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- Infos Facture (lecture seule) -->
            <div style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 4px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; color: #999; font-size: 12px; margin-bottom: 5px;">Numéro</label>
                        <div style="font-weight: 600; color: #1f3057;">
                            <?php echo htmlspecialchars($facture['numero_facture']); ?>
                        </div>
                    </div>
                    <div>
                        <label style="display: block; color: #999; font-size: 12px; margin-bottom: 5px;">Date</label>
                        <div style="font-weight: 600; color: #1f3057;">
                            <?php echo date('d/m/Y', strtotime($facture['date_facturation'])); ?>
                        </div>
                    </div>
                </div>
                <div>
                    <label style="display: block; color: #999; font-size: 12px; margin-bottom: 5px;">Client</label>
                    <div style="font-weight: 600; color: #1f3057;">
                        <?php echo htmlspecialchars($facture['nom_complet']); ?> (<?php echo htmlspecialchars($facture['telephone']); ?>)
                    </div>
                </div>
                <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0;">
                    <label style="display: block; color: #999; font-size: 12px; margin-bottom: 5px;">Montant Total</label>
                    <div style="font-size: 18px; font-weight: 600; color: #28a745;">
                        <?php echo number_format($facture['montant_total_facture'], 2); ?> FC
                    </div>
                </div>
            </div>

            <!-- Formulaire Modification -->
            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Statut Paiement * </label>
                    <select name="statut_paiement" class="form-control" required>
                        <option value="non_paye" <?php echo $facture['statut_paiement'] === 'non_paye' ? 'selected' : ''; ?>>❌ Non Payé</option>
                        <option value="avance" <?php echo $facture['statut_paiement'] === 'avance' ? 'selected' : ''; ?>>⏳ Avance</option>
                        <option value="paye" <?php echo $facture['statut_paiement'] === 'paye' ? 'selected' : ''; ?>>✅ Payé</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Mode Paiement</label>
                    <select name="mode_paiement" class="form-control">
                        <option value="cash" <?php echo $facture['mode_paiement'] === 'cash' ? 'selected' : ''; ?>>💵 Cash</option>
                        <option value="mobile_money" <?php echo $facture['mode_paiement'] === 'mobile_money' ? 'selected' : ''; ?>>📱 Mobile Money</option>
                        <option value="credit" <?php echo $facture['mode_paiement'] === 'credit' ? 'selected' : ''; ?>>🏦 Crédit</option>
                    </select>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary">✅ Mettre à jour</button>
                    <a href="/ElevageHome/public/?url=factures/view/<?php echo $facture['id_facture']; ?>" class="btn btn-secondary">❌ Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <!-- SIDEBAR STATUS -->
    <div>
        <div class="card" style="margin-bottom: 15px;">
            <div class="card-header">
                <h3 class="card-title">Status Actuel</h3>
            </div>
            <div class="card-body">
                <?php 
                $badges = [
                    'paye' => ['bg' => '#28a745', 'text' => '✅ Payé', 'desc' => 'Montant reçu en intégralité'],
                    'avance' => ['bg' => '#ffc107', 'text' => '⏳ Avance', 'desc' => 'Montant partiellement reçu'],
                    'non_paye' => ['bg' => '#dc3545', 'text' => '❌ Non Payé', 'desc' => 'Aucun montant reçu']
                ];
                $statut = $facture['statut_paiement'];
                $badge = $badges[$statut] ?? ['bg' => '#6c757d', 'text' => $statut, 'desc' => ''];
                ?>
                <div style="background: <?php echo $badge['bg']; ?>; color: white; padding: 15px; border-radius: 4px; text-align: center; margin-bottom: 10px;">
                    <div style="font-size: 14px; font-weight: 600;">
                        <?php echo $badge['text']; ?>
                    </div>
                    <div style="font-size: 12px; opacity: 0.9; margin-top: 5px;">
                        <?php echo $badge['desc']; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom: 15px;">
            <div class="card-header">
                <h3 class="card-title">Mode Paiement</h3>
            </div>
            <div class="card-body">
                <?php 
                $modes = [
                    'cash' => '💵 Paiement Cash',
                    'mobile_money' => '📱 Mobile Money',
                    'credit' => '🏦 Paiement à Crédit'
                ];
                $mode = $facture['mode_paiement'];
                $mode_text = $modes[$mode] ?? $mode;
                ?>
                <div style="padding: 10px; background: #f8f9fa; border-radius: 4px; text-align: center; font-weight: 600;">
                    <?php echo $mode_text; ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Actions</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <a href="/ElevageHome/public/?url=factures/view/<?php echo $facture['id_facture']; ?>" class="btn btn-primary" style="display: block; text-align: center; padding: 10px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; font-weight: 600;">
                        👁️ Voir Détail
                    </a>
                    <a href="/ElevageHome/public/?url=factures" class="btn btn-secondary" style="display: block; text-align: center; padding: 10px; background: #e9ecef; color: #495057; text-decoration: none; border-radius: 4px; font-weight: 600;">
                        ← Retour Liste
                    </a>
                </div>
            </div>
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
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-size: 12px;
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
        background: #e9ecef;
        color: #495057;
    }

    .btn-secondary:hover {
        background: #dee2e6;
    }

    @media (max-width: 768px) {
        .content-header {
            flex-direction: column;
        }

        [style*="grid-template-columns: 2fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
