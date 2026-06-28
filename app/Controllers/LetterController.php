<?php

namespace App\Controllers;

use App\Models\Letter;
use App\Middleware\AuthMiddleware;

class LetterController
{
    public function index()
    {
        AuthMiddleware::check();
        
        $letter = new Letter();
        $school_id = $_SESSION['school_id'] ?? 1;
        $type = $_GET['type'] ?? null;
        $letters = $letter->getBySchool($school_id, $type);
        
        include BASE_PATH . '/views/letter/index.php';
    }
    
    public function show($id)
    {
        AuthMiddleware::check();
        
        $letter = new Letter();
        $letterData = $letter->find($id);
        
        if (!$letterData) {
            http_response_code(404);
            die('Surat tidak ditemukan');
        }
        
        include BASE_PATH . '/views/letter/show.php';
    }
    
    public function create()
    {
        AuthMiddleware::check();
        $type = $_GET['type'] ?? 'keluar';
        include BASE_PATH . '/views/letter/create.php';
    }
    
    public function store()
    {
        AuthMiddleware::check();
        
        // Generate letter number
        $letter_number = $this->generateLetterNumber($_POST['letter_type']);
        
        $data = [
            'school_id' => $_SESSION['school_id'] ?? 1,
            'letter_type' => $_POST['letter_type'] ?? 'keluar',
            'letter_number' => $letter_number,
            'subject' => $_POST['subject'] ?? '',
            'sender_recipient' => $_POST['sender_recipient'] ?? '',
            'letter_date' => $_POST['letter_date'] ?? date('Y-m-d'),
            'content' => $_POST['content'] ?? '',
            'created_by' => $_SESSION['user_id']
        ];
        
        $letter = new Letter();
        if ($letter->create($data)) {
            header('Location: /surat?success=Surat berhasil dibuat');
            exit;
        } else {
            header('Location: /surat?error=Gagal membuat surat');
            exit;
        }
    }
    
    private function generateLetterNumber($type)
    {
        $prefix = ($type === 'keluar') ? 'SK' : 'SM';
        $date = date('dmy');
        $random = str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        return "{$prefix}/{$date}/{$random}";
    }
}
