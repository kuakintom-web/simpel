<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    public function showLogin()
    {
        if ($this->isAuthenticated()) {
            header('Location: /dashboard');
            exit;
        }
        
        include BASE_PATH . '/views/auth/login.php';
    }
    
    public function login()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $user = new User();
        $result = $user->authenticate($username, $password);
        
        if ($result) {
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['user_role'] = $result['role'];
            $_SESSION['user_name'] = $result['name'];
            
            header('Location: /dashboard');
            exit;
        } else {
            header('Location: /login?error=invalid_credentials');
            exit;
        }
    }
    
    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
    
    protected function isAuthenticated()
    {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
}
