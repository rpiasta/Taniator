<?php

namespace App\Controller\Biedronka;

use App\Constraints\HttpStatus;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Service\Biedronka\BiedronkaTokenService;
use Exception;
use Throwable;

class BiedronkaTokenController
{
    private BiedronkaTokenService $biedronkaTokenService;

    public function __construct(BiedronkaTokenService $biedronkaTokenService)
    {
        $this->biedronkaTokenService = $biedronkaTokenService;
    }

    public function __invoke(Request $request): Response
    {
        try {
            if ($request->getMethod() === 'GET') {
                $athorizationCode = $request->getQueryParams()['authorizationCode'];
                if (!$athorizationCode) {
                    throw new Exception("Authorization Code is required");
                }

                return new Response([$this->biedronkaTokenService->process($athorizationCode)]);
            }

            throw new Exception('Method Not Allowed', HttpStatus::NOT_ALLOWED->value);

        } catch (Throwable $th) {
            return new Response([$th->getMessage()], $th->getCode());
        }
    }
}
