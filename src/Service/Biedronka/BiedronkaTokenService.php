<?php

namespace App\Service\Biedronka;

use App\Core\Http\HttpClient;
use Exception;

class BiedronkaTokenService
{
    private string $tokenUrl = 'https://konto.biedronka.pl/realms/loyalty/protocol/openid-connect/token';
    private string $clientId = 'cma20';
    private string $redirectUri = 'app://cma20.biedronka.pl';


    private HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    /**
     * @throws Exception
     */
    public function process(string $authorizationCode): array
    {
        $body = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'code' => $authorizationCode,
        ];

        $response = $this->httpClient->post(
            $this->tokenUrl,
            $body,
            ['Accept: application/json'],
            $json = false
        );

        $data = json_decode($response, true);

        if (!is_array($data) || !isset($data['access_token'])) {
            throw new Exception('Nie udało się pobrać tokenu z serwera Biedronki. Odpowiedź: ' . $response);
        }

        return $data;
    }
}
