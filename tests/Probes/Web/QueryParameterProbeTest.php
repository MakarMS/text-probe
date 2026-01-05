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
    public function testFindsParameters(string $text, string $expected): void
    {
        $probe = new QueryParameterProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strpos($text, $expected), $results[0]->getStart());
        $this->assertSame(strpos($text, $expected) + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::QUERY_PARAMETER, $results[0]->getProbeType());
    }

    public static function parameterSamples(): array
    {
        return [
            ['foo=bar', 'foo=bar'],
            ['user_id=123', 'user_id=123'],
            ['?q=search', '?q=search'],
            ['?page=2&sort=desc', '?page=2&sort=desc'],
            ['token=abc123', 'token=abc123'],
            ['?filter=status&limit=10', '?filter=status&limit=10'],
            ['lang=en-US', 'lang=en-US'],
            ['?x=1&y=2&z=3', '?x=1&y=2&z=3'],
            ['empty=', 'empty='],
            ['?single=value', '?single=value'],
        ];
    }
}
