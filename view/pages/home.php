<title>ElevageHome - Accueil</title>
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
        <h1>Pilotez votre exploitation en toute simplicité</h1>
        <p>La plateforme tout-en-un conçue pour optimiser la gestion de votre élevage avicole, le suivi de vos hébergements et vos services de restauration.</p>
        <div class="hero-actions">
            <a href="/ElevageHome/public/?url=dashboard" class="btn-primary">Accéder à l'application <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<section id="features" class="welcome-container">
    <div class="section-title">
        <h2>Une solution intégrée pour chaque pilier de votre activité</h2>
        <p>Découvrez les outils clés mis à votre disposition pour maximiser votre productivité.</p>
    </div>

    <div class="features">
        <div class="feature-card">
            <div class="icon-box avicole"><i class="fas fa-egg"></i></div>
            <h3>Gestion Avicole</h3>
            <p>Suivez vos espèces de volailles, optimisez les dépenses, surveillez les ventes et contrôlez précisément le taux de mortalité.</p>
        </div>
        <div class="feature-card">
            <div class="icon-box hebergement"><i class="fas fa-home"></i></div>
            <h3>Hébergement</h3>
            <p>Gérez vos infrastructures et vos attributions avec un système d'allocation visuel et intelligent.</p>
        </div>
        <div class="feature-card">
            <div class="icon-box restauration"><i class="fas fa-utensils"></i></div>
            <h3>Restauration</h3>
            <p>Organisez vos services, planifiez vos menus et suivez les consommations avec des outils modernes.</p>
        </div>
        <div class="feature-card">
            <div class="icon-box analytics"><i class="fas fa-chart-pie"></i></div>
            <h3>Analytique & Factures</h3>
            <p>Générez vos factures clients et analysez la rentabilité de votre exploitation en temps réel via des graphiques interactifs.</p>
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