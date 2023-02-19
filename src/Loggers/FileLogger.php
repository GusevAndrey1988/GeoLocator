<?php

declare(strict_types = 1);

namespace Feature\GeoLocator\Loggers;

use Feature\GeoLocator\Logger;

class FileLogger implements Logger
{
    public function __construct(private string $fileName)
    {
    }

    public function log(string $message): void
    {
        $prefix = (new \DateTime())->format(\DateTime::ATOM)."[error]: ";
        file_put_contents($this->fileName, $prefix.$message."\n");
    }
}