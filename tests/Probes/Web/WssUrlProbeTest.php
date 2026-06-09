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
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new WssUrlProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::WSS_URL, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['wss://example.com', 17],
            ['wss://example.com/socket', 24],
            ['wss://localhost:8443', 20],
            ['wss://127.0.0.1:9443/ws', 23],
            ['wss://sub.example.com/path', 26],
            ['wss://example.com/path?token=abc', 32],
            ['wss://example.com/path#frag', 27],
            ['wss://example.com/chat', 22],
            ['wss://example.com/stream', 24],
            ['wss://example.com/api/v1', 24],
        ];
    }
}
