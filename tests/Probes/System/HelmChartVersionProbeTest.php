<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\HelmChartVersionProbe;

/**
 * @internal
 */
class HelmChartVersionProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new HelmChartVersionProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::HELM_CHART_VERSION, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['1.0.0', 5],
            ['2.3.4', 5],
            ['0.1.0', 5],
            ['1.2.3-alpha', 11],
            ['1.2.3-alpha.1', 13],
            ['1.2.3+build.1', 13],
            ['1.2.3-alpha+build.1', 19],
            ['v2.0.0', 6],
            ['v1.0.0-beta', 11],
            ['3.4.5-rc.1', 10],
        ];
    }
}
