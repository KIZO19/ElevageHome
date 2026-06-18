<?php

class TokenService {
    /**
     * Generate a secure random token
     */
    public static function generateToken($length = 64) {
        return bin2hex(random_bytes($length / 2));
    }
    
    /**
     * Generate confirmation token with 24-hour expiration
     */
    public static function generateConfirmationToken() {
        $token = self::generateToken();
        $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        return [
            'token' => $token,
            'expires_at' => $expiresAt
        ];
    }
    
    /**
     * Generate password reset token with 1-hour expiration
     */
    public static function generateResetToken() {
        $token = self::generateToken();
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        return [
            'token' => $token,
            'expires_at' => $expiresAt
        ];
    }
    
    /**
     * Check if token is still valid (not expired)
     */
    public static function isTokenValid($expiresAt) {
        return strtotime($expiresAt) > time();
    }
}
