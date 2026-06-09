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
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new KubernetesResourceNameProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::KUBERNETES_RESOURCE_NAME, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['pod', 3],
            ['deployment.apps', 15],
            ['service.default', 15],
            ['config-map', 10],
            ['secret.prod', 11],
            ['job.batch', 9],
            ['cronjob.batch', 13],
            ['statefulset.apps', 16],
            ['daemonset.apps', 14],
            ['ingress.networking', 18],
        ];
    }
}
