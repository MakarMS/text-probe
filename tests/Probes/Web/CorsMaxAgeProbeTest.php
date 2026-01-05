<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\CorsMaxAgeProbe;

/**
 * @internal
 */
class CorsMaxAgeProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value): void
    {
        $probe = new CorsMaxAgeProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::CORS_MAX_AGE, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['Access-Control-Max-Age: 0'],
            ['Access-Control-Max-Age: 60'],
            ['Access-Control-Max-Age: 600'],
            ['Access-Control-Max-Age: 3600'],
            ['Access-Control-Max-Age: 86400'],
            ['Access-Control-Max-Age: 120'],
            ['Access-Control-Max-Age: 300'],
            ['Access-Control-Max-Age: 7200'],
            ['Access-Control-Max-Age: 1800'],
            ['Access-Control-Max-Age: 10000'],
        ];
    }
}
