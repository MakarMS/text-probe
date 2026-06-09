<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\OpenTelemetryTraceparentProbe;

/**
 * @internal
 */
class OpenTelemetryTraceparentProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new OpenTelemetryTraceparentProbe();

        $expected = '00-4bf92f3577b34da6a3ce929d0e0e4736-00f067aa0ba902b7-01';
        $text = '00-4bf92f3577b34da6a3ce929d0e0e4736-00f067aa0ba902b7-01';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(55, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACEPARENT, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new OpenTelemetryTraceparentProbe();

        $expected = '00-aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa-bbbbbbbbbbbbbbbb-00';
        $text = '00-aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa-bbbbbbbbbbbbbbbb-00';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(55, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACEPARENT, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new OpenTelemetryTraceparentProbe();

        $first = '00-4bf92f3577b34da6a3ce929d0e0e4736-00f067aa0ba902b7-01';
        $second = '00-aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa-bbbbbbbbbbbbbbbb-00';
        $text = '00-4bf92f3577b34da6a3ce929d0e0e4736-00f067aa0ba902b7-01' . "\n" . '00-aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa-bbbbbbbbbbbbbbbb-00';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(55, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACEPARENT, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(56, $results[1]->getStart());
        $this->assertSame(111, $results[1]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACEPARENT, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new OpenTelemetryTraceparentProbe();

        $expected = '00-4bf92f3577b34da6a3ce929d0e0e4736-00f067aa0ba902b7-01';
        $text = '00-4bf92f3577b34da6a3ce929d0e0e4736-00f067aa0ba902b7-01';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(55, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACEPARENT, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new OpenTelemetryTraceparentProbe();

        $expected = '00-4bf92f3577b34da6a3ce929d0e0e4736-00f067aa0ba902b7-01';
        $text = '00-4bf92f3577b34da6a3ce929d0e0e4736-00f067aa0ba902b7-01';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(55, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACEPARENT, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new OpenTelemetryTraceparentProbe();

        $expected = '00-4bf92f3577b34da6a3ce929d0e0e4736-00f067aa0ba902b7-01';
        $text = '00-4bf92f3577b34da6a3ce929d0e0e4736-00f067aa0ba902b7-01';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(55, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACEPARENT, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new OpenTelemetryTraceparentProbe();

        $text = '00-short-span-01';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new OpenTelemetryTraceparentProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new OpenTelemetryTraceparentProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new OpenTelemetryTraceparentProbe();

        $expected = '00-4bf92f3577b34da6a3ce929d0e0e4736-00f067aa0ba902b7-01';
        $text = '00-4bf92f3577b34da6a3ce929d0e0e4736-00f067aa0ba902b7-01';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(55, $results[0]->getEnd());
        $this->assertSame(ProbeType::OPENTELEMETRY_TRACEPARENT, $results[0]->getProbeType());
    }
}
