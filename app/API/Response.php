<?php

namespace App\API;

class Response
{
    private $statusCode = 200;
    private $data = [];
    private $message = '';
    
    public function __construct($statusCode = 200, $data = [], $message = '')
    {
        $this->statusCode = $statusCode;
        $this->data = $data;
        $this->message = $message;
    }
    
    public function send()
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 ' . $this->statusCode);
        
        $response = [
            'status' => $this->statusCode,
            'message' => $this->message,
            'data' => $this->data
        ];
        
        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    public static function success($data = [], $message = 'Success')
    {
        $response = new self(200, $data, $message);
        $response->send();
    }
    
    public static function created($data = [], $message = 'Created successfully')
    {
        $response = new self(201, $data, $message);
        $response->send();
    }
    
    public static function badRequest($message = 'Bad request')
    {
        $response = new self(400, [], $message);
        $response->send();
    }
    
    public static function unauthorized($message = 'Unauthorized')
    {
        $response = new self(401, [], $message);
        $response->send();
    }
    
    public static function forbidden($message = 'Forbidden')
    {
        $response = new self(403, [], $message);
        $response->send();
    }
    
    public static function notFound($message = 'Not found')
    {
        $response = new self(404, [], $message);
        $response->send();
    }
    
    public static function error($message = 'Internal server error')
    {
        $response = new self(500, [], $message);
        $response->send();
    }
}
