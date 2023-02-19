<?php

declare(strict_types = 1);

namespace Future\GeoLocator\Test;

use Feature\GeoLocator\DaDataLocator;
use Feature\GeoLocator\HttpClient;
use Feature\GeoLocator\Ip;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DaDataLocatorTest extends TestCase
{
    private const API_KEY = 'api_key';

    #[Test]
    public function success(): void
    {
        $client = $this->createMock(HttpClient::class);
        $client->method('get')->willReturn(json_encode([
            'location' => [
                'data' => [
                    'country' => 'United States',
                    'region_with_type' => 'California',
                    'city_with_type' => 'Mountain View',
                ]
            ]
        ]));

        $locator = new DaDataLocator($client, self::API_KEY);
        $location = $locator->locate(new Ip('8.8.8.8'));

        self::assertNotNull($location);
        self::assertEquals('United States', $location->getCountry());
        self::assertEquals('California', $location->getRegion());
        self::assertEquals('Mountain View', $location->getCity());
    }

    #[Test]
    public function notFound(): void
    {
        $client = $this->createMock(HttpClient::class);
        $client->method('get')->willReturn('');

        $locator = new DaDataLocator($client, self::API_KEY);
        $location = $locator->locate(new Ip('127.0.0.1'));

        self::assertNull($location);
    }
}
