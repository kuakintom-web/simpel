<?php

namespace App\Controllers;

class DashboardController
{
    public function index()
    {
        // Check authentication
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $userName = $_SESSION['user_name'];
        $userRole = $_SESSION['user_role'];
        
        // Load dashboard view
        include BASE_PATH . '/views/dashboard/index.php';
    }
}
