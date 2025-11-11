<?php

namespace App\Controller\Factory\Product;

use App\Controller\Product\ProductController;
use App\Core\Http\HttpClient;
use App\Repository\ProductHistoryRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Service\Biedronka\BiedronkaProductService;
use App\Service\Biedronka\BiedronkaRefreshTokenService;
use App\Service\Product\ProductService;
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
        $productHistoryRepository = new ProductHistoryRepository();
        $productService = new ProductService(
            $biedronkaProductService,
            $SelgrosProductService,
            $prouctRepository,
            $userRepository,
            $productHistoryRepository
        );

        return new ProductController($productService);
    }
}
