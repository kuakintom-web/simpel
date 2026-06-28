<?php

namespace App\Models;

class FinancialReport
{
    protected $connection;
    protected $table = 'financial_reports';
    
    public function __construct()
    {
        $this->connection = $this->getConnection();
    }
    
    public function getBySchool($school_id)
    {
        $query = "SELECT * FROM {$this->table} WHERE school_id = ? ORDER BY report_date DESC";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $school_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function find($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function create($data)
    {
        $query = "INSERT INTO {$this->table} (school_id, report_date, month, year, opening_balance, created_by) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
            'isiddi',
            $data['school_id'],
            $data['report_date'],
            $data['month'],
            $data['year'],
            $data['opening_balance'],
            $data['created_by']
        );
        
        return $stmt->execute();
    }
    
    protected function getConnection()
    {
        $config = $GLOBALS['config']['database'];
        
        $connection = new \mysqli(
            $config['host'],
            $config['user'],
            $config['password'],
            $config['database'],
            $config['port']
        );
        
        if ($connection->connect_error) {
            die('Database connection failed: ' . $connection->connect_error);
        }
        
        $connection->set_charset('utf8mb4');
        return $connection;
    }
}
