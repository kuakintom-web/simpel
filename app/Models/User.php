<?php

namespace App\Models;

class User
{
    protected $connection;
    protected $table = 'users';
    
    public function __construct()
    {
        $this->connection = $this->getConnection();
    }
    
    public function authenticate($username, $password)
    {
        $query = "SELECT * FROM {$this->table} WHERE username = ? AND is_active = 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return null;
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
    
    public function all()
    {
        $query = "SELECT * FROM {$this->table}";
        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
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
