<?php

namespace Tests\Probes\Finance\Vat;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Vat\PlNipVatProbe;

/**
 * @internal
 */
class PlNipVatProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new PlNipVatProbe();

        $expected = 'PL3654345877';
        $text = 'Value: PL3654345877';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PL_NIP, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new PlNipVatProbe();

        $expected = 'PL9082421958';
        $text = 'Value: PL9082421958';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PL_NIP, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new PlNipVatProbe();

        $expectedFirst = 'PL3654345877';
        $expectedSecond = 'PL9082421958';
        $text = 'First PL3654345877 then PL9082421958';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PL_NIP, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(24, $results[1]->getStart());
        $this->assertSame(36, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_PL_NIP, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new PlNipVatProbe();

        $expected = 'PL3654345877';
        $text = 'PL3654345877 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PL_NIP, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new PlNipVatProbe();

        $expected = 'PL3654345877';
        $text = 'head PL3654345877';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PL_NIP, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new PlNipVatProbe();

        $expected = 'PL3654345877';
        $text = 'Check PL3654345877, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PL_NIP, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new PlNipVatProbe();

        $expectedFirst = 'PL3654345877';
        $expectedSecond = 'PL3654345877';
        $text = 'PL3654345877 and PL3654345877';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PL_NIP, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(17, $results[1]->getStart());
        $this->assertSame(29, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_PL_NIP, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new PlNipVatProbe();

        $expected = 'PL9082421958';
        $text = 'Prefix PL9082421958 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PL_NIP, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new PlNipVatProbe();

        $expectedFirst = 'PL3654345877';
        $expectedSecond = 'PL9082421958';
        $text = 'PL3654345877, PL9082421958';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PL_NIP, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(14, $results[1]->getStart());
        $this->assertSame(26, $results[1]->getEnd());
        $this->assertSame(ProbeType::VAT_PL_NIP, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new PlNipVatProbe();

        $expected = 'PL3654345877';
        $text = 'Value: PL3654345877';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(19, $results[0]->getEnd());
        $this->assertSame(ProbeType::VAT_PL_NIP, $results[0]->getProbeType());
    }
}
