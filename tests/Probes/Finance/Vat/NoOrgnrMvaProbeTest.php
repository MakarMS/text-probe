<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\NoOrgnrMvaProbe;

/**
 * @internal
 */
class NoOrgnrMvaProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new NoOrgnrMvaProbe();

        $expected = 'NO133640932MVA';
        $text = 'Value: NO133640932MVA';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NO_ORGNR_MVA, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new NoOrgnrMvaProbe();

        $expected = 'NO980117162MVA';
        $text = 'Value: NO980117162MVA';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NO_ORGNR_MVA, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new NoOrgnrMvaProbe();

        $expectedFirst = 'NO133640932MVA';
        $expectedSecond = 'NO980117162MVA';
        $text = 'First NO133640932MVA then NO980117162MVA';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NO_ORGNR_MVA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(26, $results[1]->getStart());
        $this->assertSame(40, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_NO_ORGNR_MVA, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new NoOrgnrMvaProbe();

        $expected = 'NO133640932MVA';
        $text = 'NO133640932MVA tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NO_ORGNR_MVA, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new NoOrgnrMvaProbe();

        $expected = 'NO133640932MVA';
        $text = 'head NO133640932MVA';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NO_ORGNR_MVA, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new NoOrgnrMvaProbe();

        $expected = 'NO133640932MVA';
        $text = 'Check NO133640932MVA, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NO_ORGNR_MVA, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new NoOrgnrMvaProbe();

        $expectedFirst = 'NO133640932MVA';
        $expectedSecond = 'NO133640932MVA';
        $text = 'NO133640932MVA and NO133640932MVA';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NO_ORGNR_MVA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(19, $results[1]->getStart());
        $this->assertSame(33, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_NO_ORGNR_MVA, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new NoOrgnrMvaProbe();

        $expected = 'NO980117162MVA';
        $text = 'Prefix NO980117162MVA suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NO_ORGNR_MVA, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new NoOrgnrMvaProbe();

        $expectedFirst = 'NO133640932MVA';
        $expectedSecond = 'NO980117162MVA';
        $text = 'NO133640932MVA, NO980117162MVA';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(14, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NO_ORGNR_MVA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(30, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_NO_ORGNR_MVA, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new NoOrgnrMvaProbe();

        $expected = 'NO133640932MVA';
        $text = 'Value: NO133640932MVA';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_NO_ORGNR_MVA, $results[0]->getProbeType());
    }
}
