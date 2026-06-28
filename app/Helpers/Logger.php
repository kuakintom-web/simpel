<?php

namespace App\Helpers;

class Logger
{
    private static $logFile = BASE_PATH . '/storage/logs/activity.log';
    
    public static function log($user_id, $action, $module, $description = '', $details = [])
    {
        $conn = Database::connect();
        
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        $query = "INSERT INTO activity_logs (user_id, action, module, description, ip_address, user_agent)
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            'isssss',
            $user_id,
            $action,
            $module,
            $description,
            $ip_address,
            $user_agent
        );
        
        $stmt->execute();
        
        // Also log to file
        self::logToFile($user_id, $action, $module, $description, $details);
    }
    
    private static function logToFile($user_id, $action, $module, $description, $details = [])
    {
        $logDir = dirname(self::$logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] User ID: $user_id | Action: $action | Module: $module | Description: $description";
        
        if (!empty($details)) {
            $logMessage .= " | Details: " . json_encode($details);
        }
        
        $logMessage .= " | IP: {$_SERVER['REMOTE_ADDR']} | User Agent: {$_SERVER['HTTP_USER_AGENT']}";
        
        file_put_contents(self::$logFile, $logMessage . "\n", FILE_APPEND);
    }
    
    public static function getLogs($user_id = null, $limit = 100)
    {
        $conn = Database::connect();
        
        $query = "SELECT * FROM activity_logs";
        $params = [];
        
        if ($user_id) {
            $query .= " WHERE user_id = ?";
            $params[] = $user_id;
        }
        
        $query .= " ORDER BY created_at DESC LIMIT ?";
        $params[] = $limit;
        
        $stmt = $conn->prepare(substr($query, 0, strpos($query, 'LIMIT')));
        
        if ($user_id) {
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ii', $user_id, $limit);
        } else {
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $limit);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
