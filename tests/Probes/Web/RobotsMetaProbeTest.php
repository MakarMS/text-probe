<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\RobotsMetaProbe;

/**
 * @internal
 */
class RobotsMetaProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new RobotsMetaProbe();

        $expected = '<meta name="robots" content="noindex,nofollow">';
        $text = '<meta name="robots" content="noindex,nofollow">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(47, $results[0]->getEnd());
        $this->assertSame(ProbeType::ROBOTS_META, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new RobotsMetaProbe();

        $expected = '<meta content="index,follow" name="robots">';
        $text = '<meta content="index,follow" name="robots">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::ROBOTS_META, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new RobotsMetaProbe();

        $first = '<meta name="robots" content="noindex,nofollow">';
        $second = '<meta content="index,follow" name="robots">';
        $text = '<meta name="robots" content="noindex,nofollow">' . "\n" . '<meta content="index,follow" name="robots">';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(47, $results[0]->getEnd());
        $this->assertSame(ProbeType::ROBOTS_META, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(48, $results[1]->getStart());
        $this->assertSame(91, $results[1]->getEnd());
        $this->assertSame(ProbeType::ROBOTS_META, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new RobotsMetaProbe();

        $expected = '<meta name="robots" content="noindex,nofollow">';
        $text = '<meta name="robots" content="noindex,nofollow">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(47, $results[0]->getEnd());
        $this->assertSame(ProbeType::ROBOTS_META, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new RobotsMetaProbe();

        $expected = '<meta name="robots" content="noindex,nofollow">';
        $text = '<meta name="robots" content="noindex,nofollow">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(47, $results[0]->getEnd());
        $this->assertSame(ProbeType::ROBOTS_META, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new RobotsMetaProbe();

        $expected = '<meta name="robots" content="noindex,nofollow">';
        $text = '<meta name="robots" content="noindex,nofollow">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(47, $results[0]->getEnd());
        $this->assertSame(ProbeType::ROBOTS_META, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new RobotsMetaProbe();

        $text = '<meta name="description" content="noindex">';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new RobotsMetaProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new RobotsMetaProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new RobotsMetaProbe();

        $expected = '<meta name="robots" content="noindex,nofollow">';
        $text = '<meta name="robots" content="noindex,nofollow">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(47, $results[0]->getEnd());
        $this->assertSame(ProbeType::ROBOTS_META, $results[0]->getProbeType());
    }
}
