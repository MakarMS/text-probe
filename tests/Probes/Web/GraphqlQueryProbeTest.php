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
    public function testFindsQueryComponents(string $text, string $expected): void
    {
        $probe = new GraphqlQueryProbe();

        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(strpos($text, $expected), $results[0]->getStart());
        $this->assertSame(strpos($text, $expected) + strlen($expected), $results[0]->getEnd());
        $this->assertSame(ProbeType::GRAPHQL_QUERY, $results[0]->getProbeType());
    }

    public static function querySamples(): array
    {
        return [
            ['query', 'query'],
            ['mutation', 'mutation'],
            ['subscription', 'subscription'],
            ['{field}', '{field}'],
            ['{user { id name }}', '{user { id name }}'],
            ['{a { b { c } }}', '{a { b { c } }}'],
            ['{items { edges { node { id } } }}', '{items { edges { node { id } } }}'],
            ['query { viewer { id } }', 'query'],
            ['mutation { update { ok } }', 'mutation'],
            ['subscription { onMessage { id } }', 'subscription'],
        ];
    }
}
