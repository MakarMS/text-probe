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
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new K8sDnsLabelProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::K8S_DNS_LABEL, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['default', 7],
            ['kube-system', 11],
            ['my-app', 6],
            ['a', 1],
            ['abc123', 6],
            ['app1', 4],
            ['node-01', 7],
            ['service', 7],
            ['test-env', 8],
            ['dev1', 4],
        ];
    }
}
