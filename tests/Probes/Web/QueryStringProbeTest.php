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
    public function testFindsMatches(string $value): void
    {
        $probe = new QueryStringProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::QUERY_STRING, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['?foo=bar'],
            ['?user_id=123'],
            ['?q=search&lang=en'],
            ['?page=2&sort=desc'],
            ['?token=abc123&empty='],
            ['?a=b&c=d&e=f'],
            ['?filter=status&limit=10'],
            ['?key=value123&ref=home'],
            ['?x=1&y=2&z=3'],
            ['?single=value'],
        ];
    }
}
