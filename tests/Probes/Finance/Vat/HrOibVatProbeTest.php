<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\HrOibVatProbe;

/**
 * @internal
 */
class HrOibVatProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new HrOibVatProbe();

        $expected = 'HR96805128475';
        $text = 'Value: HR96805128475';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HR_OIB, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new HrOibVatProbe();

        $expected = 'HR11889587344';
        $text = 'Value: HR11889587344';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HR_OIB, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new HrOibVatProbe();

        $expectedFirst = 'HR96805128475';
        $expectedSecond = 'HR11889587344';
        $text = 'First HR96805128475 then HR11889587344';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HR_OIB, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(25, $results[1]->getStart());
        $this->assertSame(38, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_HR_OIB, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new HrOibVatProbe();

        $expected = 'HR96805128475';
        $text = 'HR96805128475 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HR_OIB, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new HrOibVatProbe();

        $expected = 'HR96805128475';
        $text = 'head HR96805128475';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HR_OIB, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new HrOibVatProbe();

        $expected = 'HR96805128475';
        $text = 'Check HR96805128475, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HR_OIB, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new HrOibVatProbe();

        $expectedFirst = 'HR96805128475';
        $expectedSecond = 'HR96805128475';
        $text = 'HR96805128475 and HR96805128475';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HR_OIB, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(18, $results[1]->getStart());
        $this->assertSame(31, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_HR_OIB, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new HrOibVatProbe();

        $expected = 'HR11889587344';
        $text = 'Prefix HR11889587344 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HR_OIB, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new HrOibVatProbe();

        $expectedFirst = 'HR96805128475';
        $expectedSecond = 'HR11889587344';
        $text = 'HR96805128475, HR11889587344';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HR_OIB, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(28, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_HR_OIB, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new HrOibVatProbe();

        $expected = 'HR96805128475';
        $text = 'Value: HR96805128475';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HR_OIB, $results[0]->getProbeType());
    }
}
