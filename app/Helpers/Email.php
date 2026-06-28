<?php

namespace App\Helpers;

class Email
{
    private $to;
    private $subject;
    private $message;
    private $headers;
    
    public function __construct($to, $subject = '')
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->headers = "MIME-Version: 1.0" . "\r\n";
        $this->headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
        $this->headers .= "From: noreply@alkhairaat.sch.id" . "\r\n";
    }
    
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
    
    public function addHeader($key, $value)
    {
        $this->headers .= "{$key}: {$value}" . "\r\n";
        return $this;
    }
    
    public function send()
    {
        return mail($this->to, $this->subject, $this->message, $this->headers);
    }
    
    public static function sendWelcome($email, $name, $username)
    {
        $mailer = new self($email, 'Selamat Datang di SIMPEL-Alkhairaat');
        
        $message = "<h2>Selamat Datang, {$name}!</h2>";
        $message .= "<p>Akun Anda telah berhasil dibuat di SIMPEL-Alkhairaat.</p>";
        $message .= "<p><strong>Username:</strong> {$username}</p>";
        $message .= "<p>Silakan login di <a href='http://simpel.alkhairaat.sch.id'>SIMPEL-Alkhairaat</a></p>";
        $message .= "<p>Terima kasih!</p>";
        
        return $mailer->setMessage($message)->send();
    }
    
    public static function sendReportNotification($email, $name, $reportType)
    {
        $mailer = new self($email, 'Notifikasi Laporan - SIMPEL-Alkhairaat');
        
        $message = "<h2>Notifikasi Laporan Baru</h2>";
        $message .= "<p>Halo {$name},</p>";
        $message .= "<p>Laporan <strong>{$reportType}</strong> baru telah dibuat.</p>";
        $message .= "<p>Tanggal: " . date('d M Y H:i') . "</p>";
        $message .= "<p>Silakan login untuk melihat detail laporan.</p>";
        
        return $mailer->setMessage($message)->send();
    }
    
    public static function sendApprovalNotification($email, $name, $documentType, $documentId)
    {
        $mailer = new self($email, 'Permohonan Persetujuan - SIMPEL-Alkhairaat');
        
        $message = "<h2>Permohonan Persetujuan Dokumen</h2>";
        $message .= "<p>Halo {$name},</p>";
        $message .= "<p>Ada dokumen <strong>{$documentType}</strong> yang memerlukan persetujuan Anda.</p>";
        $message .= "<p>ID Dokumen: {$documentId}</p>";
        $message .= "<p>Silakan login untuk melihat dan memberikan persetujuan.</p>";
        
        return $mailer->setMessage($message)->send();
    }
}
