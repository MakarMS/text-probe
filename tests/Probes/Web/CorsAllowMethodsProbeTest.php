<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\CorsAllowMethodsProbe;

/**
 * @internal
 */
class CorsAllowMethodsProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new CorsAllowMethodsProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::CORS_ALLOW_METHODS, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['Access-Control-Allow-Methods: GET', 33],
            ['Access-Control-Allow-Methods: POST', 34],
            ['Access-Control-Allow-Methods: GET, POST', 39],
            ['Access-Control-Allow-Methods: PUT, PATCH', 40],
            ['Access-Control-Allow-Methods: DELETE, OPTIONS', 45],
            ['Access-Control-Allow-Methods: HEAD', 34],
            ['Access-Control-Allow-Methods: CONNECT, TRACE', 44],
            ['Access-Control-Allow-Methods: GET,POST,PUT', 42],
            ['Access-Control-Allow-Methods: OPTIONS, GET', 42],
            ['Access-Control-Allow-Methods: PATCH, DELETE, POST', 49],
        ];
    }
}
