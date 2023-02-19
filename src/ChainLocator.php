<?php

declare(strict_types = 1);

namespace Feature\GeoLocator;

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
        foreach ($this->locators as $locator) {
            $location = $locator->locate($ip);
            if (!is_null($location)) {
                return $location;
            }
        }

        return null;
    }
}