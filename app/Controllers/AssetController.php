<?php

namespace App\Controllers;

use App\Models\Asset;
use App\Middleware\AuthMiddleware;

class AssetController
{
    public function index()
    {
        AuthMiddleware::check();
        
        $asset = new Asset();
        $school_id = $_SESSION['school_id'] ?? 1;
        $assets = $asset->getBySchool($school_id);
        
        include BASE_PATH . '/views/asset/index.php';
    }
    
    public function show($id)
    {
        AuthMiddleware::check();
        
        $asset = new Asset();
        $assetData = $asset->find($id);
        
        if (!$assetData) {
            http_response_code(404);
            die('Aset tidak ditemukan');
        }
        
        include BASE_PATH . '/views/asset/show.php';
    }
    
    public function create()
    {
        AuthMiddleware::check();
        include BASE_PATH . '/views/asset/create.php';
    }
    
    public function store()
    {
        AuthMiddleware::check();
        
        $data = [
            'school_id' => $_SESSION['school_id'] ?? 1,
            'asset_code' => $_POST['asset_code'] ?? '',
            'name' => $_POST['name'] ?? '',
            'category' => $_POST['category'] ?? '',
            'description' => $_POST['description'] ?? '',
            'quantity' => (int)($_POST['quantity'] ?? 1),
            'unit' => $_POST['unit'] ?? '',
            'purchase_date' => $_POST['purchase_date'] ?? date('Y-m-d'),
            'purchase_price' => (float)($_POST['purchase_price'] ?? 0),
            'location' => $_POST['location'] ?? ''
        ];
        
        $asset = new Asset();
        if ($asset->create($data)) {
            header('Location: /aset?success=Aset berhasil ditambahkan');
            exit;
        } else {
            header('Location: /aset?error=Gagal menambahkan aset');
            exit;
        }
    }
}
