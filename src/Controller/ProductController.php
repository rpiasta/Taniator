<?php

namespace App\Controller;

use App\Constraints\HttpMethod;
use App\Constraints\HttpStatus;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Service\ProductService;
use Exception;
use Throwable;

class ProductController
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function __invoke(Request $request): Response
    {
        try {
            if ($request->getMethod() === HttpMethod::GET->value) {
                $barcode = $request->getQueryParams()['barcode'];
                if (!$barcode) {
                    throw new Exception("Barcode is required");
                }
                return new Response([$this->productService->process($barcode)]);
            }

            throw new Exception('Method Not Allowed', HttpStatus::NOT_ALLOWED->value);

        } catch (Throwable $th) {
            return new Response([$th->getMessage()], $th->getCode());
        }
    }
}
