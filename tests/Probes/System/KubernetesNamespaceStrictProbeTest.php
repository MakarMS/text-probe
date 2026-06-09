<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\KubernetesNamespaceStrictProbe;

/**
 * @internal
 */
class KubernetesNamespaceStrictProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new KubernetesNamespaceStrictProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_NAMESPACE_STRICT, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['default', 7],
            ['kube-system', 11],
            ['dev', 3],
            ['prod', 4],
            ['staging', 7],
            ['team-a', 6],
            ['team-b', 6],
            ['alpha', 5],
            ['beta', 4],
            ['gamma', 5],
        ];
    }
}
