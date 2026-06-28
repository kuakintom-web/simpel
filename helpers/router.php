<?php

/**
 * Router helper
 */

class Router
{
    protected static $routes = [];
    
    public static function get($path, $callback)
    {
        self::$routes['GET'][$path] = $callback;
    }
    
    public static function post($path, $callback)
    {
        self::$routes['POST'][$path] = $callback;
    }
    
    public static function getRoutes()
    {
        return self::$routes;
    }
}
