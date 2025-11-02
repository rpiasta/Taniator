<?php

namespace App\Service;

use App\Constraints\Store;
use App\Entity\Product;
use App\Service\Biedronka\BiedronkaProductService;
use App\Service\Selgros\SelgrosProductService;
use Exception;

class ProductService
{
    private BiedronkaProductService $biedronkaProductService;
    private SelgrosProductService $selgrosProductService;

    public function __construct(
        BiedronkaProductService $biedronkaProductService,
        SelgrosProductService   $selgrosProductService
    )
    {
        $this->biedronkaProductService = $biedronkaProductService;
        $this->selgrosProductService = $selgrosProductService;
    }

    /**
     * @throws Exception
     */
    public function process(string $barcode): string
    {
        $biedronkaResponse = $this->biedronkaProductService->getProduct($barcode);
        $selgrosResponse = $this->selgrosProductService->getProduct($barcode);

        $biedronkaProduct = new Product($barcode, Store::BIEDRONKA->value, json_decode($biedronkaResponse, true));
        $selgrosProduct = new Product($barcode, Store::SELGROS->value, json_decode($selgrosResponse, true));

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
