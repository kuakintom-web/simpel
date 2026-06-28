<?php

namespace App\Helpers;

class Excel
{
    public static function export($filename, $headers, $data)
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        
        // Create tab-separated values
        $output = '';
        
        // Add headers
        $output .= implode("\t", $headers) . "\n";
        
        // Add data
        foreach ($data as $row) {
            $output .= implode("\t", $row) . "\n";
        }
        
        echo $output;
        exit;
    }
    
    public static function exportCSV($filename, $headers, $data)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
        
        // Open file pointer
        $output = fopen('php://output', 'w');
        
        // Add BOM for UTF-8
        fwrite($output, "\xEF\xBB\xBF");
        
        // Write headers
        fputcsv($output, $headers);
        
        // Write data
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        
        fclose($output);
        exit;
    }
}
