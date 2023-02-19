<?php

declare(strict_types = 1);

namespace Feature\GeoLocator;

class IpGeoLocationLocator implements Locator
{
    public function __construct(
        private HttpClient $httpClient,
        private string $apiKey
    )
    {
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function locate(Ip $ip): ?Location
    {
        $url = 'https://api.ipgeolocation.io/ipgeo?'.http_build_query([
            'apiKey' => $this->apiKey,
            'ip' => $ip->getValue(),
        ]);

        $response = $this->httpClient->get($url);

        if (empty($response)) {
            return null;
        }

        $data = json_decode($response, true);
        $data = array_map(fn ($value) => $value !== '-' ? $value : null, $data);

        if (empty($data['country_name'])) {
            return null;
        }

        return new Location(
            $data['country_name'],
            $data['state_prov'],
            $data['city']
        );
    }
}