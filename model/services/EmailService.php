<?php
/**
 * Email Service with configuration support
 * Sends real emails via mail() or logs to file for development
 */

class EmailService {
    private $config;
    private $from;
    private $fromName;
    private $logEmailsToFile = false;
    
    public function __construct() {
        // Load email config if exists
        if (file_exists(__DIR__ . '/../../config/email.php')) {
           $this->config = require __DIR__ . '/../../config/email.php';
           $this->logEmailsToFile = $this->config['development']['enabled'] ?? true;
           $this->from = $this->config['mail']['from_email'];
           $this->fromName = $this->config['mail']['from_name'];
        } else {
           // Fallback defaults
           $this->from = 'no-reply@elevage-home.local';
           $this->fromName = 'ElevageHome';
           $this->logEmailsToFile = true;
        }
    }
    
    /**
     * Send confirmation email after registration
     */
    public function sendConfirmationEmail($email, $name, $confirmationToken) {
        $confirmationLink = "http://localhost/ElevageHome/public/?url=auth/confirm-email&token=" . urlencode($confirmationToken);
        
        $subject = "Confirmez votre adresse email - ElevageHome";
        $htmlBody = $this->getConfirmationEmailTemplate($name, $confirmationLink);
        
        return $this->sendEmail($email, $subject, $htmlBody);
    }
    
    /**
     * Send password reset email
     */
    public function sendPasswordResetEmail($email, $name, $resetToken) {
        $resetLink = "http://localhost/ElevageHome/public/?url=auth/reset-password&token=" . urlencode($resetToken);
        
        $subject = "Réinitialiser votre mot de passe - ElevageHome";
        $htmlBody = $this->getPasswordResetEmailTemplate($name, $resetLink);
        
        return $this->sendEmail($email, $subject, $htmlBody);
    }
    
    /**
     * Send account approval notification
     */
    public function sendAccountApprovedEmail($email, $name) {
        $subject = "Votre compte a été approuvé - ElevageHome";
        $loginLink = "http://localhost/ElevageHome/public/?url=auth/login";
        
        $htmlBody = $this->getApprovedEmailTemplate($name, $loginLink);
        
        return $this->sendEmail($email, $subject, $htmlBody);
    }
    
    /**
     * Send account rejection notification
     */
    public function sendAccountRejectedEmail($email, $name, $reason = '') {
        $subject = "Votre demande de compte a été rejetée - ElevageHome";
        
        $htmlBody = $this->getRejectedEmailTemplate($name, $reason);
        
        return $this->sendEmail($email, $subject, $htmlBody);
    }
    
    /**
     * Core send email method - logs to file AND sends via mail()
     */
    private function sendEmail($to, $subject, $htmlBody) {
        // Always log to file for debugging
        $this->logEmailToFile($to, $subject, $htmlBody);
        
        // Send actual email via mail()
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: {$this->fromName} <{$this->from}>\r\n";
        $headers .= "Reply-To: {$this->from}\r\n";
        
        // Send email
        $result = @mail($to, $subject, $htmlBody, $headers);
        
        if ($result) {
           error_log("[EmailService] Email sent to: $to | Subject: $subject");
        } else {
           error_log("[EmailService] Failed to send email to: $to | Subject: $subject");
        }
        
        return $result;
    }
    
    /**
     * Log email to file for development/debugging
     */
    private function logEmailToFile($to, $subject, $htmlBody) {
        if (!$this->logEmailsToFile) return;
        
        $logFile = __DIR__ . '/../../logs/emails.log';
        $logDir = dirname($logFile);
        if (!is_dir($logDir)) {
           mkdir($logDir, 0755, true);
        }
        
        $plainText = strip_tags($htmlBody);
        $logEntry = "[" . date('Y-m-d H:i:s') . "] TO: $to | SUBJECT: $subject\n" .
                   "HEADERS: From: {$this->fromName} <{$this->from}>\n" .
                   "BODY PREVIEW: " . substr($plainText, 0, 200) . "...\n" .
                   str_repeat("-", 80) . "\n\n";
        
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
    
    /**
     * Email template for confirmation
     */
    private function getConfirmationEmailTemplate($name, $confirmationLink) {
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
           <div style='background: #007bff; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;'>
               <h1>ElevageHome</h1>
               <p>Confirmez votre adresse email</p>
           </div>
           <div style='padding: 30px; background: #f5f5f5; border-radius: 0 0 5px 5px;'>
               <p>Bonjour <strong>$name</strong>,</p>
               <p>Merci de vous être inscrit sur ElevageHome!</p>
               <p>Pour activer votre compte et continuer, veuillez confirmer votre adresse email en cliquant sur le bouton ci-dessous:</p>
               <p style='text-align: center; margin-top: 30px; margin-bottom: 30px;'>
                   <a href='$confirmationLink' style='background: #28a745; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;'>
                       Confirmer mon email
                   </a>
               </p>
               <p style='font-size: 12px; color: #666;'>
                   Si le bouton ne fonctionne pas, copiez ce lien dans votre navigateur:<br>
                   <a href='$confirmationLink' style='color: #007bff;'>$confirmationLink</a>
               </p>
               <p style='font-size: 12px; color: #999; margin-top: 30px; border-top: 1px solid #ddd; padding-top: 20px;'>
                   Ce lien expire dans 24 heures.
               </p>
           </div>
        </div>";
    }
    
    /**
     * Email template for password reset
     */
    private function getPasswordResetEmailTemplate($name, $resetLink) {
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
           <div style='background: #ff9800; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;'>
               <h1>ElevageHome</h1>
               <p>Réinitialiser votre mot de passe</p>
           </div>
           <div style='padding: 30px; background: #f5f5f5; border-radius: 0 0 5px 5px;'>
               <p>Bonjour <strong>$name</strong>,</p>
               <p>Vous avez demandé la réinitialisation de votre mot de passe.</p>
               <p>Cliquez sur le bouton ci-dessous pour créer un nouveau mot de passe:</p>
               <p style='text-align: center; margin-top: 30px; margin-bottom: 30px;'>
                   <a href='$resetLink' style='background: #007bff; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;'>
                       Réinitialiser mon mot de passe
                   </a>
               </p>
               <p style='font-size: 12px; color: #666;'>
                   Si le bouton ne fonctionne pas, copiez ce lien dans votre navigateur:<br>
                   <a href='$resetLink' style='color: #007bff;'>$resetLink</a>
               </p>
               <p style='font-size: 12px; color: #999; margin-top: 30px; border-top: 1px solid #ddd; padding-top: 20px;'>
                   Ce lien expire dans 1 heure. Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.
               </p>
           </div>
        </div>";
    }
    
    /**
     * Email template for account approval
     */
    private function getApprovedEmailTemplate($name, $loginLink) {
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
           <div style='background: #2ecc71; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;'>
               <h1>ElevageHome</h1>
               <p>✅ Votre compte a été approuvé</p>
           </div>
           <div style='padding: 30px; background: #f5f5f5; border-radius: 0 0 5px 5px;'>
               <p>Bonjour <strong>$name</strong>,</p>
               <p>Votre compte a été approuvé par un administrateur!</p>
               <p>Vous pouvez maintenant vous connecter en utilisant vos identifiants.</p>
               <p style='text-align: center; margin-top: 30px; margin-bottom: 30px;'>
                   <a href='$loginLink' style='background: #2ecc71; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;'>
                       Se connecter à ElevageHome
                   </a>
               </p>
           </div>
        </div>";
    }
    
    /**
     * Email template for account rejection
     */
    private function getRejectedEmailTemplate($name, $reason = '') {
        $reasonText = $reason ? "<p><strong>Motif:</strong> " . htmlspecialchars($reason) . "</p>" : '';
        
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
           <div style='background: #e74c3c; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;'>
               <h1>ElevageHome</h1>
               <p>❌ Votre demande a été rejetée</p>
           </div>
           <div style='padding: 30px; background: #f5f5f5; border-radius: 0 0 5px 5px;'>
               <p>Bonjour <strong>$name</strong>,</p>
               <p>Malheureusement, votre demande de compte a été rejetée.</p>
               $reasonText
               <p>Si vous avez des questions, veuillez contacter l'administrateur.</p>
           </div>
        </div>";
    }
}
?>
