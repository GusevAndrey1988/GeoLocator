<?php

declare(strict_types = 1);

namespace Feature\GeoLocator;

class Location
{
    public function __construct(
        private string $country,
        private ?string $region = null,
        private ?string $city = null,
    ) {
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }
}
