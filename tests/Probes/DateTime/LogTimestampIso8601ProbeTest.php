<?php

namespace Tests\Probes\DateTime;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\DateTime\LogTimestampIso8601Probe;

/**
 * @internal
 */
class LogTimestampIso8601ProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new LogTimestampIso8601Probe();

        $expected = '2026-03-16T12:30:45Z';
        $text = 'Value: 2026-03-16T12:30:45Z';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(27, $results[0]->getEnd());
        $this->assertSame(ProbeType::LOG_TIMESTAMP_ISO8601, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new LogTimestampIso8601Probe();

        $expected = '2026-03-16T12:30:45Z';
        $text = 'First 2026-03-16T12:30:45Z then 2026-03-16T12:30:45Z';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(26, $results[0]->getEnd());
        $this->assertSame(ProbeType::LOG_TIMESTAMP_ISO8601, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(32, $results[1]->getStart());
        $this->assertSame(52, $results[1]->getEnd());
        $this->assertSame(ProbeType::LOG_TIMESTAMP_ISO8601, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new LogTimestampIso8601Probe();

        $text = 'Value: 16-03-2026 12:30:45';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new LogTimestampIso8601Probe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new LogTimestampIso8601Probe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
