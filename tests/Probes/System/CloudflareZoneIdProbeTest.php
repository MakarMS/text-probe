<?php

namespace Tests\Probes\System;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\System\CloudflareZoneIdProbe;

/**
 * @internal
 */
class CloudflareZoneIdProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new CloudflareZoneIdProbe();

        $expected = '023e105f4ecef8ad9ca31a8372d0c353';
        $text = 'Value: 023e105f4ecef8ad9ca31a8372d0c353';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(39, $results[0]->getEnd());
        $this->assertSame(ProbeType::CLOUDFLARE_ZONE_ID, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new CloudflareZoneIdProbe();

        $expected = '023e105f4ecef8ad9ca31a8372d0c353';
        $text = 'First 023e105f4ecef8ad9ca31a8372d0c353 then 023e105f4ecef8ad9ca31a8372d0c353';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(38, $results[0]->getEnd());
        $this->assertSame(ProbeType::CLOUDFLARE_ZONE_ID, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(44, $results[1]->getStart());
        $this->assertSame(76, $results[1]->getEnd());
        $this->assertSame(ProbeType::CLOUDFLARE_ZONE_ID, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new CloudflareZoneIdProbe();

        $text = 'Value: 023e105f4ecef8ad';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new CloudflareZoneIdProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new CloudflareZoneIdProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
