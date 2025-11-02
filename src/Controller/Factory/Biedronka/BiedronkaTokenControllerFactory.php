<?php

namespace App\Controller\Factory\Biedronka;

use App\Controller\Biedronka\BiedronkaTokenController;
use App\Core\Http\HttpClient;
use App\Service\Biedronka\BiedronkaTokenService;

class BiedronkaTokenControllerFactory
{
    public static function create(): BiedronkaTokenController
    {
        $httpClient = new HttpClient();
        $biedronkaGetTokenService = new BiedronkaTokenService($httpClient);

        return new BiedronkaTokenController($biedronkaGetTokenService);
    }
}
