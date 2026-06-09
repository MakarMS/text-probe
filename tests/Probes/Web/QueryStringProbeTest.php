<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\QueryStringProbe;

/**
 * @internal
 */
class QueryStringProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validSamples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new QueryStringProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::QUERY_STRING, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['?foo=bar', 8],
            ['?user_id=123', 12],
            ['?q=search&lang=en', 17],
            ['?page=2&sort=desc', 17],
            ['?token=abc123&empty=', 20],
            ['?a=b&c=d&e=f', 12],
            ['?filter=status&limit=10', 23],
            ['?key=value123&ref=home', 22],
            ['?x=1&y=2&z=3', 12],
            ['?single=value', 13],
        ];
    }
}
