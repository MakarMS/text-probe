<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\QueryParamPairProbe;

/**
 * @internal
 */
class QueryParamPairProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validSamples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new QueryParamPairProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::QUERY_PARAM_PAIR, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['foo=bar', 7],
            ['user_id=123', 11],
            ['q=search', 8],
            ['token=abc123', 12],
            ['empty=', 6],
            ['lang=en-US', 10],
            ['page=2', 6],
            ['sort=desc', 9],
            ['filter=status', 13],
            ['key=value123', 12],
        ];
    }
}
