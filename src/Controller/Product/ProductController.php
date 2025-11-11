<?php

namespace App\Controller\Product;

use App\Constraints\HttpMethod;
use App\Constraints\HttpStatus;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Service\Product\ProductService;
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
                $user = $request->getAttribute('user');
                return new Response([$this->productService->process($barcode, $user['sub'])]);
            }

            throw new Exception('Method Not Allowed', HttpStatus::NOT_ALLOWED->value);

        } catch (Throwable $th) {
            return new Response([$th->getMessage()], $th->getCode());
        }
    }
}
