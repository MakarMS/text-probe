<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\JaegerTraceIdProbe;

/**
 * @internal
 */
class JaegerTraceIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new JaegerTraceIdProbe();

        $expected = '4bf92f3577b34da6';
        $text = '4bf92f3577b34da6';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::JAEGER_TRACE_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new JaegerTraceIdProbe();

        $expected = '4bf92f3577b34da6a3ce929d0e0e4736';
        $text = '4bf92f3577b34da6a3ce929d0e0e4736';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(32, $results[0]->getEnd());
        $this->assertSame(ProbeType::JAEGER_TRACE_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new JaegerTraceIdProbe();

        $first = '4bf92f3577b34da6';
        $second = '4bf92f3577b34da6a3ce929d0e0e4736';
        $text = '4bf92f3577b34da6' . "\n" . '4bf92f3577b34da6a3ce929d0e0e4736';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::JAEGER_TRACE_ID, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(17, $results[1]->getStart());
        $this->assertSame(49, $results[1]->getEnd());
        $this->assertSame(ProbeType::JAEGER_TRACE_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new JaegerTraceIdProbe();

        $expected = '4bf92f3577b34da6';
        $text = '4bf92f3577b34da6';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::JAEGER_TRACE_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new JaegerTraceIdProbe();

        $expected = '4bf92f3577b34da6';
        $text = '4bf92f3577b34da6';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::JAEGER_TRACE_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new JaegerTraceIdProbe();

        $expected = '4bf92f3577b34da6';
        $text = '4bf92f3577b34da6';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::JAEGER_TRACE_ID, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new JaegerTraceIdProbe();

        $text = 'trace-id';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new JaegerTraceIdProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new JaegerTraceIdProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new JaegerTraceIdProbe();

        $expected = '4bf92f3577b34da6';
        $text = '4bf92f3577b34da6';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::JAEGER_TRACE_ID, $results[0]->getProbeType());
    }
}
