<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\GitRefHeadsProbe;

/**
 * @internal
 */
class GitRefHeadsProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new GitRefHeadsProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::GIT_REF_HEADS, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['refs/heads/main', 15],
            ['refs/heads/develop', 18],
            ['refs/heads/feature/test', 23],
            ['refs/heads/bugfix/issue-1', 25],
            ['refs/heads/release/v1.0', 23],
            ['refs/heads/hotfix/urgent', 24],
            ['refs/heads/feature/api/v2', 25],
            ['refs/heads/experiment/alpha', 27],
            ['refs/heads/chore/cleanup', 24],
            ['refs/heads/feature/long_branch_name', 35],
        ];
    }
}
