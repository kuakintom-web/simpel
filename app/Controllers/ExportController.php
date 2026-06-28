<?php

namespace App\Controllers;

use App\Helpers\PDF;
use App\Helpers\Excel;
use App\Models\FinancialReport;
use App\Middleware\AuthMiddleware;

class ExportController
{
    public function exportFinancialPDF($school_id)
    {
        AuthMiddleware::check();
        
        $report = new FinancialReport();
        $reports = $report->getBySchool($school_id);
        
        $headers = ['Bulan', 'Tahun', 'Saldo Awal', 'Saldo Akhir', 'Status'];
        $data = [];
        
        foreach ($reports as $rep) {
            $data[] = [
                date('F', mktime(0, 0, 0, $rep['month'])),
                $rep['year'],
                'Rp ' . number_format($rep['opening_balance'], 0),
                'Rp ' . number_format($rep['closing_balance'], 0),
                ucfirst($rep['status'])
            ];
        }
        
        $pdf = new PDF('Laporan-Keuangan-' . date('Ymd'));
        $pdf->generateReport('Laporan Keuangan', $headers, $data);
    }
    
    public function exportFinancialExcel($school_id)
    {
        AuthMiddleware::check();
        
        $report = new FinancialReport();
        $reports = $report->getBySchool($school_id);
        
        $headers = ['No', 'Bulan', 'Tahun', 'Saldo Awal', 'Saldo Akhir', 'Status'];
        $data = [];
        
        foreach ($reports as $key => $rep) {
            $data[] = [
                $key + 1,
                date('F', mktime(0, 0, 0, $rep['month'])),
                $rep['year'],
                $rep['opening_balance'],
                $rep['closing_balance'],
                ucfirst($rep['status'])
            ];
        }
        
        Excel::exportCSV('Laporan-Keuangan-' . date('Ymd'), $headers, $data);
    }
}
