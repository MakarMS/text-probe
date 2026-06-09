<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\GitRefTagsProbe;

/**
 * @internal
 */
class GitRefTagsProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new GitRefTagsProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::GIT_REF_TAGS, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['refs/tags/v1.0.0', 16],
            ['refs/tags/1.2.3', 15],
            ['refs/tags/release-2024.01', 25],
            ['refs/tags/alpha', 15],
            ['refs/tags/beta-1', 16],
            ['refs/tags/rc.1', 14],
            ['refs/tags/v2.0.0-rc.1', 21],
            ['refs/tags/2024-01-01', 20],
            ['refs/tags/build.123', 19],
            ['refs/tags/feature-tag', 21],
        ];
    }
}
