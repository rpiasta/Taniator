<?php

namespace App\Controller\Factory;

use App\Controller\ProductController;
use App\Core\Http\HttpClient;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Service\Biedronka\BiedronkaProductService;
use App\Service\Biedronka\BiedronkaRefreshTokenService;
use App\Service\ProductService;
use App\Service\Selgros\SelgrosProductService;

class ProductControllerFactory
{
    public static function create(): ProductController
    {
        $httpClient = new HttpClient();
        $biedronkaRefreshTokenService = new BiedronkaRefreshTokenService($httpClient);
        $SelgrosProductService = new SelgrosProductService($httpClient);
        $biedronkaProductService = new BiedronkaProductService($httpClient, $biedronkaRefreshTokenService);
        $prouctRepository = new ProductRepository();
        $userRepository = new UserRepository();
        $productService = new ProductService(
            $biedronkaProductService,
            $SelgrosProductService,
            $prouctRepository,
            $userRepository
        );

        return new ProductController($productService);
    }
}
