<?php
namespace App\Core;

use App\Core\Http\Request;
use App\Core\Http\Response;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, callable $handler): void
    {
        $this->routes[] = compact('method', 'path', 'handler');
    }

    public function dispatch(Request $request): Response
    {
        foreach ($this->routes as $route) {
            if (
                strtoupper($route['method']) === $request->getMethod() &&
                $route['path'] === $request->getPath()
            ) {
                return call_user_func($route['handler'], $request);
            }
        }
        return new Response(['error' => 'Not Found'], 404);
    }
}
