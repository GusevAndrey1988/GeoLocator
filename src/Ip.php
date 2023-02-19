<?php

declare(strict_types = 1);

namespace Feature\GeoLocator;

class Ip
{
    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(private string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Empty IP.');
        }

        if (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6) === false) {
            throw new \InvalidArgumentException('Invalid IP '.$value);
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}