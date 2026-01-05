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
    public function testFindsMatches(string $value): void
    {
        $probe = new GitRefHeadsProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::GIT_REF_HEADS, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['refs/heads/main'],
            ['refs/heads/develop'],
            ['refs/heads/feature/test'],
            ['refs/heads/bugfix/issue-1'],
            ['refs/heads/release/v1.0'],
            ['refs/heads/hotfix/urgent'],
            ['refs/heads/feature/api/v2'],
            ['refs/heads/experiment/alpha'],
            ['refs/heads/chore/cleanup'],
            ['refs/heads/feature/long_branch_name'],
        ];
    }
}
