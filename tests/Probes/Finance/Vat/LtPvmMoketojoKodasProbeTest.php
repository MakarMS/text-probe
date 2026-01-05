<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\LtPvmMoketojoKodasProbe;

/**
 * @internal
 */
class LtPvmMoketojoKodasProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new LtPvmMoketojoKodasProbe();

        $expected = 'LT286889588';
        $text = 'Value: LT286889588';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LT_PVM_MOKETOJO_KODAS, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new LtPvmMoketojoKodasProbe();

        $expected = 'LT931118271229';
        $text = 'Value: LT931118271229';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LT_PVM_MOKETOJO_KODAS, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new LtPvmMoketojoKodasProbe();

        $expectedFirst = 'LT286889588';
        $expectedSecond = 'LT931118271229';
        $text = 'First LT286889588 then LT931118271229';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LT_PVM_MOKETOJO_KODAS, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(23, $results[1]->getStart());
        $this->assertSame(37, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_LT_PVM_MOKETOJO_KODAS, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new LtPvmMoketojoKodasProbe();

        $expected = 'LT286889588';
        $text = 'LT286889588 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LT_PVM_MOKETOJO_KODAS, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new LtPvmMoketojoKodasProbe();

        $expected = 'LT286889588';
        $text = 'head LT286889588';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LT_PVM_MOKETOJO_KODAS, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new LtPvmMoketojoKodasProbe();

        $expected = 'LT286889588';
        $text = 'Check LT286889588, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LT_PVM_MOKETOJO_KODAS, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new LtPvmMoketojoKodasProbe();

        $expectedFirst = 'LT286889588';
        $expectedSecond = 'LT286889588';
        $text = 'LT286889588 and LT286889588';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LT_PVM_MOKETOJO_KODAS, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(27, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_LT_PVM_MOKETOJO_KODAS, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new LtPvmMoketojoKodasProbe();

        $expected = 'LT931118271229';
        $text = 'Prefix LT931118271229 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(21, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LT_PVM_MOKETOJO_KODAS, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new LtPvmMoketojoKodasProbe();

        $expectedFirst = 'LT286889588';
        $expectedSecond = 'LT931118271229';
        $text = 'LT286889588, LT931118271229';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LT_PVM_MOKETOJO_KODAS, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(13, $results[1]->getStart());
        $this->assertSame(27, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_LT_PVM_MOKETOJO_KODAS, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new LtPvmMoketojoKodasProbe();

        $expected = 'LT286889588';
        $text = 'Value: LT286889588';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_LT_PVM_MOKETOJO_KODAS, $results[0]->getProbeType());
    }
}
