<?php

declare(strict_types = 1);

namespace Feature\GeoLocator;

use Psr\Log\LoggerInterface;

class ErrorHandler
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function handle(\Exception $exception): void
    {
        $this->logger->error(sprintf('%s. File: %s, Line: %u',
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        ));
    }
}