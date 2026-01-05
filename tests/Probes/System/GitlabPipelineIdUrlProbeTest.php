<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\GitlabPipelineIdUrlProbe;

/**
 * @internal
 */
class GitlabPipelineIdUrlProbeTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('samples')]
    public function testFindsMatches(string $value): void
    {
        $probe = new GitlabPipelineIdUrlProbe();

        $results = $probe->probe($value);

        $this->assertCount(1, $results);
        $this->assertSame($value, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(strlen($value), $results[0]->getEnd());
        $this->assertSame(ProbeType::GITLAB_PIPELINE_ID_URL, $results[0]->getProbeType());
    }

    public static function samples(): array
    {
        return [
            ['https://gitlab.com/group/project/pipelines/123'],
            ['https://gitlab.com/group/subgroup/project/pipelines/456'],
            ['https://gitlab.com/org/repo/pipelines/789'],
            ['https://gitlab.com/org/repo/pipelines/1'],
            ['https://gitlab.com/a/b/pipelines/2'],
            ['https://gitlab.com/foo/bar/pipelines/3456'],
            ['https://gitlab.com/foo/bar/baz/pipelines/999'],
            ['https://gitlab.com/one/two/three/pipelines/42'],
            ['https://gitlab.com/x/y-z/pipelines/314'],
            ['https://gitlab.com/x/y_z/pipelines/271'],
        ];
    }
}
