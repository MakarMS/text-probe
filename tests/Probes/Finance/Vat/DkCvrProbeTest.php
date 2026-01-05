<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\DkCvrProbe;

/**
 * @internal
 */
class DkCvrProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new DkCvrProbe();

        $expected = 'DK01277308';
        $text = 'Value: DK01277308';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DK_CVR, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new DkCvrProbe();

        $expected = 'DK44590271';
        $text = 'Value: DK44590271';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DK_CVR, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new DkCvrProbe();

        $expectedFirst = 'DK01277308';
        $expectedSecond = 'DK44590271';
        $text = 'First DK01277308 then DK44590271';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DK_CVR, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(22, $results[1]->getStart());
        $this->assertSame(32, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_DK_CVR, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new DkCvrProbe();

        $expected = 'DK01277308';
        $text = 'DK01277308 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DK_CVR, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new DkCvrProbe();

        $expected = 'DK01277308';
        $text = 'head DK01277308';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DK_CVR, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new DkCvrProbe();

        $expected = 'DK01277308';
        $text = 'Check DK01277308, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DK_CVR, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new DkCvrProbe();

        $expectedFirst = 'DK01277308';
        $expectedSecond = 'DK01277308';
        $text = 'DK01277308 and DK01277308';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DK_CVR, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(25, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_DK_CVR, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new DkCvrProbe();

        $expected = 'DK44590271';
        $text = 'Prefix DK44590271 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DK_CVR, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new DkCvrProbe();

        $expectedFirst = 'DK01277308';
        $expectedSecond = 'DK44590271';
        $text = 'DK01277308, DK44590271';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DK_CVR, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(12, $results[1]->getStart());
        $this->assertSame(22, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_DK_CVR, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new DkCvrProbe();

        $expected = 'DK01277308';
        $text = 'Value: DK01277308';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_DK_CVR, $results[0]->getProbeType());
    }
}
