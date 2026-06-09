<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\QueryParameterProbe;

/**
 * @internal
 */
class QueryParameterProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('parameterSamples')]
    public function testFindsParameters(string $text, string $expected, int $expectedStart, int $expectedEnd): void
    {
        $probe = new QueryParameterProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame($expectedStart, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::QUERY_PARAMETER, $results[0]->getProbeType());
    }

    public static function parameterSamples(): array
    {
        return [
            ['foo=bar', 'foo=bar', 0, 7],
            ['user_id=123', 'user_id=123', 0, 11],
            ['?q=search', '?q=search', 0, 9],
            ['?page=2&sort=desc', '?page=2&sort=desc', 0, 17],
            ['token=abc123', 'token=abc123', 0, 12],
            ['?filter=status&limit=10', '?filter=status&limit=10', 0, 23],
            ['lang=en-US', 'lang=en-US', 0, 10],
            ['?x=1&y=2&z=3', '?x=1&y=2&z=3', 0, 12],
            ['empty=', 'empty=', 0, 6],
            ['?single=value', '?single=value', 0, 13],
        ];
    }
}
