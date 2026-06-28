<?php

namespace App\Models;

class Letter
{
    protected $connection;
    protected $table = 'letters';
    
    public function __construct()
    {
        $this->connection = $this->getConnection();
    }
    
    public function getBySchool($school_id, $type = null)
    {
        $query = "SELECT * FROM {$this->table} WHERE school_id = ?";
        $params = [$school_id];
        
        if ($type) {
            $query .= " AND letter_type = ?";
            $params[] = $type;
        }
        
        $query .= " ORDER BY letter_date DESC";
        
        $stmt = $this->connection->prepare($query);
        
        if ($type) {
            $stmt->bind_param('is', ...$params);
        } else {
            $stmt->bind_param('i', ...$params);
        }
        
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
        $query = "INSERT INTO {$this->table} (school_id, letter_type, letter_number, subject, sender_recipient, letter_date, content, created_by) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
            'issssssi',
            $data['school_id'],
            $data['letter_type'],
            $data['letter_number'],
            $data['subject'],
            $data['sender_recipient'],
            $data['letter_date'],
            $data['content'],
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
