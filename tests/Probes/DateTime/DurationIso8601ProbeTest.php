<?php

namespace Tests\Probes\DateTime;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\DateTime\DurationIso8601Probe;

/**
 * @internal
 */
class DurationIso8601ProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new DurationIso8601Probe();

        $expected = 'P1DT2H30M';
        $text = 'Value: P1DT2H30M';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::DURATION_ISO8601, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new DurationIso8601Probe();

        $expected = 'P1DT2H30M';
        $text = 'First P1DT2H30M then P1DT2H30M';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::DURATION_ISO8601, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(21, $results[1]->getStart());
        $this->assertSame(30, $results[1]->getEnd());
        $this->assertSame(ProbeType::DURATION_ISO8601, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new DurationIso8601Probe();

        $text = 'Value: PT';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new DurationIso8601Probe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new DurationIso8601Probe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
