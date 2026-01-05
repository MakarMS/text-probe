<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\EsNifIvaProbe;

/**
 * @internal
 */
class EsNifIvaProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new EsNifIvaProbe();

        $expected = 'ESF08109498';
        $text = 'Value: ESF08109498';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_ES_NIF_IVA, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new EsNifIvaProbe();

        $expected = 'ES77428706B';
        $text = 'Value: ES77428706B';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_ES_NIF_IVA, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new EsNifIvaProbe();

        $expectedFirst = 'ESF08109498';
        $expectedSecond = 'ES77428706B';
        $text = 'First ESF08109498 then ES77428706B';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_ES_NIF_IVA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(23, $results[1]->getStart());
        $this->assertSame(34, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_ES_NIF_IVA, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new EsNifIvaProbe();

        $expected = 'ESF08109498';
        $text = 'ESF08109498 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_ES_NIF_IVA, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new EsNifIvaProbe();

        $expected = 'ESF08109498';
        $text = 'head ESF08109498';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_ES_NIF_IVA, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new EsNifIvaProbe();

        $expected = 'ESF08109498';
        $text = 'Check ESF08109498, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_ES_NIF_IVA, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new EsNifIvaProbe();

        $expectedFirst = 'ESF08109498';
        $expectedSecond = 'ESF08109498';
        $text = 'ESF08109498 and ESF08109498';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_ES_NIF_IVA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(27, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_ES_NIF_IVA, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new EsNifIvaProbe();

        $expected = 'ES77428706B';
        $text = 'Prefix ES77428706B suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_ES_NIF_IVA, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new EsNifIvaProbe();

        $expectedFirst = 'ESF08109498';
        $expectedSecond = 'ES77428706B';
        $text = 'ESF08109498, ES77428706B';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_ES_NIF_IVA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(13, $results[1]->getStart());
        $this->assertSame(24, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_ES_NIF_IVA, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new EsNifIvaProbe();

        $expected = 'ESF08109498';
        $text = 'Value: ESF08109498';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_ES_NIF_IVA, $results[0]->getProbeType());
    }
}
