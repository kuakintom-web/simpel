<?php

namespace App\Controllers;

use App\Models\School;
use App\Models\FinancialReport;
use App\Models\Asset;
use App\Models\VisitorBook;
use App\Helpers\ChartData;
use App\Middleware\AuthMiddleware;

class ReportController
{
    public function dashboard()
    {
        AuthMiddleware::check();
        
        $school_id = $_SESSION['school_id'] ?? 1;
        
        // Get statistics
        $stats = ChartData::getStatistics($school_id);
        
        // Get chart data
        $financialChart = ChartData::getFinancialChart($school_id);
        $assetChart = ChartData::getAssetChart($school_id);
        $visitorChart = ChartData::getVisitorChart($school_id);
        
        include BASE_PATH . '/views/report/dashboard.php';
    }
    
    public function financialReport()
    {
        AuthMiddleware::check();
        
        $school_id = $_SESSION['school_id'] ?? 1;
        
        $report = new FinancialReport();
        $reports = $report->getBySchool($school_id);
        
        $financialChart = ChartData::getFinancialChart($school_id);
        
        include BASE_PATH . '/views/report/financial.php';
    }
    
    public function assetReport()
    {
        AuthMiddleware::check();
        
        $school_id = $_SESSION['school_id'] ?? 1;
        
        $asset = new Asset();
        $assets = $asset->getBySchool($school_id);
        
        $assetChart = ChartData::getAssetChart($school_id);
        
        include BASE_PATH . '/views/report/asset.php';
    }
}
