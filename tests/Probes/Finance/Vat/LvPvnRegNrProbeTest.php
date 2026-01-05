<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\LvPvnRegNrProbe;

/**
 * @internal
 */
class LvPvnRegNrProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new LvPvnRegNrProbe();

        $expected = 'LV08116995373';
        $text = 'Value: LV08116995373';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LV_PVN_REG_NR, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new LvPvnRegNrProbe();

        $expected = 'LV59829349456';
        $text = 'Value: LV59829349456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LV_PVN_REG_NR, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new LvPvnRegNrProbe();

        $expectedFirst = 'LV08116995373';
        $expectedSecond = 'LV59829349456';
        $text = 'First LV08116995373 then LV59829349456';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LV_PVN_REG_NR, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(25, $results[1]->getStart());
        $this->assertSame(38, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_LV_PVN_REG_NR, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new LvPvnRegNrProbe();

        $expected = 'LV08116995373';
        $text = 'LV08116995373 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LV_PVN_REG_NR, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new LvPvnRegNrProbe();

        $expected = 'LV08116995373';
        $text = 'head LV08116995373';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LV_PVN_REG_NR, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new LvPvnRegNrProbe();

        $expected = 'LV08116995373';
        $text = 'Check LV08116995373, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LV_PVN_REG_NR, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new LvPvnRegNrProbe();

        $expectedFirst = 'LV08116995373';
        $expectedSecond = 'LV08116995373';
        $text = 'LV08116995373 and LV08116995373';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LV_PVN_REG_NR, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(18, $results[1]->getStart());
        $this->assertSame(31, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_LV_PVN_REG_NR, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new LvPvnRegNrProbe();

        $expected = 'LV59829349456';
        $text = 'Prefix LV59829349456 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LV_PVN_REG_NR, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new LvPvnRegNrProbe();

        $expectedFirst = 'LV08116995373';
        $expectedSecond = 'LV59829349456';
        $text = 'LV08116995373, LV59829349456';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LV_PVN_REG_NR, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(28, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_LV_PVN_REG_NR, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new LvPvnRegNrProbe();

        $expected = 'LV08116995373';
        $text = 'Value: LV08116995373';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LV_PVN_REG_NR, $results[0]->getProbeType());
    }
}
