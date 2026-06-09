<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\EtagHeaderProbe;

/**
 * @internal
 */
class EtagHeaderProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new EtagHeaderProbe();

        $expected = 'ETag: "abc123"';
        $text = 'ETag: "abc123"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::ETAG_HEADER, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new EtagHeaderProbe();

        $expected = 'ETag: W/"weak-value"';
        $text = 'ETag: W/"weak-value"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::ETAG_HEADER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new EtagHeaderProbe();

        $first = 'ETag: "abc123"';
        $second = 'ETag: W/"weak-value"';
        $text = 'ETag: "abc123"' . "\n" . 'ETag: W/"weak-value"';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::ETAG_HEADER, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(35, $results[1]->getEnd());
        $this->assertSame(ProbeType::ETAG_HEADER, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new EtagHeaderProbe();

        $expected = 'ETag: "abc123"';
        $text = 'ETag: "abc123"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::ETAG_HEADER, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new EtagHeaderProbe();

        $expected = 'ETag: "abc123"';
        $text = 'ETag: "abc123"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::ETAG_HEADER, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new EtagHeaderProbe();

        $expected = 'ETag: "abc123"';
        $text = 'ETag: "abc123"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::ETAG_HEADER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new EtagHeaderProbe();

        $text = 'ETag: abc123';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new EtagHeaderProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new EtagHeaderProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new EtagHeaderProbe();

        $expected = 'ETag: "abc123"';
        $text = 'ETag: "abc123"';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::ETAG_HEADER, $results[0]->getProbeType());
    }
}
