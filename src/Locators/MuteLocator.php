<?php

declare(strict_types = 1);

namespace Feature\GeoLocator\Locators;

use Feature\GeoLocator\ErrorHandler;
use Feature\GeoLocator\Ip;
use Feature\GeoLocator\Location;
use Feature\GeoLocator\Locator;

class MuteLocator implements Locator
{
    public function __construct(
        private Locator $next,
        private ErrorHandler $handler
    )
    {
    }

    public function locate(Ip $ip): ?Location
    {
        try {
            return $this->next->locate($ip);
        } catch (\RuntimeException $exception) {
            $this->handler->handle($exception);
            return null;
        }
    }
}