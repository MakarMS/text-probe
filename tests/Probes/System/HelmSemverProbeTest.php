<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\HelmSemverProbe;

/**
 * @internal
 */
class HelmSemverProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value): void
    {
        $probe = new HelmSemverProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::HELM_SEMVER, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['1.0.0'],
            ['2.3.4'],
            ['0.1.0'],
            ['1.2.3-alpha'],
            ['1.2.3-alpha.1'],
            ['1.2.3+build.1'],
            ['1.2.3-alpha+build.1'],
            ['v2.0.0'],
            ['v1.0.0-beta'],
            ['3.4.5-rc.1'],
        ];
    }
}
