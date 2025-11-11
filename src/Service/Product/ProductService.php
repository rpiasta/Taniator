<?php

namespace App\Service\Product;

use App\Constraints\Store;
use App\Entity\Product;
use App\Entity\ProductHistory;
use App\Repository\ProductHistoryRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Service\Biedronka\BiedronkaProductService;
use App\Service\Selgros\SelgrosProductService;
use DateTimeImmutable;
use Doctrine\ORM\Exception\ORMException;
use Exception;

class ProductService
{
    private BiedronkaProductService $biedronkaProductService;
    private SelgrosProductService $selgrosProductService;

    private ProductRepository $productRepository;
    private UserRepository $userRepository;
    private ProductHistoryRepository $productHistoryRepository;

    public function __construct(
        BiedronkaProductService  $biedronkaProductService,
        SelgrosProductService    $selgrosProductService,
        ProductRepository        $productRepository,
        UserRepository           $userRepository,
        ProductHistoryRepository $productHistoryRepository
    )
    {
        $this->biedronkaProductService = $biedronkaProductService;
        $this->selgrosProductService = $selgrosProductService;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
        $this->productHistoryRepository = $productHistoryRepository;
    }

    /**
     * @throws Exception
     * @throws ORMException
     */
    public function process(string $barcode, string $userId): string
    {
        $today = new DateTimeImmutable('today');

        $biedronkaLatestProduct = $this->productRepository->findLatestByBarcodeAndStore($barcode, Store::BIEDRONKA->value);
        if (!$biedronkaLatestProduct || $biedronkaLatestProduct->createdAt < $today) {
            $biedronkaResponse = $this->biedronkaProductService->getProduct($barcode);
            $biedronkaProduct = new Product(
                $barcode,
                Store::BIEDRONKA->value,
                json_decode($biedronkaResponse, true)
            );
            $this->productRepository->save($biedronkaProduct);
        } else {
            $biedronkaProduct = $biedronkaLatestProduct;
            $biedronkaResponse = $biedronkaProduct->data;
        }

        $selgrosLatestProduct = $this->productRepository->findLatestByBarcodeAndStore($barcode, Store::SELGROS->value);
        if (!$selgrosLatestProduct || $selgrosLatestProduct->createdAt < $today) {
            $selgrosResponse = $this->selgrosProductService->getProduct($barcode);
            $selgrosProduct = new Product(
                $barcode,
                Store::SELGROS->value,
                json_decode($selgrosResponse, true)
            );
            $this->productRepository->save($selgrosProduct);
        } else {
            $selgrosProduct = $selgrosLatestProduct;
            $selgrosResponse = $selgrosProduct->data;
        }

        $user = $this->userRepository->getByUuid($userId);
        $this->productHistoryRepository->save(new ProductHistory($barcode, $user));

        return json_encode([
                'barcode' => $barcode,
                'biedronka' => [
                    'data' => $biedronkaResponse,
                ],
                'selgros' => [
                    'data' => $selgrosResponse,
                ],
                'saved_at' => $biedronkaProduct->createdAt->format('Y-m-d H:i:s') ?? $selgrosProduct->createdAt->format('Y-m-d H:i:s') ?? null,
            ]
        );
    }
}
