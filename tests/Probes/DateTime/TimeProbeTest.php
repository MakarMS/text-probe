<?php

namespace Tests\Probes\DateTime;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\DateTime\TimeProbe;

class TimeProbeTest extends TestCase
{
    public function testFindsSimpleTime(): void
    {
        $probe = new TimeProbe();

        $text = "Meeting at 09:30";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('09:30', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(16, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TIME, $results[0]->getProbeType());
    }

    public function testFindsTimeWithSeconds(): void
    {
        $probe = new TimeProbe();

        $text = "The alarm is set for 14:45:30";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('14:45:30', $results[0]->getResult());
        $this->assertEquals(21, $results[0]->getStart());
        $this->assertEquals(29, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TIME, $results[0]->getProbeType());
    }

    public function testFindsTimeWithMilliseconds(): void
    {
        $probe = new TimeProbe();

        $text = "Timestamp: 08:12:59.123 processed";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('08:12:59.123', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(23, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TIME, $results[0]->getProbeType());
    }

    public function testFindsMultipleTimes(): void
    {
        $probe = new TimeProbe();

        $text = "Start: 09:00, Break: 12:30, End: 17:45";
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('09:00', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(12, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TIME, $results[0]->getProbeType());

        $this->assertEquals('12:30', $results[1]->getResult());
        $this->assertEquals(21, $results[1]->getStart());
        $this->assertEquals(26, $results[1]->getEnd());
        $this->assertEquals(ProbeType::TIME, $results[1]->getProbeType());

        $this->assertEquals('17:45', $results[2]->getResult());
        $this->assertEquals(33, $results[2]->getStart());
        $this->assertEquals(38, $results[2]->getEnd());
        $this->assertEquals(ProbeType::TIME, $results[2]->getProbeType());
    }

    public function testFindsTimeWithAMPM(): void
    {
        $probe = new TimeProbe();

        $text = "The meeting starts at 08:30 PM and ends at 10:15 AM";
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('08:30 PM', $results[0]->getResult());
        $this->assertEquals(22, $results[0]->getStart());
        $this->assertEquals(30, $results[0]->getEnd());
        $this->assertEquals(ProbeType::TIME, $results[0]->getProbeType());

        $this->assertEquals('10:15 AM', $results[1]->getResult());
        $this->assertEquals(43, $results[1]->getStart());
        $this->assertEquals(51, $results[1]->getEnd());
        $this->assertEquals(ProbeType::TIME, $results[1]->getProbeType());
    }

    public function testNoTimeFound(): void
    {
        $probe = new TimeProbe();

        $text = "There is no time here!";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}
