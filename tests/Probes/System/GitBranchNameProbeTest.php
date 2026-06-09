<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\GitBranchNameProbe;

/**
 * @internal
 */
class GitBranchNameProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value, int $expectedEnd): void
    {
        $probe = new GitBranchNameProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame($expectedEnd, $results[0]->getEnd());
        $this->assertSame(ProbeType::GIT_BRANCH_NAME, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['main', 4],
            ['develop', 7],
            ['feature/test', 12],
            ['bugfix/issue-1', 14],
            ['release/v1.0', 12],
            ['hotfix/urgent', 13],
            ['feature/api/v2', 14],
            ['experiment/alpha', 16],
            ['chore/cleanup', 13],
            ['feature/long_branch_name', 24],
        ];
    }
}
