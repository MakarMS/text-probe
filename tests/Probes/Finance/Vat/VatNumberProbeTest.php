<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\VatNumberProbe;

/**
 * @internal
 */
class VatNumberProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new VatNumberProbe();

        $expected = 'CHE999945575MWST';
        $text = 'Value: CHE999945575MWST';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new VatNumberProbe();

        $expected = 'NO133640932MVA';
        $text = 'Value: NO133640932MVA';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new VatNumberProbe();

        $expectedFirst = 'CHE999945575MWST';
        $expectedSecond = 'NO133640932MVA';
        $text = 'First CHE999945575MWST then NO133640932MVA';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(28, $results[1]->getStart());
        $this->assertSame(42, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_NUMBER, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new VatNumberProbe();

        $expected = 'CHE999945575MWST';
        $text = 'CHE999945575MWST tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NUMBER, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new VatNumberProbe();

        $expected = 'CHE999945575MWST';
        $text = 'head CHE999945575MWST';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NUMBER, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new VatNumberProbe();

        $expected = 'CHE999945575MWST';
        $text = 'Check CHE999945575MWST, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(22, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NUMBER, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new VatNumberProbe();

        $expectedFirst = 'CHE999945575MWST';
        $expectedSecond = 'CHE999945575MWST';
        $text = 'CHE999945575MWST and CHE999945575MWST';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(21, $results[1]->getStart());
        $this->assertSame(37, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_NUMBER, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new VatNumberProbe();

        $expected = 'NO133640932MVA';
        $text = 'Prefix NO133640932MVA suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new VatNumberProbe();

        $expectedFirst = 'CHE999945575MWST';
        $expectedSecond = 'NO133640932MVA';
        $text = 'CHE999945575MWST, NO133640932MVA';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(18, $results[1]->getStart());
        $this->assertSame(32, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_NUMBER, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new VatNumberProbe();

        $expected = 'CHE999945575MWST';
        $text = 'Value: CHE999945575MWST';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(23, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NUMBER, $results[0]->getProbeType());
    }
}
