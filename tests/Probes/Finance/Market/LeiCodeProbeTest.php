<?php

namespace Tests\Probes\Finance\Market;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Market\LeiCodeProbe;

/**
 * @internal
 */
class LeiCodeProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new LeiCodeProbe();

        $expected = '5493001KJTIIGC8Y1R35';
        $text = 'Value: 5493001KJTIIGC8Y1R35';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(27, $results[0]->getEnd());
        $this->assertSame(ProbeType::LEI_CODE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new LeiCodeProbe();

        $expected = '5493001KJTIIGC8Y1R35';
        $text = 'First 5493001KJTIIGC8Y1R35 then 5493001KJTIIGC8Y1R35';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(26, $results[0]->getEnd());
        $this->assertSame(ProbeType::LEI_CODE, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(32, $results[1]->getStart());
        $this->assertSame(52, $results[1]->getEnd());
        $this->assertSame(ProbeType::LEI_CODE, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new LeiCodeProbe();

        $text = 'Value: 5493001KJTIIGC8Y1R36';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new LeiCodeProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new LeiCodeProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
