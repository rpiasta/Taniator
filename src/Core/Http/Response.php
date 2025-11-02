<?php
namespace App\Core\Http;

use App\Constraints\HttpStatus;

class Response
{
    private array $data;
    private int $status;

    public function __construct(array $data, int $status = HttpStatus::OK->value)
    {
        $this->data = $data;
        $this->status = $status;
    }

    public function send(): void
    {
        http_response_code($this->status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($this->data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
