<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\WebsocketUrlProbe;

/**
 * @internal
 */
class WebsocketUrlProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('urlSamples')]
    public function testFindsWebsocketUrls(string $value, int $expectedEnd): void
    {
        $probe = new WebsocketUrlProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::WEBSOCKET_URL, $results[0]->getProbeType());
    }

    public static function urlSamples(): array
    {
        return [
            ['ws://example.com', 16],
            ['wss://example.com', 17],
            ['ws://localhost:8080', 19],
            ['wss://localhost:8443', 20],
            ['ws://127.0.0.1:9000/ws', 22],
            ['wss://127.0.0.1:9443/ws', 23],
            ['ws://example.com/path', 21],
            ['wss://example.com/path', 22],
            ['ws://example.com/chat', 21],
            ['wss://example.com/chat', 22],
        ];
    }
}
