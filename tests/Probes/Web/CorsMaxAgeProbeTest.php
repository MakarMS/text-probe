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
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new CorsMaxAgeProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::CORS_MAX_AGE, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['Access-Control-Max-Age: 0', 25],
            ['Access-Control-Max-Age: 60', 26],
            ['Access-Control-Max-Age: 600', 27],
            ['Access-Control-Max-Age: 3600', 28],
            ['Access-Control-Max-Age: 86400', 29],
            ['Access-Control-Max-Age: 120', 27],
            ['Access-Control-Max-Age: 300', 27],
            ['Access-Control-Max-Age: 7200', 28],
            ['Access-Control-Max-Age: 1800', 28],
            ['Access-Control-Max-Age: 10000', 29],
        ];
    }
}
