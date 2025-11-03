<?php

namespace App\Service;

use App\Constraints\Store;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\Biedronka\BiedronkaProductService;
use App\Service\Selgros\SelgrosProductService;
use Doctrine\ORM\Exception\ORMException;
use Exception;

class ProductService
{
    private BiedronkaProductService $biedronkaProductService;
    private SelgrosProductService $selgrosProductService;

    private ProductRepository $productRepository;

    public function __construct(
        BiedronkaProductService $biedronkaProductService,
        SelgrosProductService   $selgrosProductService,
        ProductRepository $productRepository
    )
    {
        $this->biedronkaProductService = $biedronkaProductService;
        $this->selgrosProductService = $selgrosProductService;
        $this->productRepository = $productRepository;
    }

    /**
     * @throws Exception
     * @throws ORMException
     */
    public function process(string $barcode): string
    {
        $biedronkaResponse = $this->biedronkaProductService->getProduct($barcode);
        $selgrosResponse = $this->selgrosProductService->getProduct($barcode);

        $biedronkaProduct = new Product($barcode, Store::BIEDRONKA->value, json_decode($biedronkaResponse, true));
        $this->productRepository->save($biedronkaProduct);

        $selgrosProduct = new Product($barcode, Store::SELGROS->value, json_decode($selgrosResponse, true));
        $this->productRepository->save($selgrosProduct);

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
