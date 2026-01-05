<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\WssUrlProbe;

/**
 * @internal
 */
class WssUrlProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validSamples')]
    public function testFindsMatches(string $value): void
    {
        $probe = new WssUrlProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::WSS_URL, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['wss://example.com'],
            ['wss://example.com/socket'],
            ['wss://localhost:8443'],
            ['wss://127.0.0.1:9443/ws'],
            ['wss://sub.example.com/path'],
            ['wss://example.com/path?token=abc'],
            ['wss://example.com/path#frag'],
            ['wss://example.com/chat'],
            ['wss://example.com/stream'],
            ['wss://example.com/api/v1'],
        ];
    }
}
