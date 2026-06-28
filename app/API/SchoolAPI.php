<?php

namespace App\API;

class SchoolAPI
{
    public static function list()
    {
        if (!isset($_SESSION['user_id'])) {
            Response::unauthorized();
        }
        
        $conn = \App\Helpers\Database::connect();
        $query = "SELECT * FROM schools WHERE status = 'aktif'";
        $result = $conn->query($query);
        $schools = $result->fetch_all(MYSQLI_ASSOC);
        
        Response::success($schools, 'Schools retrieved successfully');
    }
    
    public static function get($id)
    {
        if (!isset($_SESSION['user_id'])) {
            Response::unauthorized();
        }
        
        $conn = \App\Helpers\Database::connect();
        $query = "SELECT * FROM schools WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $school = $result->fetch_assoc();
        
        if (!$school) {
            Response::notFound('School not found');
        }
        
        Response::success($school, 'School retrieved successfully');
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
        
        if (!$input || !isset($input['name']) || !isset($input['district_id'])) {
            Response::badRequest('Missing required fields');
        }
        
        $conn = \App\Helpers\Database::connect();
        
        $query = "INSERT INTO schools (name, npsn, district_id, address, phone, email, principal_name, total_students, total_teachers, founded_year)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            'ssisisiii',
            $input['name'],
            $input['npsn'] ?? '',
            $input['district_id'],
            $input['address'] ?? '',
            $input['phone'] ?? '',
            $input['email'] ?? '',
            $input['principal_name'] ?? '',
            $input['total_students'] ?? 0,
            $input['total_teachers'] ?? 0,
            $input['founded_year'] ?? date('Y')
        );
        
        if ($stmt->execute()) {
            Response::created(['id' => $conn->insert_id], 'School created successfully');
        } else {
            Response::error('Failed to create school');
        }
    }
}
