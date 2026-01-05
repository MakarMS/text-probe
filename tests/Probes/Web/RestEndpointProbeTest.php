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
    public function testFindsEndpoints(string $text, string $expected): void
    {
        $probe = new RestEndpointProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strpos($text, $expected), $results[0]->getStart());
        $this->assertSame(strpos($text, $expected) + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::REST_ENDPOINT, $results[0]->getProbeType());
    }

    public static function endpointSamples(): array
    {
        return [
            ['https://example.com/api', 'https://example.com/api'],
            ['http://example.com/v1/users', 'http://example.com/v1/users'],
            ['/health', '/health'],
            ['/api/v1/users', '/api/v1/users'],
            ['http://localhost:8080/status', 'http://localhost:8080/status'],
            ['/assets/app.js', '/assets/app.js'],
            ['https://api.example.com/users/123', 'https://api.example.com/users/123'],
            ['/v1/resource/123', '/v1/resource/123'],
            ['http://127.0.0.1:9000/metrics', 'http://127.0.0.1:9000/metrics'],
            ['/search?q=test', '/search?q=test'],
        ];
    }
}
