<?php
namespace App\Core\Http;

class Request
{
    private string $method;
    private string $path;
    private array $queryParams;
    private array $body;
    private array $headers = [];
    private array $attributes = [];

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $this->queryParams = $_GET;
        $input = file_get_contents('php://input');
        $this->body = json_decode($input, true) ?? [];

        foreach (getallheaders() as $name => $value) {
            $this->headers[strtolower($name)] = $value;
        }
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getHeader(string $name): ?string
    {
        return $this->headers[strtolower($name)] ?? null;
    }

    public function setAttribute(string $key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function getAttribute(string $key)
    {
        return $this->attributes[$key] ?? null;
    }
}
