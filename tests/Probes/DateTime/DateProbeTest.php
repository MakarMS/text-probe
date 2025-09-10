<?php

namespace Tests\Probes\DateTime;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\DateTime\DateProbe;

class DateProbeTest extends TestCase
{
    public function testFindsSlashFormat(): void
    {
        $probe = new DateProbe();

        $text = "Event on 10/09/2025";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('10/09/2025', $results[0]->getResult());
        $this->assertEquals(9, $results[0]->getStart());
        $this->assertEquals(19, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DATE, $results[0]->getProbeType());
    }

    public function testFindsDashFormat(): void
    {
        $probe = new DateProbe();

        $text = "Deadline: 2025-12-01";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('2025-12-01', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(20, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DATE, $results[0]->getProbeType());
    }

    public function testFindsDotFormat(): void
    {
        $probe = new DateProbe();

        $text = "Birthday: 31.10.2025";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('31.10.2025', $results[0]->getResult());
        $this->assertEquals(10, $results[0]->getStart());
        $this->assertEquals(20, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DATE, $results[0]->getProbeType());
    }

    public function testFindsMultipleDates(): void
    {
        $probe = new DateProbe();

        $text = "Events: 10/09/2025, 2025-12-01 and 31.10.2025";
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('10/09/2025', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(18, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DATE, $results[0]->getProbeType());

        $this->assertEquals('2025-12-01', $results[1]->getResult());
        $this->assertEquals(20, $results[1]->getStart());
        $this->assertEquals(30, $results[1]->getEnd());
        $this->assertEquals(ProbeType::DATE, $results[1]->getProbeType());

        $this->assertEquals('31.10.2025', $results[2]->getResult());
        $this->assertEquals(35, $results[2]->getStart());
        $this->assertEquals(45, $results[2]->getEnd());
        $this->assertEquals(ProbeType::DATE, $results[2]->getProbeType());
    }

    public function testFindsDateWithMonthName(): void
    {
        $probe = new DateProbe();

        $text = "Meeting scheduled on 1st Jan 2025";
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('1st Jan 2025', $results[0]->getResult());
        $this->assertEquals(21, $results[0]->getStart());
        $this->assertEquals(33, $results[0]->getEnd());
        $this->assertEquals(ProbeType::DATE, $results[0]->getProbeType());
    }

    public function testNoDateFound(): void
    {
        $probe = new DateProbe();

        $text = "No date here!";
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }
}