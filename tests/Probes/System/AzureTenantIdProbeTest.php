<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\AzureTenantIdProbe;

/**
 * @internal
 */
class AzureTenantIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new AzureTenantIdProbe();

        $expected = '87654321-4321-4321-4321-cba987654321';
        $text = '87654321-4321-4321-4321-cba987654321';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_TENANT_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new AzureTenantIdProbe();

        $expected = 'abcdefab-cdef-abcd-efab-cdefabcdefab';
        $text = 'abcdefab-cdef-abcd-efab-cdefabcdefab';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_TENANT_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new AzureTenantIdProbe();

        $first = '87654321-4321-4321-4321-cba987654321';
        $second = 'abcdefab-cdef-abcd-efab-cdefabcdefab';
        $text = '87654321-4321-4321-4321-cba987654321' . "\n" . 'abcdefab-cdef-abcd-efab-cdefabcdefab';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_TENANT_ID, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(37, $results[1]->getStart());
        $this->assertSame(73, $results[1]->getEnd());
        $this->assertSame(ProbeType::AZURE_TENANT_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new AzureTenantIdProbe();

        $expected = '87654321-4321-4321-4321-cba987654321';
        $text = '87654321-4321-4321-4321-cba987654321';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_TENANT_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new AzureTenantIdProbe();

        $expected = '87654321-4321-4321-4321-cba987654321';
        $text = '87654321-4321-4321-4321-cba987654321';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_TENANT_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new AzureTenantIdProbe();

        $expected = '87654321-4321-4321-4321-cba987654321';
        $text = '87654321-4321-4321-4321-cba987654321';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_TENANT_ID, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new AzureTenantIdProbe();

        $text = 'tenant-short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new AzureTenantIdProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new AzureTenantIdProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new AzureTenantIdProbe();

        $expected = '87654321-4321-4321-4321-cba987654321';
        $text = '87654321-4321-4321-4321-cba987654321';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_TENANT_ID, $results[0]->getProbeType());
    }
}
