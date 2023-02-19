<?php

declare(strict_types = 1);

namespace Feature\GeoLocator;

class ErrorHandler
{
    public function __construct(private Logger $logger)
    {
    }

    public function handle(\Exception $exception): void
    {
        $this->logger->log(sprintf('%s. File: %s, Line: %u',
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        ));
    }
}