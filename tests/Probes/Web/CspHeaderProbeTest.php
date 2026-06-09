<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\CspHeaderProbe;

/**
 * @internal
 */
class CspHeaderProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new CspHeaderProbe();

        $expected = 'Content-Security-Policy: default-src \'self\'';
        $text = 'Content-Security-Policy: default-src \'self\'';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSP_HEADER, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new CspHeaderProbe();

        $expected = 'Content-Security-Policy: frame-ancestors none';
        $text = 'Content-Security-Policy: frame-ancestors none';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(45, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSP_HEADER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CspHeaderProbe();

        $first = 'Content-Security-Policy: default-src \'self\'';
        $second = 'Content-Security-Policy: frame-ancestors none';
        $text = 'Content-Security-Policy: default-src \'self\'' . "\n" . 'Content-Security-Policy: frame-ancestors none';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSP_HEADER, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(44, $results[1]->getStart());
        $this->assertSame(89, $results[1]->getEnd());
        $this->assertSame(ProbeType::CSP_HEADER, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new CspHeaderProbe();

        $expected = 'Content-Security-Policy: default-src \'self\'';
        $text = 'Content-Security-Policy: default-src \'self\'';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSP_HEADER, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new CspHeaderProbe();

        $expected = 'Content-Security-Policy: default-src \'self\'';
        $text = 'Content-Security-Policy: default-src \'self\'';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSP_HEADER, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new CspHeaderProbe();

        $expected = 'Content-Security-Policy: default-src \'self\'';
        $text = 'Content-Security-Policy: default-src \'self\'';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSP_HEADER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new CspHeaderProbe();

        $text = 'Security-Policy: default-src self';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new CspHeaderProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new CspHeaderProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new CspHeaderProbe();

        $expected = 'Content-Security-Policy: default-src \'self\'';
        $text = 'Content-Security-Policy: default-src \'self\'';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::CSP_HEADER, $results[0]->getProbeType());
    }
}
