<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\NpmTokenProbe;

/**
 * @internal
 */
class NpmTokenProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new NpmTokenProbe();

        $expected = 'npm_abcdefghijklmnopqrstuvwxyz';
        $text = 'npm_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::NPM_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new NpmTokenProbe();

        $expected = 'npm_ABCDEFGHIJKLMNOPQRSTUVWXYZ123456';
        $text = 'npm_ABCDEFGHIJKLMNOPQRSTUVWXYZ123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::NPM_TOKEN, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new NpmTokenProbe();

        $first = 'npm_abcdefghijklmnopqrstuvwxyz';
        $second = 'npm_ABCDEFGHIJKLMNOPQRSTUVWXYZ123456';
        $text = 'npm_abcdefghijklmnopqrstuvwxyz' . "\n" . 'npm_ABCDEFGHIJKLMNOPQRSTUVWXYZ123456';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::NPM_TOKEN, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(31, $results[1]->getStart());
        $this->assertSame(67, $results[1]->getEnd());
        $this->assertSame(ProbeType::NPM_TOKEN, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new NpmTokenProbe();

        $expected = 'npm_abcdefghijklmnopqrstuvwxyz';
        $text = 'npm_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::NPM_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new NpmTokenProbe();

        $expected = 'npm_abcdefghijklmnopqrstuvwxyz';
        $text = 'npm_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::NPM_TOKEN, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new NpmTokenProbe();

        $expected = 'npm_abcdefghijklmnopqrstuvwxyz';
        $text = 'npm_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::NPM_TOKEN, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new NpmTokenProbe();

        $text = 'npm_short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new NpmTokenProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new NpmTokenProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new NpmTokenProbe();

        $expected = 'npm_abcdefghijklmnopqrstuvwxyz';
        $text = 'npm_abcdefghijklmnopqrstuvwxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::NPM_TOKEN, $results[0]->getProbeType());
    }
}
