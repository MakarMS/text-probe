<?php

namespace Tests\Probes\Network;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Network\PrivateIPv4Probe;

/**
 * @internal
 */
class PrivateIPv4ProbeTest extends TestCase
{
    public function testFindsPrivateIPv4Addresses(): void
    {
        $probe = new PrivateIPv4Probe();

        $text = 'Hosts: 10.0.0.1, 192.168.10.5 and 172.20.1.250';
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('10.0.0.1', $results[0]->getResult());
        $this->assertEquals(7, $results[0]->getStart());
        $this->assertEquals(15, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PRIVATE_IPV4, $results[0]->getProbeType());

        $this->assertEquals('192.168.10.5', $results[1]->getResult());
        $this->assertEquals(17, $results[1]->getStart());
        $this->assertEquals(29, $results[1]->getEnd());
        $this->assertEquals(ProbeType::PRIVATE_IPV4, $results[1]->getProbeType());

        $this->assertEquals('172.20.1.250', $results[2]->getResult());
        $this->assertEquals(34, $results[2]->getStart());
        $this->assertEquals(46, $results[2]->getEnd());
        $this->assertEquals(ProbeType::PRIVATE_IPV4, $results[2]->getProbeType());
    }

    public function testSkipsPublicIPv4Addresses(): void
    {
        $probe = new PrivateIPv4Probe();

        $text = 'Public: 8.8.8.8, 1.1.1.1 and 172.32.0.1 outside private range';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testDoesNotMatchNearbyDigits(): void
    {
        $probe = new PrivateIPv4Probe();

        $text = 'Not IPs: 1010.0.0.1 10.0.0.10.5 192.168.1';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testDetectsAddressesAtBoundaries(): void
    {
        $probe = new PrivateIPv4Probe();

        $text = '10.10.10.10 ends here and starts 192.168.0.1';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('10.10.10.10', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(11, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PRIVATE_IPV4, $results[0]->getProbeType());

        $this->assertEquals('192.168.0.1', $results[1]->getResult());
        $this->assertEquals(33, $results[1]->getStart());
        $this->assertEquals(44, $results[1]->getEnd());
        $this->assertEquals(ProbeType::PRIVATE_IPV4, $results[1]->getProbeType());
    }

    public function testHandlesMixedValidAndInvalid172Range(): void
    {
        $probe = new PrivateIPv4Probe();

        $text = 'Valid 172.16.0.1 and 172.31.255.254 but not 172.15.0.1 or 172.32.0.1';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('172.16.0.1', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(16, $results[0]->getEnd());
        $this->assertEquals(ProbeType::PRIVATE_IPV4, $results[0]->getProbeType());

        $this->assertEquals('172.31.255.254', $results[1]->getResult());
        $this->assertEquals(21, $results[1]->getStart());
        $this->assertEquals(35, $results[1]->getEnd());
        $this->assertEquals(ProbeType::PRIVATE_IPV4, $results[1]->getProbeType());
    }
}
