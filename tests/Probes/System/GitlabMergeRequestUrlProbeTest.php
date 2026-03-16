<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\GitlabMergeRequestUrlProbe;

/**
 * @internal
 */
class GitlabMergeRequestUrlProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GitlabMergeRequestUrlProbe();

        $expected = 'https://gitlab.com/acme/app/-/merge_requests/12';
        $text = 'Value: https://gitlab.com/acme/app/-/merge_requests/12';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITLAB_MERGE_REQUEST_URL, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GitlabMergeRequestUrlProbe();

        $expected = 'https://gitlab.com/acme/app/-/merge_requests/12';
        $text = 'First https://gitlab.com/acme/app/-/merge_requests/12 then https://gitlab.com/acme/app/-/merge_requests/12';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(53, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITLAB_MERGE_REQUEST_URL, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(59, $results[1]->getStart());
        $this->assertSame(106, $results[1]->getEnd());
        $this->assertSame(ProbeType::GITLAB_MERGE_REQUEST_URL, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new GitlabMergeRequestUrlProbe();

        $text = 'Value: https://gitlab.com/acme/app';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new GitlabMergeRequestUrlProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new GitlabMergeRequestUrlProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
