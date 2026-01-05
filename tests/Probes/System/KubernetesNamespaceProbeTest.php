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
    public function testFindsMatches(string $value): void
    {
        $probe = new KubernetesNamespaceProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_NAMESPACE, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['default'],
            ['kube-system'],
            ['team-a'],
            ['team-b'],
            ['org.dev'],
            ['org.prod'],
            ['alpha.beta'],
            ['ns1'],
            ['ns2'],
            ['namespace.dev'],
        ];
    }
}
