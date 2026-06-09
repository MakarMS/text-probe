<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\AzureResourceIdProbe;

/**
 * @internal
 */
class AzureResourceIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new AzureResourceIdProbe();

        $expected = '/subscriptions/12345678-1234-1234-1234-123456789abc/resourceGroups/rg-prod/providers/Microsoft.Storage/storageAccounts/appstore';
        $text = '/subscriptions/12345678-1234-1234-1234-123456789abc/resourceGroups/rg-prod/providers/Microsoft.Storage/storageAccounts/appstore';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(127, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_RESOURCE_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new AzureResourceIdProbe();

        $expected = '/subscriptions/abcdefab-cdef-abcd-efab-cdefabcdefab/resourceGroups/rg/providers/Microsoft.Web/sites/app';
        $text = '/subscriptions/abcdefab-cdef-abcd-efab-cdefabcdefab/resourceGroups/rg/providers/Microsoft.Web/sites/app';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(103, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_RESOURCE_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new AzureResourceIdProbe();

        $first = '/subscriptions/12345678-1234-1234-1234-123456789abc/resourceGroups/rg-prod/providers/Microsoft.Storage/storageAccounts/appstore';
        $second = '/subscriptions/abcdefab-cdef-abcd-efab-cdefabcdefab/resourceGroups/rg/providers/Microsoft.Web/sites/app';
        $text = '/subscriptions/12345678-1234-1234-1234-123456789abc/resourceGroups/rg-prod/providers/Microsoft.Storage/storageAccounts/appstore' . "\n" . '/subscriptions/abcdefab-cdef-abcd-efab-cdefabcdefab/resourceGroups/rg/providers/Microsoft.Web/sites/app';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(127, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_RESOURCE_ID, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(128, $results[1]->getStart());
        $this->assertSame(231, $results[1]->getEnd());
        $this->assertSame(ProbeType::AZURE_RESOURCE_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new AzureResourceIdProbe();

        $expected = '/subscriptions/12345678-1234-1234-1234-123456789abc/resourceGroups/rg-prod/providers/Microsoft.Storage/storageAccounts/appstore';
        $text = '/subscriptions/12345678-1234-1234-1234-123456789abc/resourceGroups/rg-prod/providers/Microsoft.Storage/storageAccounts/appstore';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(127, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_RESOURCE_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new AzureResourceIdProbe();

        $expected = '/subscriptions/12345678-1234-1234-1234-123456789abc/resourceGroups/rg-prod/providers/Microsoft.Storage/storageAccounts/appstore';
        $text = '/subscriptions/12345678-1234-1234-1234-123456789abc/resourceGroups/rg-prod/providers/Microsoft.Storage/storageAccounts/appstore';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(127, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_RESOURCE_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new AzureResourceIdProbe();

        $expected = '/subscriptions/12345678-1234-1234-1234-123456789abc/resourceGroups/rg-prod/providers/Microsoft.Storage/storageAccounts/appstore';
        $text = '/subscriptions/12345678-1234-1234-1234-123456789abc/resourceGroups/rg-prod/providers/Microsoft.Storage/storageAccounts/appstore';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(127, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_RESOURCE_ID, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new AzureResourceIdProbe();

        $text = '/subscriptions/short/resourceGroups/rg/providers/Microsoft.Web/sites/app';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new AzureResourceIdProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new AzureResourceIdProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new AzureResourceIdProbe();

        $expected = '/subscriptions/12345678-1234-1234-1234-123456789abc/resourceGroups/rg-prod/providers/Microsoft.Storage/storageAccounts/appstore';
        $text = '/subscriptions/12345678-1234-1234-1234-123456789abc/resourceGroups/rg-prod/providers/Microsoft.Storage/storageAccounts/appstore';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(127, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_RESOURCE_ID, $results[0]->getProbeType());
    }
}
