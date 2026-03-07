<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Compte Administrateur Créé</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #9EC967, #3E6E4B); color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; border-radius: 5px; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Annuaire des Établissements</h1>
        </div>
        
        <div class="content">
            <h2>Bonjour Admin {{ $admin->cin }},</h2>
            
            <p>Votre compte administrateur a été créé avec succès.</p>
            
            <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 5px; padding: 15px; margin: 20px 0;">
                <strong>📋 Compte créé avec succès, en attente de validation du super administrateur</strong>
            </div>
            
            <p><strong>Détails de votre compte :</strong></p>
            <ul>
                <li><strong>CIN :</strong> {{ $admin->cin }}</li>
                <li><strong>Email :</strong> {{ $admin->email }}</li>
                <li><strong>Statut :</strong> En attente de validation</li>
                <li><strong>Date de création :</strong> {{ $admin->created_at->format('d/m/Y à H:i') }}</li>
            </ul>
            
            <p>Vous recevrez une nouvelle notification dès que votre compte sera validé par le super administrateur.</p>
            
            <p>Cordialement,<br>L'équipe de l'Annuaire des Établissements</p>
        </div>
        
        <div class="footer">
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>