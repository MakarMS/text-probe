<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\LuNumeroTvaProbe;

/**
 * @internal
 */
class LuNumeroTvaProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new LuNumeroTvaProbe();

        $expected = 'LU01897480';
        $text = 'Value: LU01897480';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LU_NUMERO_TVA, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new LuNumeroTvaProbe();

        $expected = 'LU69081266';
        $text = 'Value: LU69081266';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LU_NUMERO_TVA, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new LuNumeroTvaProbe();

        $expectedFirst = 'LU01897480';
        $expectedSecond = 'LU69081266';
        $text = 'First LU01897480 then LU69081266';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LU_NUMERO_TVA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(22, $results[1]->getStart());
        $this->assertSame(32, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_LU_NUMERO_TVA, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new LuNumeroTvaProbe();

        $expected = 'LU01897480';
        $text = 'LU01897480 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LU_NUMERO_TVA, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new LuNumeroTvaProbe();

        $expected = 'LU01897480';
        $text = 'head LU01897480';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LU_NUMERO_TVA, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new LuNumeroTvaProbe();

        $expected = 'LU01897480';
        $text = 'Check LU01897480, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LU_NUMERO_TVA, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new LuNumeroTvaProbe();

        $expectedFirst = 'LU01897480';
        $expectedSecond = 'LU01897480';
        $text = 'LU01897480 and LU01897480';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LU_NUMERO_TVA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(25, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_LU_NUMERO_TVA, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new LuNumeroTvaProbe();

        $expected = 'LU69081266';
        $text = 'Prefix LU69081266 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LU_NUMERO_TVA, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new LuNumeroTvaProbe();

        $expectedFirst = 'LU01897480';
        $expectedSecond = 'LU69081266';
        $text = 'LU01897480, LU69081266';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LU_NUMERO_TVA, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(12, $results[1]->getStart());
        $this->assertSame(22, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_LU_NUMERO_TVA, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new LuNumeroTvaProbe();

        $expected = 'LU01897480';
        $text = 'Value: LU01897480';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LU_NUMERO_TVA, $results[0]->getProbeType());
    }
}
