<?php $active = 'auth'; $title = 'Confirmation Email'; ?>

<div style="max-width: 400px; margin: 100px auto; padding: 20px;">
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 40px; text-align: center;">
        <?php if (isset($error)): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                ❌ <?php echo htmlspecialchars($error); ?>
            </div>
            <a href="/ElevageHome/public/?url=auth/register" style="color: #007bff; text-decoration: none;">Essayer une nouvelle inscription</a>
        <?php else: ?>
            <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                ✅ Confirmation réussie!
            </div>
            <p>Votre email a été confirmé. Vous pouvez maintenant vous connecter.</p>
            <a href="/ElevageHome/public/?url=auth/login" class="btn btn-primary" style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block; margin-top: 20px;">
                Se connecter
            </a>
        <?php endif; ?>
    </div>
</div>
