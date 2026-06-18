<?php

require_once __DIR__ . '/../model/services/TokenService.php';
require_once __DIR__ . '/../model/services/EmailService.php';

class ControllerAuth extends Controller {
    
    public function __construct($url) {
        parent::__construct($url);
        
        if (isset($url[1])) {
            $method = strtolower($url[1]);
            
            if ($method === 'login') {
                $this->login();
            } elseif ($method === 'logout') {
                $this->logout();
            } elseif ($method === 'register') {
                $this->register();
            } elseif ($method === 'confirm-email') {
                $this->confirmEmail();
            } elseif ($method === 'forgot-password') {
                $this->forgotPassword();
            } elseif ($method === 'reset-password') {
                $this->resetPassword();
            } elseif ($method === 'profile') {
                $this->profile();
            } else {
                throw new Exception('Page introuvable');
            }
        } else {
            $this->login();
        }
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nettoyage des entrées avec trim() pour éliminer les espaces invisibles
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            
            if (empty($email) || empty($password)) {
                $error = 'Email et mot de passe requis';
                $this->renderPartial('auth/login', ['error' => $error]);
                return;
            }
            
            $utilisateursManager = new UtilisateursManager();
            $user = $utilisateursManager->verifyPassword($email, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id_utilisateur'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['nom_role'];
                $_SESSION['user_name'] = $user['prenom'] . ' ' . $user['nom'];
                $_SESSION['id_exploitation'] = $user['id_exploitation'];
                
                // Redirection basée sur le rôle
                if ($user['nom_role'] === 'Manager') {
                    header('Location: /ElevageHome/public/?url=admin/dashboard');
                } else {
                    header('Location: /ElevageHome/public/?url=dashboard');
                }
                exit;
            } else {
                $error = 'Email ou mot de passe incorrect';
                $this->renderPartial('auth/login', ['error' => $error]);
            }
        } else {
            $this->renderPartial('auth/login');
        }
    }
    
    public function logout() {
        session_destroy();
        header('Location: /ElevageHome/public/?url=auth/login');
        exit;
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nettoyage global de toutes les données soumises à l'inscription
            $data = array_map('trim', $_POST);
            
            // Validation basique
            if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email']) || empty($data['password'])) {
                $error = 'Tous les champs requis doivent être remplis';
                $this->renderPartial('auth/register', ['error' => $error]);
                return;
            }
            
            // Vérifier les mots de passe
            if ($data['password'] !== $data['confirm_password']) {
                $error = 'Les mots de passe ne correspondent pas';
                $this->renderPartial('auth/register', ['error' => $error]);
                return;
            }
            
            // Validation email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $error = 'Email invalide';
                $this->renderPartial('auth/register', ['error' => $error]);
                return;
            }
            
            $utilisateursManager = new UtilisateursManager();
            
            // Vérifier si l'email existe déjà
            if ($utilisateursManager->getUserByEmail($data['email'])) {
                $error = 'Cet email est déjà utilisé';
                $this->renderPartial('auth/register', ['error' => $error]);
                return;
            }
            
            // Créer l'utilisateur SANS confirmer l'email
            $userData = [
                'prenom' => $data['first_name'],
                'nom' => $data['last_name'],
                'email' => $data['email'],
                'mot_de_passe' => $data['password'],
                'id_role' => 2, // eleveur_chef par défaut
                'email_confirmed' => FALSE
            ];
            
            try {
                $utilisateursManager->addUtilisateur($userData);
                
                // Récupérer le nouvel utilisateur
                $user = $utilisateursManager->getUserByEmail($data['email']);
                
                // Générer token de confirmation
                $tokenData = TokenService::generateConfirmationToken();
                $utilisateursManager->setConfirmationToken($user['id_utilisateur'], $tokenData['token'], $tokenData['expires_at']);
                
                // Envoyer email de confirmation
                $emailService = new EmailService();
                $emailService->sendConfirmationEmail($user['email'], $user['prenom'], $tokenData['token']);
                
                $success = 'Inscription réussie! Veuillez vérifier votre email pour confirmer votre compte.';
                $this->renderPartial('auth/login', ['success' => $success]);
            } catch (Exception $e) {
                $error = 'Erreur lors de l\'inscription: ' . $e->getMessage();
                $this->renderPartial('auth/register', ['error' => $error]);
            }
        } else {
            $this->renderPartial('auth/register');
        }
    }
    
    public function confirmEmail() {
        $token = isset($_GET['token']) ? trim($_GET['token']) : '';
        
        if (empty($token)) {
            $error = 'Token de confirmation invalide';
            $this->renderPartial('auth/confirm-email', ['error' => $error]);
            return;
        }
        
        $utilisateursManager = new UtilisateursManager();
        $user = $utilisateursManager->getUserByConfirmationToken($token);
        
        if (!$user) {
            $error = 'Token invalide ou expiré';
            $this->renderPartial('auth/confirm-email', ['error' => $error]);
            return;
        }
        
        try {
            $utilisateursManager->confirmEmail($user['id_utilisateur']);
            $success = 'Votre email a été confirmé! Vous pouvez maintenant vous connecter.';
            $this->renderPartial('auth/login', ['success' => $success]);
        } catch (Exception $e) {
            $error = 'Erreur lors de la confirmation: ' . $e->getMessage();
            $this->renderPartial('auth/confirm-email', ['error' => $error]);
        }
    }
    
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            
            if (empty($email)) {
                $error = 'Email requis';
                $this->renderPartial('auth/forgot-password', ['error' => $error]);
                return;
            }
            
            $utilisateursManager = new UtilisateursManager();
            $user = $utilisateursManager->getUserByEmail($email);
            
            if (!$user) {
                $success = 'Si un compte existe avec cet email, vous recevrez un lien de réinitialisation.';
                $this->renderPartial('auth/forgot-password', ['success' => $success]);
                return;
            }
            
            try {
                $tokenData = TokenService::generateResetToken();
                $utilisateursManager->setResetToken($user['id_utilisateur'], $tokenData['token'], $tokenData['expires_at']);
                
                $emailService = new EmailService();
                $emailService->sendPasswordResetEmail($user['email'], $user['prenom'], $tokenData['token']);
                
                $success = 'Si un compte existe avec cet email, vous recevrez un lien de réinitialisation.';
                $this->renderPartial('auth/forgot-password', ['success' => $success]);
            } catch (Exception $e) {
                $error = 'Erreur lors de l\'envoi: ' . $e->getMessage();
                $this->renderPartial('auth/forgot-password', ['error' => $error]);
            }
        } else {
            $this->renderPartial('auth/forgot-password');
        }
    }
    
    public function resetPassword() {
        $token = isset($_GET['token']) ? trim($_GET['token']) : '';
        
        if (empty($token)) {
            $error = 'Token de réinitialisation invalide';
            $this->renderPartial('auth/reset-password', ['error' => $error, 'token' => $token]);
            return;
        }
        
        $utilisateursManager = new UtilisateursManager();
        $user = $utilisateursManager->getUserByResetToken($token);
        
        if (!$user) {
            $error = 'Token invalide ou expiré';
            $this->renderPartial('auth/reset-password', ['error' => $error]);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
            
            if (empty($password) || empty($confirm_password)) {
                $error = 'Les deux mots de passe sont requis';
                $this->renderPartial('auth/reset-password', ['error' => $error, 'token' => $token]);
                return;
            }
            
            if ($password !== $confirm_password) {
                $error = 'Les mots de passe ne correspondent pas';
                $this->renderPartial('auth/reset-password', ['error' => $error, 'token' => $token]);
                return;
            }
            
            try {
                $utilisateursManager->resetPassword($user['id_utilisateur'], $password);
                $success = 'Votre mot de passe a été réinitialisé! Vous pouvez maintenant vous connecter.';
                $this->renderPartial('auth/login', ['success' => $success]);
            } catch (Exception $e) {
                $error = 'Erreur lors de la réinitialisation: ' . $e->getMessage();
                $this->renderPartial('auth/reset-password', ['error' => $error, 'token' => $token]);
            }
        } else {
            $this->renderPartial('auth/reset-password', ['token' => $token]);
        }
    }
    
    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /ElevageHome/public/?url=auth/login');
            exit;
        }
        
        $utilisateursManager = new UtilisateursManager();
        $user = $utilisateursManager->getUserById($_SESSION['user_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            
            if (empty($data['nom']) || empty($data['prenom'])) {
                $error = 'Nom et prénom requis';
                $this->render('auth/profile', ['user' => $user, 'error' => $error]);
                return;
            }
            
            try {
                $utilisateursManager->updateProfile($_SESSION['user_id'], $data);
                $_SESSION['user_name'] = $data['prenom'] . ' ' . $data['nom'];
                
                $success = 'Profil mis à jour avec succès!';
                $user = $utilisateursManager->getUserById($_SESSION['user_id']);
                $this->render('auth/profile', ['user' => $user, 'success' => $success]);
            } catch (Exception $e) {
                $error = 'Erreur lors de la mise à jour: ' . $e->getMessage();
                $this->render('auth/profile', ['user' => $user, 'error' => $error]);
            }
        } else {
            $this->render('auth/profile', ['user' => $user]);
        }
    }
}