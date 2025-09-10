<?php

namespace Tests\Probes;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\IPv4Probe;

class IPv4ProbeTest extends TestCase
{
    public function testFindsSingleValidIPv4Address(): void
    {
        $probe = new IPv4Probe();

        $text = 'My server IP is 192.168.1.1 and it is online.';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('192.168.1.1', $results[0]->getResult());
        $this->assertEquals(16, $results[0]->getStart());
        $this->assertEquals(27, $results[0]->getEnd());
        $this->assertEquals(ProbeType::IPV4, $results[0]->getProbeType());
    }

    public function testFindsMultipleValidIPv4Addresses(): void
    {
        $probe = new IPv4Probe();

        $text = 'IPs: 8.8.8.8, 127.0.0.1, and 255.255.255.255';
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('8.8.8.8', $results[0]->getResult());
        $this->assertEquals(5, $results[0]->getStart());
        $this->assertEquals(12, $results[0]->getEnd());
        $this->assertEquals(ProbeType::IPV4, $results[0]->getProbeType());

        $this->assertEquals('127.0.0.1', $results[1]->getResult());
        $this->assertEquals(14, $results[1]->getStart());
        $this->assertEquals(23, $results[1]->getEnd());
        $this->assertEquals(ProbeType::IPV4, $results[1]->getProbeType());

        $this->assertEquals('255.255.255.255', $results[2]->getResult());
        $this->assertEquals(29, $results[2]->getStart());
        $this->assertEquals(44, $results[2]->getEnd());
        $this->assertEquals(ProbeType::IPV4, $results[2]->getProbeType());
    }

    public function testRejectsInvalidIPv4Addresses(): void
    {
        $probe = new IPv4Probe();

        $text = 'Invalid IPs: 256.100.100.100 192.168.1.999 123.456.78.90 192.168.1.1.1 192.168..1.1';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsIPv4AddressAtTextBoundaries(): void
    {
        $probe = new IPv4Probe();

        $text = '0.0.0.0 is a valid IP and so is 255.255.255.255';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('0.0.0.0', $results[0]->getResult());
        $this->assertEquals(0, $results[0]->getStart());
        $this->assertEquals(7, $results[0]->getEnd());
        $this->assertEquals(ProbeType::IPV4, $results[0]->getProbeType());

        $this->assertEquals('255.255.255.255', $results[1]->getResult());
        $this->assertEquals(32, $results[1]->getStart());
        $this->assertEquals(47, $results[1]->getEnd());
        $this->assertEquals(ProbeType::IPV4, $results[1]->getProbeType());
    }

    public function testRejectsIPsWithLeadingZerosInOctets(): void
    {
        $probe = new IPv4Probe();

        $text = 'Invalid: 192.168.001.001 010.0.0.1 Valid: 10.0.0.1';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);

        $this->assertEquals('10.0.0.1', $results[0]->getResult());
        $this->assertEquals(42, $results[0]->getStart());
        $this->assertEquals(50, $results[0]->getEnd());
        $this->assertEquals(ProbeType::IPV4, $results[0]->getProbeType());
    }

    public function testDoesNotMatchPartialIPsInText(): void
    {
        $probe = new IPv4Probe();

        $text = 'This is not an IP: 192.168.1 or 256.256.256 and 999.999.999.9999';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsIPsSeparatedByVariousDelimiters(): void
    {
        $probe = new IPv4Probe();

        $text = 'IPs: [127.0.0.1]; (192.168.0.1), and 10.10.10.10.';
        $results = $probe->probe($text);

        $this->assertCount(3, $results);

        $this->assertEquals('127.0.0.1', $results[0]->getResult());
        $this->assertEquals(6, $results[0]->getStart());
        $this->assertEquals(15, $results[0]->getEnd());
        $this->assertEquals(ProbeType::IPV4, $results[0]->getProbeType());

        $this->assertEquals('192.168.0.1', $results[1]->getResult());
        $this->assertEquals(19, $results[1]->getStart());
        $this->assertEquals(30, $results[1]->getEnd());
        $this->assertEquals(ProbeType::IPV4, $results[1]->getProbeType());

        $this->assertEquals('10.10.10.10', $results[2]->getResult());
        $this->assertEquals(37, $results[2]->getStart());
        $this->assertEquals(48, $results[2]->getEnd());
        $this->assertEquals(ProbeType::IPV4, $results[2]->getProbeType());
    }

    public function testFindsIPv4InLongText(): void
    {
        $probe = new IPv4Probe();

        $text = 'Lorem ipsum dolor sit amet, 10.0.0.1 consectetur adipiscing elit, sed do eiusmod tempor 172.16.0.254 incididunt ut labore et dolore magna aliqua.';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertEquals('10.0.0.1', $results[0]->getResult());
        $this->assertEquals(28, $results[0]->getStart());
        $this->assertEquals(36, $results[0]->getEnd());
        $this->assertEquals(ProbeType::IPV4, $results[0]->getProbeType());

        $this->assertEquals('172.16.0.254', $results[1]->getResult());
        $this->assertEquals(88, $results[1]->getStart());
        $this->assertEquals(100, $results[1]->getEnd());
        $this->assertEquals(ProbeType::IPV4, $results[1]->getProbeType());
    }

    public function testDoesNotMatchIPv6Addresses(): void
    {
        $probe = new IPv4Probe();

        $text = 'IPv6: fe80::1ff:fe23:4567:890a';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testFindsIPv4InUrl(): void
    {
        $probe = new IPv4Probe();

        $text = 'https://127.0.0.1/MakarMS/text-probe';
        $results = $probe->probe($text);

        $this->assertEquals('127.0.0.1', $results[0]->getResult());
        $this->assertEquals(8, $results[0]->getStart());
        $this->assertEquals(17, $results[0]->getEnd());
        $this->assertEquals(ProbeType::IPV4, $results[0]->getProbeType());
    }
}
