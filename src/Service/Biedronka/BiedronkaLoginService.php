<?php

namespace App\Service\Biedronka;

use App\Core\Http\HttpClient;

class BiedronkaLoginService
{
    private string $authUrl = 'https://konto.biedronka.pl/realms/loyalty/protocol/openid-connect/auth';
    private string $clientId = 'cma20';
    private string $redirectUri = 'app://cma20.biedronka.pl';
    private string $responseType = 'code';
    private string $approvalPrompt = 'auto';

    public function process(): string
    {
        $params = [
            'response_type' => $this->responseType,
            'approval_prompt' => $this->approvalPrompt,
            'redirect_uri' => $this->redirectUri,
            'client_id' => $this->clientId,
        ];

        return $this->authUrl . '?' . http_build_query($params);
    }
}
