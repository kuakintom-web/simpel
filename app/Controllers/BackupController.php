<?php

namespace App\Controllers;

use App\Helpers\Backup;
use App\Helpers\Logger;
use App\Middleware\AuthMiddleware;

class BackupController
{
    public function index()
    {
        AuthMiddleware::checkRole(['admin_pusat']);
        
        $backups = Backup::list();
        
        include BASE_PATH . '/views/backup/index.php';
    }
    
    public function create()
    {
        AuthMiddleware::checkRole(['admin_pusat']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = Backup::create();
            
            if ($result['success']) {
                header('Location: /backup?success=Backup berhasil dibuat: ' . $result['filename']);
            } else {
                header('Location: /backup?error=' . urlencode($result['error']));
            }
            exit;
        }
    }
    
    public function restore()
    {
        AuthMiddleware::checkRole(['admin_pusat']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filename = $_POST['filename'] ?? '';
            $result = Backup::restore($filename);
            
            if ($result['success']) {
                header('Location: /backup?success=Database berhasil di-restore');
            } else {
                header('Location: /backup?error=' . urlencode($result['error']));
            }
            exit;
        }
    }
    
    public function delete()
    {
        AuthMiddleware::checkRole(['admin_pusat']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filename = $_POST['filename'] ?? '';
            $result = Backup::delete($filename);
            
            if ($result['success']) {
                header('Location: /backup?success=Backup berhasil dihapus');
            } else {
                header('Location: /backup?error=' . urlencode($result['error']));
            }
            exit;
        }
    }
}
