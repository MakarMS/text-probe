<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\FiAlvNumeroProbe;

/**
 * @internal
 */
class FiAlvNumeroProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new FiAlvNumeroProbe();

        $expected = 'FI79217914';
        $text = 'Value: FI79217914';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FI_ALV_NUMERO, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new FiAlvNumeroProbe();

        $expected = 'FI98283642';
        $text = 'Value: FI98283642';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FI_ALV_NUMERO, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new FiAlvNumeroProbe();

        $expectedFirst = 'FI79217914';
        $expectedSecond = 'FI98283642';
        $text = 'First FI79217914 then FI98283642';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FI_ALV_NUMERO, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(22, $results[1]->getStart());
        $this->assertSame(32, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_FI_ALV_NUMERO, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new FiAlvNumeroProbe();

        $expected = 'FI79217914';
        $text = 'FI79217914 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FI_ALV_NUMERO, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new FiAlvNumeroProbe();

        $expected = 'FI79217914';
        $text = 'head FI79217914';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(15, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FI_ALV_NUMERO, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new FiAlvNumeroProbe();

        $expected = 'FI79217914';
        $text = 'Check FI79217914, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FI_ALV_NUMERO, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new FiAlvNumeroProbe();

        $expectedFirst = 'FI79217914';
        $expectedSecond = 'FI79217914';
        $text = 'FI79217914 and FI79217914';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FI_ALV_NUMERO, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(15, $results[1]->getStart());
        $this->assertSame(25, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_FI_ALV_NUMERO, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new FiAlvNumeroProbe();

        $expected = 'FI98283642';
        $text = 'Prefix FI98283642 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FI_ALV_NUMERO, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new FiAlvNumeroProbe();

        $expectedFirst = 'FI79217914';
        $expectedSecond = 'FI98283642';
        $text = 'FI79217914, FI98283642';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(10, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FI_ALV_NUMERO, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(12, $results[1]->getStart());
        $this->assertSame(22, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_FI_ALV_NUMERO, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new FiAlvNumeroProbe();

        $expected = 'FI79217914';
        $text = 'Value: FI79217914';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_FI_ALV_NUMERO, $results[0]->getProbeType());
    }
}
