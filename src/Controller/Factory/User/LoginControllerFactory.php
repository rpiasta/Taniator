<?php

namespace App\Controller\Factory\User;

use App\Controller\User\LoginController;
use App\Repository\UserRepository;
use App\Service\User\LoginService;

class LoginControllerFactory
{
    public static function create(): LoginController
    {
        $userRepository = new UserRepository();
        $loginService = new LoginService($userRepository);

        return new LoginController($loginService);
    }
}
