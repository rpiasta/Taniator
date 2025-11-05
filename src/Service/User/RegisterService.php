<?php

namespace App\Service\User;

use App\Constraints\UserStatus;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;

class RegisterService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws Exception
     */
    public function register(string $email, string $password, string $name): void
    {
        if ($this->userRepository->findByEmal($email)) {
            throw new Exception('User with that e-mail address already exists');
        }

        $user = new User(
            email: $email,
            password: $password,
            name: $name,
            status: UserStatus::ACTIVE->value,
        );
        $this->userRepository->save($user);
    }
}
