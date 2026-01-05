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
    public function testFindsMatches(string $value): void
    {
        $probe = new CorsAllowMethodsProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::CORS_ALLOW_METHODS, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['Access-Control-Allow-Methods: GET'],
            ['Access-Control-Allow-Methods: POST'],
            ['Access-Control-Allow-Methods: GET, POST'],
            ['Access-Control-Allow-Methods: PUT, PATCH'],
            ['Access-Control-Allow-Methods: DELETE, OPTIONS'],
            ['Access-Control-Allow-Methods: HEAD'],
            ['Access-Control-Allow-Methods: CONNECT, TRACE'],
            ['Access-Control-Allow-Methods: GET,POST,PUT'],
            ['Access-Control-Allow-Methods: OPTIONS, GET'],
            ['Access-Control-Allow-Methods: PATCH, DELETE, POST'],
        ];
    }
}
