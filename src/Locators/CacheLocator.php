<?php

declare(strict_types = 1);

namespace Feature\GeoLocator\Locators;

use Feature\GeoLocator\Ip;
use Feature\GeoLocator\Location;
use Feature\GeoLocator\Locator;
use Psr\SimpleCache\CacheInterface;

class CacheLocator implements Locator
{
    public function __construct(
        private Locator $next,
        private CacheInterface $cache,
        private int $ttl = PHP_INT_MAX
    )
    {
    }

    public function locate(Ip $ip): ?Location
    {
        $key = 'location-'.$ip->getValue();
        $location = $this->cache->get($key);
        if (is_null($location)) {
            $location = $this->next->locate($ip);
            if ($location) {
                $this->cache->set($key, $location, $this->ttl);
            }
        }

        return $location;
    }
}