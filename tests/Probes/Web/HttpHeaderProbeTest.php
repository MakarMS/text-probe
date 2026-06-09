<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\HttpHeaderProbe;

/**
 * @internal
 */
class HttpHeaderProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new HttpHeaderProbe();

        $expected = 'X-Request-Id: abc123';
        $text = 'X-Request-Id: abc123';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_HEADER, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new HttpHeaderProbe();

        $expected = 'Accept-Encoding: gzip, br';
        $text = 'Accept-Encoding: gzip, br';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(25, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_HEADER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new HttpHeaderProbe();

        $first = 'X-Request-Id: abc123';
        $second = 'Accept-Encoding: gzip, br';
        $text = 'X-Request-Id: abc123' . "\n" . 'Accept-Encoding: gzip, br';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_HEADER, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(21, $results[1]->getStart());
        $this->assertSame(46, $results[1]->getEnd());
        $this->assertSame(ProbeType::HTTP_HEADER, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new HttpHeaderProbe();

        $expected = 'X-Request-Id: abc123';
        $text = 'X-Request-Id: abc123';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_HEADER, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new HttpHeaderProbe();

        $expected = 'X-Request-Id: abc123';
        $text = 'X-Request-Id: abc123';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_HEADER, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new HttpHeaderProbe();

        $expected = 'X-Request-Id: abc123';
        $text = 'X-Request-Id: abc123';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_HEADER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new HttpHeaderProbe();

        $text = 'Not a header line';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new HttpHeaderProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new HttpHeaderProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new HttpHeaderProbe();

        $expected = 'X-Request-Id: abc123';
        $text = 'X-Request-Id: abc123';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_HEADER, $results[0]->getProbeType());
    }
}
