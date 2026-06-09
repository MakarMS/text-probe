<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\CanonicalLinkProbe;

/**
 * @internal
 */
class CanonicalLinkProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new CanonicalLinkProbe();

        $expected = '<link rel="canonical" href="https://example.com/page">';
        $text = '<link rel="canonical" href="https://example.com/page">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::CANONICAL_LINK, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new CanonicalLinkProbe();

        $expected = '<link href="https://example.com/" rel="canonical">';
        $text = '<link href="https://example.com/" rel="canonical">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(50, $results[0]->getEnd());
        $this->assertSame(ProbeType::CANONICAL_LINK, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CanonicalLinkProbe();

        $first = '<link rel="canonical" href="https://example.com/page">';
        $second = '<link href="https://example.com/" rel="canonical">';
        $text = '<link rel="canonical" href="https://example.com/page">' . "\n" . '<link href="https://example.com/" rel="canonical">';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::CANONICAL_LINK, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(55, $results[1]->getStart());
        $this->assertSame(105, $results[1]->getEnd());
        $this->assertSame(ProbeType::CANONICAL_LINK, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new CanonicalLinkProbe();

        $expected = '<link rel="canonical" href="https://example.com/page">';
        $text = '<link rel="canonical" href="https://example.com/page">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::CANONICAL_LINK, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new CanonicalLinkProbe();

        $expected = '<link rel="canonical" href="https://example.com/page">';
        $text = '<link rel="canonical" href="https://example.com/page">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::CANONICAL_LINK, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new CanonicalLinkProbe();

        $expected = '<link rel="canonical" href="https://example.com/page">';
        $text = '<link rel="canonical" href="https://example.com/page">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::CANONICAL_LINK, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new CanonicalLinkProbe();

        $text = '<link rel="stylesheet" href="style.css">';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new CanonicalLinkProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new CanonicalLinkProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new CanonicalLinkProbe();

        $expected = '<link rel="canonical" href="https://example.com/page">';
        $text = '<link rel="canonical" href="https://example.com/page">';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(54, $results[0]->getEnd());
        $this->assertSame(ProbeType::CANONICAL_LINK, $results[0]->getProbeType());
    }
}
