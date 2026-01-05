<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\XiVatNumberProbe;

/**
 * @internal
 */
class XiVatNumberProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new XiVatNumberProbe();

        $expected = 'XI816110862';
        $text = 'Value: XI816110862';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_XI_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new XiVatNumberProbe();

        $expected = 'XI411367775';
        $text = 'Value: XI411367775';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_XI_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new XiVatNumberProbe();

        $expectedFirst = 'XI816110862';
        $expectedSecond = 'XI411367775';
        $text = 'First XI816110862 then XI411367775';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_XI_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(23, $results[1]->getStart());
        $this->assertSame(34, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_XI_NUMBER, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new XiVatNumberProbe();

        $expected = 'XI816110862';
        $text = 'XI816110862 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_XI_NUMBER, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new XiVatNumberProbe();

        $expected = 'XI816110862';
        $text = 'head XI816110862';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_XI_NUMBER, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new XiVatNumberProbe();

        $expected = 'XI816110862';
        $text = 'Check XI816110862, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_XI_NUMBER, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new XiVatNumberProbe();

        $expectedFirst = 'XI816110862';
        $expectedSecond = 'XI816110862';
        $text = 'XI816110862 and XI816110862';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_XI_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(27, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_XI_NUMBER, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new XiVatNumberProbe();

        $expected = 'XI411367775';
        $text = 'Prefix XI411367775 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_XI_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new XiVatNumberProbe();

        $expectedFirst = 'XI816110862';
        $expectedSecond = 'XI411367775';
        $text = 'XI816110862, XI411367775';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_XI_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(13, $results[1]->getStart());
        $this->assertSame(24, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_XI_NUMBER, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new XiVatNumberProbe();

        $expected = 'XI816110862';
        $text = 'Value: XI816110862';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_XI_NUMBER, $results[0]->getProbeType());
    }
}
