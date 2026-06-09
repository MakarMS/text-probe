<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\CorsAllowCredentialsProbe;

/**
 * @internal
 */
class CorsAllowCredentialsProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new CorsAllowCredentialsProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::CORS_ALLOW_CREDENTIALS, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['Access-Control-Allow-Credentials: true', 38],
            ['Access-Control-Allow-Credentials: false', 39],
            ['Access-Control-Allow-Credentials: true', 38],
            ['Access-Control-Allow-Credentials: false', 39],
            ['Access-Control-Allow-Credentials: true', 38],
            ['Access-Control-Allow-Credentials: false', 39],
            ['Access-Control-Allow-Credentials: true', 38],
            ['Access-Control-Allow-Credentials: false', 39],
            ['Access-Control-Allow-Credentials: true', 38],
            ['Access-Control-Allow-Credentials: false', 39],
        ];
    }
}
