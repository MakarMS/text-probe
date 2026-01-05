<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\KubernetesResourceNameProbe;

/**
 * @internal
 */
class KubernetesResourceNameProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value): void
    {
        $probe = new KubernetesResourceNameProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_RESOURCE_NAME, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['pod'],
            ['deployment.apps'],
            ['service.default'],
            ['config-map'],
            ['secret.prod'],
            ['job.batch'],
            ['cronjob.batch'],
            ['statefulset.apps'],
            ['daemonset.apps'],
            ['ingress.networking'],
        ];
    }
}
