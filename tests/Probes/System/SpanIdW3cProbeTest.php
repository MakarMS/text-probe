<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\SpanIdW3cProbe;

/**
 * @internal
 */
class SpanIdW3cProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SpanIdW3cProbe();

        $expected = '00f067aa0ba902b7';
        $text = 'Value: 00f067aa0ba902b7';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::SPAN_ID_W3C, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SpanIdW3cProbe();

        $expected = '00f067aa0ba902b7';
        $text = 'First 00f067aa0ba902b7 then 00f067aa0ba902b7';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::SPAN_ID_W3C, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(28, $results[1]->getStart());
        $this->assertSame(44, $results[1]->getEnd());
        $this->assertSame(ProbeType::SPAN_ID_W3C, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new SpanIdW3cProbe();

        $text = 'Value: 0000000000000000';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new SpanIdW3cProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new SpanIdW3cProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
