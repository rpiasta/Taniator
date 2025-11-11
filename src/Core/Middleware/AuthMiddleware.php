<?php
namespace App\Core\Middleware;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Service\User\LoginService;
use App\Constraints\HttpStatus;
use Exception;

class AuthMiddleware
{
    private LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function handle(Request $request, callable $next): Response
    {
        $authHeader = $request->getHeader('Authorization') ?? '';
        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return new Response(['error' => 'Unauthorized'], HttpStatus::UNAUTHORIZED->value);
        }

        $token = $matches[1];

        try {
            $payload = $this->loginService->verifyToken($token);
            $request->setAttribute('user', $payload);
            return $next($request);
        } catch (Exception $e) {
            return new Response(['error' => 'Invalid or expired token'], HttpStatus::UNAUTHORIZED->value);
        }
    }
}
