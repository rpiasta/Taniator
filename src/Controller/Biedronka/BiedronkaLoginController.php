<?php

namespace App\Controller\Biedronka;

use App\Constraints\HttpStatus;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Service\Biedronka\BiedronkaLoginService;
use App\Service\Biedronka\BiedronkaTokenService;
use Exception;
use Throwable;

class BiedronkaLoginController
{
    private BiedronkaLoginService $biedronkaLoginService;

    public function __construct(BiedronkaLoginService $biedronkaLoginService)
    {
        $this->biedronkaLoginService = $biedronkaLoginService;
    }

    public function __invoke(Request $request): Response
    {
        try {
            if ($request->getMethod() === 'GET') {
                return new Response([$this->biedronkaLoginService->process()]);
            }

            throw new Exception('Method Not Allowed', HttpStatus::NOT_ALLOWED->value);

        } catch (Throwable $th) {
            return new Response([$th->getMessage()], $th->getCode());
        }
    }
}
