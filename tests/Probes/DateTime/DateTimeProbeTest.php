<?php

namespace Tests\Probes\DateTime;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\DateTime\DateTimeProbe;

/**
 * @internal
 */
class DateTimeProbeTest extends TestCase
{
    public function testFindsISODateWithTime(): void
    {
        $probe = new DateTimeProbe();

        $text = 'Event starts at 2025-12-31 14:30';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('2025-12-31 14:30', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(32, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DATETIME, $results[0]->getProbeType());
    }

    public function testFindsSlashDateWithTime(): void
    {
        $probe = new DateTimeProbe();

        $text = 'Meeting at 14:30 31/12/2025';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('14:30 31/12/2025', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(27, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DATETIME, $results[0]->getProbeType());
    }

    public function testFindsDateWithMonthNameAndTime(): void
    {
        $probe = new DateTimeProbe();

        $text = 'Deadline: 02:30 PM 31 Dec 2025';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('02:30 PM 31 Dec 2025', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(30, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DATETIME, $results[0]->getProbeType());
    }

    public function testFindsMultipleDateTimes(): void
    {
        $probe = new DateTimeProbe();

        $text = 'Start: 09:00 10/09/2025, Break: 12:30 2025-12-01, End: 17:45 31.10.2025';
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('09:00 10/09/2025', $results[0]->getResult());
        $this->assertEquals('12:30 2025-12-01', $results[1]->getResult());
        $this->assertEquals('17:45 31.10.2025', $results[2]->getResult());
    }

    public function testFindsTimeBeforeDateWithMilliseconds(): void
    {
        $probe = new DateTimeProbe();

        $text = 'Event scheduled at 08:12:59.123 PM 31/12/2025';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertEquals('08:12:59.123 PM 31/12/2025', $results[0]->getResult());
        $this->assertEquals(19, $results[0]->getStart());
        $this->assertEquals(45, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DATETIME, $results[0]->getProbeType());
    }

    public function testNoDateTimeFound(): void
    {
        $probe = new DateTimeProbe();

        $text = 'No dates or times here!';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
