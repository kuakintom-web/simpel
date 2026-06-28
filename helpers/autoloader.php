<?php

/**
 * Auto-loader for application classes
 */

spl_autoload_register(function ($class) {
    // Remove leading backslash
    $class = ltrim($class, '\\');
    
    // Base directory for classes
    $baseDir = dirname(dirname(__FILE__));
    
    // Replace namespace separators with directory separators
    $file = $baseDir . DIRECTORY_SEPARATOR . str_replace('\\', '/', $class) . '.php';
    
    // If file exists, load it
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    
    return false;
});
