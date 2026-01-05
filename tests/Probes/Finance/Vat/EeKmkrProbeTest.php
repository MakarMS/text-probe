<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\EeKmkrProbe;

/**
 * @internal
 */
class EeKmkrProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new EeKmkrProbe();

        $expected = 'EE575369975';
        $text = 'Value: EE575369975';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_EE_KMKR, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new EeKmkrProbe();

        $expected = 'EE293474498';
        $text = 'Value: EE293474498';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_EE_KMKR, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new EeKmkrProbe();

        $expectedFirst = 'EE575369975';
        $expectedSecond = 'EE293474498';
        $text = 'First EE575369975 then EE293474498';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_EE_KMKR, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(23, $results[1]->getStart());
        $this->assertSame(34, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_EE_KMKR, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new EeKmkrProbe();

        $expected = 'EE575369975';
        $text = 'EE575369975 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_EE_KMKR, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new EeKmkrProbe();

        $expected = 'EE575369975';
        $text = 'head EE575369975';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_EE_KMKR, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new EeKmkrProbe();

        $expected = 'EE575369975';
        $text = 'Check EE575369975, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_EE_KMKR, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new EeKmkrProbe();

        $expectedFirst = 'EE575369975';
        $expectedSecond = 'EE575369975';
        $text = 'EE575369975 and EE575369975';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_EE_KMKR, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(27, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_EE_KMKR, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new EeKmkrProbe();

        $expected = 'EE293474498';
        $text = 'Prefix EE293474498 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_EE_KMKR, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new EeKmkrProbe();

        $expectedFirst = 'EE575369975';
        $expectedSecond = 'EE293474498';
        $text = 'EE575369975, EE293474498';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_EE_KMKR, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(13, $results[1]->getStart());
        $this->assertSame(24, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_EE_KMKR, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new EeKmkrProbe();

        $expected = 'EE575369975';
        $text = 'Value: EE575369975';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_EE_KMKR, $results[0]->getProbeType());
    }
}
