<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\GitHubFineGrainedTokenProbe;

/**
 * @internal
 */
class GitHubFineGrainedTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GitHubFineGrainedTokenProbe();

        $expected = 'github_pat_abcdefghijklmnopqrstuvwxyz123456';
        $text = 'Value: github_pat_abcdefghijklmnopqrstuvwxyz123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(50, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_FINE_GRAINED_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new GitHubFineGrainedTokenProbe();

        $expected = 'github_pat_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $text = 'Value: github_pat_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_FINE_GRAINED_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GitHubFineGrainedTokenProbe();

        $expectedFirst = 'github_pat_abcdefghijklmnopqrstuvwxyz123456';
        $expectedSecond = 'github_pat_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $text = 'First github_pat_abcdefghijklmnopqrstuvwxyz123456 then github_pat_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(49, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_FINE_GRAINED_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(55, $results[1]->getStart());
        $this->assertSame(102, $results[1]->getEnd());
        $this->assertSame(ProbeType::GITHUB_FINE_GRAINED_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new GitHubFineGrainedTokenProbe();

        $expected = 'github_pat_abcdefghijklmnopqrstuvwxyz123456';
        $text = 'github_pat_abcdefghijklmnopqrstuvwxyz123456 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_FINE_GRAINED_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new GitHubFineGrainedTokenProbe();

        $expected = 'github_pat_abcdefghijklmnopqrstuvwxyz123456';
        $text = 'head github_pat_abcdefghijklmnopqrstuvwxyz123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(48, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_FINE_GRAINED_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new GitHubFineGrainedTokenProbe();

        $expected = 'github_pat_abcdefghijklmnopqrstuvwxyz123456';
        $text = 'Check github_pat_abcdefghijklmnopqrstuvwxyz123456, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(49, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_FINE_GRAINED_TOKEN, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new GitHubFineGrainedTokenProbe();

        $expectedFirst = 'github_pat_abcdefghijklmnopqrstuvwxyz123456';
        $expectedSecond = 'github_pat_abcdefghijklmnopqrstuvwxyz123456';
        $text = 'github_pat_abcdefghijklmnopqrstuvwxyz123456 and github_pat_abcdefghijklmnopqrstuvwxyz123456';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_FINE_GRAINED_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(48, $results[1]->getStart());
        $this->assertSame(91, $results[1]->getEnd());
        $this->assertSame(ProbeType::GITHUB_FINE_GRAINED_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new GitHubFineGrainedTokenProbe();

        $expected = 'github_pat_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $text = 'Prefix github_pat_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_FINE_GRAINED_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new GitHubFineGrainedTokenProbe();

        $expectedFirst = 'github_pat_abcdefghijklmnopqrstuvwxyz123456';
        $expectedSecond = 'github_pat_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $text = 'github_pat_abcdefghijklmnopqrstuvwxyz123456, github_pat_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_FINE_GRAINED_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(45, $results[1]->getStart());
        $this->assertSame(92, $results[1]->getEnd());
        $this->assertSame(ProbeType::GITHUB_FINE_GRAINED_TOKEN, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new GitHubFineGrainedTokenProbe();

        $expected = 'github_pat_abcdefghijklmnopqrstuvwxyz123456';
        $text = 'Value: github_pat_abcdefghijklmnopqrstuvwxyz123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(50, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_FINE_GRAINED_TOKEN, $results[0]->getProbeType());
    }
}
