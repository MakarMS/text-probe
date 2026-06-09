<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\CacheControlHeaderProbe;

/**
 * @internal
 */
class CacheControlHeaderProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new CacheControlHeaderProbe();

        $expected = 'Cache-Control: no-cache';
        $text = 'Cache-Control: no-cache';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::CACHE_CONTROL_HEADER, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new CacheControlHeaderProbe();

        $expected = 'Cache-Control: public, max-age=3600';
        $text = 'Cache-Control: public, max-age=3600';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(35, $results[0]->getEnd());
        $this->assertSame(ProbeType::CACHE_CONTROL_HEADER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CacheControlHeaderProbe();

        $first = 'Cache-Control: no-cache';
        $second = 'Cache-Control: public, max-age=3600';
        $text = 'Cache-Control: no-cache' . "\n" . 'Cache-Control: public, max-age=3600';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::CACHE_CONTROL_HEADER, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(24, $results[1]->getStart());
        $this->assertSame(59, $results[1]->getEnd());
        $this->assertSame(ProbeType::CACHE_CONTROL_HEADER, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new CacheControlHeaderProbe();

        $expected = 'Cache-Control: no-cache';
        $text = 'Cache-Control: no-cache';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::CACHE_CONTROL_HEADER, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new CacheControlHeaderProbe();

        $expected = 'Cache-Control: no-cache';
        $text = 'Cache-Control: no-cache';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::CACHE_CONTROL_HEADER, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new CacheControlHeaderProbe();

        $expected = 'Cache-Control: no-cache';
        $text = 'Cache-Control: no-cache';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::CACHE_CONTROL_HEADER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new CacheControlHeaderProbe();

        $text = 'Cache-Control no-cache';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new CacheControlHeaderProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new CacheControlHeaderProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new CacheControlHeaderProbe();

        $expected = 'Cache-Control: no-cache';
        $text = 'Cache-Control: no-cache';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::CACHE_CONTROL_HEADER, $results[0]->getProbeType());
    }
}
