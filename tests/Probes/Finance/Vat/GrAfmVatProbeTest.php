<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\GrAfmVatProbe;

/**
 * @internal
 */
class GrAfmVatProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new GrAfmVatProbe();

        $expected = 'EL442550431';
        $text = 'Value: EL442550431';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_GR_AFM, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new GrAfmVatProbe();

        $expected = 'EL153297373';
        $text = 'Value: EL153297373';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_GR_AFM, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new GrAfmVatProbe();

        $expectedFirst = 'EL442550431';
        $expectedSecond = 'EL153297373';
        $text = 'First EL442550431 then EL153297373';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_GR_AFM, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(23, $results[1]->getStart());
        $this->assertSame(34, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_GR_AFM, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new GrAfmVatProbe();

        $expected = 'EL442550431';
        $text = 'EL442550431 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_GR_AFM, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new GrAfmVatProbe();

        $expected = 'EL442550431';
        $text = 'head EL442550431';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_GR_AFM, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new GrAfmVatProbe();

        $expected = 'EL442550431';
        $text = 'Check EL442550431, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_GR_AFM, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new GrAfmVatProbe();

        $expectedFirst = 'EL442550431';
        $expectedSecond = 'EL442550431';
        $text = 'EL442550431 and EL442550431';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_GR_AFM, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(27, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_GR_AFM, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new GrAfmVatProbe();

        $expected = 'EL153297373';
        $text = 'Prefix EL153297373 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_GR_AFM, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new GrAfmVatProbe();

        $expectedFirst = 'EL442550431';
        $expectedSecond = 'EL153297373';
        $text = 'EL442550431, EL153297373';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_GR_AFM, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(13, $results[1]->getStart());
        $this->assertSame(24, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_GR_AFM, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new GrAfmVatProbe();

        $expected = 'EL442550431';
        $text = 'Value: EL442550431';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_GR_AFM, $results[0]->getProbeType());
    }
}
