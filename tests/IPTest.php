<?php

declare(strict_types = 1);

namespace Future\GeoLocator\Test;

use Feature\GeoLocator\Ip;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class IPTest extends TestCase
{
    #[Test]
    public function ip4(): void
    {
        $ip = new Ip($value = '8.8.8.8');
        self::assertEquals($value, $ip->getValue());
    }

    #[Test]
    public function ip6(): void
    {
        $ip = new Ip($value = '8:8:8:8:8:8:8:8');
        self::assertEquals($value, $ip->getValue());
    }

    #[Test]
    public function invalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Ip('incorrect');
    }

    #[Test]
    public function empty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Ip('');
    }
}