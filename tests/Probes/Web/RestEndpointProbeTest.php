<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\RestEndpointProbe;

/**
 * @internal
 */
class RestEndpointProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('endpointSamples')]
    public function testFindsEndpoints(string $text, string $expected, int $expectedStart, int $expectedEnd): void
    {
        $probe = new RestEndpointProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame($expectedStart, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::REST_ENDPOINT, $results[0]->getProbeType());
    }

    public static function endpointSamples(): array
    {
        return [
            ['https://example.com/api', 'https://example.com/api', 0, 23],
            ['http://example.com/v1/users', 'http://example.com/v1/users', 0, 27],
            ['/health', '/health', 0, 7],
            ['/api/v1/users', '/api/v1/users', 0, 13],
            ['http://localhost:8080/status', 'http://localhost:8080/status', 0, 28],
            ['/assets/app.js', '/assets/app.js', 0, 14],
            ['https://api.example.com/users/123', 'https://api.example.com/users/123', 0, 33],
            ['/v1/resource/123', '/v1/resource/123', 0, 16],
            ['http://127.0.0.1:9000/metrics', 'http://127.0.0.1:9000/metrics', 0, 29],
            ['/search?q=test', '/search?q=test', 0, 14],
        ];
    }
}
