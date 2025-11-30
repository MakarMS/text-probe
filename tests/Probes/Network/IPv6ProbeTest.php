<?php

namespace Tests\Probes\Network;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Network\IPv6Probe;

/**
 * @internal
 */
class IPv6ProbeTest extends TestCase
{
    public function testFindsSingleFullIPv6Address(): void
    {
        $probe = new IPv6Probe();

        $text = 'Server address: 2001:0db8:85a3:0000:0000:8a2e:0370:7334.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('2001:0db8:85a3:0000:0000:8a2e:0370:7334', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(55, $results[0]->getEnd());
        $this->assertEquals(ProbeType::IPV6, $results[0]->getProbeType());
    }

    public function testFindsMultipleValidIPv6Addresses(): void
    {
        $probe = new IPv6Probe();

        $text = 'Addresses: ::1, fe80::1ff:fe23:4567:890a, 2001:db8::1';
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('::1', $results[0]->getResult());
        $this->assertEquals(11, $results[0]->getStart());
        $this->assertEquals(14, $results[0]->getEnd());
        $this->assertEquals(ProbeType::IPV6, $results[0]->getProbeType());

        $this->assertEquals('fe80::1ff:fe23:4567:890a', $results[1]->getResult());
        $this->assertEquals(16, $results[1]->getStart());
        $this->assertEquals(40, $results[1]->getEnd());
        $this->assertEquals(ProbeType::IPV6, $results[1]->getProbeType());

        $this->assertEquals('2001:db8::1', $results[2]->getResult());
        $this->assertEquals(42, $results[2]->getStart());
        $this->assertEquals(53, $results[2]->getEnd());
        $this->assertEquals(ProbeType::IPV6, $results[2]->getProbeType());
    }

    public function testRejectsInvalidIPv6Addresses(): void
    {
        $probe = new IPv6Probe();

        $text = 'Bad addresses: 12345::6789, ::::';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsIPv6AtTextBoundaries(): void
    {
        $probe = new IPv6Probe();

        $text = '::1 is the loopback. Ending with: 2001:db8::1';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('::1', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(3, $results[0]->getEnd());
        $this->assertEquals(ProbeType::IPV6, $results[0]->getProbeType());

        $this->assertEquals('2001:db8::1', $results[1]->getResult());
        $this->assertEquals(34, $results[1]->getStart());
        $this->assertEquals(45, $results[1]->getEnd());
        $this->assertEquals(ProbeType::IPV6, $results[1]->getProbeType());
    }

    public function testFindsIPv6InUrl(): void
    {
        $probe = new IPv6Probe();

        $text = 'http://[2001:db8::1]/some/path';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('2001:db8::1', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(19, $results[0]->getEnd());
        $this->assertEquals(ProbeType::IPV6, $results[0]->getProbeType());
    }

    public function testFindsIPv4MappedIPv6(): void
    {
        $probe = new IPv6Probe();

        $text = 'Mapped address: ::ffff:192.168.1.1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('::ffff:192.168.1.1', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(34, $results[0]->getEnd());
        $this->assertEquals(ProbeType::IPV6, $results[0]->getProbeType());
    }

    public function testFindsIPv6WithZoneIndex(): void
    {
        $probe = new IPv6Probe();

        $text = 'fe80::1%eth0 is a link-local address';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('fe80::1%eth0', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(12, $results[0]->getEnd());
        $this->assertEquals(ProbeType::IPV6, $results[0]->getProbeType());
    }

    public function testDoesNotMatchIPv4Addresses(): void
    {
        $probe = new IPv6Probe();
        $text = 'IPs: 192.168.1.1, 10.0.0.1';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testHandlesTextWithNoIPs(): void
    {
        $probe = new IPv6Probe();
        $text = 'This is a sentence with no IP addresses.';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsIPv6InBracketsOrDelimiters(): void
    {
        $probe = new IPv6Probe();
        $text = '[::1], (fe80::1), <2001:db8::1>';
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('::1', $results[0]->getResult());
        $this->assertEquals(1, $results[0]->getStart());
        $this->assertEquals(4, $results[0]->getEnd());
        $this->assertEquals(ProbeType::IPV6, $results[0]->getProbeType());

        $this->assertEquals('fe80::1', $results[1]->getResult());
        $this->assertEquals(8, $results[1]->getStart());
        $this->assertEquals(15, $results[1]->getEnd());
        $this->assertEquals(ProbeType::IPV6, $results[1]->getProbeType());

        $this->assertEquals('2001:db8::1', $results[2]->getResult());
        $this->assertEquals(19, $results[2]->getStart());
        $this->assertEquals(30, $results[2]->getEnd());
        $this->assertEquals(ProbeType::IPV6, $results[2]->getProbeType());
    }
}
