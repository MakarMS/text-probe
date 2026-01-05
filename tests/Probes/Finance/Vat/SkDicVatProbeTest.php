<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\SkDicVatProbe;

/**
 * @internal
 */
class SkDicVatProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new SkDicVatProbe();

        $expected = 'SK5804125481';
        $text = 'Value: SK5804125481';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SK_DIC, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new SkDicVatProbe();

        $expected = 'SK8636599499';
        $text = 'Value: SK8636599499';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SK_DIC, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new SkDicVatProbe();

        $expectedFirst = 'SK5804125481';
        $expectedSecond = 'SK8636599499';
        $text = 'First SK5804125481 then SK8636599499';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SK_DIC, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(24, $results[1]->getStart());
        $this->assertSame(36, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_SK_DIC, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new SkDicVatProbe();

        $expected = 'SK5804125481';
        $text = 'SK5804125481 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SK_DIC, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new SkDicVatProbe();

        $expected = 'SK5804125481';
        $text = 'head SK5804125481';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SK_DIC, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new SkDicVatProbe();

        $expected = 'SK5804125481';
        $text = 'Check SK5804125481, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SK_DIC, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new SkDicVatProbe();

        $expectedFirst = 'SK5804125481';
        $expectedSecond = 'SK5804125481';
        $text = 'SK5804125481 and SK5804125481';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SK_DIC, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(17, $results[1]->getStart());
        $this->assertSame(29, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_SK_DIC, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new SkDicVatProbe();

        $expected = 'SK8636599499';
        $text = 'Prefix SK8636599499 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SK_DIC, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new SkDicVatProbe();

        $expectedFirst = 'SK5804125481';
        $expectedSecond = 'SK8636599499';
        $text = 'SK5804125481, SK8636599499';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SK_DIC, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(14, $results[1]->getStart());
        $this->assertSame(26, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_SK_DIC, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new SkDicVatProbe();

        $expected = 'SK5804125481';
        $text = 'Value: SK5804125481';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_SK_DIC, $results[0]->getProbeType());
    }
}
