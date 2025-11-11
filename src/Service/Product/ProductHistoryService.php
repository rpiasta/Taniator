<?php

namespace App\Service\Product;

use App\Repository\ProductHistoryRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;

class ProductHistoryService
{
    private ProductHistoryRepository $productHistoryRepository;
    private UserRepository $userRepository;
    private ProductRepository $productRepository;

    public function __construct(
        ProductHistoryRepository $productHistoryRepository,
        UserRepository           $userRepository,
        ProductRepository $productRepository
    )
    {
        $this->productHistoryRepository = $productHistoryRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    public function process(string $userMail, int $limit = 10): array
    {
        $user = $this->userRepository->getByUuid($userMail);
        $productsHistory = $this->productHistoryRepository->findLatestByUser($user, $limit);

        $response = [];

        foreach ($productsHistory as $productHistory) {

            $products = $this->productRepository->findByBarcodeStoreAndDay(
                $productHistory->barcode,
                $productHistory->createdAt
            );

            $grouped = [
                'barcode' => $productHistory->barcode,
                'date' => $productHistory->createdAt->format('Y-m-d'),
                'products' => []
            ];

            foreach ($products as $product) {
                $grouped['products'][] = [
                    'store'      => $product->store,
                    'data'       => $product->data,
                    'createdAt'  => $product->createdAt->format('Y-m-d H:i:s'),
                ];
            }

            $response[] = $grouped;
        }

        return $response;
    }
}
