<?php

namespace Future\GeoLocator\Test;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Feature\GeoLocator\Locator;

class LocatorTest extends TestCase
{
  #[Test]
  public function success(): void
  {
    $locator = new Locator();
    $location = $locator->locate('8.8.8.8');

    self::assertNotNull($location);
    self::assertEquals('United States', $location->getCountry());
    self::assertEquals('California', $location->getRegion());
    self::assertEquals('Mountain View', $location->getCity());
  }

  #[Test]
  public function notFound(): void
  {
    $locator = new Locator();
    $location = $locator->locate('127.0.0.1');

    self::assertNull($location);
  }

  #[Test]
  public function invalid(): void
  {
    $locator = new Locator();

    self::expectException(\InvalidArgumentException::clas);
    $location = $locator->locate('invalid');
  }

  #[Test]
  public function empty(): void
  {
    $locator = new Locator();

    self::expectException(\InvalidArgumentException::clas);
    $location = $locator->locate('');
  }
}
