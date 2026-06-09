<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\KubernetesNamespaceProbe;

/**
 * @internal
 */
class KubernetesNamespaceProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new KubernetesNamespaceProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_NAMESPACE, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['default', 7],
            ['kube-system', 11],
            ['team-a', 6],
            ['team-b', 6],
            ['org.dev', 7],
            ['org.prod', 8],
            ['alpha.beta', 10],
            ['ns1', 3],
            ['ns2', 3],
            ['namespace.dev', 13],
        ];
    }
}
