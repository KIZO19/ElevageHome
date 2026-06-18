<?php $active = '';
$title = 'Erreur';
?>

<div class="content-header">
    <h1>❌ Erreur</h1>
</div>

<div class="card">
    <div class="card-body">
        <div style="padding: 20px; background: #fff3cd; border: 1px solid #ffeeba; border-radius: 8px; color: #856404;">
            <h2>Une erreur est survenue</h2>
            <p><?php echo htmlspecialchars($errorMsg ?? 'Une erreur inconnue est survenue.'); ?></p>
            <div style="margin-top: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="/ElevageHome/public/?url=dashboard" class="btn btn-primary">Retour au tableau de bord</a>
                <a href="/ElevageHome/public/?url=auth/login" class="btn btn-secondary">Connexion</a>
            </div>
        </div>
    </div>
</div>
<style>
    .content-header {
        margin-bottom: 20px;
    }
    .content-header h1 {
        font-size: 26px;
        color: #d9534f;
    }
    .card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .btn-primary, .btn-secondary {
        display: inline-block;
        padding: 10px 20px;
        color: white;
        text-decoration: none;
        border-radius: 4px;
    }
    .btn-primary {
        background: #007bff;
    }
    .btn-primary:hover {
        background: #0056b3;
    }
    .btn-secondary {
        background: #6c757d;
    }
    .btn-secondary:hover {
        background: #5a6268;
    }
</style>
