<div class="error-container">
    <div class="error-content">
        <h1>❌ Erreur</h1>
        <p class="error-message"><?php echo isset($errorMsg) ? htmlspecialchars($errorMsg) : 'Une erreur inconnue s\'est produite'; ?></p>
        <a href="/ElevageHome/public/" class="error-button">Retour à l'accueil</a>
    </div>
</div>

<style>
    .error-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .error-content {
        background: white;
        padding: 50px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-left: 4px solid #dc3545;
    }

    .error-content h1 {
        font-size: 32px;
        color: #dc3545;
        margin-bottom: 20px;
    }

    .error-message {
        font-size: 16px;
        color: #666;
        margin-bottom: 30px;
        font-family: monospace;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 4px;
    }

    .error-button {
        display: inline-block;
        padding: 12px 24px;
        background: #0d6efd;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-weight: 600;
        transition: background 0.3s;
    }

    .error-button:hover {
        background: #0b5ed7;
    }
</style>
