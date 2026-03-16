<?php

namespace Tests\Probes\Web;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Web\HttpRequestLineProbe;

/**
 * @internal
 */
class HttpRequestLineProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new HttpRequestLineProbe();

        $expected = 'GET /health HTTP/1.1';
        $text = 'Value: GET /health HTTP/1.1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(27, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_REQUEST_LINE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new HttpRequestLineProbe();

        $expected = 'GET /health HTTP/1.1';
        $text = 'First GET /health HTTP/1.1 then GET /health HTTP/1.1';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(26, $results[0]->getEnd());
        $this->assertSame(ProbeType::HTTP_REQUEST_LINE, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(32, $results[1]->getStart());
        $this->assertSame(52, $results[1]->getEnd());
        $this->assertSame(ProbeType::HTTP_REQUEST_LINE, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new HttpRequestLineProbe();

        $text = 'Value: FETCH /health HTTP/1.1';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new HttpRequestLineProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new HttpRequestLineProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
