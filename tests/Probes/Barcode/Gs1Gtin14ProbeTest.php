<?php

namespace Tests\Probes\Barcode;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Barcode\Gs1Gtin14Probe;

/**
 * @internal
 */
class Gs1Gtin14ProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new Gs1Gtin14Probe();

        $expected = '10012345678902';
        $text = 'Value: 10012345678902';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::GS1_GTIN_14, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new Gs1Gtin14Probe();

        $expected = '10012345678902';
        $text = 'First 10012345678902 then 10012345678902';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::GS1_GTIN_14, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(26, $results[1]->getStart());
        $this->assertSame(40, $results[1]->getEnd());
        $this->assertSame(ProbeType::GS1_GTIN_14, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new Gs1Gtin14Probe();

        $text = 'Value: 10012345678903';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new Gs1Gtin14Probe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new Gs1Gtin14Probe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
