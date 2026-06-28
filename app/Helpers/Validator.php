<?php

namespace App\Helpers;

class Validator
{
    private $errors = [];
    private $data = [];
    private $rules = [];
    
    public function __construct($data = [])
    {
        $this->data = $data;
    }
    
    public function validate($rules)
    {
        $this->rules = $rules;
        
        foreach ($rules as $field => $ruleSet) {
            $value = $this->data[$field] ?? null;
            $fieldRules = explode('|', $ruleSet);
            
            foreach ($fieldRules as $rule) {
                $this->applyRule($field, $value, $rule);
            }
        }
        
        return $this;
    }
    
    private function applyRule($field, $value, $rule)
    {
        if (strpos($rule, ':') !== false) {
            list($ruleName, $parameter) = explode(':', $rule, 2);
            $rule = $ruleName;
        } else {
            $parameter = null;
        }
        
        switch (trim($rule)) {
            case 'required':
                if (empty($value)) {
                    $this->addError($field, "{$field} wajib diisi");
                }
                break;
                
            case 'email':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "{$field} harus berupa email yang valid");
                }
                break;
                
            case 'numeric':
                if (!empty($value) && !is_numeric($value)) {
                    $this->addError($field, "{$field} harus berupa angka");
                }
                break;
                
            case 'min':
                if (!empty($value) && strlen($value) < (int)$parameter) {
                    $this->addError($field, "{$field} minimal {$parameter} karakter");
                }
                break;
                
            case 'max':
                if (!empty($value) && strlen($value) > (int)$parameter) {
                    $this->addError($field, "{$field} maksimal {$parameter} karakter");
                }
                break;
                
            case 'unique':
                $this->validateUnique($field, $value, $parameter);
                break;
                
            case 'date':
                if (!empty($value) && !$this->isValidDate($value)) {
                    $this->addError($field, "{$field} harus berupa tanggal yang valid");
                }
                break;
                
            case 'url':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
                    $this->addError($field, "{$field} harus berupa URL yang valid");
                }
                break;
        }
    }
    
    private function validateUnique($field, $value, $parameter)
    {
        if (empty($value)) return;
        
        list($table, $column) = explode(',', $parameter);
        
        $conn = Database::connect();
        $query = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $value);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row['count'] > 0) {
            $this->addError($field, "{$field} sudah digunakan");
        }
    }
    
    private function isValidDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
    
    private function addError($field, $message)
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }
    
    public function passes()
    {
        return empty($this->errors);
    }
    
    public function fails()
    {
        return !$this->passes();
    }
    
    public function errors()
    {
        return $this->errors;
    }
    
    public function getError($field)
    {
        return $this->errors[$field] ?? [];
    }
    
    public function getFirstError($field)
    {
        return $this->errors[$field][0] ?? null;
    }
}
