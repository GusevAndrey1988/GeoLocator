<?php

declare(strict_types = 1);

namespace Feature\GeoLocator\Locators;

use Feature\GeoLocator\Ip;
use Feature\GeoLocator\Location;
use Feature\GeoLocator\Locator;

class ChainLocator implements Locator
{
    /** @var array<Locator> $locators */
    private $locators = [];

    public function __construct(Locator ...$locators)
    {
        $this->locators = $locators;
    }

    public function locate(Ip $ip): ?Location
    {
        $result = null;
        foreach ($this->locators as $locator) {
            $location = $locator->locate($ip);
            if (is_null($location)) {
                continue;
            }
            if (!is_null($location->getCity())) {
                return $location;
            }
            if (
                !is_null($location->getRegion())
                && (is_null($result) || is_null($result->getRegion()))
            ) {
                $result = $location;
                continue;
            }
            if (is_null($result)) {
                $result = $location;
            }
        }

        return $result;
    }
}