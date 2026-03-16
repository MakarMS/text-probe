<?php

namespace Tests\Probes\Finance\Market;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Market\SedolCodeProbe;

/**
 * @internal
 */
class SedolCodeProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SedolCodeProbe();

        $expected = '0263494';
        $text = 'Value: 0263494';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::SEDOL_CODE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SedolCodeProbe();

        $expected = '0263494';
        $text = 'First 0263494 then 0263494';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::SEDOL_CODE, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(19, $results[1]->getStart());
        $this->assertSame(26, $results[1]->getEnd());
        $this->assertSame(ProbeType::SEDOL_CODE, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new SedolCodeProbe();

        $text = 'Value: 0263495';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new SedolCodeProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new SedolCodeProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
