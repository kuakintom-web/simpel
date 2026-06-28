<?php

/**
 * Database Configuration
 */

return [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'user' => getenv('DB_USER') ?: 'root',
    'password' => getenv('DB_PASS') ?: '',
    'database' => getenv('DB_NAME') ?: 'simpel_alkhairaat',
    'port' => getenv('DB_PORT') ?: 3306,
    'charset' => 'utf8mb4',
];
