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
    public function testFindsHeaders(string $text): void
    {
        $probe = new CorsHeaderProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($text, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($text), $results[0]->getEnd());
        $this->assertSame(ProbeType::CORS_HEADER, $results[0]->getProbeType());
    }

    public static function headerSamples(): array
    {
        return [
            ['Access-Control-Allow-Origin: *'],
            ['Access-Control-Allow-Methods: GET, POST'],
            ['Access-Control-Allow-Headers: Content-Type'],
            ['Access-Control-Allow-Credentials: true'],
            ['Access-Control-Expose-Headers: X-Request-Id'],
            ['Access-Control-Max-Age: 600'],
            ['Access-Control-Allow-Origin: https://example.com'],
            ['Access-Control-Allow-Methods: PUT, PATCH'],
            ['Access-Control-Allow-Headers: Authorization'],
            ['Access-Control-Max-Age: 3600'],
        ];
    }
}
