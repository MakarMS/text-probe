<?php

namespace Tests\Probes\Security;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Security\DatadogApiKeyProbe;

/**
 * @internal
 */
class DatadogApiKeyProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new DatadogApiKeyProbe();

        $expected = '1234567890abcdef1234567890abcdef';
        $text = 'Value: 1234567890abcdef1234567890abcdef';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::DATADOG_API_KEY, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new DatadogApiKeyProbe();

        $expected = '1234567890abcdef1234567890abcdef';
        $text = 'First 1234567890abcdef1234567890abcdef then 1234567890abcdef1234567890abcdef';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::DATADOG_API_KEY, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(44, $results[1]->getStart());
        $this->assertSame(76, $results[1]->getEnd());
        $this->assertSame(ProbeType::DATADOG_API_KEY, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new DatadogApiKeyProbe();

        $text = 'Value: 123456';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new DatadogApiKeyProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new DatadogApiKeyProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
