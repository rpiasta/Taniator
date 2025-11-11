<?php

namespace App\Service\User;

use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class LoginService
{
    private UserRepository $userRepository;
    private string $jwtSecret;

    private const int TOKEN_EXPIRATION_TIME = 3600;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->jwtSecret = $_ENV['JWT_SECRET'] ?? 'supersecretkey';
    }

    /**
     * @throws Exception
     */
    public function login(string $email, string $password): string
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            throw new Exception('Invalid credentials');
        }

        if (!password_verify($password, $user->password)) {
            throw new Exception('Invalid credentials');
        }

        $payload = [
            'sub' => $user->uuid,
            'email' => $user->email,
            'role' => $user->role,
            'iat' => time(),
            'exp' => time() + self::TOKEN_EXPIRATION_TIME,
        ];

        return JWT::encode($payload, $this->jwtSecret, 'HS256');
    }

    public function verifyToken(string $token): array
    {
        return (array) JWT::decode($token, new Key($this->jwtSecret, 'HS256'));
    }
}
