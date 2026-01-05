<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\WsUrlProbe;

/**
 * @internal
 */
class WsUrlProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validSamples')]
    public function testFindsMatches(string $value): void
    {
        $probe = new WsUrlProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::WS_URL, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['ws://example.com'],
            ['ws://example.com/socket'],
            ['ws://localhost:8080'],
            ['ws://127.0.0.1:9000/ws'],
            ['ws://sub.example.com/path'],
            ['ws://example.com/path?token=abc'],
            ['ws://example.com/path#frag'],
            ['ws://example.com/chat'],
            ['ws://example.com/stream'],
            ['ws://example.com/api/v1'],
        ];
    }
}
