<?php

namespace App\Service\Biedronka;

use App\Core\Http\HttpClient;
use Exception;

class BiedronkaRefreshTokenService
{
    private $url = 'https://konto.biedronka.pl/realms/loyalty/protocol/openid-connect/token';
    private HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @throws Exception
     */
    public function refreshAccessToken(): void
    {
        $body = [
            'grant_type' => 'refresh_token',
            'client_id' => 'cma20',
            'refresh_token' => $_ENV['BIEDRONKA_REFRESH_TOKEN'],
        ];

        $response = $this->httpClient->post(
            $this->url,
            $body,
            ['Accept: application/json'],
            false
        );

        $data = json_decode($response, true);

        if (!isset($data['access_token'])) {
            throw new Exception('Nie udało się odświeżyć tokena: ' . $response);
        }

        $_ENV['BIEDRONKA_ACCESS_TOKEN'] = $data['access_token'];

        if (isset($data['refresh_token'])) {
            $_ENV['BIEDRONKA_REFRESH_TOKEN'] = $data['refresh_token'];
        }
    }
}
