<?php

namespace Tests\Probes\Network;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Network\Ipv4CidrProbe;

/**
 * @internal
 */
class Ipv4CidrProbeTest extends TestCase
{
    public function testFindsSingleMatch(): void
    {
        $probe = new Ipv4CidrProbe();

        $expected = '10.0.0.0/24';
        $text = 'Value: 10.0.0.0/24';
        $results = $probe->probe($text);

        $this->assertCount(1, $results);
        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(7, $results[0]->getStart());
        $this->assertSame(18, $results[0]->getEnd());
        $this->assertSame(ProbeType::IPV4_CIDR, $results[0]->getProbeType());
    }

    public function testFindsMultipleMatches(): void
    {
        $probe = new Ipv4CidrProbe();

        $expected = '10.0.0.0/24';
        $text = 'First 10.0.0.0/24 then 10.0.0.0/24';
        $results = $probe->probe($text);

        $this->assertCount(2, $results);

        $this->assertSame($expected, $results[0]->getResult());
        $this->assertSame(6, $results[0]->getStart());
        $this->assertSame(17, $results[0]->getEnd());
        $this->assertSame(ProbeType::IPV4_CIDR, $results[0]->getProbeType());

        $this->assertSame($expected, $results[1]->getResult());
        $this->assertSame(23, $results[1]->getStart());
        $this->assertSame(34, $results[1]->getEnd());
        $this->assertSame(ProbeType::IPV4_CIDR, $results[1]->getProbeType());
    }

    public function testRejectsInvalidValue(): void
    {
        $probe = new Ipv4CidrProbe();

        $text = 'Value: 10.0.0.0';
        $results = $probe->probe($text);

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyForEmptyText(): void
    {
        $probe = new Ipv4CidrProbe();

        $results = $probe->probe('');

        $this->assertCount(0, $results);
    }

    public function testReturnsEmptyWhenValueAbsent(): void
    {
        $probe = new Ipv4CidrProbe();

        $results = $probe->probe('No probeable tokens in this text.');

        $this->assertCount(0, $results);
    }
}
