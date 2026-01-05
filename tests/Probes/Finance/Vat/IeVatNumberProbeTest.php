<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\IeVatNumberProbe;

/**
 * @internal
 */
class IeVatNumberProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new IeVatNumberProbe();

        $expected = 'IE9429088M';
        $text = 'Value: IE9429088M';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IE_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new IeVatNumberProbe();

        $expected = 'IE1091640K';
        $text = 'Value: IE1091640K';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IE_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new IeVatNumberProbe();

        $expectedFirst = 'IE9429088M';
        $expectedSecond = 'IE1091640K';
        $text = 'First IE9429088M then IE1091640K';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IE_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(22, $results[1]->getStart());
        $this->assertSame(32, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_IE_NUMBER, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new IeVatNumberProbe();

        $expected = 'IE9429088M';
        $text = 'IE9429088M tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IE_NUMBER, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new IeVatNumberProbe();

        $expected = 'IE9429088M';
        $text = 'head IE9429088M';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IE_NUMBER, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new IeVatNumberProbe();

        $expected = 'IE9429088M';
        $text = 'Check IE9429088M, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IE_NUMBER, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new IeVatNumberProbe();

        $expectedFirst = 'IE9429088M';
        $expectedSecond = 'IE9429088M';
        $text = 'IE9429088M and IE9429088M';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IE_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(25, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_IE_NUMBER, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new IeVatNumberProbe();

        $expected = 'IE1091640K';
        $text = 'Prefix IE1091640K suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IE_NUMBER, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new IeVatNumberProbe();

        $expectedFirst = 'IE9429088M';
        $expectedSecond = 'IE1091640K';
        $text = 'IE9429088M, IE1091640K';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IE_NUMBER, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(12, $results[1]->getStart());
        $this->assertSame(22, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_IE_NUMBER, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new IeVatNumberProbe();

        $expected = 'IE9429088M';
        $text = 'Value: IE9429088M';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IE_NUMBER, $results[0]->getProbeType());
    }
}
