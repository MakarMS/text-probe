<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\GithubActionsRunIdUrlProbe;

/**
 * @internal
 */
class GithubActionsRunIdUrlProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value): void
    {
        $probe = new GithubActionsRunIdUrlProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_ACTIONS_RUN_ID_URL, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['https://github.com/org/repo/actions/runs/123456789'],
            ['https://github.com/my-org/my-repo/actions/runs/1'],
            ['https://github.com/owner/repo/actions/runs/987654321'],
            ['https://github.com/example/test/actions/runs/555'],
            ['https://github.com/org123/repo456/actions/runs/42'],
            ['https://github.com/a/b/actions/runs/100'],
            ['https://github.com/foo/bar/actions/runs/7777'],
            ['https://github.com/foo-bar/baz/actions/runs/999'],
            ['https://github.com/foo_bar/baz-1/actions/runs/314159'],
            ['https://github.com/org.repo/name/actions/runs/271828'],
        ];
    }
}
