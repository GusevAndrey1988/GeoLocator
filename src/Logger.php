<?php

declare(strict_types = 1);

namespace Feature\GeoLocator;

interface Logger
{
    public function log(string $message): void;
}