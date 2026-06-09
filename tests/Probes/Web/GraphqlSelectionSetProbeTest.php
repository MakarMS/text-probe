<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\GraphqlSelectionSetProbe;

/**
 * @internal
 */
class GraphqlSelectionSetProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('validSamples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new GraphqlSelectionSetProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::GRAPHQL_SELECTION_SET, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['{field}', 7],
            ['{field subfield}', 16],
            ['{user { id name }}', 18],
            ['{a { b { c } }}', 15],
            ['{items { edges { node { id } } }}', 33],
            ['{query { nodes { id } }}', 24],
            ['{root { left right }}', 21],
            ['{foo { bar baz }}', 17],
            ['{alpha { beta { gamma } }}', 26],
            ['{nested { level1 { level2 { level3 } } }}', 41],
        ];
    }
}
