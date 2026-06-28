<?php

/**
 * Bootstrap application
 */

// Load configuration
$config = [
    'app' => require_once dirname(__DIR__) . '/config/app.php',
    'database' => require_once dirname(__DIR__) . '/config/database.php',
];

// Store configuration in global variable
$GLOBALS['config'] = $config;

// Set error handler
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (getenv('APP_DEBUG')) {
        echo "<pre>Error: $errstr in $errfile on line $errline</pre>";
    }
    return true;
});

// Set timezone
date_default_timezone_set($config['app']['timezone']);
