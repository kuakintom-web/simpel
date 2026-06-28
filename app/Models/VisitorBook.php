<?php

namespace App\Models;

class VisitorBook
{
    protected $connection;
    protected $table = 'visitor_books';
    
    public function __construct()
    {
        $this->connection = $this->getConnection();
    }
    
    public function getBySchool($school_id, $limit = 50)
    {
        $query = "SELECT * FROM {$this->table} WHERE school_id = ? ORDER BY visit_date DESC LIMIT ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('ii', $school_id, $limit);
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
        $query = "INSERT INTO {$this->table} (school_id, visitor_name, visitor_phone, visitor_email, visitor_organization, purpose, visit_date, remarks) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
            'isssssss',
            $data['school_id'],
            $data['visitor_name'],
            $data['visitor_phone'],
            $data['visitor_email'],
            $data['visitor_organization'],
            $data['purpose'],
            $data['visit_date'],
            $data['remarks']
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
