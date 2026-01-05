<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\CyVatNumberProbe;

/**
 * @internal
 */
class CyVatNumberProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new CyVatNumberProbe();

        $expected = 'CY05866324G';
        $text = 'Value: CY05866324G';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CY_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new CyVatNumberProbe();

        $expected = 'CY01812357Y';
        $text = 'Value: CY01812357Y';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CY_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CyVatNumberProbe();

        $expectedFirst = 'CY05866324G';
        $expectedSecond = 'CY01812357Y';
        $text = 'First CY05866324G then CY01812357Y';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CY_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(23, $results[1]->getStart());
        $this->assertSame(34, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_CY_NUMBER, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new CyVatNumberProbe();

        $expected = 'CY05866324G';
        $text = 'CY05866324G tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CY_NUMBER, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new CyVatNumberProbe();

        $expected = 'CY05866324G';
        $text = 'head CY05866324G';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CY_NUMBER, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new CyVatNumberProbe();

        $expected = 'CY05866324G';
        $text = 'Check CY05866324G, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CY_NUMBER, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new CyVatNumberProbe();

        $expectedFirst = 'CY05866324G';
        $expectedSecond = 'CY05866324G';
        $text = 'CY05866324G and CY05866324G';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CY_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(27, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_CY_NUMBER, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new CyVatNumberProbe();

        $expected = 'CY01812357Y';
        $text = 'Prefix CY01812357Y suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CY_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new CyVatNumberProbe();

        $expectedFirst = 'CY05866324G';
        $expectedSecond = 'CY01812357Y';
        $text = 'CY05866324G, CY01812357Y';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CY_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(13, $results[1]->getStart());
        $this->assertSame(24, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_CY_NUMBER, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new CyVatNumberProbe();

        $expected = 'CY05866324G';
        $text = 'Value: CY05866324G';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CY_NUMBER, $results[0]->getProbeType());
    }
}
