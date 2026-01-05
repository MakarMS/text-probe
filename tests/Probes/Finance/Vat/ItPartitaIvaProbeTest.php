<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\ItPartitaIvaProbe;

/**
 * @internal
 */
class ItPartitaIvaProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new ItPartitaIvaProbe();

        $expected = 'IT63069758801';
        $text = 'Value: IT63069758801';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IT_PARTITA_IVA, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new ItPartitaIvaProbe();

        $expected = 'IT99495551782';
        $text = 'Value: IT99495551782';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IT_PARTITA_IVA, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new ItPartitaIvaProbe();

        $expectedFirst = 'IT63069758801';
        $expectedSecond = 'IT99495551782';
        $text = 'First IT63069758801 then IT99495551782';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IT_PARTITA_IVA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(25, $results[1]->getStart());
        $this->assertSame(38, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_IT_PARTITA_IVA, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new ItPartitaIvaProbe();

        $expected = 'IT63069758801';
        $text = 'IT63069758801 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IT_PARTITA_IVA, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new ItPartitaIvaProbe();

        $expected = 'IT63069758801';
        $text = 'head IT63069758801';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IT_PARTITA_IVA, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new ItPartitaIvaProbe();

        $expected = 'IT63069758801';
        $text = 'Check IT63069758801, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IT_PARTITA_IVA, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new ItPartitaIvaProbe();

        $expectedFirst = 'IT63069758801';
        $expectedSecond = 'IT63069758801';
        $text = 'IT63069758801 and IT63069758801';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IT_PARTITA_IVA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(18, $results[1]->getStart());
        $this->assertSame(31, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_IT_PARTITA_IVA, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new ItPartitaIvaProbe();

        $expected = 'IT99495551782';
        $text = 'Prefix IT99495551782 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IT_PARTITA_IVA, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new ItPartitaIvaProbe();

        $expectedFirst = 'IT63069758801';
        $expectedSecond = 'IT99495551782';
        $text = 'IT63069758801, IT99495551782';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IT_PARTITA_IVA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(28, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_IT_PARTITA_IVA, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new ItPartitaIvaProbe();

        $expected = 'IT63069758801';
        $text = 'Value: IT63069758801';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(20, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_IT_PARTITA_IVA, $results[0]->getProbeType());
    }
}
