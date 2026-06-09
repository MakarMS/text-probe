<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\CorsHeaderProbe;

/**
 * @internal
 */
class CorsHeaderProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('headerSamples')]
    public function testFindsHeaders(string $text, int $expectedEnd): void
    {
        $probe = new CorsHeaderProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($text, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::CORS_HEADER, $results[0]->getProbeType());
    }

    public static function headerSamples(): array
    {
        return [
            ['Access-Control-Allow-Origin: *', 30],
            ['Access-Control-Allow-Methods: GET, POST', 39],
            ['Access-Control-Allow-Headers: Content-Type', 42],
            ['Access-Control-Allow-Credentials: true', 38],
            ['Access-Control-Expose-Headers: X-Request-Id', 43],
            ['Access-Control-Max-Age: 600', 27],
            ['Access-Control-Allow-Origin: https://example.com', 48],
            ['Access-Control-Allow-Methods: PUT, PATCH', 40],
            ['Access-Control-Allow-Headers: Authorization', 43],
            ['Access-Control-Max-Age: 3600', 28],
        ];
    }
}
