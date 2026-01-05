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
    public function testFindsMatches(string $value): void
    {
        $probe = new KubernetesNamespaceStrictProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_NAMESPACE_STRICT, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['default'],
            ['kube-system'],
            ['dev'],
            ['prod'],
            ['staging'],
            ['team-a'],
            ['team-b'],
            ['alpha'],
            ['beta'],
            ['gamma'],
        ];
    }
}
