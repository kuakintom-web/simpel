<?php

namespace App\Helpers;

class Backup
{
    private static $backupDir = BASE_PATH . '/storage/backups';
    
    public static function create()
    {
        if (!is_dir(self::$backupDir)) {
            mkdir(self::$backupDir, 0755, true);
        }
        
        $timestamp = date('Y-m-d_H-i-s');
        $filename = "backup_simpel_{$timestamp}.sql";
        $filepath = self::$backupDir . '/' . $filename;
        
        $config = $GLOBALS['config']['database'];
        
        // Create backup using mysqldump
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            escapeshellarg($config['user']),
            escapeshellarg($config['password']),
            escapeshellarg($config['host']),
            escapeshellarg($config['database']),
            escapeshellarg($filepath)
        );
        
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0) {
            // Log the backup
            Logger::log(
                $_SESSION['user_id'] ?? 0,
                'BACKUP_CREATE',
                'database',
                "Database backup created: {$filename}",
                ['filename' => $filename, 'size' => filesize($filepath)]
            );
            
            return ['success' => true, 'filename' => $filename];
        }
        
        return ['success' => false, 'error' => 'Failed to create backup'];
    }
    
    public static function restore($filename)
    {
        $filepath = self::$backupDir . '/' . $filename;
        
        if (!file_exists($filepath)) {
            return ['success' => false, 'error' => 'Backup file not found'];
        }
        
        $config = $GLOBALS['config']['database'];
        
        // Restore backup using mysql
        $command = sprintf(
            'mysql --user=%s --password=%s --host=%s %s < %s',
            escapeshellarg($config['user']),
            escapeshellarg($config['password']),
            escapeshellarg($config['host']),
            escapeshellarg($config['database']),
            escapeshellarg($filepath)
        );
        
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0) {
            Logger::log(
                $_SESSION['user_id'] ?? 0,
                'BACKUP_RESTORE',
                'database',
                "Database restored from: {$filename}"
            );
            
            return ['success' => true, 'message' => 'Database restored successfully'];
        }
        
        return ['success' => false, 'error' => 'Failed to restore backup'];
    }
    
    public static function list()
    {
        $backups = [];
        
        if (is_dir(self::$backupDir)) {
            $files = scandir(self::$backupDir, SCANDIR_SORT_DESCENDING);
            
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && strpos($file, '.sql') !== false) {
                    $backups[] = [
                        'filename' => $file,
                        'size' => filesize(self::$backupDir . '/' . $file),
                        'created' => date('Y-m-d H:i:s', filemtime(self::$backupDir . '/' . $file))
                    ];
                }
            }
        }
        
        return $backups;
    }
    
    public static function delete($filename)
    {
        $filepath = self::$backupDir . '/' . $filename;
        
        if (!file_exists($filepath)) {
            return ['success' => false, 'error' => 'File not found'];
        }
        
        if (unlink($filepath)) {
            Logger::log(
                $_SESSION['user_id'] ?? 0,
                'BACKUP_DELETE',
                'database',
                "Backup deleted: {$filename}"
            );
            
            return ['success' => true, 'message' => 'Backup deleted successfully'];
        }
        
        return ['success' => false, 'error' => 'Failed to delete backup'];
    }
}
