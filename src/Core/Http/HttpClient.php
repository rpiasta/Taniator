<?php

namespace App\Core\Http;

use App\Constraints\HttpStatus;
use Exception;

class HttpClient
{
    public function get(string $url): string
    {
        return file_get_contents($url);
    }

    /**
     * @throws Exception
     */
    public function getWithHeaders(string $url, array $headers = []): string
    {
        $options = [
            'http' => [
                'header' => implode("\r\n", $headers),
                'method' => 'GET',
                'ignore_errors' => true,
            ]
        ];

        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);

        if ($result === false) {
            throw new Exception("HTTP GET failed to $url");
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    public function post(string $url, array $data, array $headers = [], bool $json = true): string
    {

        if ($json) {
            $body = json_encode($data, JSON_UNESCAPED_UNICODE);
            $headers[] = 'Content-Type: application/json';
        } else {
            $body = http_build_query($data);
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        }

        $options = [
            'http' => [
                'header' => implode("\r\n", $headers),
                'method' => 'POST',
                'content' => $body,
                'ignore_errors' => true,
            ]
        ];


        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);

        if ($result === false) {
            throw new Exception("HTTP request failed to $url", HttpStatus::INTERNAL_SERVER_ERROR->value);
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    public function put(string $url, array $data, array $headers = []): string
    {
        $body = json_encode($data, JSON_UNESCAPED_UNICODE);
        $headers[] = 'Content-Type: application/json';

        $options = [
            'http' => [
                'header' => implode("\r\n", $headers),
                'method' => 'PUT',
                'content' => $body,
                'ignore_errors' => true,
            ]
        ];

        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);

        if ($result === false) {
            throw new Exception("HTTP PUT failed to $url", HttpStatus::INTERNAL_SERVER_ERROR->value);
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    public function delete(string $url, array $headers = []): string
    {
        $options = [
            'http' => [
                'header' => implode("\r\n", $headers),
                'method' => 'DELETE',
                'ignore_errors' => true,
            ]
        ];

        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);

        if ($result === false) {
            throw new Exception("HTTP DELETE failed to $url", HttpStatus::INTERNAL_SERVER_ERROR->value);
        }

        return $result;
    }
}
