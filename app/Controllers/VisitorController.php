<?php

namespace App\Controllers;

use App\Models\VisitorBook;
use App\Middleware\AuthMiddleware;

class VisitorController
{
    public function index()
    {
        AuthMiddleware::check();
        
        $visitor = new VisitorBook();
        $school_id = $_SESSION['school_id'] ?? 1;
        $visitors = $visitor->getBySchool($school_id);
        
        include BASE_PATH . '/views/visitor/index.php';
    }
    
    public function show($id)
    {
        AuthMiddleware::check();
        
        $visitor = new VisitorBook();
        $visitorData = $visitor->find($id);
        
        if (!$visitorData) {
            http_response_code(404);
            die('Data pengunjung tidak ditemukan');
        }
        
        include BASE_PATH . '/views/visitor/show.php';
    }
    
    public function create()
    {
        AuthMiddleware::check();
        include BASE_PATH . '/views/visitor/create.php';
    }
    
    public function store()
    {
        AuthMiddleware::check();
        
        $data = [
            'school_id' => $_SESSION['school_id'] ?? 1,
            'visitor_name' => $_POST['visitor_name'] ?? '',
            'visitor_phone' => $_POST['visitor_phone'] ?? '',
            'visitor_email' => $_POST['visitor_email'] ?? '',
            'visitor_organization' => $_POST['visitor_organization'] ?? '',
            'purpose' => $_POST['purpose'] ?? '',
            'visit_date' => $_POST['visit_date'] ?? date('Y-m-d H:i:s'),
            'remarks' => $_POST['remarks'] ?? ''
        ];
        
        $visitor = new VisitorBook();
        if ($visitor->create($data)) {
            header('Location: /buku-tamu?success=Data pengunjung berhasil ditambahkan');
            exit;
        } else {
            header('Location: /buku-tamu?error=Gagal menambahkan pengunjung');
            exit;
        }
    }
}
