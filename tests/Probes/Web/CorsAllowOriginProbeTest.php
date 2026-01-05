<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\CorsAllowOriginProbe;

/**
 * @internal
 */
class CorsAllowOriginProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value): void
    {
        $probe = new CorsAllowOriginProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::CORS_ALLOW_ORIGIN, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['Access-Control-Allow-Origin: *'],
            ['Access-Control-Allow-Origin: https://example.com'],
            ['Access-Control-Allow-Origin: http://localhost:3000'],
            ['Access-Control-Allow-Origin: null'],
            ['Access-Control-Allow-Origin: https://api.example.com'],
            ['Access-Control-Allow-Origin: https://sub.example.com'],
            ['Access-Control-Allow-Origin: https://example.com:8443'],
            ['Access-Control-Allow-Origin: https://example.com/path'],
            ['Access-Control-Allow-Origin: https://example.com?x=1'],
            ['Access-Control-Allow-Origin: https://example.com#hash'],
        ];
    }
}
