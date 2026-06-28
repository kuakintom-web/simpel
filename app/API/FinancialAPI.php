<?php

namespace App\API;

class FinancialAPI
{
    public static function list($school_id)
    {
        if (!isset($_SESSION['user_id'])) {
            Response::unauthorized();
        }
        
        $conn = \App\Helpers\Database::connect();
        
        $query = "SELECT * FROM financial_reports WHERE school_id = ? ORDER BY report_date DESC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $school_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $reports = $result->fetch_all(MYSQLI_ASSOC);
        
        Response::success($reports, 'Financial reports retrieved successfully');
    }
    
    public static function get($id)
    {
        if (!isset($_SESSION['user_id'])) {
            Response::unauthorized();
        }
        
        $conn = \App\Helpers\Database::connect();
        
        $query = "SELECT * FROM financial_reports WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $report = $result->fetch_assoc();
        
        if (!$report) {
            Response::notFound('Report not found');
        }
        
        // Get transactions
        $query = "SELECT * FROM financial_transactions WHERE report_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $report['transactions'] = $result->fetch_all(MYSQLI_ASSOC);
        
        Response::success($report, 'Report retrieved successfully');
    }
    
    public static function create()
    {
        if (!isset($_SESSION['user_id'])) {
            Response::unauthorized();
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::badRequest('Method not allowed');
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input || !isset($input['school_id']) || !isset($input['report_date'])) {
            Response::badRequest('Missing required fields');
        }
        
        $conn = \App\Helpers\Database::connect();
        
        $query = "INSERT INTO financial_reports (school_id, report_date, month, year, opening_balance, created_by)
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($query);
        
        $month = (int)date('m', strtotime($input['report_date']));
        $year = (int)date('Y', strtotime($input['report_date']));
        $created_by = $_SESSION['user_id'];
        
        $stmt->bind_param(
            'isiddi',
            $input['school_id'],
            $input['report_date'],
            $month,
            $year,
            $input['opening_balance'] ?? 0,
            $created_by
        );
        
        if ($stmt->execute()) {
            Response::created(['id' => $conn->insert_id], 'Report created successfully');
        } else {
            Response::error('Failed to create report');
        }
    }
}
