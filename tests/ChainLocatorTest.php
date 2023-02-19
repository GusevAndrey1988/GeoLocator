<?php

declare(strict_types = 1);

namespace Future\GeoLocator\Test;

use Feature\GeoLocator\Location;
use Feature\GeoLocator\Locator;
use Feature\GeoLocator\Ip;
use Feature\GeoLocator\Locators\ChainLocator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ChainLocatorTest extends TestCase
{
    #[Test]
    public function success(): void
    {
        $locators = [
            $this->mockLocator(null),
            $this->mockLocator($expected = new Location('Expected')),
            $this->mockLocator(null),
            $this->mockLocator(new Location('Other')),
            $this->mockLocator(null),
        ];

        $locator = new ChainLocator(...$locators);
        $actual = $locator->locate(new Ip('8.8.8.8'));

        self::assertNotNull($actual);
        self::assertEquals($expected, $actual);
    }

    private function mockLocator(?Location $location): Locator
    {
        $mock = $this->createMock(Locator::class);
        $mock->method('locate')->willReturn($location);
        return $mock;
    }
}