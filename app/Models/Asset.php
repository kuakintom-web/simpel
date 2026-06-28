<?php

namespace App\Models;

class Asset
{
    protected $connection;
    protected $table = 'assets';
    
    public function __construct()
    {
        $this->connection = $this->getConnection();
    }
    
    public function getBySchool($school_id)
    {
        $query = "SELECT * FROM {$this->table} WHERE school_id = ? AND status = 'aktif' ORDER BY created_at DESC";
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
        $query = "INSERT INTO {$this->table} (school_id, asset_code, name, category, description, quantity, unit, purchase_date, purchase_price, location) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
            'issssissds',
            $data['school_id'],
            $data['asset_code'],
            $data['name'],
            $data['category'],
            $data['description'],
            $data['quantity'],
            $data['unit'],
            $data['purchase_date'],
            $data['purchase_price'],
            $data['location']
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
