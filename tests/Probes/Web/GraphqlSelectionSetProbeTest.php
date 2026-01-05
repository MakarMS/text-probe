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
    public function testFindsMatches(string $value): void
    {
        $probe = new GraphqlSelectionSetProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::GRAPHQL_SELECTION_SET, $results[0]->getProbeType());
    }

    public static function validSamples(): array
    {
        return [
            ['{field}'],
            ['{field subfield}'],
            ['{user { id name }}'],
            ['{a { b { c } }}'],
            ['{items { edges { node { id } } }}'],
            ['{query { nodes { id } }}'],
            ['{root { left right }}'],
            ['{foo { bar baz }}'],
            ['{alpha { beta { gamma } }}'],
            ['{nested { level1 { level2 { level3 } } }}'],
        ];
    }
}
