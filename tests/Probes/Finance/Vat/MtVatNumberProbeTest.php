<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\MtVatNumberProbe;

/**
 * @internal
 */
class MtVatNumberProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new MtVatNumberProbe();

        $expected = 'MT16545205';
        $text = 'Value: MT16545205';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_MT_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new MtVatNumberProbe();

        $expected = 'MT58130128';
        $text = 'Value: MT58130128';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_MT_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new MtVatNumberProbe();

        $expectedFirst = 'MT16545205';
        $expectedSecond = 'MT58130128';
        $text = 'First MT16545205 then MT58130128';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_MT_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(22, $results[1]->getStart());
        $this->assertSame(32, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_MT_NUMBER, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new MtVatNumberProbe();

        $expected = 'MT16545205';
        $text = 'MT16545205 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_MT_NUMBER, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new MtVatNumberProbe();

        $expected = 'MT16545205';
        $text = 'head MT16545205';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_MT_NUMBER, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new MtVatNumberProbe();

        $expected = 'MT16545205';
        $text = 'Check MT16545205, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_MT_NUMBER, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new MtVatNumberProbe();

        $expectedFirst = 'MT16545205';
        $expectedSecond = 'MT16545205';
        $text = 'MT16545205 and MT16545205';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_MT_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(25, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_MT_NUMBER, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new MtVatNumberProbe();

        $expected = 'MT58130128';
        $text = 'Prefix MT58130128 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_MT_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new MtVatNumberProbe();

        $expectedFirst = 'MT16545205';
        $expectedSecond = 'MT58130128';
        $text = 'MT16545205, MT58130128';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_MT_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(12, $results[1]->getStart());
        $this->assertSame(22, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_MT_NUMBER, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new MtVatNumberProbe();

        $expected = 'MT16545205';
        $text = 'Value: MT16545205';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_MT_NUMBER, $results[0]->getProbeType());
    }
}
