<?php

namespace App\Controller\Factory\User;

use App\Controller\User\RegisterController;
use App\Repository\UserRepository;
use App\Service\User\RegisterService;

class RegsterControllerFactory
{
    public static function create(): RegisterController
    {
        $userRepository = new UserRepository;
        $registerServce = new RegisterService($userRepository);

        return new RegisterController($registerServce);
    }
}
