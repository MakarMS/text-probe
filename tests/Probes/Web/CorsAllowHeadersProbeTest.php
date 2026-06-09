<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\CorsAllowHeadersProbe;

/**
 * @internal
 */
class CorsAllowHeadersProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new CorsAllowHeadersProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::CORS_ALLOW_HEADERS, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['Access-Control-Allow-Headers: Content-Type', 42],
            ['Access-Control-Allow-Headers: Authorization', 43],
            ['Access-Control-Allow-Headers: Content-Type, Authorization', 57],
            ['Access-Control-Allow-Headers: X-Requested-With', 46],
            ['Access-Control-Allow-Headers: X-API-KEY, X-REQUEST-ID', 53],
            ['Access-Control-Allow-Headers: Accept, Content-Length', 52],
            ['Access-Control-Allow-Headers: X-Custom-Header', 45],
            ['Access-Control-Allow-Headers: If-None-Match, If-Modified-Since', 62],
            ['Access-Control-Allow-Headers: X-Trace-Id, X-Span-Id', 51],
            ['Access-Control-Allow-Headers: Cache-Control', 43],
        ];
    }
}
