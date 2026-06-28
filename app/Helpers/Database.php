<?php

namespace App\Helpers;

class Database
{
    private static $connection;
    
    public static function connect()
    {
        if (self::$connection) {
            return self::$connection;
        }
        
        $config = $GLOBALS['config']['database'];
        
        $connection = new \mysqli(
            $config['host'],
            $config['user'],
            $config['password'],
            $config['database'],
            $config['port']
        );
        
        if ($connection->connect_error) {
            die('Koneksi database gagal: ' . $connection->connect_error);
        }
        
        $connection->set_charset('utf8mb4');
        self::$connection = $connection;
        
        return self::$connection;
    }
    
    public static function query($sql)
    {
        $conn = self::connect();
        return $conn->query($sql);
    }
    
    public static function prepare($sql)
    {
        $conn = self::connect();
        return $conn->prepare($sql);
    }
    
    public static function escape($string)
    {
        $conn = self::connect();
        return $conn->real_escape_string($string);
    }
}
