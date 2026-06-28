<?php

namespace App\Helpers;

class Filter
{
    private $query;
    private $table;
    private $conditions = [];
    private $params = [];
    private $types = '';
    
    public function __construct($table)
    {
        $this->table = $table;
        $this->query = "SELECT * FROM {$table}";
    }
    
    public function where($column, $operator, $value)
    {
        $this->conditions[] = "{$column} {$operator} ?";
        $this->params[] = $value;
        $this->types .= $this->getParamType($value);
        
        return $this;
    }
    
    public function search($searchTerm, $columns = [])
    {
        if (empty($columns) || empty($searchTerm)) {
            return $this;
        }
        
        $searchConditions = [];
        foreach ($columns as $column) {
            $searchConditions[] = "{$column} LIKE ?";
            $this->params[] = "%{$searchTerm}%";
            $this->types .= 's';
        }
        
        if (!empty($searchConditions)) {
            $this->conditions[] = '(' . implode(' OR ', $searchConditions) . ')';
        }
        
        return $this;
    }
    
    public function orderBy($column, $direction = 'ASC')
    {
        $this->query .= " ORDER BY {$column} {$direction}";
        return $this;
    }
    
    public function limit($limit, $offset = 0)
    {
        $this->query .= " LIMIT {$limit} OFFSET {$offset}";
        return $this;
    }
    
    public function paginate($page = 1, $perPage = 25)
    {
        $offset = ($page - 1) * $perPage;
        return $this->limit($perPage, $offset);
    }
    
    public function between($column, $start, $end)
    {
        $this->conditions[] = "{$column} BETWEEN ? AND ?";
        $this->params[] = $start;
        $this->params[] = $end;
        $this->types .= 'ss';
        
        return $this;
    }
    
    public function in($column, $values = [])
    {
        if (empty($values)) {
            return $this;
        }
        
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $this->conditions[] = "{$column} IN ({$placeholders})";
        
        foreach ($values as $value) {
            $this->params[] = $value;
            $this->types .= $this->getParamType($value);
        }
        
        return $this;
    }
    
    public function get()
    {
        if (!empty($this->conditions)) {
            $this->query .= ' WHERE ' . implode(' AND ', $this->conditions);
        }
        
        $conn = Database::connect();
        $stmt = $conn->prepare($this->query);
        
        if (!empty($this->params)) {
            $stmt->bind_param($this->types, ...$this->params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function count()
    {
        $countQuery = str_replace('SELECT *', 'SELECT COUNT(*) as total', $this->query);
        
        if (!empty($this->conditions)) {
            $countQuery .= ' WHERE ' . implode(' AND ', $this->conditions);
        }
        
        $conn = Database::connect();
        $stmt = $conn->prepare($countQuery);
        
        if (!empty($this->params)) {
            $stmt->bind_param($this->types, ...$this->params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['total'] ?? 0;
    }
    
    private function getParamType($value)
    {
        if (is_int($value)) return 'i';
        if (is_float($value)) return 'd';
        return 's';
    }
}
