<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\K8sDnsLabelProbe;

/**
 * @internal
 */
class K8sDnsLabelProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value): void
    {
        $probe = new K8sDnsLabelProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::K8S_DNS_LABEL, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['default'],
            ['kube-system'],
            ['my-app'],
            ['a'],
            ['abc123'],
            ['app1'],
            ['node-01'],
            ['service'],
            ['test-env'],
            ['dev1'],
        ];
    }
}
