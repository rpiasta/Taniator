<?php

namespace App\Service\Biedronka;

use App\Core\Http\HttpClient;
use Exception;

class BiedronkaProductService
{
    private HttpClient $httpClient;

    private BiedronkaRefreshTokenService $refreshService;
    private string $storeId = '7743';
    private string $apiBase = 'https://api.prod.biedronka.cloud/api/v6';

    public function __construct(HttpClient $httpClient, BiedronkaRefreshTokenService $refreshService)
    {
        $this->httpClient = $httpClient;
        $this->refreshService = $refreshService;
    }

    /**
     * @throws Exception
     */
    public function getProduct(string $barcode): string
    {
        if ($_ENV['MOCK']) {
            $mock = '{"theme_name":"AlwaysLowPrices","name":"NAPÓJ GAZOWANY COCA-COLA 0,5l","unit":"but","unit_price":["9,98 zł/l"],"price":"4.99","promotion_valid_period":null,"details":"","limit_message":null,"only_with_biedronka_card":false,"regular_price":"4.99","is_promotion":false,"is_minimal_basket_value_bonus_buy":false,"discount":null,"price_tag_info":null,"price_tag_note":null,"omnibus_price":"0.00","discount_to_omnibus_price":null,"omnibus_type":null,"description":"","type_of_wine":null,"sweetness_of_wine":null,"country_of_origin":null,"product_additional_country_of_origin_info":false,"fruits_or_vegetables_class":null,"image_url":"https://assets.prod.biedronka.cloud/products/resized/472_189.webp","thumb_url":"https://assets.prod.biedronka.cloud/products/resized/472_189.webp","multipack":null,"is_multipack":false,"omnibus_price_line":null,"regular_price_line":"Cena za but: 4.99 zł (9,98 zł/l)","non_promotional":false,"badges":[]}';

            return $mock;
        }
        $url = "{$this->apiBase}/products/price/{$this->storeId}/{$barcode}/";
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            "Authorization: Bearer {$_ENV['BIEDRONKA_ACCESS_TOKEN']}"
        ];

        $response = $this->httpClient->getWithHeaders($url, $headers);
//        $this->refreshService->refreshAccessToken();
        return $response;
    }
}
