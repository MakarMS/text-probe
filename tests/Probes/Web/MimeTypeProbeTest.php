<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\MimeTypeProbe;

/**
 * @internal
 */
class MimeTypeProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new MimeTypeProbe();

        $expected = 'application/json';
        $text = 'application/json';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::MIME_TYPE, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new MimeTypeProbe();

        $expected = 'text/html; charset=UTF-8';
        $text = 'text/html; charset=UTF-8';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(24, $results[0]->getEnd());
        $this->assertSame(ProbeType::MIME_TYPE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new MimeTypeProbe();

        $first = 'application/json';
        $second = 'text/html; charset=UTF-8';
        $text = 'application/json' . "\n" . 'text/html; charset=UTF-8';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::MIME_TYPE, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(17, $results[1]->getStart());
        $this->assertSame(41, $results[1]->getEnd());
        $this->assertSame(ProbeType::MIME_TYPE, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new MimeTypeProbe();

        $expected = 'application/json';
        $text = 'application/json';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::MIME_TYPE, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new MimeTypeProbe();

        $expected = 'application/json';
        $text = 'application/json';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::MIME_TYPE, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new MimeTypeProbe();

        $expected = 'application/json';
        $text = 'application/json';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::MIME_TYPE, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new MimeTypeProbe();

        $text = 'application';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new MimeTypeProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new MimeTypeProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new MimeTypeProbe();

        $expected = 'application/json';
        $text = 'application/json';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::MIME_TYPE, $results[0]->getProbeType());
    }
}
