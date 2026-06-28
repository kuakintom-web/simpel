<?php

namespace App\Helpers;

class PDF
{
    private $pdf;
    private $title;
    private $author = 'SIMPEL-Alkhairaat';
    
    public function __construct($title = 'Report')
    {
        $this->title = $title;
        $this->initializePDF();
    }
    
    private function initializePDF()
    {
        // Simple PDF generation using built-in functions
        // For production, use TCPDF or similar library
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $this->title . '.pdf"');
    }
    
    public function generateReport($title, $headers, $data)
    {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    color: #333;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                    border-bottom: 2px solid #667eea;
                    padding-bottom: 10px;
                }
                .header h1 {
                    margin: 0;
                    color: #667eea;
                }
                .header p {
                    margin: 5px 0;
                    font-size: 12px;
                    color: #999;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                th {
                    background-color: #667eea;
                    color: white;
                    padding: 10px;
                    text-align: left;
                    border: 1px solid #ddd;
                }
                td {
                    padding: 10px;
                    border: 1px solid #ddd;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                .footer {
                    margin-top: 30px;
                    text-align: center;
                    font-size: 11px;
                    color: #999;
                    border-top: 1px solid #ddd;
                    padding-top: 10px;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1><?php echo htmlspecialchars($title); ?></h1>
                <p>SIMPEL-Alkhairaat | <?php echo date('d M Y H:i'); ?></p>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <?php foreach ($headers as $header): ?>
                            <th><?php echo htmlspecialchars($header); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $key => $row): ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <?php foreach ($row as $cell): ?>
                                <td><?php echo htmlspecialchars($cell); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="footer">
                <p>© 2024 SIMPEL-Alkhairaat. Sistem Informasi Manajemen Pendidikan Lengkap.</p>
            </div>
        </body>
        </html>
        <?php
        $html = ob_get_clean();
        
        // Output as PDF (in production, use library like TCPDF)
        echo $html;
        exit;
    }
}
