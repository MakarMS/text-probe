<?php

namespace Tests\Probes\Network;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Network\MacAddressProbe;

/**
 * @internal
 */
class MacAddressProbeTest extends TestCase
{
    public function testFindsSingleValidMacAddress(): void
    {
        $probe = new MacAddressProbe();

        $text = 'Device MAC: 00:1A:2B:3C:4D:5E';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('00:1A:2B:3C:4D:5E', $results[0]->getResult());
        $this->assertEquals(12, $results[0]->getStart());
        $this->assertEquals(29, $results[0]->getEnd());
        $this->assertEquals(ProbeType::MAC_ADDRESS, $results[0]->getProbeType());
    }

    public function testFindsMultipleMacAddresses(): void
    {
        $probe = new MacAddressProbe();

        $text = 'MACs: 00:1A:2B:3C:4D:5E and 01-23-45-67-89-AB';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('00:1A:2B:3C:4D:5E', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(23, $results[0]->getEnd());
        $this->assertEquals(ProbeType::MAC_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('01-23-45-67-89-AB', $results[1]->getResult());
        $this->assertEquals(28, $results[1]->getStart());
        $this->assertEquals(45, $results[1]->getEnd());
        $this->assertEquals(ProbeType::MAC_ADDRESS, $results[1]->getProbeType());
    }

    public function testRejectsInvalidMacAddresses(): void
    {
        $probe = new MacAddressProbe();

        $text = 'Invalid: 00:1A:2B:3C:4D, GG:HH:II:JJ:KK:LL, 00-1A-2B-3C-4D-5E-6F';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMacAddressAtBoundaries(): void
    {
        $probe = new MacAddressProbe();

        $text = '00:1A:2B:3C:4D:5E is at start and 01-23-45-67-89-AB is at end';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('00:1A:2B:3C:4D:5E', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(17, $results[0]->getEnd());
        $this->assertEquals(ProbeType::MAC_ADDRESS, $results[0]->getProbeType());

        $this->assertEquals('01-23-45-67-89-AB', $results[1]->getResult());
        $this->assertEquals(34, $results[1]->getStart());
        $this->assertEquals(51, $results[1]->getEnd());
        $this->assertEquals(ProbeType::MAC_ADDRESS, $results[1]->getProbeType());
    }

    public function testDoesNotMatchMacLikeStrings(): void
    {
        $probe = new MacAddressProbe();

        $text = 'Not MAC: 001A2B3C4D5E, 00:1G:2H:3I:4J:5K, 123.456.789.000';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsMacInSurroundingText(): void
    {
        $probe = new MacAddressProbe();

        $text = 'This device uses MAC address 12-34-56-78-9A-BC for network communication.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('12-34-56-78-9A-BC', $results[0]->getResult());
        $this->assertEquals(29, $results[0]->getStart());
        $this->assertEquals(46, $results[0]->getEnd());
        $this->assertEquals(ProbeType::MAC_ADDRESS, $results[0]->getProbeType());
    }
}
