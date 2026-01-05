<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\SiDavcnaStevilkaVatProbe;

/**
 * @internal
 */
class SiDavcnaStevilkaVatProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SiDavcnaStevilkaVatProbe();

        $expected = 'SI28415779';
        $text = 'Value: SI28415779';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SI_DAVCNA_STEVILKA, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new SiDavcnaStevilkaVatProbe();

        $expected = 'SI13557629';
        $text = 'Value: SI13557629';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SI_DAVCNA_STEVILKA, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SiDavcnaStevilkaVatProbe();

        $expectedFirst = 'SI28415779';
        $expectedSecond = 'SI13557629';
        $text = 'First SI28415779 then SI13557629';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SI_DAVCNA_STEVILKA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(22, $results[1]->getStart());
        $this->assertSame(32, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_SI_DAVCNA_STEVILKA, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new SiDavcnaStevilkaVatProbe();

        $expected = 'SI28415779';
        $text = 'SI28415779 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SI_DAVCNA_STEVILKA, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new SiDavcnaStevilkaVatProbe();

        $expected = 'SI28415779';
        $text = 'head SI28415779';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SI_DAVCNA_STEVILKA, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new SiDavcnaStevilkaVatProbe();

        $expected = 'SI28415779';
        $text = 'Check SI28415779, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SI_DAVCNA_STEVILKA, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new SiDavcnaStevilkaVatProbe();

        $expectedFirst = 'SI28415779';
        $expectedSecond = 'SI28415779';
        $text = 'SI28415779 and SI28415779';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SI_DAVCNA_STEVILKA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(25, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_SI_DAVCNA_STEVILKA, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new SiDavcnaStevilkaVatProbe();

        $expected = 'SI13557629';
        $text = 'Prefix SI13557629 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SI_DAVCNA_STEVILKA, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new SiDavcnaStevilkaVatProbe();

        $expectedFirst = 'SI28415779';
        $expectedSecond = 'SI13557629';
        $text = 'SI28415779, SI13557629';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SI_DAVCNA_STEVILKA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(12, $results[1]->getStart());
        $this->assertSame(22, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_SI_DAVCNA_STEVILKA, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new SiDavcnaStevilkaVatProbe();

        $expected = 'SI28415779';
        $text = 'Value: SI28415779';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SI_DAVCNA_STEVILKA, $results[0]->getProbeType());
    }
}
