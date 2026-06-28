<?php

/**
 * Application Configuration
 */

return [
    'name' => getenv('APP_NAME') ?: 'SIMPEL-Alkhairaat',
    'env' => getenv('APP_ENV') ?: 'production',
    'debug' => getenv('APP_DEBUG') ?: false,
    'url' => getenv('APP_URL') ?: 'http://localhost',
    'timezone' => 'Asia/Jakarta',
    
    // Roles dan Permissions
    'roles' => [
        'admin_pusat' => 'Administrator Pusat',
        'admin_kabupaten' => 'Admin Kabupaten',
        'admin_kecamatan' => 'Admin Kecamatan',
        'admin_sekolah' => 'Admin Sekolah',
    ],
    
    // Default pagination
    'pagination' => [
        'per_page' => 25,
    ],
];
