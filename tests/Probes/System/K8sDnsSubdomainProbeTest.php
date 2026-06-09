<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\K8sDnsSubdomainProbe;

/**
 * @internal
 */
class K8sDnsSubdomainProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new K8sDnsSubdomainProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::K8S_DNS_SUBDOMAIN, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['default', 7],
            ['kube-system', 11],
            ['my-app.default', 14],
            ['service.prod', 12],
            ['app1.stage', 10],
            ['node-01.cluster', 15],
            ['api.v1', 6],
            ['frontend.dev', 12],
            ['backend.prod', 12],
            ['alpha.beta.gamma', 16],
        ];
    }
}
