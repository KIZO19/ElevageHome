<?php
require_once __DIR__ . '/../model/services/EmailService.php';

class ControllerAdmin extends Controller {
    
    public function __construct($url) {
        parent::__construct($url);
        
        // Vérifier l'authentification
        if (!isset($_SESSION['user_id'])) {
            header('Location: /ElevageHome/public/?url=auth/login');
            exit;
        }
        
        // Vérifier que l'utilisateur est Manager
        if ($_SESSION['user_role'] !== 'Manager') {
            header('Location: /ElevageHome/public/?url=dashboard');
            exit;
        }
        
        if (isset($url[1])) {
            $method = strtolower($url[1]);
            
            if ($method === 'dashboard') {
                $this->dashboard();
            } elseif ($method === 'pending') {
                $this->pendingUsers();
            } elseif ($method === 'approve' && isset($url[2])) {
                $this->approveUser($url[2]);
            } elseif ($method === 'reject' && isset($url[2])) {
                $this->rejectUser($url[2]);
            } elseif ($method === 'users') {
                $this->allUsers();
            } elseif ($method === 'edit' && isset($url[2])) {
                $this->editUser($url[2]);
            } elseif ($method === 'suspend' && isset($url[2])) {
                $this->suspendUser($url[2]);
            } elseif ($method === 'activate' && isset($url[2])) {
                $this->activateUser($url[2]);
            } else {
                $this->dashboard();
            }
        } else {
            $this->dashboard();
        }
    }
    
    public function dashboard() {
        $utilisateursManager = new UtilisateursManager();
        
        $totalUsers = count($utilisateursManager->getAllUtilisateurs());
        $pendingUsers = count($utilisateursManager->getPendingUsers());
        $confirmedUsers = count($utilisateursManager->getConfirmedUsers());
        $recentUsers = array_slice($utilisateursManager->getAllUtilisateurs(), 0, 10);
        
        $stats = [
            'total' => $totalUsers,
            'pending' => $pendingUsers,
            'confirmed' => $confirmedUsers,
            'recent' => $recentUsers
        ];
        
        $this->render('admin/dashboard', $stats);
    }
    
    public function pendingUsers() {
        $utilisateursManager = new UtilisateursManager();
        $users = $utilisateursManager->getPendingUsers();
        
        $this->render('admin/pending-users', ['users' => $users]);
    }
    
    public function allUsers() {
        $utilisateursManager = new UtilisateursManager();
        $users = $utilisateursManager->getAllUtilisateurs();
        
        $this->render('admin/users-list', ['users' => $users]);
    }
    
    public function approveUser($id) {
        $utilisateursManager = new UtilisateursManager();
        $user = $utilisateursManager->getUserById($id);
        
        if (!$user) {
            throw new Exception('Utilisateur non trouvé');
        }
        
        try {
            $utilisateursManager->confirmEmail($id);
            
            // Send approval email
            $emailService = new EmailService();
            $emailService->sendAccountApprovedEmail($user['email'], $user['prenom'] . ' ' . $user['nom']);
            
            $_SESSION['success'] = 'Compte approuvé et email de notification envoyé!';
            header('Location: /ElevageHome/public/?url=admin/pending');
            exit;
        } catch (Exception $e) {
            throw new Exception('Erreur lors de l\'approbation: ' . $e->getMessage());
        }
    }
    
    public function rejectUser($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reason = $_POST['reason'] ?? '';
            $utilisateursManager = new UtilisateursManager();
            $user = $utilisateursManager->getUserById($id);
            
            if (!$user) {
                throw new Exception('Utilisateur non trouvé');
            }
            
            try {
                $utilisateursManager->suspendUser($id);
                
                // Send rejection email
                $emailService = new EmailService();
                $emailService->sendAccountRejectedEmail($user['email'], $user['prenom'] . ' ' . $user['nom'], $reason);
                
                $_SESSION['success'] = 'Compte rejeté et email de notification envoyé!';
                header('Location: /ElevageHome/public/?url=admin/pending');
                exit;
            } catch (Exception $e) {
                throw new Exception('Erreur lors du rejet: ' . $e->getMessage());
            }
        } else {
            $utilisateursManager = new UtilisateursManager();
            $user = $utilisateursManager->getUserById($id);
            
            $this->render('admin/reject-user', ['user' => $user]);
        }
    }
    
    public function editUser($id) {
        $utilisateursManager = new UtilisateursManager();
        $user = $utilisateursManager->getUserById($id);
        
        if (!$user) {
            throw new Exception('Utilisateur non trouvé');
        }
        
        // Get roles and exploitations for dropdowns
        $roleManager = new RoleManager();
        $roles = $roleManager->getAllRoles();
        
        $exploitationsManager = new ExploitationsManager();
        $exploitations = $exploitationsManager->getAllExploitations();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = [
                    'nom' => trim($_POST['nom'] ?? ''),
                    'prenom' => trim($_POST['prenom'] ?? ''),
                    'email' => trim($_POST['email'] ?? ''),
                    'id_role' => $_POST['id_role'] ?? null,
                    'id_exploitation' => !empty($_POST['id_exploitation']) ? $_POST['id_exploitation'] : null,
                    'statut_compte' => $_POST['statut_compte'] ?? 'actif'
                ];

                if (!empty($_POST['password'])) {
                    $data['mot_de_passe'] = trim($_POST['password']);
                }

                $utilisateursManager->updateUtilisateur($id, $data);
                $_SESSION['success'] = 'Utilisateur mis à jour!';
                header('Location: /ElevageHome/public/?url=admin/users');
                exit;
            } catch (Exception $e) {
                throw new Exception('Erreur lors de la mise à jour: ' . $e->getMessage());
            }
        }
        
        $this->render('admin/edit-user', [
            'user' => $user,
            'roles' => $roles,
            'exploitations' => $exploitations
        ]);
    }
    
    public function suspendUser($id) {
        $utilisateursManager = new UtilisateursManager();
        
        try {
            $utilisateursManager->suspendUser($id);
            $_SESSION['success'] = 'Utilisateur suspendu!';
            header('Location: /ElevageHome/public/?url=admin/users');
            exit;
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la suspension: ' . $e->getMessage());
        }
    }
    
    public function activateUser($id) {
        $utilisateursManager = new UtilisateursManager();
        
        try {
            $utilisateursManager->activateUser($id);
            $_SESSION['success'] = 'Utilisateur activé!';
            header('Location: /ElevageHome/public/?url=admin/users');
            exit;
        } catch (Exception $e) {
            throw new Exception('Erreur lors de l\'activation: ' . $e->getMessage());
        }
    }
}
