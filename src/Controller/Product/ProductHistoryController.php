<?php

namespace App\Controller\Product;

use App\Constraints\HttpStatus;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Service\Product\ProductHistoryService;

class ProductHistoryController
{
    private ProductHistoryService $service;

    public function __construct(ProductHistoryService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): Response
    {
        $query = $request->getQueryParams();
        $user = $request->getAttribute('user');
        $userId = $user['sub'] ?? null;
        $limit = (int)($query['limit'] ?? 10);

        if (!$userId) {
            return new Response(['error' => 'user_id is required'], HttpStatus::BAD_REQUEST->value);
        }

        $history = $this->service->process($userId, $limit);

        return new Response(['history' => $history]);
    }
}
