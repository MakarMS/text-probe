<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\ContentTypeHeaderProbe;

/**
 * @internal
 */
class ContentTypeHeaderProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new ContentTypeHeaderProbe();

        $expected = 'Content-Type: application/json';
        $text = 'Content-Type: application/json';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::CONTENT_TYPE_HEADER, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new ContentTypeHeaderProbe();

        $expected = 'Content-Type: text/html; charset=UTF-8';
        $text = 'Content-Type: text/html; charset=UTF-8';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::CONTENT_TYPE_HEADER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new ContentTypeHeaderProbe();

        $first = 'Content-Type: application/json';
        $second = 'Content-Type: text/html; charset=UTF-8';
        $text = 'Content-Type: application/json' . "\n" . 'Content-Type: text/html; charset=UTF-8';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::CONTENT_TYPE_HEADER, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(31, $results[1]->getStart());
        $this->assertSame(69, $results[1]->getEnd());
        $this->assertSame(ProbeType::CONTENT_TYPE_HEADER, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new ContentTypeHeaderProbe();

        $expected = 'Content-Type: application/json';
        $text = 'Content-Type: application/json';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::CONTENT_TYPE_HEADER, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new ContentTypeHeaderProbe();

        $expected = 'Content-Type: application/json';
        $text = 'Content-Type: application/json';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::CONTENT_TYPE_HEADER, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new ContentTypeHeaderProbe();

        $expected = 'Content-Type: application/json';
        $text = 'Content-Type: application/json';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::CONTENT_TYPE_HEADER, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new ContentTypeHeaderProbe();

        $text = 'Content-Type application/json';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new ContentTypeHeaderProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new ContentTypeHeaderProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new ContentTypeHeaderProbe();

        $expected = 'Content-Type: application/json';
        $text = 'Content-Type: application/json';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::CONTENT_TYPE_HEADER, $results[0]->getProbeType());
    }
}
