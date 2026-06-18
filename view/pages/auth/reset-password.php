<?php $active = 'auth'; $title = 'Réinitialiser le mot de passe'; ?>

<div style="max-width: 400px; margin: 100px auto; padding: 20px;">
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 40px;">
        <h2 style="text-align: center; color: #1f3057; margin-bottom: 30px;">🔑 Créer un nouveau mot de passe</h2>
        
        <?php if (isset($error)): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                ❌ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($token) && !isset($error)): ?>
            <form method="POST">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Nouveau mot de passe</label>
                    <input type="password" name="password" required minlength="8" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <small style="color: #666;">Minimum 8 caractères</small>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Confirmez le mot de passe</label>
                    <input type="password" name="confirm_password" required minlength="8" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                </div>
                
                <button type="submit" style="width: 100%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                    Réinitialiser le mot de passe
                </button>
            </form>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="/ElevageHome/public/?url=auth/login" style="color: #007bff; text-decoration: none;">Retour à la connexion</a>
        </div>
    </div>
</div>
