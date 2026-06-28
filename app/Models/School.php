<?php

namespace App\Models;

class School
{
    protected $connection;
    protected $table = 'schools';
    
    public function __construct()
    {
        $this->connection = $this->getConnection();
    }
    
    public function getAll()
    {
        $query = "SELECT * FROM {$this->table} WHERE status = 'aktif'";
        $result = $this->connection->query($query);
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
        $query = "INSERT INTO {$this->table} (name, npsn, district_id, address, phone, email, principal_name, total_students, total_teachers, founded_year) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
            'ssisisiii',
            $data['name'],
            $data['npsn'],
            $data['district_id'],
            $data['address'],
            $data['phone'],
            $data['email'],
            $data['principal_name'],
            $data['total_students'],
            $data['total_teachers'],
            $data['founded_year']
        );
        
        return $stmt->execute();
    }
    
    public function update($id, $data)
    {
        $query = "UPDATE {$this->table} SET name = ?, principal_name = ?, total_students = ?, total_teachers = ?, phone = ?, email = ? WHERE id = ?";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(
            'ssiiisi',
            $data['name'],
            $data['principal_name'],
            $data['total_students'],
            $data['total_teachers'],
            $data['phone'],
            $data['email'],
            $id
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
