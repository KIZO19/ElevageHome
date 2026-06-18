<?php
/**
 * Email Configuration
 * Configure your SMTP settings here
 */

return [
    'smtp' => [
        'enabled' => false,  // Set to true to use SMTP
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'username' => 'johkizo19@gmail.com',
        'password' => 'otpo bznf atey kuav',  // Use app password for Gmail
        'encryption' => 'tls',  // 'tls' or 'ssl'
        'from_email' => 'noreply@elevage-home.local',
        'from_name' => 'ElevageHome',
    ],
    'mail' => [
        // Fallback to PHP mail() function
        'from_email' => 'noreply@elevage-home.local',
        'from_name' => 'ElevageHome',
    ],
    'development' => [
        // Log emails to file in development
        'enabled' => true,
        'log_path' => __DIR__ . '/../logs/emails.log',
    ]
];
?>
