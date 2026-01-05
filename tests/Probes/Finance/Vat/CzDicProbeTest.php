<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\CzDicProbe;

/**
 * @internal
 */
class CzDicProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new CzDicProbe();

        $expected = 'CZ194308303';
        $text = 'Value: CZ194308303';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CZ_DIC, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new CzDicProbe();

        $expected = 'CZ56743483';
        $text = 'Value: CZ56743483';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CZ_DIC, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CzDicProbe();

        $expectedFirst = 'CZ194308303';
        $expectedSecond = 'CZ56743483';
        $text = 'First CZ194308303 then CZ56743483';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CZ_DIC, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(23, $results[1]->getStart());
        $this->assertSame(33, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_CZ_DIC, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new CzDicProbe();

        $expected = 'CZ194308303';
        $text = 'CZ194308303 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CZ_DIC, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new CzDicProbe();

        $expected = 'CZ194308303';
        $text = 'head CZ194308303';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CZ_DIC, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new CzDicProbe();

        $expected = 'CZ194308303';
        $text = 'Check CZ194308303, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CZ_DIC, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new CzDicProbe();

        $expectedFirst = 'CZ194308303';
        $expectedSecond = 'CZ194308303';
        $text = 'CZ194308303 and CZ194308303';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CZ_DIC, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(16, $results[1]->getStart());
        $this->assertSame(27, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_CZ_DIC, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new CzDicProbe();

        $expected = 'CZ56743483';
        $text = 'Prefix CZ56743483 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CZ_DIC, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new CzDicProbe();

        $expectedFirst = 'CZ194308303';
        $expectedSecond = 'CZ56743483';
        $text = 'CZ194308303, CZ56743483';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CZ_DIC, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(13, $results[1]->getStart());
        $this->assertSame(23, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_CZ_DIC, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new CzDicProbe();

        $expected = 'CZ194308303';
        $text = 'Value: CZ194308303';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_CZ_DIC, $results[0]->getProbeType());
    }
}
