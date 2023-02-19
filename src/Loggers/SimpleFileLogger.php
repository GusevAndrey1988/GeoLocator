<?php

declare(strict_types = 1);

namespace Feature\GeoLocator\Loggers;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class SimpleFileLogger implements LoggerInterface
{
    use LoggerTrait;

    public function __construct(private string $fileName)
    {
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $prefix = (new \DateTime())->format(\DateTime::ATOM)."[error]: ";
        file_put_contents($this->fileName, $prefix.$message."\n", FILE_APPEND);
    }
}