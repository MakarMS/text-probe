<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\FrNumeroTvaIntracommunautaireProbe;

/**
 * @internal
 */
class FrNumeroTvaIntracommunautaireProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new FrNumeroTvaIntracommunautaireProbe();

        $expected = 'FR17336019286';
        $text = 'Value: FR17336019286';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FR_NUMERO_TVA_INTRACOMMUNAUTAIRE, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new FrNumeroTvaIntracommunautaireProbe();

        $expected = 'FR06124937065';
        $text = 'Value: FR06124937065';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FR_NUMERO_TVA_INTRACOMMUNAUTAIRE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new FrNumeroTvaIntracommunautaireProbe();

        $expectedFirst = 'FR17336019286';
        $expectedSecond = 'FR06124937065';
        $text = 'First FR17336019286 then FR06124937065';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FR_NUMERO_TVA_INTRACOMMUNAUTAIRE, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(25, $results[1]->getStart());
        $this->assertSame(38, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_FR_NUMERO_TVA_INTRACOMMUNAUTAIRE, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new FrNumeroTvaIntracommunautaireProbe();

        $expected = 'FR17336019286';
        $text = 'FR17336019286 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FR_NUMERO_TVA_INTRACOMMUNAUTAIRE, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new FrNumeroTvaIntracommunautaireProbe();

        $expected = 'FR17336019286';
        $text = 'head FR17336019286';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FR_NUMERO_TVA_INTRACOMMUNAUTAIRE, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new FrNumeroTvaIntracommunautaireProbe();

        $expected = 'FR17336019286';
        $text = 'Check FR17336019286, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FR_NUMERO_TVA_INTRACOMMUNAUTAIRE, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new FrNumeroTvaIntracommunautaireProbe();

        $expectedFirst = 'FR17336019286';
        $expectedSecond = 'FR17336019286';
        $text = 'FR17336019286 and FR17336019286';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FR_NUMERO_TVA_INTRACOMMUNAUTAIRE, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(18, $results[1]->getStart());
        $this->assertSame(31, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_FR_NUMERO_TVA_INTRACOMMUNAUTAIRE, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new FrNumeroTvaIntracommunautaireProbe();

        $expected = 'FR06124937065';
        $text = 'Prefix FR06124937065 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FR_NUMERO_TVA_INTRACOMMUNAUTAIRE, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new FrNumeroTvaIntracommunautaireProbe();

        $expectedFirst = 'FR17336019286';
        $expectedSecond = 'FR06124937065';
        $text = 'FR17336019286, FR06124937065';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FR_NUMERO_TVA_INTRACOMMUNAUTAIRE, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(28, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_FR_NUMERO_TVA_INTRACOMMUNAUTAIRE, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new FrNumeroTvaIntracommunautaireProbe();

        $expected = 'FR17336019286';
        $text = 'Value: FR17336019286';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FR_NUMERO_TVA_INTRACOMMUNAUTAIRE, $results[0]->getProbeType());
    }
}
