<?php

namespace Tests\Probes\Logistics;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Logistics\EuEoriNumberProbe;

/**
 * @internal
 */
class EuEoriNumberProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new EuEoriNumberProbe();

        $expected = 'DE123456789012';
        $text = 'Value: DE123456789012';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::EU_EORI_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new EuEoriNumberProbe();

        $expected = 'DE123456789012';
        $text = 'First DE123456789012 then DE123456789012';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::EU_EORI_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(26, $results[1]->getStart());
        $this->assertSame(40, $results[1]->getEnd());
        $this->assertSame(ProbeType::EU_EORI_NUMBER, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new EuEoriNumberProbe();

        $text = 'Value: D1234';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new EuEoriNumberProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new EuEoriNumberProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
