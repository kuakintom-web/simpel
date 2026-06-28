<?php

/**
 * SIMPEL-Alkhairaat - Entry Point Application
 */

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', getenv('APP_DEBUG') ? 1 : 0);

// Define base path
define('BASE_PATH', dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);

// Load environment variables
require_once BASE_PATH . '/helpers/load-env.php';

// Load autoloader and bootstrap
require_once BASE_PATH . '/helpers/autoloader.php';
require_once BASE_PATH . '/helpers/bootstrap.php';

// Start session
session_start();

// Load router
require_once BASE_PATH . '/helpers/router.php';

// Simple routing
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = str_replace('/simpel', '', $requestUri); // Adjust if in subfolder
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Routes
$routes = [
    'GET' => [
        '/' => 'DashboardController@index',
        '/login' => 'AuthController@showLogin',
        '/logout' => 'AuthController@logout',
        '/dashboard' => 'DashboardController@index',
        '/profile' => 'ProfileController@show',
    ],
    'POST' => [
        '/login' => 'AuthController@login',
    ],
];

// Route matching dan dispatch
$route = $routes[$requestMethod][$requestUri] ?? null;

if ($route) {
    list($controller, $method) = explode('@', $route);
    $controller = "App\\Controllers\\" . $controller;
    
    if (class_exists($controller)) {
        $instance = new $controller();
        if (method_exists($instance, $method)) {
            $instance->$method();
        } else {
            http_response_code(404);
            echo "Method not found: $method";
        }
    } else {
        http_response_code(404);
        echo "Controller not found: $controller";
    }
} else {
    http_response_code(404);
    require_once BASE_PATH . '/views/404.php';
}
