<?php

namespace App\Controllers;

use App\Models\User;
use App\Middleware\AuthMiddleware;

class UserController
{
    public function index()
    {
        AuthMiddleware::checkRole(['admin_pusat', 'admin_kabupaten', 'admin_kecamatan']);
        
        $user = new User();
        $users = $user->all();
        
        include BASE_PATH . '/views/user/index.php';
    }
    
    public function show($id)
    {
        AuthMiddleware::checkRole(['admin_pusat', 'admin_kabupaten', 'admin_kecamatan']);
        
        $user = new User();
        $userData = $user->find($id);
        
        if (!$userData) {
            http_response_code(404);
            die('Pengguna tidak ditemukan');
        }
        
        include BASE_PATH . '/views/user/show.php';
    }
    
    public function create()
    {
        AuthMiddleware::checkRole(['admin_pusat', 'admin_kabupaten', 'admin_kecamatan']);
        include BASE_PATH . '/views/user/create.php';
    }
    
    public function store()
    {
        AuthMiddleware::checkRole(['admin_pusat', 'admin_kabupaten', 'admin_kecamatan']);
        
        $data = [
            'username' => $_POST['username'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT),
            'name' => $_POST['name'] ?? '',
            'role' => $_POST['role'] ?? 'admin_sekolah',
            'school_id' => $_POST['school_id'] ?? null
        ];
        
        $user = new User();
        if ($user->create($data)) {
            header('Location: /pengguna?success=Pengguna berhasil ditambahkan');
            exit;
        } else {
            header('Location: /pengguna?error=Gagal menambahkan pengguna');
            exit;
        }
    }
}
