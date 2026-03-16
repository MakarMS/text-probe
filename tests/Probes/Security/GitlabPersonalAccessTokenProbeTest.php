<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\GitlabPersonalAccessTokenProbe;

/**
 * @internal
 */
class GitlabPersonalAccessTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GitlabPersonalAccessTokenProbe();

        $expected = 'glpat-abcdefghijklmnopqrst';
        $text = 'Value: glpat-abcdefghijklmnopqrst';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(33, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITLAB_PERSONAL_ACCESS_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GitlabPersonalAccessTokenProbe();

        $expected = 'glpat-abcdefghijklmnopqrst';
        $text = 'First glpat-abcdefghijklmnopqrst then glpat-abcdefghijklmnopqrst';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITLAB_PERSONAL_ACCESS_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(38, $results[1]->getStart());
        $this->assertSame(64, $results[1]->getEnd());
        $this->assertSame(ProbeType::GITLAB_PERSONAL_ACCESS_TOKEN, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new GitlabPersonalAccessTokenProbe();

        $text = 'Value: glpat-short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new GitlabPersonalAccessTokenProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new GitlabPersonalAccessTokenProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
