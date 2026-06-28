<?php

namespace App\Controllers;

use App\Models\User;

class ProfileController
{
    public function show()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $user = new User();
        $profile = $user->find($_SESSION['user_id']);
        
        include BASE_PATH . '/views/profile/show.php';
    }
}
