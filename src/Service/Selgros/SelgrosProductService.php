<?php

namespace App\Service\Selgros;

use App\Core\Http\HttpClient;
use Exception;

class SelgrosProductService
{
    private HttpClient $httpClient;
    private string $apiBase = 'https://webapi.selgros24.pl/m/v3.6';
    private string $apiKey = 'A26KVt8Reu5UfmvRyGz';
    private string $authorization = 'Basic d2ViYXBpOmoxX1M0azNmREhZZw==';
    private string $appVersion = 'A_3.29.1';
    private string $deviceId = '9f2d48cb66f82135';
    private string $hallNumbe = '123';

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @throws Exception
     */
    public function getProduct(string $barcode): string
    {
        if ($_ENV['MOCK'])
        {
            $mock = '{"productId":90906,"name":"Coca Cola PET 500 ml","description":"Coca-Cola ka\u017cdego dnia dostarcza rado\u015b\u0107 i orze\u017awienie ludziom na ca\u0142ym \u015bwiecie. To najpopularniejszy i najch\u0119tniej kupowany nap\u00f3j gazowany w historii, jak r\u00f3wnie\u017c najlepiej znany produkt na \u015bwiecie. Tajemnica Coca-Coli tkwi w unikalnej recepturze, opieraj\u0105cej si\u0119 na sk\u0142adnikach pochodzenia naturalnego, kt\u00f3ra nie zmieni\u0142a si\u0119 od przesz\u0142o 125 lat.","packType":"szt.","bestPrice":{"available":true,"userPrice":false,"discount":27.5,"packCount":1,"singlePackType":"szt.","totalPackType":"opak.","netto":2.95,"brutto":3.63,"nettoTotal":2.95,"bruttoTotal":3.63,"title":"1 szt.","showTotal":false},"taxValue":23,"images":["https:\/\/webapi.selgros24.pl\/m\/prodImages\/90\/9090\/90906_0_1746736817381.jpg"],"attrGroups":[{"groupName":"Parametry produktu","attributes":[{"name":"Rodzaj","value":["Gazowany"]},{"name":"Pojemno\u015b\u0107","value":["500 ml"]},{"name":"Smak","value":["Cola"]},{"name":"Sk\u0142adniki","value":["Woda, cukier, dwutlenek w\u0119gla, barwnik e 150d, kwas: kwas fosforowy, naturalne aromaty w tym kofeina."]},{"name":"Kraj pochodzenia\/Wyprodukowano w","value":["Polska"]},{"name":"Temperatura przechowywania min - max","value":["0 - 20 \u00b0C"]},{"name":"Waga jednostkowa brutto","value":["0,54 kg"]},{"name":"Adres podmiotu wprowadzaj\u0105cego do obrotu","value":["Nazwa firmy: coca cola hbc polska sp. z o.o. ulica i numer: \u017cwirki i wigury 16 kod pocztowy i miasto: 02-092 warszawa pl"]},{"name":"Liczba opakowa\u0144 pierwszego rz\u0119du na palecie","value":["72 op. zb. (DU)"]}]},{"groupName":"Alergeny","attributes":[{"name":"Orzechy","value":["Nie"]},{"name":"Ryby i produkty pochodne","value":["Nie"]},{"name":"Seler i produkty pochodne","value":["Nie"]},{"name":"Skorupiaki i produkty pochodne","value":["Nie"]},{"name":"Soja i produkty pochodne","value":["Nie"]},{"name":"Zbo\u017ca zawierajace gluten","value":["Nie"]},{"name":"Dwutlenek siarki i siarczyny","value":["Nie"]},{"name":"Gorczyca i produkty pochodne","value":["Nie"]},{"name":"Jaja i produkty pochodne","value":["Nie"]},{"name":"\u0141ubin i produkty pochodne","value":["Nie"]},{"name":"Mi\u0119czaki i produkty pochodne","value":["Nie"]},{"name":"Mleko i produkty pochodne (\u0142\u0105cznie z laktoz\u0105)","value":["Nie"]},{"name":"Nasiona sezamu i produkty pochodne","value":["Nie"]}]},{"groupName":"Przechowywanie","attributes":[{"name":"Inne uwagi dotycz\u0105ce przechowywania","value":["Chroni\u0107 przed dzia\u0142aniem promieni s\u0142onecznych."]},{"name":"Spos\u00f3b przechowywania","value":["przechowywa\u0107 w suchym i ch\u0142odnym miejscu"]}]},{"groupName":"Warto\u015b\u0107 od\u017cywcza","attributes":[{"name":"Zawarto\u015b\u0107 bia\u0142ek w porcji (og\u00f3lnie)","value":["0 g"]},{"name":"Zawarto\u015b\u0107 soli w porcji (og\u00f3lnie)","value":["0 g"]},{"name":"Zawarto\u015b\u0107 w\u0119glowodan\u00f3w w porcji (cukry)","value":["27 g"]},{"name":"Zawarto\u015b\u0107 w\u0119glowodan\u00f3w w porcji","value":["27 g"]},{"name":"Jednostka b\u0119d\u0105ca podstaw\u0105 przelicze\u0144","value":["g\/100 ml"]},{"name":"Warto\u015b\u0107 energetyczna kcal","value":["42 kcal"]},{"name":"Warto\u015b\u0107 energetyczna kcal w porcji (energia)","value":["105 kcal"]},{"name":"Warto\u015b\u0107 energetyczna kJ","value":["180 kJ"]},{"name":"Warto\u015b\u0107 energetyczna kJ w porcji (energia)","value":["450 kJ"]},{"name":"Wielko\u015b\u0107 porcji","value":["250 ml"]},{"name":"Zawarto\u015b\u0107 bia\u0142ek","value":["0 g"]},{"name":"Zawarto\u015b\u0107 soli","value":["0 g"]},{"name":"Kwasy t\u0142uszczowe nasycone","value":["0 g"]},{"name":"Zawarto\u015b\u0107 t\u0142uszcz\u00f3w (og\u00f3lnie)","value":["0 %RWS"]},{"name":"Zawarto\u015b\u0107 t\u0142uszcz\u00f3w w porcji (kwasy t\u0142uszczowe nasycone)","value":["0 g"]},{"name":"Zawarto\u015b\u0107 t\u0142uszcz\u00f3w w porcji (og\u00f3lnie)","value":["0 g"]},{"name":"Cukry","value":["10,6 g"]},{"name":"Zawarto\u015b\u0107 w\u0119glowodan\u00f3w","value":["10,6 g"]},{"name":"Warto\u015b\u0107 energetyczna kcal (energia)","value":["5 %RWS"]},{"name":"Zawarto\u015b\u0107 bia\u0142ek (og\u00f3lnie)","value":["0 %RWS"]},{"name":"Zawarto\u015b\u0107 soli (og\u00f3lnie)","value":["0 %RWS"]},{"name":"Zawarto\u015b\u0107 t\u0142uszcz\u00f3w (kwasy t\u0142uszczowe nasycone)","value":["0 %RWS"]},{"name":"Zawarto\u015b\u0107 w\u0119glowodan\u00f3w (cukry)","value":["29 %RWS"]},{"name":"Zawarto\u015b\u0107 w\u0119glowodan\u00f3w (og\u00f3lnie)","value":["10 %RWS"]},{"name":"Ilo\u015b\u0107 porcji w opakowaniu","value":["2 szt."]}]},{"groupName":"Witaminy i sk\u0142adniki mineralne","attributes":[]},{"groupName":"Inne informacje o zawarto\u015bci","attributes":[{"name":"Zawiera barwniki","value":["Tak"]},{"name":"Dodatki zawarte w produkcie (E-symbole)","value":["E150d Karmel amoniakalno-siarczynowy"]},{"name":"Funkcje dodatk\u00f3w obecnych w produkcie (zadeklarowanych jako dodatki lub numery E)","value":["Barwnik"]}]},{"groupName":"Dodatkowe informacje","attributes":[]}],"unitPrice":{"available":true,"userPrice":false,"packCount":1,"singlePackType":"l","totalPackType":"opak.","netto":5.9,"brutto":7.26,"nettoTotal":5.9,"bruttoTotal":7.26,"showTotal":false}}';
            return $mock;
        }
        $url = "{$this->apiBase}/product/{$barcode}";
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            "X-REST-HALL: {$this->hallNumbe}",
            "X-REST-API-KEY: {$this->apiKey}",
            "Authorization: {$this->authorization}",
            "X-REST-APP-VERSION: {$this->appVersion}",
            "X-REST-DEVICE-ID: {$this->deviceId}",
        ];

        $request = $this->httpClient->getWithHeaders($url, $headers);

        $data = json_decode($request);
        return json_encode($data->data);
    }
}
