<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\SyslogTimestampProbe;

/**
 * @internal
 */
class SyslogTimestampProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SyslogTimestampProbe();

        $expected = 'Jan  2 03:04:05';
        $text = 'Jan  2 03:04:05';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::SYSLOG_TIMESTAMP, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new SyslogTimestampProbe();

        $expected = 'Dec 31 23:59:59';
        $text = 'Dec 31 23:59:59';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::SYSLOG_TIMESTAMP, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SyslogTimestampProbe();

        $first = 'Jan  2 03:04:05';
        $second = 'Dec 31 23:59:59';
        $text = 'Jan  2 03:04:05' . "\n" . 'Dec 31 23:59:59';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::SYSLOG_TIMESTAMP, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(31, $results[1]->getEnd());
        $this->assertSame(ProbeType::SYSLOG_TIMESTAMP, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new SyslogTimestampProbe();

        $expected = 'Jan  2 03:04:05';
        $text = 'Jan  2 03:04:05';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::SYSLOG_TIMESTAMP, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new SyslogTimestampProbe();

        $expected = 'Jan  2 03:04:05';
        $text = 'Jan  2 03:04:05';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::SYSLOG_TIMESTAMP, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new SyslogTimestampProbe();

        $expected = 'Jan  2 03:04:05';
        $text = 'Jan  2 03:04:05';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::SYSLOG_TIMESTAMP, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new SyslogTimestampProbe();

        $text = 'Foo 99 99:99:99';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new SyslogTimestampProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new SyslogTimestampProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new SyslogTimestampProbe();

        $expected = 'Jan  2 03:04:05';
        $text = 'Jan  2 03:04:05';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::SYSLOG_TIMESTAMP, $results[0]->getProbeType());
    }
}
