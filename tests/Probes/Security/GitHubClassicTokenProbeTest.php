<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\GitHubClassicTokenProbe;

/**
 * @internal
 */
class GitHubClassicTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GitHubClassicTokenProbe();

        $expected = 'ghp_abcdefghijklmnopqrstuvwxyz123456';
        $text = 'Value: ghp_abcdefghijklmnopqrstuvwxyz123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_CLASSIC_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new GitHubClassicTokenProbe();

        $expected = 'ghp_1234567890ABCDEFGHIJKLMNOPQRSTUV';
        $text = 'Value: ghp_1234567890ABCDEFGHIJKLMNOPQRSTUV';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_CLASSIC_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GitHubClassicTokenProbe();

        $expectedFirst = 'ghp_abcdefghijklmnopqrstuvwxyz123456';
        $expectedSecond = 'ghp_1234567890ABCDEFGHIJKLMNOPQRSTUV';
        $text = 'First ghp_abcdefghijklmnopqrstuvwxyz123456 then ghp_1234567890ABCDEFGHIJKLMNOPQRSTUV';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_CLASSIC_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(48, $results[1]->getStart());
        $this->assertSame(84, $results[1]->getEnd());
        $this->assertSame(ProbeType::GITHUB_CLASSIC_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new GitHubClassicTokenProbe();

        $expected = 'ghp_abcdefghijklmnopqrstuvwxyz123456';
        $text = 'ghp_abcdefghijklmnopqrstuvwxyz123456 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_CLASSIC_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new GitHubClassicTokenProbe();

        $expected = 'ghp_abcdefghijklmnopqrstuvwxyz123456';
        $text = 'head ghp_abcdefghijklmnopqrstuvwxyz123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_CLASSIC_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new GitHubClassicTokenProbe();

        $expected = 'ghp_abcdefghijklmnopqrstuvwxyz123456';
        $text = 'Check ghp_abcdefghijklmnopqrstuvwxyz123456, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_CLASSIC_TOKEN, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new GitHubClassicTokenProbe();

        $expectedFirst = 'ghp_abcdefghijklmnopqrstuvwxyz123456';
        $expectedSecond = 'ghp_abcdefghijklmnopqrstuvwxyz123456';
        $text = 'ghp_abcdefghijklmnopqrstuvwxyz123456 and ghp_abcdefghijklmnopqrstuvwxyz123456';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_CLASSIC_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(41, $results[1]->getStart());
        $this->assertSame(77, $results[1]->getEnd());
        $this->assertSame(ProbeType::GITHUB_CLASSIC_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new GitHubClassicTokenProbe();

        $expected = 'ghp_1234567890ABCDEFGHIJKLMNOPQRSTUV';
        $text = 'Prefix ghp_1234567890ABCDEFGHIJKLMNOPQRSTUV suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_CLASSIC_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new GitHubClassicTokenProbe();

        $expectedFirst = 'ghp_abcdefghijklmnopqrstuvwxyz123456';
        $expectedSecond = 'ghp_1234567890ABCDEFGHIJKLMNOPQRSTUV';
        $text = 'ghp_abcdefghijklmnopqrstuvwxyz123456, ghp_1234567890ABCDEFGHIJKLMNOPQRSTUV';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_CLASSIC_TOKEN, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(38, $results[1]->getStart());
        $this->assertSame(74, $results[1]->getEnd());
        $this->assertSame(ProbeType::GITHUB_CLASSIC_TOKEN, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new GitHubClassicTokenProbe();

        $expected = 'ghp_abcdefghijklmnopqrstuvwxyz123456';
        $text = 'Value: ghp_abcdefghijklmnopqrstuvwxyz123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::GITHUB_CLASSIC_TOKEN, $results[0]->getProbeType());
    }
}
