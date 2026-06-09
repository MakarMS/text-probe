<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\HttpMethodProbe;

/**
 * @internal
 */
class HttpMethodProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new HttpMethodProbe();

        $expected = 'GET';
        $text = 'GET';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(3, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_METHOD, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new HttpMethodProbe();

        $expected = 'PATCH';
        $text = 'PATCH';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(5, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_METHOD, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new HttpMethodProbe();

        $first = 'GET';
        $second = 'PATCH';
        $text = 'GET' . "\n" . 'PATCH';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(3, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_METHOD, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(4, $results[1]->getStart());
        $this->assertSame(9, $results[1]->getEnd());
        $this->assertSame(ProbeType::HTTP_METHOD, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new HttpMethodProbe();

        $expected = 'GET';
        $text = 'GET';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(3, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_METHOD, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new HttpMethodProbe();

        $expected = 'GET';
        $text = 'GET';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(3, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_METHOD, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new HttpMethodProbe();

        $expected = 'GET';
        $text = 'GET';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(3, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_METHOD, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new HttpMethodProbe();

        $text = 'FETCH';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new HttpMethodProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new HttpMethodProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new HttpMethodProbe();

        $expected = 'GET';
        $text = 'GET';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(3, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_METHOD, $results[0]->getProbeType());
    }
}
