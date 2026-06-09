<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\DockerHubTokenProbe;

/**
 * @internal
 */
class DockerHubTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new DockerHubTokenProbe();

        $expected = 'dckr_pat_abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'dckr_pat_abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::DOCKER_HUB_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new DockerHubTokenProbe();

        $expected = 'dckr_pat_ABCDEFGHIJKLMNOPQRSTUVWXYZ-123456';
        $text = 'dckr_pat_ABCDEFGHIJKLMNOPQRSTUVWXYZ-123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::DOCKER_HUB_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new DockerHubTokenProbe();

        $first = 'dckr_pat_abcdefghijklmnopqrstuvwxyz_123456';
        $second = 'dckr_pat_ABCDEFGHIJKLMNOPQRSTUVWXYZ-123456';
        $text = 'dckr_pat_abcdefghijklmnopqrstuvwxyz_123456' . "\n" . 'dckr_pat_ABCDEFGHIJKLMNOPQRSTUVWXYZ-123456';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::DOCKER_HUB_TOKEN, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(43, $results[1]->getStart());
        $this->assertSame(85, $results[1]->getEnd());
        $this->assertSame(ProbeType::DOCKER_HUB_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new DockerHubTokenProbe();

        $expected = 'dckr_pat_abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'dckr_pat_abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::DOCKER_HUB_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new DockerHubTokenProbe();

        $expected = 'dckr_pat_abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'dckr_pat_abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::DOCKER_HUB_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new DockerHubTokenProbe();

        $expected = 'dckr_pat_abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'dckr_pat_abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::DOCKER_HUB_TOKEN, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new DockerHubTokenProbe();

        $text = 'dckr_pat_short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new DockerHubTokenProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new DockerHubTokenProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new DockerHubTokenProbe();

        $expected = 'dckr_pat_abcdefghijklmnopqrstuvwxyz_123456';
        $text = 'dckr_pat_abcdefghijklmnopqrstuvwxyz_123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(42, $results[0]->getEnd());
        $this->assertSame(ProbeType::DOCKER_HUB_TOKEN, $results[0]->getProbeType());
    }
}
