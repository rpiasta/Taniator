<?php

namespace App\Controller\User;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Service\User\LoginService;
use App\Constraints\HttpMethod;
use App\Constraints\HttpStatus;
use Throwable;
use Exception;

class LoginController
{
    private LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function __invoke(Request $request): Response
    {
        try {
            if ($request->getMethod() !== HttpMethod::POST->value) {
                throw new Exception('Method Not Allowed', HttpStatus::NOT_ALLOWED->value);
            }

            $data = $request->getBody();
            if (empty($data['email']) || empty($data['password'])) {
                throw new Exception('Missing email or password', HttpStatus::BAD_REQUEST->value);
            }

            $token = $this->loginService->login($data['email'], $data['password']);

            return new Response(['token' => $token]);

        } catch (Throwable $th) {
            return new Response(['error' => $th->getMessage()], $th->getCode() ?: 400);
        }
    }
}
