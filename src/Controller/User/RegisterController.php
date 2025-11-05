<?php

namespace App\Controller\User;

use App\Constraints\HttpMethod;
use App\Constraints\HttpStatus;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Service\User\RegisterService;
use Exception;
use Throwable;

class RegisterController
{
    private RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function __invoke(Request $request): Response
    {
        try {
            if ($request->getMethod() === HttpMethod::POST->value) {
                $data = $request->getBody();
                $this->registerService->register($data['email'], $data['password'], $data['name']);
                return new Response(['message' => 'User registered successfully']);
            }

            throw new Exception('Method Not Allowed', HttpStatus::NOT_ALLOWED->value);

        } catch (Throwable $th) {
            return new Response([$th->getMessage()], $th->getCode());
        }
    }
}
