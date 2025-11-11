<?php
namespace App\Core;

use App\Core\Http\Request;
use App\Core\Http\Response;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, callable $handler, array $middleware = []): void
    {
        $this->routes[] = compact('method', 'path', 'handler', 'middleware');
    }

    public function dispatch(Request $request): Response
    {
        foreach ($this->routes as $route) {
            if (strtoupper($route['method']) === $request->getMethod() &&
                $route['path'] === $request->getPath()
            ) {
                $handler = $route['handler'];
                foreach ($route['middleware'] as $mw) {
                    $handler = fn($req) => $mw->handle($req, $handler);
                }
                return $handler($request);
            }
        }
        return new Response(['error' => 'Not Found'], 404);
    }
}
