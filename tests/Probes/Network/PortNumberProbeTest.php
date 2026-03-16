<?php

namespace Tests\Probes\Network;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Network\PortNumberProbe;

/**
 * @internal
 */
class PortNumberProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new PortNumberProbe();

        $expected = '443';
        $text = 'Value: 443';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::PORT_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PortNumberProbe();

        $expected = '443';
        $text = 'First 443 then 443';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(9, $results[0]->getEnd());
        $this->assertSame(ProbeType::PORT_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(18, $results[1]->getEnd());
        $this->assertSame(ProbeType::PORT_NUMBER, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new PortNumberProbe();

        $text = 'Value: 70000';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new PortNumberProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new PortNumberProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
