<?php

namespace App\Middleware;

class AuthMiddleware
{
    public static function check()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
    
    public static function checkRole($allowedRoles)
    {
        self::check();
        
        if (!in_array($_SESSION['user_role'], $allowedRoles)) {
            http_response_code(403);
            die('Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }
    
    public static function isAdmin()
    {
        return isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], [
            'admin_pusat',
            'admin_kabupaten',
            'admin_kecamatan',
            'admin_sekolah'
        ]);
    }
}
