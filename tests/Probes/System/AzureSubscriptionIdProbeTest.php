<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\AzureSubscriptionIdProbe;

/**
 * @internal
 */
class AzureSubscriptionIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new AzureSubscriptionIdProbe();

        $expected = '12345678-1234-1234-1234-123456789abc';
        $text = '12345678-1234-1234-1234-123456789abc';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_SUBSCRIPTION_ID, $results[0]->getProbeType());
    }

    public function testFindsSecondSingleMatch(): void
    {
        $probe = new AzureSubscriptionIdProbe();

        $expected = 'abcdefab-cdef-abcd-efab-cdefabcdefab';
        $text = 'abcdefab-cdef-abcd-efab-cdefabcdefab';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_SUBSCRIPTION_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new AzureSubscriptionIdProbe();

        $first = '12345678-1234-1234-1234-123456789abc';
        $second = 'abcdefab-cdef-abcd-efab-cdefabcdefab';
        $text = '12345678-1234-1234-1234-123456789abc' . "\n" . 'abcdefab-cdef-abcd-efab-cdefabcdefab';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);
        $this->assertSame($first, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_SUBSCRIPTION_ID, $results[0]->getProbeType());

        $this->assertSame($second, $results[1]->getResult());
        $this->assertSame(37, $results[1]->getStart());
        $this->assertSame(73, $results[1]->getEnd());
        $this->assertSame(ProbeType::AZURE_SUBSCRIPTION_ID, $results[1]->getProbeType());
    }

    public function testMatchesAtStart(): void
    {
        $probe = new AzureSubscriptionIdProbe();

        $expected = '12345678-1234-1234-1234-123456789abc';
        $text = '12345678-1234-1234-1234-123456789abc';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_SUBSCRIPTION_ID, $results[0]->getProbeType());
    }

    public function testMatchesAtEnd(): void
    {
        $probe = new AzureSubscriptionIdProbe();

        $expected = '12345678-1234-1234-1234-123456789abc';
        $text = '12345678-1234-1234-1234-123456789abc';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_SUBSCRIPTION_ID, $results[0]->getProbeType());
    }

    public function testMatchesWithPunctuation(): void
    {
        $probe = new AzureSubscriptionIdProbe();

        $expected = '12345678-1234-1234-1234-123456789abc';
        $text = '12345678-1234-1234-1234-123456789abc';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_SUBSCRIPTION_ID, $results[0]->getProbeType());
    }

    public function testIgnoresInvalidCandidate(): void
    {
        $probe = new AzureSubscriptionIdProbe();

        $text = 'subscription-short';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new AzureSubscriptionIdProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new AzureSubscriptionIdProbe();

        $results = $probe->probe('!!!');

        $this->assertCount(0, $results);
    }

    public function testReportsProbeType(): void
    {
        $probe = new AzureSubscriptionIdProbe();

        $expected = '12345678-1234-1234-1234-123456789abc';
        $text = '12345678-1234-1234-1234-123456789abc';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(0, $results[0]->getStart());
        $this->assertSame(36, $results[0]->getEnd());
        $this->assertSame(ProbeType::AZURE_SUBSCRIPTION_ID, $results[0]->getProbeType());
    }
}
