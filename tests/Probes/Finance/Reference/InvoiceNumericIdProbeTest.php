<?php

namespace Tests\Probes\Finance\Reference;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Reference\InvoiceNumericIdProbe;

/**
 * @internal
 */
class InvoiceNumericIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new InvoiceNumericIdProbe();

        $expected = '123456';
        $text = 'Value: 123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_NUMERIC_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new InvoiceNumericIdProbe();

        $expected = '987654321';
        $text = 'Value: 987654321';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_NUMERIC_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new InvoiceNumericIdProbe();

        $expectedFirst = '123456';
        $expectedSecond = '987654321';
        $text = 'First 123456 then 987654321';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_NUMERIC_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(18, $results[1]->getStart());
        $this->assertSame(27, $results[1]->getEnd());
        $this->assertSame(ProbeType::INVOICE_NUMERIC_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new InvoiceNumericIdProbe();

        $expected = '123456';
        $text = '123456 tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(6, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_NUMERIC_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new InvoiceNumericIdProbe();

        $expected = '123456';
        $text = 'head 123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_NUMERIC_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new InvoiceNumericIdProbe();

        $expected = '123456';
        $text = 'Check 123456, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_NUMERIC_ID, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new InvoiceNumericIdProbe();

        $expectedFirst = '123456';
        $expectedSecond = '123456';
        $text = '123456 and 123456';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(6, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_NUMERIC_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(11, $results[1]->getStart());
        $this->assertSame(17, $results[1]->getEnd());
        $this->assertSame(ProbeType::INVOICE_NUMERIC_ID, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new InvoiceNumericIdProbe();

        $expected = '987654321';
        $text = 'Prefix 987654321 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(16, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_NUMERIC_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new InvoiceNumericIdProbe();

        $expectedFirst = '123456';
        $expectedSecond = '987654321';
        $text = '123456, 987654321';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(6, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_NUMERIC_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(8, $results[1]->getStart());
        $this->assertSame(17, $results[1]->getEnd());
        $this->assertSame(ProbeType::INVOICE_NUMERIC_ID, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new InvoiceNumericIdProbe();

        $expected = '123456';
        $text = 'Value: 123456';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_NUMERIC_ID, $results[0]->getProbeType());
    }
}
