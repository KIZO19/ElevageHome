<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture POS - <?php echo htmlspecialchars($facture['numero_facture']); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background: #f5f5f5;
            padding: 20px;
        }

        .pos-receipt {
            width: 80mm;
            margin: 0 auto;
            background: white;
            padding: 10mm;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: 11px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .logo {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .title {
            font-size: 12px;
            font-weight: bold;
            margin: 5px 0;
        }

        .subtitle {
            font-size: 9px;
            color: #666;
            margin: 2px 0;
        }

        .divider {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }

        .divider-solid {
            border-bottom: 1px solid #000;
            margin: 10px 0;
        }

        .info-block {
            margin: 10px 0;
            font-size: 10px;
        }

        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 30mm;
        }

        .info-value {
            display: inline-block;
        }

        .table {
            width: 100%;
            margin: 10px 0;
            font-size: 10px;
        }

        .table-header {
            display: grid;
            grid-template-columns: 3fr 1fr 2fr;
            font-weight: bold;
            border-bottom: 1px solid #000;
            padding: 5px 0;
            gap: 3px;
        }

        .table-row {
            display: grid;
            grid-template-columns: 3fr 1fr 2fr;
            padding: 3px 0;
            border-bottom: 1px dotted #ccc;
            gap: 3px;
            word-wrap: break-word;
            word-break: break-word;
        }

        .table-col-left {
            text-align: left;
        }

        .table-col-center {
            text-align: center;
        }

        .table-col-right {
            text-align: right;
        }

        .total-section {
            margin: 10px 0;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 11px;
        }

        .total-final {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 14px;
            margin-top: 5px;
            padding-top: 5px;
            border-top: 1px solid #000;
        }

        .payment-info {
            margin: 10px 0;
            font-size: 10px;
            text-align: center;
        }

        .payment-badge {
            display: inline-block;
            background: #1f3057;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            margin: 2px;
            font-weight: bold;
        }

        .qrcode-section {
            text-align: center;
            margin: 15px 0;
            padding: 10px 0;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
        }

        .qrcode-section #qrcode {
            display: inline-block;
            margin: 10px 0;
        }

        .qrcode-text {
            font-size: 9px;
            color: #666;
            margin-top: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 9px;
            color: #666;
        }

        .timestamp {
            font-size: 10px;
            text-align: center;
            margin: 10px 0;
            color: #999;
        }

        .print-btn {
            display: block;
            text-align: center;
            margin: 20px 0;
        }

        .print-btn button {
            padding: 10px 30px;
            background: #1f3057;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .print-btn button:hover {
            background: #0f1a2f;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .pos-receipt {
                width: 80mm;
                box-shadow: none;
                margin: 0;
                padding: 5mm;
            }

            .print-btn {
                display: none;
            }

            @page {
                size: 80mm auto;
                margin: 0;
                padding: 0;
            }
        }

        @media screen and (max-width: 600px) {
            .pos-receipt {
                width: 100%;
                max-width: 80mm;
            }
        }
    </style>
</head>
<body>
    <div class="pos-receipt">
        <!-- HEADER -->
        <div class="header">
            <div class="logo">🐔 ÉLEVAGE HOME</div>
            <div class="title">FACTURE/REÇU</div>
            <div class="subtitle">Gestion d'Élevage Familial</div>
        </div>

        <!-- INFOS FACTURE -->
        <div class="info-block">
            <div><span class="info-label">Facture #:</span> <span class="info-value"><strong><?php echo htmlspecialchars($facture['numero_facture']); ?></strong></span></div>
            <div><span class="info-label">Date:</span> <span class="info-value"><?php echo date('d/m/Y H:i', strtotime($facture['date_facturation'])); ?></span></div>
        </div>

        <div class="divider"></div>

        <!-- INFOS CLIENT -->
        <div class="info-block">
            <div><strong>CLIENT</strong></div>
            <div><span class="info-label">Nom:</span> <span class="info-value"><?php echo htmlspecialchars($facture['nom_complet']); ?></span></div>
            <div><span class="info-label">Tél:</span> <span class="info-value"><?php echo htmlspecialchars($facture['telephone']); ?></span></div>
            <?php if ($facture['adresse_goma']): ?>
                <div style="font-size: 9px; margin-top: 3px;"><?php echo htmlspecialchars($facture['adresse_goma']); ?></div>
            <?php endif; ?>
        </div>

        <div class="divider"></div>

        <!-- ARTICLES -->
        <div class="table">
            <div class="table-header">
                <div class="table-col-left">ARTICLE</div>
                <div class="table-col-center">QT</div>
                <div class="table-col-right">MONTANT</div>
            </div>

            <?php 
            $total = 0;
            if (!empty($lignes)):
                foreach ($lignes as $l): 
                    $montant = round($l['quantite'] * $l['prix_unitaire_vente'], 2);
                    $total = round($total + $montant, 2);
            ?>
                <div class="table-row">
                    <div class="table-col-left">
                        <div><strong><?php echo ucfirst(str_replace('_', ' ', $l['produit_vendu'])); ?></strong></div>
                        <div style="font-size: 9px; color: #666;">
                            <?php echo number_format($l['prix_unitaire_vente'], 2); ?> FC x <?php echo number_format($l['quantite'], 2); ?>
                        </div>
                    </div>
                    <div class="table-col-center"><?php echo number_format($l['quantite'], 2); ?></div>
                    <div class="table-col-right"><strong><?php echo number_format($montant, 2); ?> FC</strong></div>
                </div>
            <?php 
                endforeach;
            endif;
            ?>
        </div>

        <div class="divider-solid"></div>

        <!-- TOTAL -->
        <div class="total-section">
            <div class="total-row">
                <span>Sous-total:</span>
                <span><?php echo number_format($total, 2); ?> FC</span>
            </div>
            <div class="total-final">
                <span>TOTAL</span>
                <span><?php echo number_format($total, 2); ?> FC</span>
            </div>
        </div>

        <!-- PAIEMENT -->
        <div class="payment-info">
            <div style="margin: 5px 0;">
                <?php 
                $modes = [
                    'cash' => '💵 CASH',
                    'mobile_money' => '📱 MOBILE MONEY',
                    'credit' => '🏦 CRÉDIT'
                ];
                $mode = $facture['mode_paiement'];
                $mode_text = $modes[$mode] ?? strtoupper($mode);
                ?>
                <div class="payment-badge"><?php echo $mode_text; ?></div>
            </div>
            <div style="margin-top: 5px;">
                <?php 
                $statuts = [
                    'paye' => '✅ PAYÉ',
                    'avance' => '⏳ AVANCE',
                    'non_paye' => '❌ NON PAYÉ'
                ];
                $statut = $facture['statut_paiement'];
                $statut_text = $statuts[$statut] ?? strtoupper($statut);
                ?>
                <strong><?php echo $statut_text; ?></strong>
            </div>
        </div>

        <div class="divider"></div>

        <!-- QR CODE -->
        <div class="qrcode-section">
            <div id="qrcode"></div>
            <div class="qrcode-text">Scannez pour vérifier</div>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <div style="margin: 10px 0;">Merci pour votre achat!</div>
            <div class="timestamp"><?php echo date('d/m/Y à H:i:s'); ?></div>
            <div style="margin-top: 10px; font-size: 8px; color: #ccc;">Conservez ce reçu</div>
        </div>
    </div>

    <div class="print-btn">
        <button onclick="window.print()">🖨️ Imprimer</button>
    </div>

    <!-- CDN QRCode.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Données pour le QR Code
            const qrText = 
                'FAC:<?php echo htmlspecialchars($facture['numero_facture']); ?>\n' +
                'DATE:<?php echo date('d/m/Y', strtotime($facture['date_facturation'])); ?>\n' +
                'CLIENT:<?php echo htmlspecialchars($facture['nom_complet']); ?>\n' +
                'TEL:<?php echo htmlspecialchars($facture['telephone']); ?>\n' +
                'MONTANT:<?php echo round($total, 2); ?> FC\n' +
                'MODE:<?php echo htmlspecialchars($facture['mode_paiement']); ?>\n' +
                'STATUT:<?php echo htmlspecialchars($facture['statut_paiement']); ?>';

            // Générer le QR Code
            const qrcodeDiv = document.getElementById('qrcode');
            if (qrcodeDiv) {
                new QRCode(qrcodeDiv, {
                    text: qrText,
                    width: 150,
                    height: 150,
                    colorDark: '#1f3057',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.H
                });
            }
        });
    </script>
</body>
</html>
