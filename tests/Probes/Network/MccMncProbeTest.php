<?php

namespace Tests\Probes\Network;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Network\MccMncProbe;

/**
 * @internal
 */
class MccMncProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new MccMncProbe();

        $expected = '310-260';
        $text = 'Value: 310-260';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::MCC_MNC, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new MccMncProbe();

        $expected = '310-260';
        $text = 'First 310-260 then 310-260';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::MCC_MNC, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(19, $results[1]->getStart());
        $this->assertSame(26, $results[1]->getEnd());
        $this->assertSame(ProbeType::MCC_MNC, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new MccMncProbe();

        $text = 'Value: 31-260';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new MccMncProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new MccMncProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
