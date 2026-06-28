<?php

namespace App\Helpers;

class ChartData
{
    public static function getFinancialChart($school_id)
    {
        $conn = Database::connect();
        
        $query = "SELECT 
                    DATE_FORMAT(report_date, '%Y-%m') as month,
                    SUM(closing_balance) as total
                  FROM financial_reports
                  WHERE school_id = ?
                  GROUP BY DATE_FORMAT(report_date, '%Y-%m')
                  ORDER BY report_date DESC
                  LIMIT 12";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $school_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        
        return self::formatChartData($data);
    }
    
    public static function getAssetChart($school_id)
    {
        $conn = Database::connect();
        
        $query = "SELECT 
                    category,
                    COUNT(*) as count,
                    SUM(purchase_price) as total_value
                  FROM assets
                  WHERE school_id = ? AND status = 'aktif'
                  GROUP BY category";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $school_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        
        return $data;
    }
    
    public static function getVisitorChart($school_id, $days = 30)
    {
        $conn = Database::connect();
        
        $query = "SELECT 
                    DATE(visit_date) as visit_day,
                    COUNT(*) as visitors
                  FROM visitor_books
                  WHERE school_id = ? AND visit_date >= DATE_SUB(NOW(), INTERVAL ? DAY)
                  GROUP BY DATE(visit_date)
                  ORDER BY visit_date ASC";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $school_id, $days);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        
        return self::formatChartData($data);
    }
    
    private static function formatChartData($data)
    {
        $labels = [];
        $values = [];
        
        foreach ($data as $item) {
            $labels[] = array_values($item)[0];
            $values[] = end($item);
        }
        
        return [
            'labels' => $labels,
            'data' => $values
        ];
    }
    
    public static function getStatistics($school_id)
    {
        $conn = Database::connect();
        
        // Total students
        $stmt = $conn->prepare("SELECT SUM(total_students) as total FROM schools WHERE id = ?");
        $stmt->bind_param('i', $school_id);
        $stmt->execute();
        $students = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
        
        // Total teachers
        $stmt = $conn->prepare("SELECT SUM(total_teachers) as total FROM schools WHERE id = ?");
        $stmt->bind_param('i', $school_id);
        $stmt->execute();
        $teachers = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
        
        // Total assets
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM assets WHERE school_id = ? AND status = 'aktif'");
        $stmt->bind_param('i', $school_id);
        $stmt->execute();
        $assets = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
        
        // Total visitors this month
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM visitor_books WHERE school_id = ? AND MONTH(visit_date) = MONTH(NOW())");
        $stmt->bind_param('i', $school_id);
        $stmt->execute();
        $visitors = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
        
        return [
            'total_students' => $students,
            'total_teachers' => $teachers,
            'total_assets' => $assets,
            'total_visitors' => $visitors
        ];
    }
}
