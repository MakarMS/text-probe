<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\RoCuiVatProbe;

/**
 * @internal
 */
class RoCuiVatProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new RoCuiVatProbe();

        $expected = 'RO76503380';
        $text = 'Value: RO76503380';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_RO_CUI, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new RoCuiVatProbe();

        $expected = 'RO7899630';
        $text = 'Value: RO7899630';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_RO_CUI, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new RoCuiVatProbe();

        $expectedFirst = 'RO76503380';
        $expectedSecond = 'RO7899630';
        $text = 'First RO76503380 then RO7899630';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_RO_CUI, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(22, $results[1]->getStart());
        $this->assertSame(31, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_RO_CUI, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new RoCuiVatProbe();

        $expected = 'RO76503380';
        $text = 'RO76503380 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_RO_CUI, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new RoCuiVatProbe();

        $expected = 'RO76503380';
        $text = 'head RO76503380';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_RO_CUI, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new RoCuiVatProbe();

        $expected = 'RO76503380';
        $text = 'Check RO76503380, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_RO_CUI, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new RoCuiVatProbe();

        $expectedFirst = 'RO76503380';
        $expectedSecond = 'RO76503380';
        $text = 'RO76503380 and RO76503380';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_RO_CUI, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(25, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_RO_CUI, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new RoCuiVatProbe();

        $expected = 'RO7899630';
        $text = 'Prefix RO7899630 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_RO_CUI, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new RoCuiVatProbe();

        $expectedFirst = 'RO76503380';
        $expectedSecond = 'RO7899630';
        $text = 'RO76503380, RO7899630';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_RO_CUI, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(12, $results[1]->getStart());
        $this->assertSame(21, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_RO_CUI, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new RoCuiVatProbe();

        $expected = 'RO76503380';
        $text = 'Value: RO76503380';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_RO_CUI, $results[0]->getProbeType());
    }
}
