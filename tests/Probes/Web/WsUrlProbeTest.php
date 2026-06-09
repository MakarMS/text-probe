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
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new WsUrlProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::WS_URL, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['ws://example.com', 16],
            ['ws://example.com/socket', 23],
            ['ws://localhost:8080', 19],
            ['ws://127.0.0.1:9000/ws', 22],
            ['ws://sub.example.com/path', 25],
            ['ws://example.com/path?token=abc', 31],
            ['ws://example.com/path#frag', 26],
            ['ws://example.com/chat', 21],
            ['ws://example.com/stream', 23],
            ['ws://example.com/api/v1', 23],
        ];
    }
}
