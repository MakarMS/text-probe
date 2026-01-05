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
    public function testFindsMatches(string $value): void
    {
        $probe = new K8sDnsSubdomainProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::K8S_DNS_SUBDOMAIN, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['default'],
            ['kube-system'],
            ['my-app.default'],
            ['service.prod'],
            ['app1.stage'],
            ['node-01.cluster'],
            ['api.v1'],
            ['frontend.dev'],
            ['backend.prod'],
            ['alpha.beta.gamma'],
        ];
    }
}
