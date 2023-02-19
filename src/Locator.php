<?php

declare(strict_types = 1);

namespace Feature\GeoLocator;

use Feature\GeoLocator\Ip;
use Feature\GeoLocator\Location;

interface Locator
{
    public function locate(Ip $ip): ?Location;
}