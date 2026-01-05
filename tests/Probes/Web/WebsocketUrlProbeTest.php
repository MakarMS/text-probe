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
    public function testFindsWebsocketUrls(string $value): void
    {
        $probe = new WebsocketUrlProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::WEBSOCKET_URL, $results[0]->getProbeType());
    }

    public static function urlSamples(): array
    {
        return [
            ['ws://example.com'],
            ['wss://example.com'],
            ['ws://localhost:8080'],
            ['wss://localhost:8443'],
            ['ws://127.0.0.1:9000/ws'],
            ['wss://127.0.0.1:9443/ws'],
            ['ws://example.com/path'],
            ['wss://example.com/path'],
            ['ws://example.com/chat'],
            ['wss://example.com/chat'],
        ];
    }
}
