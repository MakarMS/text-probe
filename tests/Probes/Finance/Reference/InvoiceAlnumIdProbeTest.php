<?php

namespace Tests\Probes\Finance\Reference;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Reference\InvoiceAlnumIdProbe;

/**
 * @internal
 */
class InvoiceAlnumIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new InvoiceAlnumIdProbe();

        $expected = 'AB12CD';
        $text = 'Value: AB12CD';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_ALNUM_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new InvoiceAlnumIdProbe();

        $expected = 'INV-123/45';
        $text = 'Value: INV-123/45';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_ALNUM_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new InvoiceAlnumIdProbe();

        $expectedFirst = 'AB12CD';
        $expectedSecond = 'INV-123/45';
        $text = 'First AB12CD then INV-123/45';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_ALNUM_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(18, $results[1]->getStart());
        $this->assertSame(28, $results[1]->getEnd());
        $this->assertSame(ProbeType::INVOICE_ALNUM_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new InvoiceAlnumIdProbe();

        $expected = 'AB12CD';
        $text = 'AB12CD tail';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(6, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_ALNUM_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new InvoiceAlnumIdProbe();

        $expected = 'AB12CD';
        $text = 'head AB12CD';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(5, $results[0]->getStart());
        $this->assertSame(11, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_ALNUM_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new InvoiceAlnumIdProbe();

        $expected = 'AB12CD';
        $text = 'Check AB12CD, next.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(12, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_ALNUM_ID, $results[0]->getProbeType());
    }

    public function testHandlesDuplicateMatches(): void
    {
        $probe = new InvoiceAlnumIdProbe();

        $expectedFirst = 'AB12CD';
        $expectedSecond = 'AB12CD';
        $text = 'AB12CD and AB12CD';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(6, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_ALNUM_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(11, $results[1]->getStart());
        $this->assertSame(17, $results[1]->getEnd());
        $this->assertSame(ProbeType::INVOICE_ALNUM_ID, $results[1]->getProbeType());
    }

    public function testMatchesWithinSentence(): void
    {
        $probe = new InvoiceAlnumIdProbe();

        $expected = 'INV-123/45';
        $text = 'Prefix INV-123/45 suffix';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_ALNUM_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleWithPunctuation(): void
    {
        $probe = new InvoiceAlnumIdProbe();

        $expectedFirst = 'AB12CD';
        $expectedSecond = 'INV-123/45';
        $text = 'AB12CD, INV-123/45';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($expectedFirst, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(6, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_ALNUM_ID, $results[0]->getProbeType());

        $this->assertSame($expectedSecond, $results[1]->getResult());
        $this->assertSame(8, $results[1]->getStart());
        $this->assertSame(18, $results[1]->getEnd());
        $this->assertSame(ProbeType::INVOICE_ALNUM_ID, $results[1]->getProbeType());
    }

    public function testReportsProbeType(): void
    {
        $probe = new InvoiceAlnumIdProbe();

        $expected = 'AB12CD';
        $text = 'Value: AB12CD';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(13, $results[0]->getEnd());
        $this->assertSame(ProbeType::INVOICE_ALNUM_ID, $results[0]->getProbeType());
    }
}
