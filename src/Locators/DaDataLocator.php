<?php

declare(strict_types = 1);

namespace Feature\GeoLocator\Locators;

use Feature\GeoLocator\HttpClient;
use Feature\GeoLocator\Ip;
use Feature\GeoLocator\Location;
use Feature\GeoLocator\Locator;

class DaDataLocator implements Locator
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
        $url = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address?'.http_build_query([
            'ip' => $ip->getValue(),
        ]);

        $response = $this->httpClient->get($url, [
            'Accept: application/json',
            'Authorization: Token '.$this->apiKey,
        ]);

        if (empty($response)) {
            return null;
        }

        $data = json_decode($response, true);
        if (empty($data['location']) || empty($data['location']['data'])) {
            return null;
        }

        if (empty($data['location']['data']['country'])) {
            return null;
        }

        return new Location(
            $data['location']['data']['country'],
            $data['location']['data']['region_with_type'],
            $data['location']['data']['city_with_type']
        );
    }
}