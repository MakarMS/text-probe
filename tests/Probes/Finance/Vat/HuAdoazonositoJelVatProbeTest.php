<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\HuAdoazonositoJelVatProbe;

/**
 * @internal
 */
class HuAdoazonositoJelVatProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new HuAdoazonositoJelVatProbe();

        $expected = 'HU70473056';
        $text = 'Value: HU70473056';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HU_ADOAZONOSITO_JEL, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new HuAdoazonositoJelVatProbe();

        $expected = 'HU24855086';
        $text = 'Value: HU24855086';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HU_ADOAZONOSITO_JEL, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new HuAdoazonositoJelVatProbe();

        $expectedFirst = 'HU70473056';
        $expectedSecond = 'HU24855086';
        $text = 'First HU70473056 then HU24855086';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HU_ADOAZONOSITO_JEL, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(22, $results[1]->getStart());
        $this->assertSame(32, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_HU_ADOAZONOSITO_JEL, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new HuAdoazonositoJelVatProbe();

        $expected = 'HU70473056';
        $text = 'HU70473056 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HU_ADOAZONOSITO_JEL, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new HuAdoazonositoJelVatProbe();

        $expected = 'HU70473056';
        $text = 'head HU70473056';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HU_ADOAZONOSITO_JEL, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new HuAdoazonositoJelVatProbe();

        $expected = 'HU70473056';
        $text = 'Check HU70473056, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HU_ADOAZONOSITO_JEL, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new HuAdoazonositoJelVatProbe();

        $expectedFirst = 'HU70473056';
        $expectedSecond = 'HU70473056';
        $text = 'HU70473056 and HU70473056';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HU_ADOAZONOSITO_JEL, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(25, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_HU_ADOAZONOSITO_JEL, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new HuAdoazonositoJelVatProbe();

        $expected = 'HU24855086';
        $text = 'Prefix HU24855086 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HU_ADOAZONOSITO_JEL, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new HuAdoazonositoJelVatProbe();

        $expectedFirst = 'HU70473056';
        $expectedSecond = 'HU24855086';
        $text = 'HU70473056, HU24855086';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HU_ADOAZONOSITO_JEL, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(12, $results[1]->getStart());
        $this->assertSame(22, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_HU_ADOAZONOSITO_JEL, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new HuAdoazonositoJelVatProbe();

        $expected = 'HU70473056';
        $text = 'Value: HU70473056';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_HU_ADOAZONOSITO_JEL, $results[0]->getProbeType());
    }
}
