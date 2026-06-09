<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\OpenTelemetryTracestateProbe;

/**
 * @internal
 */
class OpenTelemetryTracestateProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new OpenTelemetryTracestateProbe();

        $expected = 'rojo=00f067aa0ba902b7';
        $text = 'rojo=00f067aa0ba902b7';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACESTATE, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new OpenTelemetryTracestateProbe();

        $expected = 'vendor=value,congo=t61rcWkgMzE';
        $text = 'vendor=value,congo=t61rcWkgMzE';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(30, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACESTATE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new OpenTelemetryTracestateProbe();

        $first = 'rojo=00f067aa0ba902b7';
        $second = 'vendor=value,congo=t61rcWkgMzE';
        $text = 'rojo=00f067aa0ba902b7' . "\n" . 'vendor=value,congo=t61rcWkgMzE';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACESTATE, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(22, $results[1]->getStart());
        $this->assertSame(52, $results[1]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACESTATE, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new OpenTelemetryTracestateProbe();

        $expected = 'rojo=00f067aa0ba902b7';
        $text = 'rojo=00f067aa0ba902b7';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACESTATE, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new OpenTelemetryTracestateProbe();

        $expected = 'rojo=00f067aa0ba902b7';
        $text = 'rojo=00f067aa0ba902b7';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACESTATE, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new OpenTelemetryTracestateProbe();

        $expected = 'rojo=00f067aa0ba902b7';
        $text = 'rojo=00f067aa0ba902b7';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACESTATE, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new OpenTelemetryTracestateProbe();

        $text = '=missingkey';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new OpenTelemetryTracestateProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new OpenTelemetryTracestateProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new OpenTelemetryTracestateProbe();

        $expected = 'rojo=00f067aa0ba902b7';
        $text = 'rojo=00f067aa0ba902b7';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACESTATE, $results[0]->getProbeType());
    }
}
