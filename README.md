# ElevageHome - Application Hybride et Responsive

## 🎯 Vue d'ensemble

**ElevageHome** est une application web moderne pour la gestion d'exploitations avicoles familiales. L'application est:

- ✅ **Hybride (PWA)**: Installable comme app mobile/desktop
- ✅ **Responsive**: Adaptée à tous les appareils (mobile, tablette, desktop)
- ✅ **Offline-Ready**: Fonctionne sans connexion internet
- ✅ **Sécurisée**: Authentification avec Bcrypt
- ✅ **Complète**: CRUD pour bandes, dépenses, ventes, mortalité

---

## 📋 Table des matières

1. [Installation](#installation)
2. [Configuration PWA](#configuration-pwa)
3. [Structure Responsive](#structure-responsive)
4. [Tests](#tests)
5. [Déploiement](#déploiement)
6. [Dépannage](#dépannage)

---

## 🚀 Installation

### Prérequis

- PHP 7.4+
- MySQL 5.7+
- XAMPP ou serveur PHP avec support MySQL

### Étapes d'Installation

```bash
# 1. Cloner/copier le projet
cd C:\xampp\htdocs\ElevageHome

# 2. Importer la base de données
# Utilisez phpMyAdmin pour importer:
# - database_setup.sql
# - ou créez les tables manuellement

# 3. Accéder à l'application
http://localhost/ElevageHome/public/

# 4. Connexion par défaut (si base de données setup exécutée)
# Email: user@example.com
# Password: password123
```

### Configuration Base de Données

```php
// model/Manager.php - Vérifier ces paramètres:
const HOST = 'localhost';
const DBNAME = 'elevage_home';
const USER = 'root';
const PASSWORD = '';
```

---

## 🌐 Configuration PWA

### Qu'est-ce qu'une PWA?

Une **Progressive Web App** combine:
- Web progressif (fonctionne partout)
- Responsive (s'adapte aux écrans)
- Installable (ajoutable à l'écran d'accueil)
- App-like (interface app native)

### Fichiers PWA de l'Application

```
public/
├── manifest.json           # Métadonnées PWA
├── service-worker.js       # Caching offline
├── offline.html           # Page offline
└── images/
    ├── icon-192.png       # Icône app
    └── icon-512.png       # Icône grande
```

### Installation sur Appareil Mobile

#### 📱 Android (Chrome/Edge)

1. Ouvrez l'app dans Chrome ou Edge
2. Appuyez sur ⋮ (menu) → **"Installer l'app"**
3. Confirmez → L'app s'ajoute à l'écran d'accueil

#### 🍎 iOS (Safari)

1. Ouvrez l'app dans Safari
2. Appuyez sur **Partage** 
3. Sélectionnez **"Sur l'écran d'accueil"**
4. Donnez un nom → L'app s'ajoute

---

## 📱 Structure Responsive

### Breakpoints Définis

| Résolution | Type | Adaptations |
|-----------|------|-------------|
| **< 480px** | Petit téléphone | Font réduite, layout 1 col |
| **480-768px** | Téléphone | Sidebar cachée, drawer menu |
| **768-992px** | Tablette | Sidebar + contenu 2 col |
| **> 992px** | Desktop | Layout complet |

### Fonctionnalités Responsive

✅ **Navigation**: Sidebar adaptative (fixed → drawer → hidden)  
✅ **Grille**: Responsive grid layout (1 → 2 → 4 colonnes)  
✅ **Formulaires**: Optimisés pour touch (44px min)  
✅ **Tableaux**: Scroll horizontal sur petit écran  

### Tester la Responsivité

```javascript
// DevTools - F12
// Ctrl+Shift+M pour responsive mode
// Ou inspecter avec:

// Chrome DevTools > Device Toolbar
// Tester les appareils prédéfinis:
// - iPhone 12 (390x844)
// - Pixel 5 (393x851)  
// - iPad (768x1024)
```

---

## 🧪 Tests

### 1️⃣ Test PWA Installation

Accédez à: `http://localhost/ElevageHome/public/test-pwa.html`

Vérifiez:
- ✅ Service Worker status
- ✅ Device information
- ✅ Network status
- ✅ Installation disponible

### 2️⃣ Test Responsive

```bash
# Redimensionner la fenêtre à:
# 1920px (Desktop)  → Layout full
# 1024px (Tablette) → 2 colonnes
# 768px (Tablette)  → 1 colonne
# 480px (Mobile)    → Full width
# 375px (iPhone)    → Full width optimisé
```

### 3️⃣ Test Offline

1. Ouvrir DevTools (F12)
2. Onglet **Network** → **Offline**
3. Rafraîchir la page
4. Vérifier que:
   - Le cache s'affiche
   - Offline page s'affiche si pas de cache

### 4️⃣ Test Authentification

```
Endpoint: /ElevageHome/public/?url=auth/login

Test 1 - Connexion valide:
- Email: user@example.com
- Password: password123
- Résultat: Redirection dashboard ✅

Test 2 - Connexion invalide:
- Email: wrong@example.com
- Password: wrong
- Résultat: Message d'erreur ✅

Test 3 - S'inscrire:
- Prénom, nom, email, password
- Vérifier création utilisateur ✅
```

### 5️⃣ Test CRUD Opérations

```
Bandes: /ElevageHome/public/?url=bandes
- Lister ✅
- Ajouter ✅
- Éditer ✅
- Supprimer ✅

Dépenses: /ElevageHome/public/?url=depenses
- Ajouter dépense ✅
- Lister ✅
- Éditer montant ✅
- Supprimer ✅
```

---

## 📦 Déploiement

### Sur Production (HTTPS requis pour PWA)

#### 1️⃣ Prérequis

```bash
# HTTPS (certificat SSL)
# Apache mod_rewrite activé
# PHP 7.4+
# MySQL 5.7+
```

#### 2️⃣ Configuration

```bash
# 1. Uploader fichiers
# scp -r . user@server:/var/www/ElevageHome/

# 2. Configurer base de données
# mysql -u user -p < database_setup.sql

# 3. Vérifier permissions
chmod 755 /var/www/ElevageHome/
chmod 775 /var/www/ElevageHome/public/cache/

# 4. Configurer .htaccess
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /ElevageHome/public/
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?url=$1 [L,QSA]
</IfModule>
```

#### 3️⃣ Configuration HTTPS/SSL

```apache
# .htaccess - Forcer HTTPS
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
```

---

## 🐛 Dépannage

### PWA ne s'installe pas

**Problème**: App n'apparaît pas dans le menu d'installation

**Solutions**:
1. Vérifier HTTPS est activé (ou localhost)
2. Vérifier manifest.json existe et est valide
3. Vérifier les icônes existent (192x192, 512x512)
4. Vérifier Service Worker s'enregistre (DevTools → Application)

```javascript
// Vérifier dans DevTools Console:
navigator.serviceWorker.getRegistrations()
  .then(registrations => {
    console.log('Service Workers:', registrations);
  });
```

### Page offline ne s'affiche pas

**Problème**: Hors ligne = page blanche au lieu d'offline.html

**Solutions**:
1. Vérifier offline.html existe
2. Vérifier Service Worker intercepte les requêtes
3. Forcer vidage du cache: Ctrl+Shift+Suppr

```javascript
// DevTools → Application → Service Workers
// Cliquer "Unregister" et rafraîchir
```

### Responsive cassé sur mobile

**Problème**: Page n'adapte pas la taille sur mobile

**Solutions**:
1. Vérifier meta viewport:
   ```html
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   ```

2. Vérifier CSS media queries chargent
3. Tester DevTools Device Mode (Ctrl+Shift+M)

### Formulaires font zoomer sur iOS

**Problème**: Clicks sur input = zoom iOS

**Solution**: Augmenter la police à 16px
```css
input, select, textarea {
    font-size: 16px; /* Évite zoom iOS */
}
```

---

## 📊 Checklist de Déploiement

- [ ] HTTPS activé sur production
- [ ] Base de données correctement configurée
- [ ] Permissions fichiers/dossiers OK
- [ ] manifest.json valide
- [ ] Service Worker enregistré
- [ ] Icônes PWA fournies (192x192, 512x512)
- [ ] Meta tags PWA présentes
- [ ] offline.html accessible
- [ ] Tests responsive effectués
- [ ] Tests offline effectués
- [ ] Tests authentication effectués

---

## 📚 Documentation Complète

- **PWA Guide**: `PWA_RESPONSIVE_GUIDE.md`
- **Auth System**: `AUTHENTIFICATION_GUIDE.md`
- **API Routes**: `controller/Router.php`
- **Database Schema**: Database structure in SQL setup

---

## 🤝 Support

Pour des issues ou améliorations, vérifiez:

1. **DevTools Console** (F12) pour erreurs
2. **Network Tab** pour requêtes échouées  
3. **Application Tab** pour PWA/Cache/Storage
4. **Logs PHP** pour erreurs serveur

---

## 📄 Licence

Application développée pour gestion d'exploitations avicoles familiales.

---

**Version**: 1.0 PWA & Responsive  
**Dernière mise à jour**: 2026-06-16  
**Auteur**: ElevageHome Development Team
