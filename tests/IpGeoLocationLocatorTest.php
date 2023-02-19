<?php

declare(strict_types = 1);

namespace Future\GeoLocator\Test;

use Feature\GeoLocator\HttpClient;
use Feature\GeoLocator\Ip;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Feature\GeoLocator\IpGeoLocationLocator;

class IpGeoLocationLocatorTest extends TestCase
{
    #[Test]
    public function success(): void
    {
        $client = $this->createMock(HttpClient::class);
        $client->method('get')->willReturn(json_encode([
            'country_name' => 'United States',
            'state_prov' => 'California',
            'city' => 'Mountain View',
        ]));

        $locator = new IpGeoLocationLocator($client, 'api_key');
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

        $locator = new IpGeoLocationLocator($client, 'api_key');
        $location = $locator->locate(new Ip('127.0.0.1'));

        self::assertNull($location);
    }
}
