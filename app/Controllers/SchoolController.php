<?php

namespace App\Controllers;

use App\Models\School;
use App\Middleware\AuthMiddleware;

class SchoolController
{
    public function index()
    {
        AuthMiddleware::check();
        
        $school = new School();
        $schools = $school->getAll();
        
        include BASE_PATH . '/views/school/index.php';
    }
    
    public function show($id)
    {
        AuthMiddleware::check();
        
        $school = new School();
        $schoolData = $school->find($id);
        
        if (!$schoolData) {
            http_response_code(404);
            die('Sekolah tidak ditemukan');
        }
        
        include BASE_PATH . '/views/school/show.php';
    }
    
    public function create()
    {
        AuthMiddleware::checkRole(['admin_pusat', 'admin_kabupaten', 'admin_kecamatan']);
        
        include BASE_PATH . '/views/school/create.php';
    }
    
    public function store()
    {
        AuthMiddleware::checkRole(['admin_pusat', 'admin_kabupaten', 'admin_kecamatan']);
        
        $data = [
            'name' => $_POST['name'] ?? '',
            'npsn' => $_POST['npsn'] ?? '',
            'district_id' => $_POST['district_id'] ?? '',
            'address' => $_POST['address'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'email' => $_POST['email'] ?? '',
            'principal_name' => $_POST['principal_name'] ?? '',
            'total_students' => $_POST['total_students'] ?? 0,
            'total_teachers' => $_POST['total_teachers'] ?? 0,
            'founded_year' => $_POST['founded_year'] ?? date('Y')
        ];
        
        $school = new School();
        if ($school->create($data)) {
            header('Location: /sekolah?success=Sekolah berhasil ditambahkan');
            exit;
        } else {
            header('Location: /sekolah?error=Gagal menambahkan sekolah');
            exit;
        }
    }
}
