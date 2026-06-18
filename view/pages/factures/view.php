<?php $active = 'factures'; $title = 'Détail Facture'; ?>

<div class="content-header">
    <h1>📄 Détail Facture</h1>
    <div class="breadcrumb">
        <a href="/ElevageHome/public/?url=dashboard">Accueil</a> / 
        <a href="/ElevageHome/public/?url=factures">Factures</a> / 
        Détail
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
    <!-- FACTURE DÉTAIL -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Facture <?php echo htmlspecialchars($facture['numero_facture']); ?></h3>
            <div>
                <a href="/ElevageHome/public/?url=factures/pos/<?php echo $facture['id_facture']; ?>" class="btn btn-primary btn-sm">🧾 Vue POS</a>
                <a href="/ElevageHome/public/?url=factures/edit/<?php echo $facture['id_facture']; ?>" class="btn btn-primary btn-sm">✏️ Modifier Paiement</a>
                <a href="javascript:window.print()" class="btn btn-secondary btn-sm">🖨️ Imprimer</a>
            </div>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 1fr auto; gap: 30px; align-items: start;">
                <!-- Infos Principales -->
                <div>
                    <!-- Infos Facture -->
                    <div style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 4px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <div style="color: #999; font-size: 12px;">Numéro Facture</div>
                                <div style="font-size: 14px; font-weight: 600; color: #1f3057;">
                                    <?php echo htmlspecialchars($facture['numero_facture']); ?>
                                </div>
                            </div>
                            <div>
                                <div style="color: #999; font-size: 12px;">Date Facturation</div>
                                <div style="font-size: 14px; font-weight: 600; color: #1f3057;">
                                    <?php echo date('d/m/Y', strtotime($facture['date_facturation'])); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Infos Client -->
                    <div style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 4px;">
                        <h4 style="margin: 0 0 10px 0; color: #1f3057; font-size: 14px; font-weight: 600;">👥 Informations Client</h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <div style="color: #999; font-size: 12px;">Nom</div>
                                <div style="font-size: 13px; color: #1f3057;">
                                    <?php echo htmlspecialchars($facture['nom_complet']); ?>
                                </div>
                            </div>
                            <div>
                                <div style="color: #999; font-size: 12px;">Téléphone</div>
                                <div style="font-size: 13px; color: #1f3057;">
                                    <?php echo htmlspecialchars($facture['telephone']); ?>
                                </div>
                            </div>
                            <div style="grid-column: 1 / -1;">
                                <div style="color: #999; font-size: 12px;">Adresse</div>
                                <div style="font-size: 13px; color: #1f3057;">
                                    <?php echo htmlspecialchars($facture['adresse_goma'] ?? '-'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tableau Lignes -->
                    <div style="margin-bottom: 20px;">
                        <h4 style="margin: 0 0 10px 0; color: #1f3057; font-size: 14px; font-weight: 600;">📋 Détail des Produits</h4>
                        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                            <thead>
                                <tr style="background: #f8f9fa;">
                                    <th style="padding: 10px; text-align: left; border-bottom: 2px solid #e0e0e0; font-weight: 600;">Produit</th>
                                    <th style="padding: 10px; text-align: center; border-bottom: 2px solid #e0e0e0; font-weight: 600;">Quantité</th>
                                    <th style="padding: 10px; text-align: center; border-bottom: 2px solid #e0e0e0; font-weight: 600;">P.U. (FC)</th>
                                    <th style="padding: 10px; text-align: right; border-bottom: 2px solid #e0e0e0; font-weight: 600;">Montant (FC)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total = 0;
                                if (empty($lignes)): 
                                ?>
                                    <tr>
                                        <td colspan="4" style="padding: 20px; text-align: center; color: #999;">
                                            Aucune ligne de facture
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php 
                                    foreach ($lignes as $l): 
                                        $montant = round($l['quantite'] * $l['prix_unitaire_vente'], 2);
                                        $total = round($total + $montant, 2);
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
                                                <?php echo number_format($montant, 2); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Total -->
                    <div style="display: flex; justify-content: flex-end;">
                        <div style="width: 300px; padding: 15px; background: #f8f9fa; border-radius: 4px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span>Sous-total:</span>
                                <span><?php echo number_format(round($total, 2), 2); ?> FC</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 16px; font-weight: 600; color: #1f3057; border-top: 2px solid #e0e0e0; padding-top: 10px;">
                                <span>TOTAL:</span>
                                <span><?php echo number_format(round($total, 2), 2); ?> FC</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QR CODE SIDEBAR -->
                <div style="text-align: center;">
                    <div id="qrcode" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"></div>
                    <p style="margin-top: 10px; font-size: 12px; color: #999;">Scannez pour vérifier</p>
                </div>
            </div>
        </div>
    </div>

    <!-- SIDEBAR INFO -->
    <div>
        <!-- Statut Paiement -->
        <div class="card" style="margin-bottom: 15px;">
            <div class="card-header">
                <h3 class="card-title">Statut Paiement</h3>
            </div>
            <div class="card-body">
                <?php 
                $badges = [
                    'paye' => ['bg' => '#28a745', 'text' => '✅ Payé'],
                    'avance' => ['bg' => '#ffc107', 'text' => '⏳ Avance'],
                    'non_paye' => ['bg' => '#dc3545', 'text' => '❌ Non Payé']
                ];
                $statut = $facture['statut_paiement'];
                $badge = $badges[$statut] ?? ['bg' => '#6c757d', 'text' => $statut];
                ?>
                <div style="background: <?php echo $badge['bg']; ?>; color: white; padding: 10px; border-radius: 4px; text-align: center; font-weight: 600;">
                    <?php echo $badge['text']; ?>
                </div>
            </div>
        </div>

        <!-- Mode Paiement -->
        <div class="card" style="margin-bottom: 15px;">
            <div class="card-header">
                <h3 class="card-title">Mode Paiement</h3>
            </div>
            <div class="card-body">
                <?php 
                $modes = [
                    'cash' => '💵 Cash',
                    'mobile_money' => '📱 Mobile Money',
                    'credit' => '🏦 Crédit'
                ];
                $mode = $facture['mode_paiement'];
                $mode_text = $modes[$mode] ?? $mode;
                ?>
                <div style="padding: 10px; background: #f8f9fa; border-radius: 4px; text-align: center;">
                    <?php echo $mode_text; ?>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Actions</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <a href="/ElevageHome/public/?url=factures/edit/<?php echo $facture['id_facture']; ?>" class="btn btn-primary" style="display: block; text-align: center; padding: 10px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; font-weight: 600;">
                        ✏️ Modifier Statut
                    </a>
                    <a href="/ElevageHome/public/?url=factures" class="btn btn-secondary" style="display: block; text-align: center; padding: 10px; background: #e9ecef; color: #495057; text-decoration: none; border-radius: 4px; font-weight: 600;">
                        ← Retour Liste
                    </a>
                    <a href="/ElevageHome/public/?url=factures/delete/<?php echo $facture['id_facture']; ?>" class="btn btn-danger" style="display: block; text-align: center; padding: 10px; background: #dc3545; color: white; text-decoration: none; border-radius: 4px; font-weight: 600;" onclick="return confirm('Supprimer cette facture?')">
                        🗑️ Supprimer
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
        display: flex;
        justify-content: space-between;
        align-items: center;
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

    .btn-sm {
        padding: 4px 8px;
        font-size: 11px;
    }

    @media (max-width: 768px) {
        .content-header {
            flex-direction: column;
        }

        [style*="grid-template-columns: 2fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }

    @media print {
        .content-header, .btn, .breadcrumb {
            display: none;
        }

        body {
            background: white;
        }

        .card {
            box-shadow: none;
            border: 1px solid #e0e0e0;
        }
    }

    @media (max-width: 768px) {
        [style*="grid-template-columns: 1fr auto"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- CDN QRCode.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Données de la facture
        const factureData = {
            numero: '<?php echo htmlspecialchars($facture['numero_facture']); ?>',
            date: '<?php echo date('d/m/Y', strtotime($facture['date_facturation'])); ?>',
            client: '<?php echo htmlspecialchars($facture['nom_complet']); ?>',
            telephone: '<?php echo htmlspecialchars($facture['telephone']); ?>',
            montant: <?php echo round($total, 2); ?>,
            statut: '<?php echo htmlspecialchars($facture['statut_paiement']); ?>',
            mode: '<?php echo htmlspecialchars($facture['mode_paiement']); ?>'
        };

        // Créer le texte du QR Code
        const qrText = 
            'FACTURE\n' +
            'Numéro: ' + factureData.numero + '\n' +
            'Date: ' + factureData.date + '\n' +
            'Client: ' + factureData.client + '\n' +
            'Téléphone: ' + factureData.telephone + '\n' +
            'Montant: ' + factureData.montant + ' FC\n' +
            'Statut: ' + factureData.statut + '\n' +
            'Mode: ' + factureData.mode;

        // Générer le QR Code
        const qrcodeDiv = document.getElementById('qrcode');
        if (qrcodeDiv) {
            new QRCode(qrcodeDiv, {
                text: qrText,
                width: 200,
                height: 200,
                colorDark: '#1f3057',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            });
        }
    });
</script>
