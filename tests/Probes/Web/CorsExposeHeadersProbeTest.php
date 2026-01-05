<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\CorsExposeHeadersProbe;

/**
 * @internal
 */
class CorsExposeHeadersProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value): void
    {
        $probe = new CorsExposeHeadersProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::CORS_EXPOSE_HEADERS, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['Access-Control-Expose-Headers: Content-Type'],
            ['Access-Control-Expose-Headers: X-Request-Id'],
            ['Access-Control-Expose-Headers: Content-Type, X-Request-Id'],
            ['Access-Control-Expose-Headers: Location'],
            ['Access-Control-Expose-Headers: Cache-Control, Expires'],
            ['Access-Control-Expose-Headers: X-RateLimit-Remaining'],
            ['Access-Control-Expose-Headers: X-Total-Count, X-Page'],
            ['Access-Control-Expose-Headers: ETag'],
            ['Access-Control-Expose-Headers: X-Trace-Id'],
            ['Access-Control-Expose-Headers: X-Span-Id'],
        ];
    }
}
