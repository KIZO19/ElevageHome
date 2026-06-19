<?php
// view/template.php

// 1. DÉTECTION AUTOMATIQUE DE LA PAGE D'ACCUEIL
// Si l'URL demandée est vide, vaut '/' ou n'a pas de paramètre de route actif, c'est la vitrine publique.
if (!isset($_GET['url']) || empty(trim($_GET['url'], '/'))) {
    // On affiche directement le contenu de home.php sans injecter la structure applicative
    echo $content;
    exit; // On coupe proprement l'exécution ici
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#667eea">
    <meta name="description" content="ElevageHome - Gestion d'exploitation avicole">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="ElevageHome">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="manifest" href="/ElevageHome/public/manifest.json">
    
    <link rel="icon" type="image/png" href="/ElevageHome/public/images/icon-192.png">
    <link rel="apple-touch-icon" href="/ElevageHome/public/images/icon-192.png">
    <link rel="manifest" href="/ElevageHome/public/manifest.json">
    
    <title><?php echo isset($title) ? htmlspecialchars($title) . ' - ' : ''; ?>ElevageHome</title>
    
    <link rel="stylesheet" href="/ElevageHome/public/css/adminlte-custom.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.min.js"></script>
    
    <style>
        /* Page specific styles override */
    </style>
</head>
<body>
    <div class="wrapper">
        <nav class="navbar">
            <div class="navbar-brand">
                <i class="fas fa-layer-group"></i><a href="/ElevageHome/" style="color: inherit; text-decoration: none; margin-left: 8px;">
                ElevageHome</a>
            </div>
            
            <ul class="navbar-nav">
                <!-- <li title="Notifications">
                    <i class="fas fa-bell"></i>
                </li>
                <li title="Paramètres">
                    <i class="fas fa-cog"></i>
                </li> -->
                <!-- <li>
                    <select id="themeSelector" class="theme-selector" title="Changer le thème">
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                        <option value="custom">Custom</option>
                    </select>
                </li> -->
            </ul>
            
            <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-profile">
                <div class="avatar" title="Profil">
                    <a href="/ElevageHome/auth/profile" style="color: inherit; text-decoration: none; cursor: pointer;">
                        <?php echo strtoupper(substr($_SESSION['user_name'] ?? 'User', 0, 1)); ?>
                    </a>
                </div>
                <div>
                    <div style="font-size: 13px;"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></div>
                    <div style="font-size: 11px; opacity: 0.8;"><?php echo htmlspecialchars($_SESSION['user_role'] ?? 'User'); ?></div>
                </div>
                <div style="display: flex; gap: 8px; margin-left: 10px;">
                    <a href="/ElevageHome/auth/profile" title="Mon profil">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="/ElevageHome/public/?url=auth/logout" title="Déconnexion">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </nav>
        
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li class="menu-title">Navigation</li>
                <li>
                    <a href="?url=dashboard" <?php echo (isset($active) && $active === 'dashboard') ? 'class="active"' : ''; ?>>
                        <i class="fas fa-chart-line"></i>
                        <span> Tableau de bord</span>
                    </a>
                </li>

                <li class="menu-title">Gestion</li>
                <li>
                    <a href="?url=bandes" <?php echo (isset($active) && $active === 'bandes') ? 'class="active"' : ''; ?>>
                        <i class="fas fa-layer-group"></i>
                        <span> Espèces</span>
                    </a>
                </li>
                <li>
                    <a href="?url=depenses" <?php echo (isset($active) && $active === 'depenses') ? 'class="active"' : ''; ?>>
                        <i class="fas fa-money-bill-wave"></i>
                        <span> Dépenses</span>
                    </a>
                </li>
                <li>
                    <a href="?url=ventes" <?php echo (isset($active) && $active === 'ventes') ? 'class="active"' : ''; ?>>
                        <i class="fas fa-shopping-cart"></i>
                        <span> Ventes</span>
                    </a>
                </li>
                <li>
                    <a href="?url=mortalite" <?php echo (isset($active) && $active === 'mortalite') ? 'class="active"' : ''; ?>>
                        <i class="fas fa-heartbeat"></i>
                        <span> Mortalité</span>
                    </a>
                </li>

                <li class="menu-title">Commercial</li>
                <li>
                    <a href="?url=clients" <?php echo (isset($active) && $active === 'clients') ? 'class="active"' : ''; ?>>
                        <i class="fas fa-users"></i>
                        <span> Clients</span>
                    </a>
                </li>
                <li>
                    <a href="?url=factures" <?php echo (isset($active) && $active === 'factures') ? 'class="active"' : ''; ?>>
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Factures</span>
                    </a>
                </li>

                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Manager'): ?>
                <li class="menu-title">Administration</li>
                <li>
                    <a href="/ElevageHome/public/?url=admin/dashboard" <?php echo (isset($active) && $active === 'admin') ? 'class="active"' : ''; ?>>
                        <i class="fas fa-users-cog"></i>
                        <span>⚙️ Utilisateurs</span>
                    </a>
                </li>
                <?php endif; ?>

                <li class="menu-title">Paramètres</li>
                <li>
                    <a href="/ElevageHome/public/?url=auth/profile" <?php echo (isset($active) && $active === 'profile') ? 'class="active"' : ''; ?>>
                        <i class="fas fa-user"></i>
                        <span> Mon Profil</span>
                    </a>
                </li>
                <li>
                    <a href="/ElevageHome/public/?url=auth/logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span> Déconnexion</span>
                    </a>
                </li>
            </ul>
        </aside>

        <div class="content-wrapper">
            <?php echo $content; ?>
        </div>
    </div>

    <script>
        var themeKey = 'elevagehome_theme';
        var themePalette = {
            light: '#667eea',
            dark: '#111827',
            custom: '#0d9488'
        };

        function applyTheme(theme) {
            var selected = theme || 'light';
            document.body.classList.remove('theme-light', 'theme-dark', 'theme-custom');
            document.body.classList.add('theme-' + selected);
            document.body.dataset.theme = selected;
            var themeColorMeta = document.querySelector('meta[name="theme-color"]');
            if (themeColorMeta) {
                themeColorMeta.content = themePalette[selected] || themePalette.light;
            }
            var selector = document.getElementById('themeSelector');
            if (selector) {
                selector.value = selected;
            }
        }

        function saveTheme(theme) {
            localStorage.setItem(themeKey, theme);
        }

        function loadTheme() {
            var stored = localStorage.getItem(themeKey) || 'light';
            applyTheme(stored);
        }

        function initThemeSelector() {
            var themeSelector = document.getElementById('themeSelector');
            if (!themeSelector) {
                return;
            }
            themeSelector.addEventListener('change', function() {
                saveTheme(this.value);
                applyTheme(this.value);
            });
        }

        var deferredPrompt = null;
        function initInstallPrompt() {
            var installBtn = document.getElementById('installAppBtn');
            if (!installBtn) {
                return;
            }

            window.addEventListener('beforeinstallprompt', function(event) {
                event.preventDefault();
                deferredPrompt = event;
                installBtn.style.display = 'inline-flex';
            });

            installBtn.addEventListener('click', async function() {
                if (!deferredPrompt) {
                    return;
                }
                deferredPrompt.prompt();
                var choiceResult = await deferredPrompt.userChoice;
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the install prompt');
                } else {
                    console.log('User dismissed the install prompt');
                }
                deferredPrompt = null;
                installBtn.style.display = 'none';
            });

            window.addEventListener('appinstalled', function() {
                console.log('ElevageHome has been installed');
                if (installBtn) {
                    installBtn.style.display = 'none';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadTheme();
            initThemeSelector();
            initInstallPrompt();

            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.querySelector('[data-toggle="sidebar"]');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    sidebar.classList.toggle('active');
                });
            }

            if (window.innerWidth < 768) {
                document.querySelectorAll('.sidebar a').forEach(link => {
                    link.addEventListener('click', function() {
                        sidebar.classList.remove('active');
                    });
                });
            }
        });

        // Service Worker Registration for PWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/ElevageHome/public/service-worker.js')
                    .then(registration => {
                        console.log('Service Worker registered successfully:', registration);
                        setInterval(() => { registration.update(); }, 60000);
                    })
                    .catch(error => {
                        console.log('Service Worker registration failed:', error);
                    });
            });
        }

        function initFullDataTable(selector, params) {
            var defaults = {
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json'
                },
                pageLength: 25,
                dom: 'Bfrtip',
                buttons: [
                    'copy',
                    { extend: 'csv', text: 'CSV' },
                    { extend: 'excel', text: 'Excel' },
                    { extend: 'pdf', text: 'PDF' },
                    'print'
                ],
                responsive: true,
                orderCellsTop: true,
                columnDefs: [{ targets: -1, orderable: false }]
            };

            var settings = $.extend(true, {}, defaults, params || {});
            var $table = $(selector);
            if (!$table.length) {
                return null;
            }

            var $thead = $table.find('thead');
            if ($thead.find('tr.filters').length === 0) {
                var $filterRow = $('<tr class="filters"></tr>');
                $thead.find('tr').first().find('th').each(function() {
                    $filterRow.append('<th><input type="text" placeholder="Filtrer..." style="width:100%; box-sizing:border-box;" /></th>');
                });
                $thead.append($filterRow);
            }

            if ($table.find('tfoot').length === 0) {
                var $tfoot = $('<tfoot><tr></tr></tfoot>');
                var colCount = $thead.find('tr').first().find('th').length;
                for (var i = 0; i < colCount; i++) {
                    $tfoot.find('tr').append('<th></th>');
                }
                $table.append($tfoot);
            }
            $table.find('tfoot tr th').first().text('Total page / global');

            settings.initComplete = function() {
                var api = this.api();
                $table.find('thead tr.filters th').each(function(index) {
                    $('input', this).on('keyup change clear', function() {
                        if (api.column(index).search() !== this.value) {
                            api.column(index).search(this.value).draw();
                        }
                    });
                });

                if (typeof params === 'object' && params.totalColumns) {
                    return;
                }

                var rowCount = api.rows({ page: 'current' }).count();
                var totalCount = api.rows().count();
                $(api.footer()).find('th').first().text('Lignes page / total: ' + rowCount + ' / ' + totalCount);
            };

            if (settings.totalColumns) {
                settings.footerCallback = function(row, data, start, end, display) {
                    var api = this.api();
                    var parseValue = function(value) {
                        if (typeof value === 'string') {
                            value = value.replace(/[^0-9,\.\-]/g, '').replace(/,/g, '.');
                            return parseFloat(value) || 0;
                        }
                        return typeof value === 'number' ? value : 0;
                    };

                    settings.totalColumns.forEach(function(columnConfig) {
                        var index = columnConfig.index;
                        var decimals = columnConfig.decimals || 2;
                        var currency = columnConfig.currency ? ' ' + columnConfig.currency : '';

                        var total = api.column(index, { search: 'applied' }).data().reduce(function(a, b) {
                            return a + parseValue(b);
                        }, 0);
                        var pageTotal = api.column(index, { page: 'current' }).data().reduce(function(a, b) {
                            return a + parseValue(b);
                        }, 0);
                        $(api.column(index).footer()).html(pageTotal.toLocaleString('fr-FR', { minimumFractionDigits: decimals, maximumFractionDigits: decimals }) + ' / ' + total.toLocaleString('fr-FR', { minimumFractionDigits: decimals, maximumFractionDigits: decimals }) + currency);
                    });
                };
            }

            return $table.DataTable(settings);
        }
    </script>
</body>
</html>