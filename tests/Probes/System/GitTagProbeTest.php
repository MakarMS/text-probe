<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\GitTagProbe;

/**
 * @internal
 */
class GitTagProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new GitTagProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::GIT_TAG, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['v1.0.0', 6],
            ['1.2.3', 5],
            ['release-2024.01', 15],
            ['alpha', 5],
            ['beta-1', 6],
            ['rc.1', 4],
            ['v2.0.0-rc.1', 11],
            ['2024-01-01', 10],
            ['build.123', 9],
            ['feature-tag', 11],
        ];
    }
}
