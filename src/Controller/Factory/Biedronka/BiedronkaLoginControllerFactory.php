<?php

namespace App\Controller\Factory\Biedronka;

use App\Controller\Biedronka\BiedronkaLoginController;
use App\Core\Http\HttpClient;
use App\Service\Biedronka\BiedronkaLoginService;

class BiedronkaLoginControllerFactory
{
    public static function create(): BiedronkaLoginController
    {
        $httpClient = new HttpClient();
        $biedronkaLoginService = new BiedronkaLoginService($httpClient);

        return new BiedronkaLoginController($biedronkaLoginService);
    }

}