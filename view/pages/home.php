<title>ElevageHome - Accueil</title>
<link rel="manifest" href="/ElevageHome/public/manifest.json">
<meta name="theme-color" content="#667eea">
<header class="public-header">
    <div class="header-container">
        <div class="logo">
            <i class="fas fa-layer-group"></i> ElevageHome
        </div>
        <nav class="public-nav">
            <a href="#features">Fonctionnalités</a>
            <a href="/ElevageHome/public/?url=auth/login" class="btn-nav-login">Connexion</a>
        </nav>
    </div>
</header>

<section class="hero-section">
    <div class="hero-container">
        <h1>Pilotez votre élevage avicole en toute simplicité</h1>
        <p>La plateforme dédiée à la gestion opérationnelle d'une exploitation avicole : suivi des espèces, dépenses, ventes, factures, clients et mortalité.</p>
        <div class="hero-actions">
            <a href="/ElevageHome/public/?url=dashboard" class="btn-primary">Accéder à l'application <i class="fas fa-arrow-right"></i></a>
            <button id="installAppBtn" class="btn-primary" style="display:none; margin-left: 16px;">Installer l'application</button>
        </div>
    </div>
</section>

<section id="features" class="welcome-container">
    <div class="section-title">
        <h2>Fonctionnalités réelles de l’application</h2>
        <p>ElevageHome se concentre sur la gestion pratique de votre production avicole et de vos opérations commerciales.</p>
    </div>

    <div class="features">
        <div class="feature-card">
            <div class="icon-box avicole"><i class="fas fa-egg"></i></div>
            <h3>Gestion des espèces</h3>
            <p>Suivi des espèces, quantités, dates de lancement et statut des lots directement depuis l’interface.</p>
        </div>
        <div class="feature-card">
            <div class="icon-box hebergement"><i class="fas fa-money-bill-wave"></i></div>
            <h3>Suivi des dépenses</h3>
            <p>Enregistrez les charges, calculez les coûts unitaires et visualisez les dépenses par bande et période.</p>
        </div>
        <div class="feature-card">
            <div class="icon-box restauration"><i class="fas fa-shopping-cart"></i></div>
            <h3>Ventes et facturation</h3>
            <p>Créez vos ventes, générez des factures automatiques et suivez les paiements clients.</p>
        </div>
        <div class="feature-card">
            <div class="icon-box analytics"><i class="fas fa-heartbeat"></i></div>
            <h3>Performance & mortalité</h3>
            <p>Analysez les pertes, le taux de mortalité et la rentabilité de votre exploitation avec des rapports clairs.</p>
        </div>
    </div>
</section>

<footer class="public-footer">
    <p>&copy; <?= date('Y') ?> ElevageHome. Tous droits réservés. Design & Code par Eric BENDA.</p>
</footer>

<style>
    /* Reset & Styles Généraux de la page publique */
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8fafc;
        color: #334155;
    }

    /* Header Navigation */
    .public-header {
        background: white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    .header-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .logo {
        font-size: 22px;
        font-weight: 700;
        color: #1e3a8a;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .public-nav {
        display: flex;
        align-items: center;
        gap: 25px;
    }
    .public-nav a {
        text-decoration: none;
        color: #64748b;
        font-weight: 500;
        transition: color 0.3s;
    }
    .public-nav a:hover {
        color: #1e3a8a;
    }
    .public-nav .btn-nav-login {
        background: #1e3a8a;
        color: white;
        padding: 8px 20px;
        border-radius: 6px;
        font-weight: 600;
    }
    .public-nav .btn-nav-login:hover {
        background: #1d4ed8;
        color: white;
    }

    /* Section Hero */
    .hero-section {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        padding: 90px 20px;
        text-align: center;
    }
    .hero-container {
        max-width: 800px;
        margin: 0 auto;
    }
    .hero-section h1 {
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.2;
    }
    .hero-section p {
        font-size: 18px;
        opacity: 0.9;
        margin-bottom: 35px;
        line-height: 1.6;
    }
    .btn-primary {
        display: inline-block;
        padding: 14px 30px;
        background: #fbfbfb;
        color: #1e3a8a;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        background: white;
    }

    /* Section Contenu & Titres */
    .welcome-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 80px 20px;
    }
    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }
    .section-title h2 {
        font-size: 28px;
        color: #1e3a8a;
        margin-bottom: 10px;
    }
    .section-title p {
        color: #64748b;
        font-size: 16px;
    }

    /* Grille de cartes */
    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 30px;
    }
    .feature-card {
        background: white;
        padding: 35px 25px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
        transition: transform 0.3s, box-shadow 0.3s;
        border: 1px solid #f1f5f9;
    }
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 20px;
    }
    .avicole { background: #fee2e2; color: #dc2626; }
    .hebergement { background: #e0f2fe; color: #0284c7; }
    .restauration { background: #fef3c7; color: #d97706; }
    .analytics { background: #dcfce7; color: #16a34a; }

    .feature-card h3 {
        font-size: 20px;
        color: #0f172a;
        margin-bottom: 12px;
        font-weight: 600;
    }
    .feature-card p {
        color: #64748b;
        font-size: 14px;
        line-height: 1.5;
    }

    /* Footer */
    .public-footer {
        text-align: center;
        padding: 40px 20px;
        background: #0f172a;
        color: #94a3b8;
        font-size: 14px;
        margin-top: 40px;
    }
</style>
<script>
    let deferredPrompt = null;
    const installBtn = document.getElementById('installAppBtn');

    window.addEventListener('beforeinstallprompt', function(event) {
        event.preventDefault();
        deferredPrompt = event;
        if (installBtn) {
            installBtn.style.display = 'inline-flex';
        }
    });

    window.addEventListener('appinstalled', function() {
        if (installBtn) {
            installBtn.style.display = 'none';
        }
        deferredPrompt = null;
    });

    if (installBtn) {
        installBtn.addEventListener('click', async function() {
            if (!deferredPrompt) {
                return;
            }
            deferredPrompt.prompt();
            const choiceResult = await deferredPrompt.userChoice;
            if (choiceResult.outcome === 'accepted') {
                console.log('Install accepted');
            } else {
                console.log('Install dismissed');
            }
            deferredPrompt = null;
            installBtn.style.display = 'none';
        });
    }

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/ElevageHome/public/service-worker.js')
                .then(function(registration) {
                    console.log('Service Worker registered:', registration.scope);
                })
                .catch(function(error) {
                    console.log('Service Worker registration failed:', error);
                });
        });
    }
</script>