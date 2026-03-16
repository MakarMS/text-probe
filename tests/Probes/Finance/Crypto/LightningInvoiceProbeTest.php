<?php

namespace Tests\Probes\Finance\Crypto;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Finance\Crypto\LightningInvoiceProbe;

/**
 * @internal
 */
class LightningInvoiceProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new LightningInvoiceProbe();

        $expected = 'lnbc2500u1p0testinvoicevaluexyzxyzxyz';
        $text = 'Value: lnbc2500u1p0testinvoicevaluexyzxyzxyz';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(44, $results[0]->getEnd());
        $this->assertSame(ProbeType::LIGHTNING_INVOICE, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new LightningInvoiceProbe();

        $expected = 'lnbc2500u1p0testinvoicevaluexyzxyzxyz';
        $text = 'First lnbc2500u1p0testinvoicevaluexyzxyzxyz then lnbc2500u1p0testinvoicevaluexyzxyzxyz';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(43, $results[0]->getEnd());
        $this->assertSame(ProbeType::LIGHTNING_INVOICE, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(49, $results[1]->getStart());
        $this->assertSame(86, $results[1]->getEnd());
        $this->assertSame(ProbeType::LIGHTNING_INVOICE, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new LightningInvoiceProbe();

        $text = 'Value: lnbc123';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new LightningInvoiceProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new LightningInvoiceProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
