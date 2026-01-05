<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\PtNifIvaProbe;

/**
 * @internal
 */
class PtNifIvaProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new PtNifIvaProbe();

        $expected = 'PT955881234';
        $text = 'Value: PT955881234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PT_NIF_IVA, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new PtNifIvaProbe();

        $expected = 'PT143794973';
        $text = 'Value: PT143794973';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PT_NIF_IVA, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PtNifIvaProbe();

        $expectedFirst = 'PT955881234';
        $expectedSecond = 'PT143794973';
        $text = 'First PT955881234 then PT143794973';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PT_NIF_IVA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(23, $results[1]->getStart());
        $this->assertSame(34, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_PT_NIF_IVA, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new PtNifIvaProbe();

        $expected = 'PT955881234';
        $text = 'PT955881234 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PT_NIF_IVA, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new PtNifIvaProbe();

        $expected = 'PT955881234';
        $text = 'head PT955881234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PT_NIF_IVA, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new PtNifIvaProbe();

        $expected = 'PT955881234';
        $text = 'Check PT955881234, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PT_NIF_IVA, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new PtNifIvaProbe();

        $expectedFirst = 'PT955881234';
        $expectedSecond = 'PT955881234';
        $text = 'PT955881234 and PT955881234';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PT_NIF_IVA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(27, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_PT_NIF_IVA, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new PtNifIvaProbe();

        $expected = 'PT143794973';
        $text = 'Prefix PT143794973 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PT_NIF_IVA, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new PtNifIvaProbe();

        $expectedFirst = 'PT955881234';
        $expectedSecond = 'PT143794973';
        $text = 'PT955881234, PT143794973';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PT_NIF_IVA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(13, $results[1]->getStart());
        $this->assertSame(24, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_PT_NIF_IVA, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new PtNifIvaProbe();

        $expected = 'PT955881234';
        $text = 'Value: PT955881234';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PT_NIF_IVA, $results[0]->getProbeType());
    }
}
