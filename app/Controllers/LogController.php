<?php

namespace App\Controllers;

use App\Helpers\Logger;
use App\Helpers\Filter;
use App\Middleware\AuthMiddleware;

class LogController
{
    public function index()
    {
        AuthMiddleware::checkRole(['admin_pusat', 'admin_kabupaten']);
        
        $search = $_GET['search'] ?? '';
        $module = $_GET['module'] ?? '';
        
        $filter = new Filter('activity_logs');
        $filter->orderBy('created_at', 'DESC')->limit(500);
        
        if (!empty($search)) {
            $filter->search($search, ['description', 'action']);
        }
        
        if (!empty($module)) {
            $filter->where('module', '=', $module);
        }
        
        $logs = $filter->get();
        
        include BASE_PATH . '/views/log/activity.php';
    }
    
    public function export()
    {
        AuthMiddleware::checkRole(['admin_pusat']);
        
        $logs = Logger::getLogs(null, 5000);
        
        $headers = ['No', 'User ID', 'Action', 'Module', 'Description', 'IP Address', 'Timestamp'];
        $data = [];
        
        foreach ($logs as $key => $log) {
            $data[] = [
                $key + 1,
                $log['user_id'],
                $log['action'],
                $log['module'],
                $log['description'],
                $log['ip_address'],
                $log['created_at']
            ];
        }
        
        \App\Helpers\Excel::exportCSV('activity-logs-' . date('Ymd'), $headers, $data);
    }
}
