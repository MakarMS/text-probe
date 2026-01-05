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
    public function testFindsMatches(string $value): void
    {
        $probe = new QueryParamPairProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::QUERY_PARAM_PAIR, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['foo=bar'],
            ['user_id=123'],
            ['q=search'],
            ['token=abc123'],
            ['empty='],
            ['lang=en-US'],
            ['page=2'],
            ['sort=desc'],
            ['filter=status'],
            ['key=value123'],
        ];
    }
}
