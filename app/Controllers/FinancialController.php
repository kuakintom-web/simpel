<?php

namespace App\Controllers;

use App\Models\FinancialReport;
use App\Middleware\AuthMiddleware;

class FinancialController
{
    public function index()
    {
        AuthMiddleware::check();
        
        $report = new FinancialReport();
        $school_id = $_SESSION['school_id'] ?? 1;
        $reports = $report->getBySchool($school_id);
        
        include BASE_PATH . '/views/financial/index.php';
    }
    
    public function show($id)
    {
        AuthMiddleware::check();
        
        $report = new FinancialReport();
        $reportData = $report->find($id);
        
        if (!$reportData) {
            http_response_code(404);
            die('Laporan keuangan tidak ditemukan');
        }
        
        include BASE_PATH . '/views/financial/show.php';
    }
    
    public function create()
    {
        AuthMiddleware::check();
        include BASE_PATH . '/views/financial/create.php';
    }
    
    public function store()
    {
        AuthMiddleware::check();
        
        $data = [
            'school_id' => $_SESSION['school_id'] ?? 1,
            'report_date' => $_POST['report_date'] ?? date('Y-m-d'),
            'month' => (int)date('m', strtotime($_POST['report_date'] ?? date('Y-m-d'))),
            'year' => (int)date('Y', strtotime($_POST['report_date'] ?? date('Y-m-d'))),
            'opening_balance' => (float)($_POST['opening_balance'] ?? 0),
            'created_by' => $_SESSION['user_id']
        ];
        
        $report = new FinancialReport();
        if ($report->create($data)) {
            header('Location: /keuangan?success=Laporan keuangan berhasil dibuat');
            exit;
        } else {
            header('Location: /keuangan?error=Gagal membuat laporan');
            exit;
        }
    }
}
