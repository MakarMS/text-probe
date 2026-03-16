<?php

namespace Tests\Probes\Network;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Network\Ipv6CidrProbe;

/**
 * @internal
 */
class Ipv6CidrProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new Ipv6CidrProbe();

        $expected = '2001:db8:85a3:0:0:8a2e:370:7334/64';
        $text = 'Value: 2001:db8:85a3:0:0:8a2e:370:7334/64';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(41, $results[0]->getEnd());
        $this->assertSame(ProbeType::IPV6_CIDR, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new Ipv6CidrProbe();

        $expected = '2001:db8:85a3:0:0:8a2e:370:7334/64';
        $text = 'First 2001:db8:85a3:0:0:8a2e:370:7334/64 then 2001:db8:85a3:0:0:8a2e:370:7334/64';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(40, $results[0]->getEnd());
        $this->assertSame(ProbeType::IPV6_CIDR, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(46, $results[1]->getStart());
        $this->assertSame(80, $results[1]->getEnd());
        $this->assertSame(ProbeType::IPV6_CIDR, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new Ipv6CidrProbe();

        $text = 'Value: 2001:db8::1';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new Ipv6CidrProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new Ipv6CidrProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
