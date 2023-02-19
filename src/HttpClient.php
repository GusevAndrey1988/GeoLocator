<?php

declare(strict_types = 1);

namespace Feature\GeoLocator;

interface HttpClient
{
    /**
     * @param array<string> $headers
     * @throws \RuntimeException
     */
    public function get(string $url, array $headers = []): string;
}