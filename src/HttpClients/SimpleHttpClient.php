<?php

declare(strict_types = 1);

namespace Feature\GeoLocator\HttpClients;

use Feature\GeoLocator\HttpClient;

class SimpleHttpClient implements HttpClient
{
    private ?\CurlHandle $curl = null;

    public function __construct()
    {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 6);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    }

    /**
     * @param array<string> $headers
     * @throws \RuntimeException
     */
    public function get(string $url, array $headers = []): string
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($this->curl);
        if ($response === false) {
            throw new \RuntimeException(curl_error($this->curl));
        }

        return $response;
    }

    public function __destruct()
    {
        if ($this->curl) {
            curl_close($this->curl);
        }
    }
}