<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\TraceIdW3cProbe;

/**
 * @internal
 */
class TraceIdW3cProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new TraceIdW3cProbe();

        $expected = '4bf92f3577b34da6a3ce929d0e0e4736';
        $text = 'Value: 4bf92f3577b34da6a3ce929d0e0e4736';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::TRACE_ID_W3C, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new TraceIdW3cProbe();

        $expected = '4bf92f3577b34da6a3ce929d0e0e4736';
        $text = 'First 4bf92f3577b34da6a3ce929d0e0e4736 then 4bf92f3577b34da6a3ce929d0e0e4736';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::TRACE_ID_W3C, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(44, $results[1]->getStart());
        $this->assertSame(76, $results[1]->getEnd());
        $this->assertSame(ProbeType::TRACE_ID_W3C, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new TraceIdW3cProbe();

        $text = 'Value: 00000000000000000000000000000000';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new TraceIdW3cProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new TraceIdW3cProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
