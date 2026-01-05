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
    public function testFindsMatches(string $value): void
    {
        $probe = new GitBranchNameProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::GIT_BRANCH_NAME, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['main'],
            ['develop'],
            ['feature/test'],
            ['bugfix/issue-1'],
            ['release/v1.0'],
            ['hotfix/urgent'],
            ['feature/api/v2'],
            ['experiment/alpha'],
            ['chore/cleanup'],
            ['feature/long_branch_name'],
        ];
    }
}
