<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\AbsoluteHttpUrlProbe;

/**
 * @internal
 */
class AbsoluteHttpUrlProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validSamples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new AbsoluteHttpUrlProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::ABSOLUTE_HTTP_URL, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['http://example.com', 18],
            ['https://example.com', 19],
            ['https://example.com/path', 24],
            ['http://example.com:8080', 23],
            ['https://sub.example.co.uk/path?x=1', 34],
            ['http://localhost', 16],
            ['https://127.0.0.1:8443/api/v1', 29],
            ['http://example.com/path/to/resource', 35],
            ['https://example.com/path#section', 32],
            ['http://example.com/path?foo=bar&baz=qux', 39],
        ];
    }
}
