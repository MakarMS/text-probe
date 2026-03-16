<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\GithubPullRequestUrlProbe;

/**
 * @internal
 */
class GithubPullRequestUrlProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GithubPullRequestUrlProbe();

        $expected = 'https://github.com/acme/app/pull/45';
        $text = 'Value: https://github.com/acme/app/pull/45';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_PULL_REQUEST_URL, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GithubPullRequestUrlProbe();

        $expected = 'https://github.com/acme/app/pull/45';
        $text = 'First https://github.com/acme/app/pull/45 then https://github.com/acme/app/pull/45';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_PULL_REQUEST_URL, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(47, $results[1]->getStart());
        $this->assertSame(82, $results[1]->getEnd());
        $this->assertSame(ProbeType::GITHUB_PULL_REQUEST_URL, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new GithubPullRequestUrlProbe();

        $text = 'Value: https://github.com/acme/app/pulls';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new GithubPullRequestUrlProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new GithubPullRequestUrlProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
