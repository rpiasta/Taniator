<?php

namespace App\Controller\Factory\Product;

use App\Controller\Product\ProductHistoryController;
use App\Repository\ProductHistoryRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Service\Product\ProductHistoryService;

class ProductHistoryControllerFactory
{
    public static function create(): ProductHistoryController
    {
        $productHistoryRepository = new ProductHistoryRepository();
        $userRepository = new UserRepository();
        $productRepository = new ProductRepository();
        $service = new ProductHistoryService($productHistoryRepository, $userRepository, $productRepository);
        return new ProductHistoryController($service);
    }
}
