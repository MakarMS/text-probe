<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\GithubIssueUrlProbe;

/**
 * @internal
 */
class GithubIssueUrlProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GithubIssueUrlProbe();

        $expected = 'https://github.com/acme/app/issues/12';
        $text = 'Value: https://github.com/acme/app/issues/12';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_ISSUE_URL, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GithubIssueUrlProbe();

        $expected = 'https://github.com/acme/app/issues/12';
        $text = 'First https://github.com/acme/app/issues/12 then https://github.com/acme/app/issues/12';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_ISSUE_URL, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(49, $results[1]->getStart());
        $this->assertSame(86, $results[1]->getEnd());
        $this->assertSame(ProbeType::GITHUB_ISSUE_URL, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new GithubIssueUrlProbe();

        $text = 'Value: https://github.com/acme/app';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new GithubIssueUrlProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new GithubIssueUrlProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
