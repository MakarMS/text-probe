<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\GraphqlQueryProbe;

/**
 * @internal
 */
class GraphqlQueryProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('querySamples')]
    public function testFindsQueryComponents(string $text, string $expected, int $expectedStart, int $expectedEnd): void
    {
        $probe = new GraphqlQueryProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame($expectedStart, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::GRAPHQL_QUERY, $results[0]->getProbeType());
    }

    public static function querySamples(): array
    {
        return [
            ['query', 'query', 0, 5],
            ['mutation', 'mutation', 0, 8],
            ['subscription', 'subscription', 0, 12],
            ['{field}', '{field}', 0, 7],
            ['{user { id name }}', '{user { id name }}', 0, 18],
            ['{a { b { c } }}', '{a { b { c } }}', 0, 15],
            ['{items { edges { node { id } } }}', '{items { edges { node { id } } }}', 0, 33],
            ['query { viewer { id } }', 'query', 0, 5],
            ['mutation { update { ok } }', 'mutation', 0, 8],
            ['subscription { onMessage { id } }', 'subscription', 0, 12],
        ];
    }
}
